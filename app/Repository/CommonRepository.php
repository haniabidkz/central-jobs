<?php

namespace App\Repository;

use App\Repository\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use DB;

class CommonRepository implements RepositoryInterface
{
    // model property on class instances
    protected $model;

    // Constructor to bind model to repo
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    // Get all instances of model
    public function all()
    {
        return $this->model->all();
    }
    // Get all instances of model with count
    public function getCount($condition = false)
    {
        if ($condition) {
            return $this->model->where($condition)->count();
        } else {
            return $this->model->count();
        }
    }
    // create a new record in the database
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $record = $this->model->find($id);
        return $record->update($data);
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->model->destroy($id);
    }
// remove record from the database wuth condition
    public function deleteWhere($condition)
    {
        return $this->model->where($condition)->delete();
    }

    // show the record with the given id
    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    // Get the associated model
    public function getModel()
    {
        return $this->model;
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    // Eager load database relationships
    public function with($relations)
    {
        return $this->model->with($relations);
    }
    //function to get model data
    public function get($condition='', $limit='')
    {
        return $this->model->where($condition)->orderBy('id',"desc")->paginate($limit);
    }
    //functionToFind Single Row ByCondition
    public function findSingleRow($condition='')
    {
         return $this->model->where($condition)->first();
    }
    //functionToFind delete Row ByCondition
    public function deleteRows($condition='')
    {
         return $this->model->where($condition)->delete();
    }
    //function to get all model data
    public function getAll($condition='')
    {
        return $this->model->where($condition)->get();
    }
    //function to get model data
    public function getWith($condition='', $limit='', $relations='', $type='', $whereIn='',$wherHasTbl='',$wherHasCon='',$whereNotIn='')
    {
        $data = $this->model->where($condition);
        if($whereNotIn != ''){
            $data = $data->whereNotIn('user_id',$whereNotIn);
        }
        if($wherHasTbl != ''){
            $data = $data->whereHas($wherHasTbl,function($q) use ($wherHasCon) {
                $q->where($wherHasCon);
            });
        }
        if($type != ''){
            $data = $data->whereIn($type,$whereIn);
        }
        if($limit != ''){
            $data = $data->with($relations)->orderBy('id',"desc")->paginate($limit);
        }else{
            $data = $data->with($relations)->orderBy('id',"desc")->get();
        }
        
        
        return $data;
    }
    public function getPostWith($condition='', $limit='', $relations='',$whereIn,$whereNotIn)
    {
        $data = $this->model->where($condition)->whereIn('user_id',$whereIn)->whereNotIn('user_id',$whereNotIn);
        $data = $data->with($relations)->orderBy('id',"desc")->paginate($limit);
        return $data;
    }
    //function to get model data
    public function showWith($condition, $relations)
    {
        return $this->model->where($condition)->with($relations)->first();
        
    }
    //function to get model data
    public function showWithDeleted($condition, $relations)
    {
        return $this->model->withTrashed()->where($condition)->with($relations)->first();
        
    }
    //function to get model data
    public function getSearchWithUser($condition,$condition1,$limit, $relations)
    {
        $data =  $this->model->where($condition)->with($relations);
        if($condition1 != ''){
            $data = $data->whereHas('user',function($q) use ($condition1) {
                $q->where($condition1);
            });
        }
        $data = $data->orderBy("id","DESC")
        ->paginate($limit);
        return $data;
    }

    // create a new record in the database
    public function multipleRowInsert(array $data)
    {
        return $this->model->insert($data);
    }
    /**
     * Find a one 
     * @param array $condition
     * @return category
     */
    public function findOne($condition) {
        $page = $this->model->where($condition)->first();
        if($page){
            $page = $page->toArray();
        }
        return $page;
    }
    // remove record from the database with condition
    public function deleteByCondition($condition)
    {
        return $this->model->where($condition)->delete();
    }

    //function to get model data
    public function getDetailWithOthers($condition,$condition1,$relations,$relationTbl)
    {
        $data =  $this->model->where($condition)->with($relations);
        if($condition1 != ''){
            $data = $data->whereHas($relationTbl,function($q) use ($condition1) {
                $q->orWhere($condition1);
            });
        }
        $data = $data->first();
        return $data;
    }

    //Id IN
    //function to get all model data
    public function getAllIdInArray($condition='')
    {
        return $this->model->whereIn('id',$condition)->orderBy("name","ASC")->get();
    }

    //function to get all model data
    public function getAllOrder($condition='',$orderBy='', $order='')
    {
        return $this->model->where($condition)->orderBy($orderBy,$order)->get();
    }

    //function to get model data
    public function getSearchWithRelationAll($condition,$condition1,$limit, $relations='',$relationTbl='',$condition2='',$relationTbl2='',$whereinField='',$whereCond='',$whereNotIn='',$whereNotInPost='',$whereinLikeField='',$whereLikeCond='')
    {
       
        $data =  $this->model->where($condition);
        if($whereNotInPost != ''){
            $data = $data->whereNotIn('id',$whereNotInPost);
        }
        if($whereNotIn != ''){
            $data = $data->whereNotIn('user_id',$whereNotIn);
        }
        if($whereinField != ''){
            $data = $data->whereIn($whereinField,$whereCond);
        }
        if($whereinLikeField != ''){
            $data = $data->Where(function ($query) use($whereLikeCond) {
                for ($i = 0; $i < count($whereLikeCond); $i++){
                $query->orwhere('title', 'like',  '%' . $whereLikeCond[$i] .'%');
                     // ->orwhere('job_id', 'like',  '%' . $whereLikeCond[$i] .'%');
                }      
            });
            
        }
        $data = $data->with($relations);
        if($condition1 != ''){
            $data = $data->whereHas($relationTbl,function($q) use ($condition1) {
                $q->where($condition1);
            });
        }
        if($condition2 != ''){
            $data = $data->whereHas($relationTbl2,function($q) use ($condition2) {
                $q->where($condition2);
            });
        }
        if($limit != ''){
            $data = $data->orderBy("id","DESC")->paginate($limit);
        }else{
            $data = $data->orderBy("id","DESC")->get();
        }
        
        return $data;
    }
    //function to get all model data
    public function getAllIdInArrayData($condition='')
    {
        return $this->model->whereIn('job_id',$condition)->get();
    }
     //function to update multiple rows
    public function updateMultipleRows(array $data,$conditions)
    {
        return $this->model->where($conditions)->update($data);
    }

    //functionToFind Single Row ByCondition
    public function findSingleRowWithDeletedData($condition='',$with='')
    {
         return $this->model->withTrashed()->where($condition)->with($with)->first();
    }
    
    //function to get model data
    public function getAllUnblockFollower($condition='',$relations='',$whereNotIn='',$limit='')
    {
        $data = $this->model->where($condition);
        if($whereNotIn != ''){
            $data = $data->whereNotIn('follower_id',$whereNotIn);
        }
        
        $data = $data->with($relations)->orderBy('id',"desc")->paginate($limit);
        return $data;
    }


    public function getLastVideoData($condition='', $limit='')
    {
        return $this->model->where($condition)->orderBy('id',"desc")->take($limit)->get()->first();
    }

    //function to get model data
    public function getWithCondition($condition='', $limit='', $relations='', $wherHasTbl='',$wherHasCon='',$whereNotIn='')
    {
        $data = $this->model->where($condition);
        if($whereNotIn != ''){
            $data = $data->whereNotIn('follower_id',$whereNotIn);
        }
        if($wherHasTbl != ''){
            $data = $data->whereHas($wherHasTbl,function($q) use ($wherHasCon) {
                $q->where($wherHasCon);
            });
        }
        if($limit == ''){
            $data = $data->with($relations)->orderBy('id',"desc")->get();
        }else{
            $data = $data->with($relations)->orderBy('id',"desc")->paginate($limit);
        }
        
        return $data;
    }

     //function to get model data
     public function showWithWhereIn($condition, $relations, $whereInField, $whereInArr)
     {
         return $this->model->where($condition)->whereIn($whereInField,$whereInArr)->with($relations)->get()->toArray();
         
     }

     public function checkBlockUser($userIdTo,$userIdFrom){
        return $this->model->where([['blocked_user_id',$userIdTo],['blocked_by',$userIdFrom]])->orWhere([['blocked_by',$userIdTo],['blocked_user_id',$userIdFrom]])->get()->toArray();
     }

     public function getWithNoPagination($condition='', $limit='', $relations='', $type='', $whereIn='',$wherHasTbl='',$wherHasCon='',$whereNotIn='')
    {
        $data = $this->model->where($condition);
        if($whereNotIn != ''){
            $data = $data->whereNotIn('user_id',$whereNotIn);
        }
        if($wherHasTbl != ''){
            $data = $data->whereHas($wherHasTbl,function($q) use ($wherHasCon) {
                $q->where($wherHasCon);
            });
        }
        if($type != ''){
            $data = $data->whereIn($type,$whereIn);
        }
        $data = $data->with($relations)->orderBy('id',"desc")->get();
        return $data;
    }

    public function getPostWithAll($condition='', $limit='', $relations='',$whereIn,$whereNotIn,$whereOrCondi='')
    {
        $data = $this->model->doesntHave('reportedPost')->where($condition)->orWhere($whereOrCondi);
        $data = $data->whereIn('user_id',$whereIn)->whereNotIn('user_id',$whereNotIn);
        $data = $data->with($relations)->orderBy('id',"desc")->paginate($limit);
        return $data;
    }

    public function getPostWithAllDashboard($condition='', $limit='', $relations='',$whereIn,$whereNotIn,$whereOrCondi='')
    {
        //DB::enableQueryLog();
        
        $data = $this->model->doesntHave('reportedPost');
        $data = $data->whereIn('user_id',$whereIn)->where($condition)
                ->orWhere(function($query) use ($whereOrCondi,$whereIn) {
                    $query->where($whereOrCondi)
                        ->whereIn('user_id',$whereIn);
            });
        $data = $data->with($relations)->orderBy('id',"desc")->paginate($limit);
        //dd(DB::getQueryLog()); // Show results of log
        return $data;
    }

}
