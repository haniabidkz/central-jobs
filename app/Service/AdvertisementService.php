<?php
namespace App\Service;
use App\Repository\CommonRepository;
use App\Http\Model\Advertisements;
use Illuminate\Support\Facades\Auth;

class AdvertisementService {
    
    protected $advertisements;

   
    public function __construct(
        Advertisements $advertisements
    ) {
        //$this->advertisements = $advertisements;
        $this->advertisements = new CommonRepository($advertisements);
    }

    /** 
     * Get All category List
    */
    public function fetchList() {
        $data = Advertisements::orderBy("id","DESC")->paginate(env('ADMIN_PAGINATION_LIMIT'));
        return $data;
    }

    
    public function addAdvertisement($request) {
        $insertArr = [];
        if($file   =   $request->file('image_name')) {
            $name  =   time().'.'.$file->getClientOriginalExtension();
            $target_path   =   public_path().'/upload/advertise_image';
            if($file->move($target_path, $name)) {
                $insertArr['image_name'] = $name;
            }
        }
        $insertArr['url'] = $request['url'];
        $insertArr['status'] = $request['status'];
        $data = Advertisements::create($insertArr);
        return $data;
    }

    public function details($id){
        $data = Advertisements::where('id',$id)->get()->first();
        return $data;
    }

    public function updateDetails($request){
        $id = $request['id'];
        $oldData = Advertisements::where('id',$id)->get()->first();
        $insertArr = [];
        if($file   =   $request->file('image_name')) {
            $name  =   time().'.'.$file->getClientOriginalExtension();
            $target_path   =   public_path().'/upload/advertise_image';
            if($file->move($target_path, $name)) {
                $insertArr['image_name'] = $name;
                if(file_exists(public_path().'/upload/advertise_image/'.$oldData['image_name'])){
                    unlink(public_path().'/upload/advertise_image/'.$oldData['image_name']);
                }
            }
        }
        $insertArr['url'] = $request['url'];
        $insertArr['status'] = $request['status'];
        $data = Advertisements::where('id', $id)->update($insertArr);
        return $data;
    }

    public function advertiseDestroy($id){
        $oldData = Advertisements::where('id',$id)->get()->first();
        $data = Advertisements::findOrFail($id);
        $data->delete();
        if(file_exists(public_path().'/upload/advertise_image/'.$oldData['image_name'])){
            unlink(public_path().'/upload/advertise_image/'.$oldData['image_name']);
        }
        return $data;  
    }

    /** 
     * Fetch Ambassador Details of a specific ID
     * @param $request 
     * @return array $profile
    */
    public function changeStatus($request)
    {
        $updateData = [];
        if($request['status'] == 0){
            $updateData['status'] = 1;
        }else{
            $updateData['status'] = 0;
        }
        $id = $request['id'];
        $catData = Advertisements::where('id',$id)->update($updateData);
        return $catData;       
    }
    

}