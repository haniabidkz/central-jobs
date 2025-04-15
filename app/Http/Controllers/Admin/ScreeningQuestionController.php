<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\ScreeningQuestionService;
use App\Http\Requests\Admin\ScreeningRequest;

class ScreeningQuestionController extends Controller
{
    protected $screeningQuestionService;
    public function __construct(ScreeningQuestionService $screeningQuestionService)
    {   
        $this->screeningQuestionService = $screeningQuestionService;
    }
    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 09/04/2020
    @FunctionFor: Screening Question list
    */
    public function index(Request $request)
    {
        $questions = $this->screeningQuestionService->getAllList();
        $activeModule = "screeningQuestions";
        $pageTitle = 'Screening Questions List';
        return view('Admin.screeningQuestion.questionList', compact("questions","activeModule","pageTitle"));
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 09/04/2020
    @FunctionFor: Question Answer add 
    */
    public function addQuestionAnswer(){
        $activeModule = 'screeningQuestions';
        $pageTitle = 'Add Question & Answer';
        return view('Admin.screeningQuestion.questionAnsAdd', compact('activeModule','pageTitle'));
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 10/04/2020
    @FunctionFor: Question Answer add post
    */
    public function addQuestionAnswerPost(ScreeningRequest $request){
        try {
            $activeModule = 'screeningQuestions';
            $title        = "Add Question & Answer";  
            $added = $this->screeningQuestionService->screeningAdd($request);
            request()->session()->flash('message-success', "Screening question and answer added successfully" );
            return redirect('admin/screening-question-list');
        } catch (Exception $e) {
            $request->session()->flash('message-error', 'An error occurred.');
            return redirect('admin/screening-question-list');
        }
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 10/04/2020
    @FunctionFor: Question Answer edit 
    */
    public function editQuestionAnswer(Request $request){
        $activeModule = 'screeningQuestions';
        $pageTitle = 'Edit Question & Answer';
        $id = decrypt($request['id']);
        $details = $this->screeningQuestionService->details($id);
        //dd($details);
        return view('Admin.screeningQuestion.questionAnsAdd', compact('activeModule','pageTitle','details'));
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 10/04/2020
    @FunctionFor: Question Answer edit post
    */
    public function editQuestionAnswerPost(ScreeningRequest $request){
        $data = $this->screeningQuestionService->updateDetails($request);
        request()->session()->flash('message-success', "Screening question and answer updated successfully");
        return redirect('admin/screening-question-list');
    }

     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 10/04/2020
    @FunctionFor: screening change status
    */
    public function changeStatusQuestion(Request $request)
    {
        $result = $this->screeningQuestionService->changeStatus($request->all());
        if($result != 1){
            request()->session()->flash('message-error', "Sorry! You can have only three active questions at a time.");
        }else{
            request()->session()->flash('message-success', "Status changed successfully" );
        }
        
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 10/04/2020
    @FunctionFor: Question delete
    */
    public function deleteQuestion($id)
    {
        try{
            $status = $this->screeningQuestionService->removeQuestion($id);
            request()->session()->flash('message-success', "Screening question has been deleted successfully" );
            return redirect()->back();
        }catch (\Illuminate\Database\QueryException $e) {
            request()->session()->flash('message-error', "Screening question can not be deleted.");
            return redirect()->back();
        }
    }
}
