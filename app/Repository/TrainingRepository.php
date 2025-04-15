<?php
namespace App\Repository;
use App\Http\Model\TrainingCategory;
use App\Http\Model\TrainingVideo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TrainingRepository {

    /**
     * Get category list
     * @return training
     */
    public function get($search) {

        $category = TrainingCategory::orderBy("id","DESC");
        if((isset($search['name'])) && ($search['name'] != null)){
            $category = $category->where(DB::raw('name'),'like','%'.$search['name'].'%');
        }
        $category = $category->paginate(env('ADMIN_PAGINATION_LIMIT'));
        return $category;
    }
    /**
     * Add category 
     * @return training
     */
    public function categoryAdd($data) {
        $training = TrainingCategory::create($data);
        return $training;
    }
    /**
     * Find a category 
     * @param array $condition
     * @return category
     */
    public function findOne($condition) {
        $training = TrainingCategory::where($condition)->first();
        if($training){
            $training = $training->toArray();
        }
        return $training;
    }

    /**
     * @param array $condition
     * @return category
     */
    public function updateDetails($id='',$data=''){
        $category = TrainingCategory::where('id', $id)->update($data);
        return $category;
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
        $catId = $request['id'];
        $catData = TrainingCategory::where('id',$catId)->update($updateData);
        return $catData;       
    }

    /** 
     * Fetch Ambassador Details of a specific ID
     * @param $ambassadorId
     * @return array $profile
    */
    public function removeCategory($catId)
    {
        $company= TrainingCategory::findOrFail($catId);
        $company->delete();
        return $company;       
    }

    /**
     * Get video list
     * @return training
     */
    public function getVideo($search='') {
        $video = TrainingVideo::with('category');
        if((isset($search['title'])) && ($search['title'] != null)){
            $video = $video->where(DB::raw('title'),'like','%'.$search['title'].'%');
        }
        if((isset($search['category_id'])) && ($search['category_id'] != null)){
            $video = $video->where('category_id',$search['category_id']);
        }
        $video = $video->orderBy("id","DESC")->paginate(env('ADMIN_PAGINATION_LIMIT'));
        return $video;
    }

    /**
     * Find a all state list
     * @param array $condition
     * @return State list
     */
    public function getCategoryList() {
        $category = TrainingCategory::all()->where('status',1);
        return $category;
    }

     /**
     * Add Video 
     * @return training
     */
    public function videoAdd($data) {
        $trainingVideo = TrainingVideo::create($data);
        return $trainingVideo;
    }

     /**
     * Find a category 
     * @param array $condition
     * @return category
     */
    public function findOneVideo($condition) {
        $training = TrainingVideo::where($condition)->first();
        if($training){
            $training = $training->toArray();
        }
        return $training;
    }

    /**
     * @param array $condition
     * @return category
     */
    public function updateVideoDetails($id='',$data=''){
        $video = TrainingVideo::where('id', $id)->update($data);
        return $video;
    }

     /** 
     * Fetch Ambassador Details of a specific ID
     * @param $request 
     * @return array $profile
    */
    public function videoChangeStatus($request)
    {
        $updateData = [];
        if($request['status'] == 0){
            $updateData['status'] = 1;
        }else{
            $updateData['status'] = 0;
        }
        $catId = $request['id'];
        $catData = TrainingVideo::where('id',$catId)->update($updateData);
        return $catData;       
    }
     /** 
     * Fetch Ambassador Details of a specific ID
     * @param $ambassadorId
     * @return array $profile
    */
    public function removeVideo($catId)
    {
        $company= TrainingVideo::findOrFail($catId);
        $company->delete();
        return $company;       
    }
    public function getCountTrainingVideos($condition)
    {
        $list = TrainingVideo::get();
        return $list->count();
    }

    /**
     * Find a all state list
     * @param array $condition
     * @return State list
     */
    public function getActiveCategory() {
        $category = TrainingCategory::where('status',1)->orderBy("id","DESC")->paginate(env('FRONTEND_PAGINATION_LIMIT'));
        return $category;
    }

    public function getActiveTraining($catId='',$trainingId=''){
        if($trainingId == 0){
            $where = [['status',1],['category_id',$catId]];
        }else{
            $where = [['status',1],['category_id',$catId],['id','>=',$trainingId]];
        }
        
        $training = TrainingVideo::where($where)->orderBy("id","ASC")->limit(4)->get()->toArray();
        return $training;
    }
}