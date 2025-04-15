<?php
namespace App\Service;
use App\Repository\CommonRepository;
use App\Repository\UserRepository;
use App\Repository\PostRepository;
use Illuminate\Support\Facades\Auth;
use App\Service\UploadService;
use App\Http\Model\Country;
use App\Http\Model\Post;
use App\Http\Model\CommonComment;
use App\Http\Model\ReportedPost;
use DB;
use File;
use App\Http\Model\JobPost;
use App\Http\Model\JobApplied;
use App\Http\Model\PostState;
use App\Http\Model\UserPostLike;
use App\Http\Model\UserConnection;
use App\Http\Model\UserBlock;
use App\Http\Model\BlockMessage;
use App\Http\Model\Notification;
use App\Http\Model\Message;
use App\Http\Model\User;
use App\Mail\ConnectionRequestNotification;
use Illuminate\Support\Facades\Mail;
use App\Http\Model\UserPostShare;
use App\Mail\PostReportNotification;
use Illuminate\Support\Facades\Storage;

use Response;

class PostService {
    
    protected $postRepo;
    protected $userRepo;
    protected $postModel;
    protected $uploadService;
    protected $jobPost;
    protected $userPostLike;
    protected $commonComment;
    protected $reportedPost;
    protected $postState;
    protected $userConnection;
    protected $notification;
    protected $user;
    protected $userPostShare;
    protected $userBlock;
    protected $blockMessage;
    protected $message;
    /**
     * @param PostRepository $candidateRepo reference to postRepository
     * @param UserRepository $userRepo reference to userRepo
     */
    public function __construct(
        PostRepository $postRepo,
        UserRepository $userRepo,
        UploadService $uploadService,
        JobPost $jobPost,
        UserPostLike $userPostLike,
        CommonComment $commonComment,
        ReportedPost $reportedPost,
        PostState $postState,
        UserConnection $userConnection,
        Notification $notification,
        User $user,
        UserPostShare $userPostShare,
        UserBlock $userBlock,
        BlockMessage $blockMessage,
        Message $message
    ) {
        $this->postRepo  =  $postRepo;
        $this->userRepo  =  $userRepo;
        $this->uploadService = $uploadService;
        $this->jobPost = new CommonRepository($jobPost);
        $this->userPostLike = new CommonRepository($userPostLike);
        $this->commonCommentRepository = new CommonRepository($commonComment);
        $this->reportedPostRepository = new CommonRepository($reportedPost);
        $this->postState = new CommonRepository($postState);
        $this->userConnection = new CommonRepository($userConnection);
        $this->notification = new CommonRepository($notification);
        $this->user = new CommonRepository($user);
        $this->userPostShare = new CommonRepository($userPostShare);
        $this->userBlock = new CommonRepository($userBlock);
        $this->blockMessage = new CommonRepository($blockMessage);
        $this->message = new CommonRepository($message);
    }

    /** 
     * Get All Candidate List
    */
    public function fetchList() {
        return $this->postRepo->get();
    }

    /** 
     * Get Details of post with ID
     * @param array $id
    */
    public function details($id){
        return $this->postRepo->findOne([ ["id",$id] ]);
    }

    /** 
     * job update
     * @param array $id job id
    */
    public function updateDetails($id='',$request=''){
        $dataForUpload = [];
        $data = $request->all();
        
        if($data['category_id'] == 1){
            $data['country_id'] = $data['cntrId'];
            $data['description'] = $data['description_job'];
            $data['title'] = $data['title_job'];
            
        }
        elseif($data['category_id'] == 2){
            $data['description'] = $data['description_text'];
            $data['title'] = $data['title_text'];
        }
        elseif($data['category_id'] == 3){
            $data['description'] = $data['description_img'];
            $data['title'] = $data['title_img'];
            //image upload
            if($file   =   $request->file('image')) {
                $name  =   time().'.'.$file->getClientOriginalExtension();
                $target_path   =   public_path().'/upload/'.$data['user_id'];
                if($file->move($target_path, $name)) {
                    $dataForUpload['name'] = $name;
                    $dataForUpload['type'] = 'post';
                    $dataForUpload['uploads_type'] = 'image';
                    $dataForUpload['description'] = 'image post';
                    $dataForUpload['location'] = '/upload/'.$data['user_id'].'/'.$name;
                }
            }
            
        }
        elseif($data['category_id'] == 4){
            $data['description'] = $data['description_vdo'];
            $data['title'] = $data['title_vdo'];
            $dataForUpload['name'] = $data['video'];
            $dataForUpload['type'] = 'post';
            $dataForUpload['uploads_type'] = 'video';
            $dataForUpload['description'] = 'video post';
        }
       
        unset($data['video']);
        unset($data['image']);
        unset($data['_token']);
        unset($data['cntrId']);
        unset($data['description_vdo']);
        unset($data['description_job']);
        unset($data['description_img']);
        unset($data['description_text']);
        unset($data['title_job']);
        unset($data['title_text']);
        unset($data['title_vdo']);
        unset($data['title_img']);
       
        return $this->postRepo->updateDetails($id,$data,$dataForUpload);
    }

