<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\ScreeningQuestionService;
use Auth;
use Cookie;

class Mcq extends Controller
{

    protected $screeningMcqService;
    protected $language; 
    public function __construct(ScreeningQuestionService $screeningMcqService)
    {   

        $this->middleware('checkMcqScreening', ['except' => array('screeningMcq','screeningMcqAnswer')]);
        $this->middleware('auth', ['except' => [""]]);
        $this->screeningMcqService = $screeningMcqService;
        
        
    }
   /**
     * Developer : Rumpa Ghosh 
     * Function to proceed screening mcq
     * @return string view
     */
    public function screeningMcq()
    {
        $lang = request()->cookie('locale');
        if($lang == 'fr'){
            $this->language = 1; //French
        }else if($lang == 'en'){
            $this->language = 0; //English
        }else{
            $this->language = 2; //Portuguese
        }
        if((Auth::user()) && (Auth::user()->is_mcq_complete == 1)){
            return redirect('/');
        }
        $mcqData = $this->screeningMcqService->getActiveData();
        $language = $this->language;
        return view('frontend.mcq.mcqQuestions',compact('mcqData','language'));
    }

    /**
     * Developer : Rumpa Ghosh 
     * Function to proceed screening mcq ans
     * @return string view
     */
    public function screeningMcqAnswer(Request $request)
    {
        $lang = request()->cookie('locale');
        if($lang == 'fr'){
            $this->language = 1; //French
        }else if($lang == 'en'){
            $this->language = 0; //English
        }else{
            $this->language = 2; //Portuguese
        }
        if((Auth::user()) && (Auth::user()->is_mcq_complete == 1)){
            return redirect('/');
        }
        if((Auth::user()) && (Auth::user()->is_mcq_complete == 1)){
            return redirect('/');
        }
        $candidateChecked = $request->all();
        $insertData = $this->screeningMcqService->screeningUserAnswer($candidateChecked);
        $result = $this->screeningMcqService->updateUser();
        $mcqData = $this->screeningMcqService->getActiveData();
        $language = $this->language;
        return view('frontend.mcq.mcqAnswer',compact('mcqData','language','candidateChecked'));
    }


}
