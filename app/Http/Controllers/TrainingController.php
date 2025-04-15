<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\TrainingService;
use DB;

class TrainingController extends Controller
{

   protected $trainingService; 
   public function __construct(TrainingService $trainingService)
    {   
        $this->trainingService = $trainingService;
    }
   /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */ 
    public function index()
    {
        $categoryList = $this->trainingService->getActiveCategory();
        $pageTitle = 'Training List';
        $metaTitle = "Training List";
        return view('frontend.training.list',compact('pageTitle','metaTitle','categoryList'));
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function details($catid='',$videoid='')
    {
        $pageTitle = 'Training List';
        $metaTitle = "Training List";

        $catid = decrypt($catid);
        if($videoid == ''){
            $videoid = 0;
        }else{
            $videoid = decrypt($videoid);
        }
       
        $training = $this->trainingService->getActiveTraining($catid,$videoid);
        if(!empty($training)){
            $main = $training[0];
            unset($training[0]);
        }
       
        return view('frontend.training.details',compact('pageTitle','metaTitle','training','main','catid'));
    }
    
}