    public function postAdd($request = ''){
        $data = [];
        $dataForUpload = [];
        //$user_id = Auth::user()->id;
        $data = $request->all();
       
        //$data['user_id'] = $user_id;
        $data['status'] = 1;
        
        if(isset($data['cntrId'])){
            $data['country_id'] = $data['cntrId'];
            unset($data['cntrId']);
        }
        if(isset($data['description_job'])){
            $data['description'] = $data['description_job'];
            $data['title'] = $data['title_job'];
            unset($data['title_job']);
            unset($data['description_job']);
        }
        elseif(isset($data['description_text'])){
            $data['description'] = $data['description_text'];
            $data['title'] = $data['title_text'];
            unset($data['title_text']);
            unset($data['description_text']);
        }
        elseif(isset($data['description_img'])){
            $data['title'] = $data['description_img'];
            $data['title'] = $data['title_img'];
            unset($data['title_img']);
            unset($data['description_img']);
            //image upload
            if($file   =   $request->file('image')) {
                $name  =   time().'.'.$file->getClientOriginalExtension();
                $target_path   =   public_path().'/upload/'.$data['user_id'];
                if($file->move($target_path, $name)) {
                    $dataForUpload['name'] = $name;
                    $dataForUpload['type'] = 'post';
                    $dataForUpload['uploads_type'] = 'image';
                    $dataForUpload['user_id'] = $data['user_id'];
                    $dataForUpload['description'] = 'image post';
                    $dataForUpload['location'] = '/upload/'.$data['user_id'].'/'.$name;
                }
            }
            
        }
        elseif(isset($data['description_vdo'])){
            $data['title'] = $data['description_vdo'];
            $data['title'] = $data['title_vdo'];
            unset($data['title_vdo']);
            unset($data['description_vdo']);
            $dataForUpload['name'] = $data['video'];
            $dataForUpload['type'] = 'post';
            $dataForUpload['uploads_type'] = 'video';
            $dataForUpload['user_id'] = $data['user_id'];
            $dataForUpload['description'] = 'video post';
        }
        
        $postData = $this->postRepo->postAdd($data,$dataForUpload);
        
    }
   /**
    * Funtion to store text post
    * @param Illuminate\Http\Request $request
    * @return 
    */
   public function storeTextPost($request)
   {
        $data['description'] = $request->input('description');
        $data['user_id'] = Auth::user()->id;
        $data['title'] = '';
        $data['status'] = 1;
        $data['category_id'] = 2;//text
        $data['description'] = $request->input('description');
        return Post::create($data);
   }
   /**
    * Funtion to store image post
    * @param Illuminate\Http\Request $request
    * @return 
    */
   public function storeImageVideoPost($request,$postType='image')
   {

        $image = $request->file;  // your base64 encoded
        $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];

        $replace = substr($image, 0, strpos($image, ',')+1); 

        // find substring fro replace here eg: data:image/png;base64,
         $image = str_replace($replace, '', $image); 
         $image = str_replace(' ', '+', $image); 

