<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\TrainingService;
use App\Repository\TrainingRepository;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Requests\Admin\TrainingVideoRequest;


class TrainingController extends Controller {

    protected $trainingService;
    protected $trainingRepo;

    public function __construct(
        TrainingService $trainingService,
        TrainingRepository $trainingRepo
    )
    {   
        $this->trainingService = $trainingService;
        $this->trainingRepo = $trainingRepo;
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 10/03/2020
    @FunctionFor: All Training category listing
    */

    public function index(Request $request) {
        $search = $request->all();
        $trainings = $this->trainingService->fetchList($search);
        $activeModule = 'category';
        $pageTitle = 'Training Category List';
        return view('Admin.Training.categoryList', compact('trainings', 'activeModule','search','pageTitle'));
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 10/03/2020
    @FunctionFor: Category add view
    */
    public function categoryAdd(Request $request){
        $activeModule = 'category';
        $pageTitle = 'Training Category Add';
        return view('Admin.Training.categoryAdd', compact('activeModule','pageTitle'));
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 10/03/2020
    @FunctionFor: Category add to db
    */
    public function categoryAddPost(CategoryRequest $request){
        try {
            $activeModule = 'category';
            $title        = "Training Category Add";  
            $added = $this->trainingService->categoryAdd($request);
            if($added == 'error'){
                request()->session()->flash('message-error', "Category name already exsist." );
                return redirect('admin/training-category-list');
            }else{
                request()->session()->flash('message-success', "Category added successfully" );
                return redirect('admin/training-category-list');
            }
        } catch (Exception $e) {
            $request->session()->flash('message-error', 'An error occurred.');
            return redirect('admin/training-category-list');
        }
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 10/03/2020
    @FunctionFor: Category edit
    */
    public function categoryEdit(Request $request, $id) {
        $id = decrypt($request['id']);
        $details = $this->trainingService->details($id);
        $activeModule = 'category';
        $pageTitle = 'Training Category Edit';
        return view('Admin.Training.categoryAdd', compact('details', 'activeModule','pageTitle'));
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 10/03/2020
    @FunctionFor: Category edit post
    */
    public function categoryEditPost(CategoryRequest $request, $id){
        $datanew = $request->all();
        $id = decrypt($id);
        $data = $this->trainingService->updateDetails($id,$request);
        if($data == 'error'){
            request()->session()->flash('message-error', "Category name already exsist." );
            return redirect('admin/training-category-list');
        }else{
            request()->session()->flash('message-success', "Category updated successfully");
            return redirect('admin/training-category-list');
        }
    }
     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 10/03/2020
    @FunctionFor: category change status
    */
    public function categoryChangeStatus(Request $request)
    {
        $result = $this->trainingRepo->changeStatus($request->all());
        request()->session()->flash('message-success', "Status changed successfully" );
        echo 1;
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 10/03/2020
    @FunctionFor: category delete
    */
    public function destroy($id)
    {
        try{
            $status = $this->trainingRepo->removeCategory($id);
            request()->session()->flash('message-success', "Category has been deleted successfully" );
            return redirect()->back();
        }catch (\Illuminate\Database\QueryException $e) {
            request()->session()->flash('message-error', "Category can not be deleted. This category associated with a training video." );
            return redirect()->back();
        }
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 10/03/2020
    @FunctionFor: All Training video listing
    */
    public function videoList(Request $request) {
        $search = $request->all();
        $videos = $this->trainingService->fetchVideoList($search);
        $categoryList = $this->trainingRepo->getCategoryList();
        $activeModule = 'video';
        $pageTitle = 'Video List';
        return view('Admin.Training.videoList', compact('videos', 'activeModule','categoryList','search','pageTitle'));
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 10/03/2020
    @FunctionFor: Category add view
    */
    public function videoAdd(Request $request){
        $categoryList = $this->trainingRepo->getCategoryList();
        $activeModule = 'video';
        $pageTitle = 'Video Add';
        return view('Admin.Training.videoAdd', compact('activeModule','categoryList','pageTitle'));
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 10/03/2020
    @FunctionFor: Video add to db
    */
    public function videoAddPost(TrainingVideoRequest $request){
        try {
            $activeModule = 'video';
            $title        = "Training Video Add";  
            $added = $this->trainingService->videoAdd($request);
            request()->session()->flash('message-success', "Video added successfully" );
            return redirect('admin/training-video-list');
        } catch (Exception $e) {
            $request->session()->flash('message-error', 'An error occurred.');
            return redirect('admin/training-video-list');
        }
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 10/03/2020
    @FunctionFor: Video edit
    */
    public function videoEdit(Request $request,$id) {
        $id = decrypt($request['id']);
        $categoryList = $this->trainingRepo->getCategoryList();
        $details = $this->trainingService->videoDetails($id);
        $activeModule = 'video';
        $pageTitle = 'Video Edit';
        return view('Admin.Training.videoAdd', compact('details', 'activeModule','categoryList','pageTitle'));
        
    }

      /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 10/03/2020
    @FunctionFor: Video edit post
    */
    public function videoEditPost(TrainingVideoRequest $request, $id){
        $datanew = $request->all();
        $id = decrypt($id);
        $data = $this->trainingService->updateVideoDetails($id,$request);
        request()->session()->flash('message-success', "Video updated successfully");
        return redirect('admin/training-video-list');
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 10/03/2020
    @FunctionFor: video change status
    */
    public function videoChangeStatus(Request $request)
    {
        $result = $this->trainingRepo->videoChangeStatus($request->all());
        request()->session()->flash('message-success', "Status changed successfully" );
        echo 1;
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 10/03/2020
    @FunctionFor: category delete
    */
    public function videoDestroy($id)
    {
        $this->trainingRepo->removeVideo($id);
        request()->session()->flash('message-success', "Job has been deleted successfully" );
        return redirect()->back();
    }

}
