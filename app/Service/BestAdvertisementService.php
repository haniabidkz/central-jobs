<?php
namespace App\Service;
use App\Repository\CommonRepository;
use App\Http\Model\BestAdvertisements;
use Illuminate\Support\Facades\Auth;

class BestAdvertisementService {
    
    protected $bestAdvertisements;

   
    public function __construct(
        BestAdvertisements $bestAdvertisements
    ) {
        //$this->advertisements = $advertisements;
        $this->bestAdvertisements = new CommonRepository($bestAdvertisements);
    }

    /** 
     * Get All category List
    */
    public function fetchList() {
        $data = BestAdvertisements::orderBy("id","DESC")->paginate(env('ADMIN_PAGINATION_LIMIT'));
        return $data;
    }

    
    public function add($request) {
        $insertArr = [];
        $insertArr['initial_text'] = $request['initial_text'];
        $insertArr['position'] = $request['position'];
        $insertArr['requirment'] = $request['requirment'];
        $insertArr['ref_no'] = $request['ref_no'];
        $insertArr['status'] = $request['status'];
        $data = BestAdvertisements::create($insertArr);
        return $data;
    }

    public function details($id){
        $data = BestAdvertisements::where('id',$id)->get()->first();
        return $data;
    }

    public function updateDetails($request){
        $id = $request['id'];
        $oldData = BestAdvertisements::where('id',$id)->get()->first();
        $insertArr['initial_text'] = $request['initial_text'];
        $insertArr['position'] = $request['position'];
        $insertArr['requirment'] = $request['requirment'];
        $insertArr['ref_no'] = $request['ref_no'];
        $insertArr['status'] = $request['status'];
        $data = BestAdvertisements::where('id', $id)->update($insertArr);
        return $data;
    }

    public function destroy($id){
        $oldData = BestAdvertisements::where('id',$id)->get()->first();
        $data = BestAdvertisements::findOrFail($id);
        $data->delete();
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
        $catData = BestAdvertisements::where('id',$id)->update($updateData);
        return $catData;       
    }
    
    public function getBestAdvertise()
    {
        $data = BestAdvertisements::where('status', 1)->orderBy("id","DESC")->limit(4)->get();
        return $data;
    }

}