         if($extension == 'x-ms-wmv'){
             $extension = "wmv";
         }
       // $path = public_path().'\upload\post\/';//windows
        if($postType == 'image'){
            $path = public_path().'/upload/post/images/';//linux
            $imageName = 'post_image_'.time().'.'.$extension;
            $options['location']  = '/upload/post/images/';
            $options['uploads_type'] = 'image';
            $data['category_id'] = 3;//image
            $options['description'] = 'Post image is uploaded';
        }else{
            $path = public_path().'/upload/post/videos/';//linux 
            $imageName = 'post_video_'.time().'.'.$extension;
            $options['location']  = '/upload/post/videos/';
            $options['uploads_type'] = 'video';
            $data['category_id'] = 4;//video
            $options['description'] = 'Post video is uploaded';
        }
       // $path = str_replace('/','\\', $path) ;      
        $uploadWithInfo = $path.$imageName;
        //create path folder if not exists
        $this->uploadService->createDirecrotory($path);
        //dd($path);
        //insert post data
        $data['title'] = $request->input('title');
        $data['user_id'] = Auth::user()->id;
        $data['description'] = '';
        $data['status'] = 1;
        
        $data['description'] = '';
        $inserted = Post::create($data);
        //insert post image
        $options['name'] = $imageName;
        $options['file_name'] = $imageName;
        
        $options['user_id']  = Auth::user()->id;
       
        
        $options['org_name']  = $imageName;
        $options['type_id']   = $inserted->id;
        $options['type']  = 'post';
       
