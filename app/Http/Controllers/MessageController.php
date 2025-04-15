<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\Message;
use App\Service\MessageService;
use App\Service\JobService;
use stdClass;
use Illuminate\Support\Facades\Storage;
use Session;
use Auth;
use Aws\S3\S3Client;
use Response;

class MessageController extends Controller
{
    protected $messageServiceData;

    public function __construct(MessageService $messageService)
    {       
        $this->messageService = $messageService; 
       
        $this->middleware('checkMcqScreening', ['except' => array('')]);
        $this->middleware('isCmpnyCandLoggedIn', ['except' => array('')]);
        
    }

    /**
     * Message index page $id
     * @param string $id
     */
    public function index($id,$msgId='',Request $request)
    {
        $userSelectedId = decrypt($id);
        if($msgId != ''){
            $msgId = decrypt($msgId);
            $changeSeenStatus = $this->messageService->changeStatus($msgId);
        }
    	$chatHitory = $this->messageService->getChatHistory();
        $userId = Auth::user()->id;
        $candidateName = '';
        $companyName = '';
        $name = '';
        
        if(!empty($request->all())){
            if(isset($request['candidate_name']) && ($request['candidate_name'] != '')){
                $name = $request['candidate_name'];
                $candidateName = $request['candidate_name'];
            }else if(isset($request['company_name']) && ($request['company_name'] != '')){
                $name = $request['company_name'];
                $companyName = $request['company_name'];
            }
            
        }

        $usersChatHistory = $this->messageService->getUsersDataFromChatHistory($name); 
    	$userChatingInfo  = $this->messageService->getChatingUserInfo($userSelectedId);  
        $userLastChatedData = $this->messageService->chatHistoryUsersData(); 
        
        //MANAGE MESSAGE ORDER AT CONTACT LIST 
        $lastChatArrkey = array_keys($userLastChatedData);
        $result = (object)[];
        $index = 0;
        foreach ($lastChatArrkey as $position) {
           
            foreach($usersChatHistory as $key=>$val){
                if($val['id'] == $position){
                    $result->$index = $val;
                    $index++;
                }
            }
            
        }
        $usersChatHistory = $result;
       
       //MANAGE MESSAGE ORDER AT CONTACT LIST 
        $isSelectedUserBlocked = $this->messageService->getBlockStatus($userId,$userSelectedId);
    	$chatHitoryBtwnUsers = $this->messageService->getChatHistoryBetwnUsers($userId,$userSelectedId);  
       		
    	return view('frontend.messages.index',compact("chatHitory","userId","usersChatHistory","userChatingInfo","userLastChatedData","chatHitoryBtwnUsers","userSelectedId","candidateName","companyName","isSelectedUserBlocked"));
    }

    /**
     * Function to store msg
     * @param string $userId
     */
    public function storeMsg($id,Request $request)
    {    	
        $userSelectedId = decrypt($id);
        $selectedUserStatus = $this->messageService->getSelectedUserStatus($userSelectedId);
       
        if((!empty($selectedUserStatus)) && (($selectedUserStatus['status'] == 0) || ($selectedUserStatus['status'] == 2) || ($selectedUserStatus['deleted_at'] != null))){
            return redirect()->back(); 
        }
    	$request->session()->flash('success-msg', __('messages.YOUR_MESSAGE_IS_SENT_SUCCESSFULLY'));
    	$this->messageService->storeMsg($request,$userSelectedId);
    	return redirect()->back(); 
    }
    /**
     * Function to delete message from one end
     * @param Request $request
     * @return json $response
     */
    public function deleteMsgFrom(Request $request)
    {
        $userId = encrypt(Auth::user()->id);
        $request->session()->flash('success-msg', __('messages.YOUR_MESSAGE_HAS_BEEN_DELETED_SUCCESSFULLY'));
        $this->messageService->deleteMsgFrom($request);
        echo json_encode(["status" =>1,"message" => __('messages.YOUR_MESSAGE_HAS_BEEN_DELETED_SUCCESSFULLY'),'user_type'=>Auth::user()->user_type,'user_id'=> $userId]);
    }
    /**
     * Function to block message from one end
     * @param Request $request
     * @return json $response
     */
    public function blockContactMsg(Request $request)
    {
        $userId = encrypt(Auth::user()->id);
        
        $isUnblocked = $this->messageService->blockUnblockContactMsg($request);
        if($isUnblocked){
             $request->session()->flash('success-msg', __('messages.YOUR_CONTACT_IS_UNBLOCKED_SUCCESSFULLY'));
        }else{
             $request->session()->flash('success-msg', __('messages.YOUR_CONTACT_IS_BLOCKED_SUCCESSFULLY'));
        }
        echo json_encode(["status" =>1,"message" => __('messages.YOUR_BLOCK_UNBLOCK_HAS_BEEN_DONE_SUCCESSFULLY'),'user_type'=>Auth::user()->user_type,'user_id'=> $userId]);
    }
    /**
     * Function to upload message files
     * @param Request $request
     * @return json $response
     */
    public function uploadMsgFileData(Request $request)
    {
       $request->session()->flash('success-msg', __('messages.YOUR_FILE_IS_SENT_SUCCESSFULLY'));
       $upload = $this->messageService->storMsgFiles($request);
        echo json_encode(["successfully"]);
    }

    /**
     * Function to delete message from one end
     * @param Request $request
     * @return json $response
     */
    public function removeMessage(Request $request)
    {
        $data= $this->messageService->removeMessage($request);
        echo $data;
    }

    /**
     * Function to download file
     * @param Request $request
     * @return json $response
     */
    public function downloadMessageFile(Request $request,$file)
    {

        return response()->streamDownload(function () use ($file) {
            //S3 BUCKET IMG
            $adapter = Storage::disk('s3')->getDriver()->getAdapter();       
            $command = $adapter->getClient()->getCommand('GetObject', [
            'Bucket' => $adapter->getBucket(),
            'Key'    => $adapter->getPathPrefix(). '' . $file
            ]);
            $img = $adapter->getClient()->createPresignedRequest($command, '+'.env('AWS_FILE_PATH_EXP_TIME').' minute');
            $path = (string)$img->getUri();
            Header("Content-disposition: attachment; filename=".$file); 
            Header("Content-Type: application/download"); 
            readfile($path);
        }, $file);
            
    }
}
