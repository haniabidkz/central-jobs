<?php
namespace App\Service;
use App\Repository\CommonRepository;
use App\Http\Model\Upload;
use Illuminate\Http\Request;
use Validator;
use File;
use Response;
use Auth;
use Illuminate\Support\Facades\Storage;

class UploadService {
    
    protected $upload;
    public function __construct(Upload $upload)
    {
        $this->uploadRepository = new CommonRepository($upload);
    }

    public function destroy($id)
    {
        $data = $this->uploadRepository->show($id);
        $returndata = $this->uploadRepository->delete($id);
        if($returndata){
            if(file_exists(public_path().'/upload/banner_image/'.$data['name'])){
              unlink(public_path().'/upload/banner_image/'.$data['name']);
            }
        }
        return $returndata;
    }
   /**
    * Function to create folder
    * 
    */
   public function createDirecrotory($path)
   {
        $status = false;
        // demo path : "upload/banner_image"
        $path = public_path($path);
        if(!File::isDirectory($path)){
            $status = File::makeDirectory($path, 0777, true, true);
        }
        if(File::exists($path)){
            $status = true;
        }        
        return $status;
    }
   public function file_upload($directory,$file_prefix,$request)
   {

        $input = $request->all();
        $rules = array(
            'file.*' => 'required|file|max:5000|mimes:pdf,docx,doc',
        );

        $validation = Validator::make($input, $rules);

        if ($validation->fails())
        {
            return Response::make($validation->errors->first(), 400);
        }
        
        $file = $request->file('file');    
        $org_name = $file->getClientOriginalName();   
        $extension = $file->extension();       
        $filename  = $file_prefix.'_'.time().".{$extension}";
        $upload_success = $file->storeAs($directory,$filename);
        $response = ['file_name' => $filename,"org_name"=> $org_name ,"success" => $upload_success,'path' => $directory];       
        return $response;
    }
    public function other_doc_upload($directory, $file_prefix, $request, $key)
    {
        $input = $request->all();
        $rules = array(
            'additional_doc.*' => 'required|file|max:5000|mimes:pdf,docx,doc',
        );

        $validation = Validator::make($input, $rules);

        if ($validation->fails())
        {
            return Response::make($validation->errors->first(), 400);
        }
        
        $file = $request->file('additional_doc')[$key];    
        $org_name = $file->getClientOriginalName();   
        $extension = $file->extension();       
        $filename  = $file_prefix.'_'.time().".{$extension}";
        $upload_success = $file->storeAs($directory,$filename);
        $response = ['file_name' => $filename,"org_name"=> $org_name ,"success" => $upload_success,'path' => $directory];       
        return $response;
    }
    public function intro_video_upload($directory,$file_prefix,$request)
   {

        // $input = $request->all();
        // $rules = array(
        //     'file.*' => 'required|file|max:5000|mimes:pdf,docx,doc',
        // );

        // $validation = Validator::make($input, $rules);

        // if ($validation->fails())
        // {
        //     return Response::make($validation->errors->first(), 400);
        // }
       
        $file = $request->file('file');  
        $extension = "mp4";       
        $filename  = $file_prefix.'_'.time().".{$extension}";
        $org_name  =  $filename;
        $upload_success = $request->file->storeAs($directory,$filename);
        $response = ['file_name' => $filename,"org_name"=> $org_name ,"success" => $upload_success,'path' => $directory];       
        return $response;
    }
    /**
     * Function to insert uploads profile row
     * @param array $options  
     * @param string $uploadsPath
     */
    public function createUploadsProfile($options)
    {
         $data = [
                    'name' => $options['file_name'],
                    'uploads_type' => $options['uploads_type'],
                    'user_id'      => $options['user_id'],
                    'description'  =>  $options['description'],
                    'location'     =>  $options['location'],  
                    'org_name'     =>  $options['org_name'],                    
                    'type_id'      =>  $options['type_id'],  
                    'type'         =>  $options['type'],  
                    'job_id'       =>  isset($options['job_id']) ? $options['job_id'] : NULL,
                ];   
        return $this->uploadRepository->create($data);
    }
    /**
     * function to remove uploads
     * @param string $type
     * @param integer $typeId
     */
    public function removeUploads($type,$typeId)
    {        
        $conditions [] = ['type_id',$typeId];
        $conditions [] = ['type','=',$type];
        $uploadInfo =  $this->uploadRepository->findSingleRow($conditions);
        if($uploadInfo){
            $this->destroy($uploadInfo->id);
        }
        
    }
    /**
     * Function to remove banner of user
     * @param Illuminate\Http\Request $request
     * @return json $response
     */
    public function deleteBannerImg()
    {
        $status = $this->removeUploads('banner_img',Auth::user()->id);
        $response = Response::json('success', 200);
         return $response;
    }
    /**
     * Function to remove profile img of user
     * @param Illuminate\Http\Request $request
     * @return json $response
     */
    public function deleteProfileImg()
    {
        $status = $this->removeUploads('profile_img',Auth::user()->id);
        $response = Response::json('success', 200);
        return $response;
    }
    /**
     * Function to get all library images by MyHR
     * @return array $imgLibrary
     */
    public function getMyhrLibImgs()
    {
        $conditions [] = ['type','=','image_library'];
        $imgLibrary = $this->uploadRepository->getAll($conditions);
        if($imgLibrary){
            $imgLibrary = $imgLibrary->toArray();
        }else{
            $imgLibrary = false;
        }   
        return $imgLibrary;     
    }
    /**
     * Function to get only lib img names
     * @return array $imgLibraryNames
     */
    public function getImglibNames()
    {
        $imgLibNames = $this->getMyhrLibImgs();
        $names = false;
        if(!empty($imgLibNames)){
            foreach ($imgLibNames as $key => $row) {
                     $names[] = $row['org_name'];
            }
        }
        return $names;
    }
    /**
     * Function to insert uploads post image
     * @param array $options  
     * @param string $uploadsPath
     */
    public function createUploadsPost($options)
    {
         $data = [
                    'name' => $options['file_name'],
                    'uploads_type' => $options['uploads_type'],
                    'user_id'      => $options['user_id'],
                    'description'  =>  $options['description'],
                    'location'     =>  $options['location'],  
                    'org_name'     =>  $options['org_name'],                    
                    'type_id'      =>  $options['type_id'],  
                    'type'         =>  $options['type'],  
                ];   
        return $this->uploadRepository->create($data);
    }
     /**
     * Function to remove post video/image
     * @return integer $postId
     */
    public function deletePostStuff($postId)
    {
        $conditions [] = ['type_id','=',$postId];
        $conditions [] = ['type','=','post'];
        $returndata = false;
        $data = $this->uploadRepository->findSingleRow($conditions);
        if($data){
            $data = $data->toArray();
            $returndata = $this->uploadRepository->delete($data['id']);
            if($returndata){
                if(Storage::disk('s3')->exists('/'.$data['name'])){
                    Storage::disk('s3')->delete('/'.$data['name']);
                }
            }
        }
        
        return $returndata;
    }

     
}