        File::put($uploadWithInfo, base64_decode($image));
        $this->uploadService->createUploadsPost($options);
        
   }

   /**
    * Funtion to store image post
    * @param Illuminate\Http\Request $request
    * @return 
    */
    public function storeAnyTypePost($request)
    {
        //dd($request->file);
        $postType = 2;
        if($request->file != null){
            $validePostImageType = ['jpeg','png','jpg'];
            $validePostVideoType = ['mp4','mpeg','wmv','mpg'];
            $image = $request->file;  // your base64 encoded
            $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
    
            $replace = substr($image, 0, strpos($image, ',')+1); 
    
            // find substring fro replace here eg: data:image/png;base64,
             $image = str_replace($replace, '', $image); 
             $image = str_replace(' ', '+', $image); 
    
             if($extension == 'x-ms-wmv'){
                 $extension = "wmv";
             }
             if(in_array($extension, $validePostImageType)){
                $postType = 3;
             }
             else if(in_array($extension, $validePostVideoType)){
                $postType = 4;
             }
             else{
                $postType = 2;
             }


        }
         
        // $path = public_path().'\upload\post\/';//windows
         if($postType == 3){
             $path = public_path().'/upload/post/images/';//linux
             $imageName = 'post_image_'.time().'.'.$extension;
             $options['location']  = env('AWS_IMG_VIEW_URL');
             $options['uploads_type'] = 'image';
             $data['category_id'] = 3;//image
             $options['description'] = 'Post image is uploaded';
             // $path = str_replace('/','\\', $path) ;      
            $uploadWithInfo = $path.$imageName;
            //create path folder if not exists
            $this->uploadService->createDirecrotory($path);
            $data['title'] = $request->input('title');
            //dd($path);
         }else if($postType == 4){
             $path = public_path().'/upload/post/videos/';//linux 
             $imageName = 'post_video_'.time().'.'.$extension;
             $options['location']  = env('AWS_IMG_VIEW_URL');
             $options['uploads_type'] = 'video';
             $data['category_id'] = 4;//video
             $options['description'] = 'Post video is uploaded';
             // $path = str_replace('/','\\', $path) ;      
             $uploadWithInfo = $path.$imageName;
             //create path folder if not exists
             $this->uploadService->createDirecrotory($path);
             $data['title'] = $request->input('title');
             //dd($path);
         }else{
            $data['category_id'] = 2;
            $data['description'] = $request->input('title');
            $options['description'] = $request->input('title');
         }
        
         //insert post data
         
         $data['user_id'] = Auth::user()->id;
         $data['status'] = 1;
         
         $inserted = Post::create($data);
         if($postType != 2){
            //insert post image
            
            $options['name'] = $imageName;
            $options['file_name'] = $imageName;
            
            $options['user_id']  = Auth::user()->id;
            
            
            $options['org_name']  = $imageName;
            $options['type_id']   = $inserted->id;
            $options['type']  = 'post';
            
            //File::put($uploadWithInfo, base64_decode($image));
            $path = Storage::disk('s3')->put('/'.$imageName, base64_decode($image),'private');
            $this->uploadService->createUploadsPost($options);
         }
         
         
    }
    /**
    * Function to view post
    * @param Illuminate\Http\Request $request
    * @return array obj $candidatePost
    */
    public function getPostDetails($id){        
        $condition = [['status','=',1],['id','=',$id]];
        $relations = ['user','upload','likes','comments','postState'];
        $candidatePost = $this->jobPost->showWith($condition,$relations);
        return $candidatePost;
    }

    /**
     * Function to report comment 
     * @param Illuminate\Http\Request $request
     * @return json $response
     */
    public function postLike($request) {
        $id = $request['post_id'];
        $status = $this->chkUserPostStatus($id);
        if($status == 0){
            $response = Response::json('error', 400);
            return $response;
        }
        $total = $request['like'];
        $userId = Auth::user()->id;
        $condition['user_id'] = $userId;
        $condition['post_id'] = $id;
        $isdata = $this->userPostLike->findSingleRow($condition);
        if($isdata){
            $like = $this->userPostLike->delete($isdata['id']);
            if($total > 0){
                $total--;
            }
        }else{
            $insertData = [];
            $insertData['post_id'] = $id;
            $insertData['user_id'] = $userId;
            $like = $this->userPostLike->create($insertData);
            $total++;
            if($like){
                $conditions[] = ['id','=',$id];
                $with = 'user';
                $postUser = $this->jobPost->showWith($conditions,$with);
                if($userId != $postUser['user_id']){
                    $notification = [];
                    $notification['type'] = 'like';
                    if($postUser['user']['user_type'] == 2){
                        if($postUser['category_id'] == 1){
                            $notification['redirect_link'] = 'candidate/view-job-post/'.encrypt($id);
                        }else{
                            $notification['redirect_link'] = 'candidate/view-post/'.encrypt($id);
                        }
                        
                    }else if($postUser['user']['user_type'] == 3){
                        if($postUser['category_id'] == 1){
                            $notification['redirect_link'] = 'company/view-job-post/'.encrypt($id);
                        }else{
                            $notification['redirect_link'] = 'company/view-post/'.encrypt($id);
                        }
                        
                    }
                    $notification['type_id'] = $like->id;
                    $notification['from_user_id'] = $userId;
                    $notification['to_user_id'] = $postUser['user_id'];
                    $this->notification->create($notification);
                }
                
                
                // $imgPath = env('APP_URL').'public/backend/dist/img/user.png'; 
                // $logoPath = env('APP_URL').'public/frontend/images/logo-color.png';   
                // $dataMail['imgPath'] = $imgPath;
                // $dataMail['logoPath'] = $logoPath;
                // $conditions[] = ['id','=',1];
                // $toUser = $this->user->findSingleRow($conditions);
                // $dataMail['first_name'] = $toUser['first_name'];
                // $dataMail['from_first_name'] = Auth::user()->first_name;
                // Mail::to($toUser['email'])->send(new CommentPostNotification($dataMail));
            }
        }
        
        // if($like){
        //     $response = Response::json('success', 200);
        // }else{
        //     $response = Response::json('error', 400);
        // }
        return $total;
        
    }

    /**
     * Function to report comment 
     * @param Illuminate\Http\Request $request
     * @return json $response
     */
    public function postComment($request) {
        $id = $request['post_id'];

        $status = $this->chkUserPostStatus($id);
        if($status == 0){
            $response = Response::json('error', 400);
            return $response;
        }
        $userId = Auth::user()->id;
        $insertData = [];
        $insertData['type'] = 'post';
        $insertData['type_id'] = $id;
        $insertData['comment'] = $request['comment'];
        $insertData['status'] = 1;
        $insertData['user_id'] = $userId;
        $comment = $this->commonCommentRepository->create($insertData);
        if($comment){
            $conditions[] = ['id','=',$id];
            $with = 'user';
            $postUser = $this->jobPost->showWith($conditions,$with);
            if($userId != $postUser['user_id']){
            $notification = [];
            $notification['type'] = 'comment';
            if($postUser['user']['user_type'] == 2){
                if($postUser['category_id'] == 1){
                    $notification['redirect_link'] = 'candidate/view-job-post/'.encrypt($id);
                }else{
                    $notification['redirect_link'] = 'candidate/view-post/'.encrypt($id);
                }
                
            }else if($postUser['user']['user_type'] == 3){
                if($postUser['category_id'] == 1){
                    $notification['redirect_link'] = 'company/view-job-post/'.encrypt($id);
                }else{
                    $notification['redirect_link'] = 'company/view-post/'.encrypt($id);
                }
                
            }
            $notification['type_id'] = $comment->id;
            $notification['from_user_id'] = $userId;
            $notification['to_user_id'] = $postUser['user_id'];
            $this->notification->create($notification);
            }
            // $imgPath = env('APP_URL').'public/backend/dist/img/user.png'; 
            // $logoPath = env('APP_URL').'public/frontend/images/logo-color.png';   
            // $dataMail['imgPath'] = $imgPath;
            // $dataMail['logoPath'] = $logoPath;
            // $conditions[] = ['id','=',1];
            // $toUser = $this->user->findSingleRow($conditions);
            // $dataMail['first_name'] = $toUser['first_name'];
            // $dataMail['from_first_name'] = Auth::user()->first_name;
            // Mail::to($toUser['email'])->send(new CommentPostNotification($dataMail));
            $response = Response::json('success', 200);
        }else{
            $response = Response::json('error', 400);
        }
        return $response;
        
    }

    /**
     * Function to report comment 
     * @param Illuminate\Http\Request $request
     * @return json $response
     */
    public function reportPost($request) {
        $id = $request['post_id'];
        $status = $this->chkUserPostStatus($id);
        if($status == 0){
            $response = Response::json('error', 400);
            return $response;
        }
        $condition[] = ['id','=',$id];
        $relation = ['user'];
        $postDetails = $this->jobPost->showWith($condition,$relation);
        $userId = Auth::user()->id;
        $insertData = [];
        $insertData['type'] = 'post';
        $insertData['type_id'] = $id;
        $insertData['comment'] = $request['comment'];
        $insertData['status'] = 0;
        $insertData['user_id'] = $userId;
        $report = $this->reportedPostRepository->create($insertData);
        if($report){
            $notification = [];
            $notification['type'] = 'report';
            $notification['type_id'] = $report->id;
            $notification['from_user_id'] = $userId;
            $notification['to_user_id'] = 1;
            $this->notification->create($notification);
            
            $imgPath = env('APP_URL').'public/backend/dist/img/user.png'; 
            $logoPath = env('APP_URL').'public/frontend/images/logo-color.png';   
            $dataMail['imgPath'] = $imgPath;
            $dataMail['logoPath'] = $logoPath;
            $conditions[] = ['id','=',1];
            $toUser = $this->user->findSingleRow($conditions);
            $dataMail['first_name'] = $toUser['first_name'];
            $dataMail['postDetail'] = $postDetails;
            $dataMail['from_first_name'] = Auth::user()->first_name;
            Mail::to($toUser['email'])->send(new PostReportNotification($dataMail));
            $response = Response::json('success', 200);
        }else{
            $response = Response::json('error', 400);
        }
        return $response;
        
    }
    /**
     * Function to report comment 
     * @param Illuminate\Http\Request $request
     * @return json $response
     */
    public function sendConnectionRequest($request) {
        $candidateId = $request['candidate_id'];
        //CHECK USER STATUS
        $chkUserStatus = $this->chkUserStatusForAll($candidateId);
        if($chkUserStatus == 0){
            $response = Response::json('error', 400);
            return $response;
        }
        $fromUserId = Auth::user()->id;
        $insertData = [];
        $insertData['request_sent_by'] = $fromUserId;
        $insertData['request_accepted_by'] = $candidateId;
        $insertData['personal_note'] = $request['comment'];
        $insertData['status'] = 0;
        $sent = $this->userConnection->create($insertData);
        if($sent){
            $notification = [];
            $notification['type'] = 'connection_request';
            $notification['type_id'] = $sent->id;
            $notification['from_user_id'] = $fromUserId;
            $notification['to_user_id'] = $candidateId;
            $this->notification->create($notification);
            
            $imgPath = env('APP_URL').'public/backend/dist/img/user.png'; 
            $logoPath = env('APP_URL').'public/frontend/images/logo-color.png';   
            $dataMail['imgPath'] = $imgPath;
            $dataMail['logoPath'] = $logoPath;
            $conditions[] = ['id','=',$candidateId];
            $toUser = $this->user->findSingleRow($conditions);
            $dataMail['first_name'] = $toUser['first_name'];
            $dataMail['from_first_name'] = Auth::user()->first_name;
            $dataMail['from_last_name'] = Auth::user()->last_name;
            $dataMail['type'] = $notification['type'];
            $dataMail['message'] = $request['comment'];
            Mail::to($toUser['email'])->send(new ConnectionRequestNotification($dataMail));
            $response = Response::json('success', 200);
        }else{
            $response = Response::json('error', 400);
        }
        return $response;
        
    }

    /**
     * Function to report comment 
     * @param Illuminate\Http\Request $request
     * @return json $response
     */
    public function acceptRejectConnection($request) {
        $candidateId = $request['candidate_id'];
        //CHECK USER STATUS
        $chkUserStatus = $this->chkUserStatusForAll($candidateId);
        if($chkUserStatus == 0){
            $response = Response::json('error', 400);
            return $response;
        }

        $tag = $request['tag'];
        $connectionId = $request['connection_id'];
        $fromUserId = Auth::user()->id;
        if($tag == 1){
            // ACCEPTED
            $insertData['status'] = 1;
            $sent = $this->userConnection->update($insertData,$connectionId);
        }else{
            // REJECTED AND REMOVE CONNECTION
            $sent = $this->userConnection->delete($connectionId);
        }
        if($sent && ($tag != 0)){
            $notification = [];
            if($tag == 1){
                $notification['type'] = 'connection_accepted';
            }else if($tag == 2){
                $notification['type'] = 'connection_rejected';
            }
            $notification['type_id'] = $connectionId;
            $notification['from_user_id'] = $fromUserId;
            $notification['to_user_id'] = $candidateId;
            $this->notification->create($notification);
            
            $imgPath = env('APP_URL').'public/backend/dist/img/user.png'; 
            $logoPath = env('APP_URL').'public/frontend/images/logo-color.png';   
            $dataMail['imgPath'] = $imgPath;
            $dataMail['logoPath'] = $logoPath;
            $conditions[] = ['id','=',$candidateId];
            $toUser = $this->user->findSingleRow($conditions);
            $dataMail['first_name'] = $toUser['first_name'];
            $dataMail['from_first_name'] = Auth::user()->first_name;
            $dataMail['from_last_name'] = Auth::user()->last_name;
            $dataMail['type'] = $notification['type'];
            Mail::to($toUser['email'])->send(new ConnectionRequestNotification($dataMail));
            $response = Response::json('success', 200);
        }else{
            $response = Response::json('success', 200);
        }
        return $response;
        
    }

    /**
    * Funtion to store text post
    * @param Illuminate\Http\Request $request
    * @return 
    */
   public function postShare($request)
   { 
        $id = $request->input('post_id');
        $status = $this->chkUserPostStatus($id);
        if($status == 0){
            $response = Response::json('error', 400);
            return $response;
        }
        $userId = Auth::user()->id;
        $data['user_id'] = $userId;
        $data['title'] = '';
        $data['status'] = 1;
        $data['category_id'] = 2;//text
        $data['description'] = $request->input('description');
        $addPostText = $this->jobPost->create($data);
        // ADD SHARE POST
        $share['user_id'] = $userId;
        $share['status'] = 1;
        $share['post_id'] = $addPostText->id;
        $share['reference_post_id'] = $request->input('post_id');
        $addShare = $this->userPostShare->create($share);

        if($addShare){
            $conditions[] = ['id','=',$request->input('post_id')];
            $with = 'user';
            $postUser = $this->jobPost->showWithDeleted($conditions,$with);
            if($userId != $postUser['user_id']){
            $notification = [];
            $notification['type'] = 'share_post';
            if($postUser['user']['user_type'] == 2){
                if($postUser['category_id'] == 1){
                    $notification['redirect_link'] = 'candidate/view-job-post/'.encrypt($request->input('post_id'));
                }else{
                    $notification['redirect_link'] = 'candidate/view-post/'.encrypt($request->input('post_id'));
                }
                
            }else if($postUser['user']['user_type'] == 3){
                if($postUser['category_id'] == 1){
                    $notification['redirect_link'] = 'company/view-job-post/'.encrypt($request->input('post_id'));
                }else{
                    $notification['redirect_link'] = 'company/view-post/'.encrypt($request->input('post_id'));
                }
                
            }
            $notification['type_id'] = $addPostText->id;
            $notification['from_user_id'] = $userId;
            $notification['to_user_id'] = $postUser['user_id'];
            $this->notification->create($notification);
            }
            
        }

        return $addPostText;

   }

   public function chkPostShare($request){
        $userId = Auth::user()->id;
        $postId = $request->input('post_id');
        $cond['user_id'] = $userId;
        $cond['reference_post_id'] = $postId;
        $addShare = $this->userPostShare->findSingleRow($cond);
        return $addShare;
   }

   /**
     * Function to report comment 
     * @param Illuminate\Http\Request $request
     * @return json $response
     */
    public function blockUnblockUser($request) {
        $blockedUserId = $request['user_id'];
        $blockById = Auth::user()->id;

        $userDetails = User::where([['id',$blockedUserId],['status',1]])->get()->first();
        $authUserDetails = User::where([['id',$blockById],['status',1]])->get()->first();
        if(empty($userDetails) || empty($authUserDetails)){
            $response = Response::json('error', 400);
            return $response;
        }

        $tag = $request['tag'];
        $condition['blocked_by'] = $blockById;
        $condition['blocked_user_id'] = $blockedUserId;
        $isdata = $this->userBlock->findSingleRow($condition);
        if((!empty($isdata)) && ($tag == 0)){
            $blockUser = $this->userBlock->delete($isdata['id']);
            $blockMsg = $this->blockMessage->deleteRows($condition);
            $conditions = array(); 
            $conditions[] = ['user_from_id',$blockById];
            $conditions[] = ['user_to_id',$blockedUserId];
            $data = array();
            $data['blocked_by'] = 0;
            $data['blocked_to'] = 0;
            $this->message->updateMultipleRows($data,$conditions);
            $conditionsOr[] = ['user_from_id',$blockedUserId];
            $conditionsOr[] = ['user_to_id',$blockById];
            $this->message->updateMultipleRows($data,$conditionsOr);
        }else{
            $insertData = [];
            $insertData['blocked_by'] = $blockById;
            $insertData['blocked_user_id'] = $blockedUserId;
            $blockUser = $this->userBlock->create($insertData);
            $isdata = $this->blockMessage->findSingleRow($condition);
            if(empty($isdata)){
                $blockMsg = $this->blockMessage->create($insertData);
            }
            
        }
       
        $response = Response::json('success', 200);
        return $response;
        
    }

    public function acceptedBy($userId){
        $acceptedBy = UserConnection::where('request_accepted_by',$userId)->orderBy("id","ASC")->pluck('request_accepted_by')->all();
        return $acceptedBy;
    }

    public function chkUserStatus($userId){
        $user = User::where([['id',$userId],['status',1]])->get()->first();
        if(!empty($user)){
            return 1;
        }else{
            return 0;
        }
        
    }

    public function chkUserStatusForAll($userId){
        $authUserId = Auth::user()->id;
        $userDetails = User::where([['id',$userId],['status',1]])->get()->first();
        $authUserDetails = User::where([['id',$authUserId],['status',1]])->get()->first();
        if(!empty($userDetails) && !empty($authUserDetails)){
            $blockData = UserBlock::where([['blocked_user_id',$authUserId],['blocked_by',$userId]])->orWhere([['blocked_by',$authUserId],['blocked_user_id',$userId]])->get()->toArray();
            if(!empty($blockData)){
                return 0;
            }else{
                return 1;
            }
        }else{
            return 0;
        }
    }

    public function chkUserPostStatus($postId){
        $userId = Auth::user()->id;
        $user = User::where([['id',$userId],['status',1]])->get()->first();
        $post = JobPost::where([['id',$postId],['status',1]])->get()->first();
        //dd($post);
        if(!empty($user) && !empty($post)){
            return 1;
        }else{
            return 0;
        }
        
    }

    public function chkUserJobAppliedStatus($request){
        $jobId = $request['job_id'];
        $userId = Auth::user()->id;
        $post = JobApplied::where([['job_id',$jobId],['user_id',$userId],['applied_status',2]])->get()->first();
        if(!empty($post)){
            return 0;
        }else{
            return 1;
        }
        
    }
    
}