<?php
namespace App\Service;
use App\Repository\TrainingRepository;
use Illuminate\Support\Facades\Auth;

class TrainingService {
    
    protected $trainingRepo;

    /**
     * @param TrainingRepository $candidateRepo reference to trainingRepo 
     */
    public function __construct(
        TrainingRepository $trainingRepo
    ) {
        $this->trainingRepo = $trainingRepo;
    }

    /** 
     * Get All category List
    */
    public function fetchList($search) {
        return $this->trainingRepo->get($search);
    }

    /** 
     * Add category
    */
    public function categoryAdd($request) {
        $id = Auth::user()->id;
        $data = [];
        $data = $request->all();
        $data['user_id'] = $id;
        $chkname = $this->chkUniqueName($data['name']);
        if($chkname != NULL){
            return 'error';
        }else{
            $categoryData = $this->trainingRepo->categoryAdd($data);
            return $categoryData;
        }
        
    }

     /** 
     * Get Details of category with ID
     * @param array $id
    */
    public function details($id){
        return $this->trainingRepo->findOne([ ["id",$id] ]);
    }

     /** 
     * category update
     * @param array $id category id
    */
    public function updateDetails($id='',$request=''){
        $data = $request->all();
        unset($data['_token']);
        $chkname = $this->chkUniqueName($data['name'],$id);
        if($chkname != NULL){
            return 'error';
        }else{
            return $this->trainingRepo->updateDetails($id,$data);
        }
    }
      /** 
     * category unique check
     * @param array $id category id
    */
    public function chkUniqueName($name='',$id=''){
        if($id != ''){
            $condition = [["id",'!=',$id],["name",$name]];
        }else{
            $condition = [["name",$name]];
        }
        $data = $this->trainingRepo->findOne($condition);
        return $data;
    }

    /** 
     * Get All training video List
    */
    public function fetchVideoList($search='') {
        return $this->trainingRepo->getVideo($search);
    }

     /** 
     * Add Video 
    */
    public function videoAdd($request) {
        $data = [];
        $data = $request->all();
        $videoData = $this->trainingRepo->videoAdd($data);
        return $videoData;
    }
     /** 
     * Get Details of category with ID
     * @param array $id
    */
    public function videoDetails($id){
        return $this->trainingRepo->findOneVideo([ ["id",$id] ]);
    }

     /** 
     * category update
     * @param array $id category id
    */
    public function updateVideoDetails($id='',$request=''){
        $data = $request->all();
        unset($data['_token']);
        return $this->trainingRepo->updateVideoDetails($id,$data);
    }

    public function getActiveCategory(){
        return $this->trainingRepo->getActiveCategory();
    }

    public function getActiveTraining($catId='',$trainingId=''){
        return $this->trainingRepo->getActiveTraining($catId,$trainingId);
    }

}