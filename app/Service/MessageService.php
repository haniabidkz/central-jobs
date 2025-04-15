<?php
namespace App\Service;

use Illuminate\Support\Facades\Auth;
use App\Repository\CommonRepository;
use App\Http\Model\User;
use App\Http\Model\Message;
use App\Http\Model\Notification;
use App\Http\Model\BlockMessage;
use App\Mail\NotificationMessage;
use App\Service\UploadService;
use App\Http\Model\Upload;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class MessageService {

     protected $user;
     protected $message;
     protected $notification;
     protected $blockMessage;
     protected $uploadService;
     protected $uploadRepository;
    /**
     * @param user $user reference to user model
     * 
     */
    public function __construct(User $user,Message $message,Notification $notification, BlockMessage $blockMessage,UploadService $uploadService,Upload $upload) {
        $this->user = new CommonRepository($user);
        $this->notification = new CommonRepository($notification);
        $this->message = new CommonRepository($message);
        $this->blockMessage = new CommonRepository($blockMessage);
        $this->uploadService = $uploadService;
        $this->uploadRepository   = new CommonRepository($upload);
    }

    /**
     * Function to get user chat history
     * 
     */
    public function getChatHistory()
    {
    	$userId = Auth::user()->id;
        $conditions [] = ['user_from_id',$userId];
        $conditions [] = ['deleted_from',0];
        $conditionsOr [] = ['user_to_id',$userId];
        $conditionsOr [] = ['deleted_to',0];
    	$messagesHistory = Message::where($conditions)
    						->with('userFrom')
    						->with('userTo')
                            ->orWhere($conditionsOr)
                            ->orderBy('id', 'DESC')
    						->get(); 

    	return $messagesHistory;
    }
    /**
     * Function get unique chated users
     * 
     */
    public function getUsersIdsFromChatHistory()
    {
    	$usersIds = [];
    	$currentUserId = Auth::user()->id;
    	$chatedMessage = $this->getChatHistory();
    	if($chatedMessage->isNotEmpty()){
    		foreach ($chatedMessage as $key => $row) {
    				 $usersIds[] = $row->user_from_id;		
    				 $usersIds[] = $row->user_to_id;
    		}
    	} 
    	return array_diff(array_unique($usersIds),[$currentUserId]);    	
    }
    /**
     * Function to get users from my chat history
     * 
     */
    public function getUsersDataFromChatHistory($name='')
    {
        $usersIds = $this->getUsersIdsFromChatHistory();
        $usersList = User::withTrashed()->whereIn('id',$usersIds);
        if($name != ''){
            $usersList = $usersList->where('first_name','LIKE','%'.$name.'%');
        }
        $usersList = $usersList->with('profile','profileImage','isBlocked','isLogedInUserBlock')
                               ->get();    	    	
    	return $usersList;
    }
    public function chatHistoryUsersData()
    {
    	$currentUserId = Auth::user()->id;
    	$chatedUsers = $this->getUsersDataFromChatHistory();
    	$chatHistoryUsersData = [];
    	if($chatedUsers->isNotEmpty()){
    		foreach ($chatedUsers as $key => $row) {
    			# code...
    				$chatData = Message::where([['user_from_id',$row->id],['user_to_id',$currentUserId],['blocked_to','!=',$currentUserId]])
    							->orWhere([['user_from_id',$currentUserId],['user_to_id',$row->id],['blocked_to','!=',$row->id]])
    							->orderBy('id', 'desc')
    							->limit(1)
    							->get();
    				if($chatData->isNotEmpty()){
    					foreach ($chatData as $key => $chatRow) {
    							 $chatHistoryUsersData[$row->id] = $chatRow->toArray();
    					}
    					
    				}    				
    		}
        }
        $chatHistoryUsersData = $this->array_msort($chatHistoryUsersData, array('created_at'=>SORT_DESC));
    	return $chatHistoryUsersData;
    }

    public function array_msort($array, $cols)
    {
        $colarr = array();
        foreach ($cols as $col => $order) {
            $colarr[$col] = array();
            foreach ($array as $k => $row) { $colarr[$col]['_'.$k] = strtolower($row[$col]); }
        }
        $eval = 'array_multisort(';
        foreach ($cols as $col => $order) {
            $eval .= '$colarr[\''.$col.'\'],'.$order.',';
        }
        $eval = substr($eval,0,-1).');';
        eval($eval);
        $ret = array();
        foreach ($colarr as $col => $arr) {
            foreach ($arr as $k => $v) {
                $k = substr($k,1);
                if (!isset($ret[$k])) $ret[$k] = $array[$k];
                $ret[$k][$col] = $array[$k][$col];
            }
        }
        return $ret;

    }
    /**
     * Function to get chating with user info
     * @param integer $userId
     * @return array $userInfo
     */
    public function getChatingUserInfo($userId)
    {
        $conditions[] = ['id','=',$userId];
        $with = 'isLogedInUserBlock';
    	$userInfo = $this->user->findSingleRowWithDeletedData($conditions,$with);
    	return $userInfo;
    }
    /**
     * Function to get chat history between two users
     * @param integer $userId1
     * @param integer $userId2
     * @return array $chatHistory
     */
    public function getChatHistoryBetwnUsers($userId1,$userId2)
    {
    	$chatHistoryData = Message::where([
                                            ['user_from_id',$userId1],
                                            ['user_to_id',$userId2],
                                            ['blocked_to','!=',$userId1],
                                            ['deleted_from','!=',1],
                                         ])                                     
    							->orWhere([
                                    ['user_from_id',$userId2],
                                    ['user_to_id',$userId1],
                                    ['blocked_to','!=',$userId1],
                                    ['deleted_to','!=',1]
                                    ])
                                ->with('attachments')
    							->orderBy('id', 'asc')    						
                                ->get();
                                
    	return $chatHistoryData;
    }

    public function storeMsg($request,$userSelectedId,$fileType='')
    {
    	$userId = Auth::user()->id;
        $isBlockedByMe = $this->getBlockStatus($userId,$userSelectedId);
        $isBlockedByHim = $this->getBlockStatus($userSelectedId,$userId);

        if($isBlockedByMe || $isBlockedByHim){//contacts in block status   
                $data['blocked_by'] = $userId;
                $data['blocked_to'] = $userSelectedId;      
        }
        if(($fileType != '') && ($fileType == 1)){
            $data['message'] = 'Sent an attachment';
        }else{
            $data['message'] = $request->input('message');
        }
        
        $data['user_from_id'] = $userId;
        $data['user_to_id'] = $userSelectedId;
        $message = $this->message->create($data);
        $message_id = $message->id;
        if(!$isBlockedByMe && !$isBlockedByHim)
        {
             $notification = [];
             $notification['type'] = 'message';
             $notification['type_id'] = $message->id;
             $notification['from_user_id'] = $userId;
             $notification['to_user_id'] = $userSelectedId;
             $this->notification->create($notification);
        }
    	

        $conditions[] = ['id','=',$userSelectedId];
        $toUser = $this->user->findSingleRow($conditions);

        $conditions1[] = ['id','=',$userId];
        $fromUser = $this->user->findSingleRow($conditions1);
        
        $imgPath = env('APP_URL').'public/backend/dist/img/user.png'; 
        $logoPath = env('APP_URL').'public/frontend/images/logo-color.png';   
        $dataMail['imgPath'] = $imgPath;
        $dataMail['logoPath'] = $logoPath;
        $dataMail['to_first_name'] = $toUser['first_name'];
        $dataMail['from_first_name'] = $fromUser['first_name'];
        if(($fileType != '') && ($fileType == 1)){
            $dataMail['message'] = 'an attachment';
        }else{
            $dataMail['message'] = $request->input('message');
        }
        
        Mail::to($toUser['email'])->send(new NotificationMessage($dataMail));
        return $message_id;
    }

    public function changeStatus($id){
        $data['seen_status'] = 1;
        $message = $this->notification->update($data,$id);
        return $message;
    }

    /**
     * Function to delete message from user logged in end
     * @param Request $request
     */
    public function deleteMsgFrom($request)
    {
        $userId = Auth::user()->id;
        $chatingUserId = $request->input('message_id');
        $history = $this->getChatHistoryBetwnUsers($userId,$chatingUserId);
        if($history->isNotEmpty()){
            foreach ($history as $key => $row) {
                    
                    $conditions =  array();
                    $data = array();
                    if($row->user_from_id == $userId){
                        $conditions[] = ['user_from_id',$userId];
                        $conditions[] = ['user_to_id',$chatingUserId];
                        $data['deleted_from'] = 1;
                        $this->message->updateMultipleRows($data,$conditions);
                    }else if($row->user_to_id == $userId)
                    {
                        $conditions[] = ['user_from_id',$chatingUserId];
                        $conditions[] = ['user_to_id',$userId];
                        $data['deleted_to'] = 1;
                        $this->message->updateMultipleRows($data,$conditions);
                    }
                    
            }
        }
               
    }
    /**
     * Function to block/unblock message from user logged in end
     * @param Request $request
     * @return boolean $isUnblocked
     */
    public function blockUnblockContactMsg($request)
    {
        $data = array();        
        $userId = Auth::user()->id; 
        $chatingUserId = $request->input('message_id');
        $data['blocked_by'] =  $userId; 
        $data['blocked_user_id'] =  $chatingUserId;
        $isBlocked = $this->getBlockStatus(Auth::user()->id,$chatingUserId);
        if($isBlocked){//blocked
             $conditions[] = ['blocked_by','=',Auth::user()->id];
             $conditions[] = ['blocked_user_id','=',$chatingUserId];
             $this->blockMessage->deleteRows($conditions);  
            $conditions = array(); 
            $conditions[] = ['user_from_id',$userId];
            $conditions[] = ['user_to_id',$chatingUserId];
            $data = array();
            $data['blocked_by'] = 0;
            $data['blocked_to'] = 0;
            $this->message->updateMultipleRows($data,$conditions);
            $conditionsOr[] = ['user_from_id',$chatingUserId];
            $conditionsOr[] = ['user_to_id',$userId];
            $this->message->updateMultipleRows($data,$conditionsOr);
            $isUnblocked = true; 
        }else{
             $this->blockMessage->create($data);
             $isUnblocked = false;
        }
        return $isUnblocked;
    }
    /**
     * Function to get block status from user1 to users2
     * @param integer $loggedUser
     * @param integer $selectedUser
     * @return boolean $isBlocked
     */
    public function getBlockStatus($loggedUser,$selectedUser)
    {
        $isBlocked = false;
        $conditions[] = ['blocked_by','=',$loggedUser];
        $conditions[] = ['blocked_user_id','=',$selectedUser];
        $blockedInfo = $this->blockMessage->findSingleRow($conditions);
        if($blockedInfo){
            $isBlocked = true;
        }
        return $isBlocked;
    }
    /**
     * Function to store message files
     * @param Request $request
     * @return array $upload
     */
    public function storMsgFiles($request)
    {
        $upload = array();
        if($request->file('image')){
            $file   =   $request->file('image');
            $name   =    'message_'.time().'.'.$file->getClientOriginalExtension();
            $dataForUpload['uploads_type'] = 'image';
        }else{
            $file   =   $request->file('fileupload');
            $name   =    'message_'.time().'.'.$file->getClientOriginalExtension();
            if(!in_array($file->getClientOriginalExtension(), ['jpg','jpeg','png'])){
                $dataForUpload['uploads_type'] = 'file';
            }else{
                $dataForUpload['uploads_type'] = 'image';
            }
            
        }
        $target_path   =   public_path().'/upload/message';
        $userSelectedId =  $request->input('selected_user_id');
        $fileTyp = 1;
        $message_id = $this->storeMsg($request,$userSelectedId,$fileTyp);
        $s3upload = Storage::disk('s3')->put('/'.$name, file_get_contents($file),'private');
        if($s3upload) {
            $dataForUpload['name'] = $name;
            $dataForUpload['type'] = 'message';
            $dataForUpload['type_id'] = $message_id;
            $dataForUpload['org_name'] = $file->getClientOriginalName();
            $dataForUpload['user_id'] = Auth::user()->id;
            $dataForUpload['description'] = 'message uploads';
            $dataForUpload['location'] = env('AWS_IMG_VIEW_URL').$name;
            $upload = $this->uploadRepository->create($dataForUpload);            
        }
         return $upload;
    }

    /**
     * Function to delete message from user logged in end
     * @param Request $request
     */
    public function removeMessage($request)
    {
        $messageId = $request->input('messageId');
        $condition = [];
        $condition['type'] = 'message';
        $condition['type_id'] = $messageId;
        $uploadData = $this->uploadRepository->findSingleRow($condition);
        if(!empty($uploadData)){
            if(Storage::disk('s3')->exists('/'.$uploadData['name'])){
                Storage::disk('s3')->delete('/'.$uploadData['name']);
            }
            $this->uploadRepository->delete($uploadData['id']);
        }
        $this->message->delete($messageId);
        return 1;
    }

    /**
     * Function to get block status from user1 to users2
     * @param integer $loggedUser
     * @param integer $selectedUser
     * @return boolean $isBlocked
     */
    public function getSelectedUserStatus($selectedUser)
    {
        $cond['id'] = $selectedUser;
        $userStatus = $this->user->findSingleRow($cond);
        return $userStatus;
    }

    public function getNotificationDetail($notifyId){
        $condition = [['id',$notifyId]];
        $relations = ['post'];
        $userNotification = $this->notification->showWith($condition,$relations);
        //dd($userNotification);
        if($userNotification['post'] == null){
            return 0;
        } else{
            return 1;
        }
    }
}