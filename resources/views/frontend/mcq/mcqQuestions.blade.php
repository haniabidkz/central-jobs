@extends('layouts.app_after_login_layout')
@section('content')

 <!-- main -->
<main>
 <div class="sign-in">
    <div class="container">
       <div class="sign-in-page">
          <div class="signin-popup">
             <div class="signin-pop">
                <div class="row">
                   <div class="col-md-5 col-12 right-border-sign">
                      <div class="cmp-info">
                         <div class="cm-logo">
                            <a href="index.html" class="logo-holder"><img src="{{ asset('frontend/images/logo-color-2.png') }}" alt="" class="img-fluid"></a>
                            <!-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p> -->
                         </div>
                         <!--cm-logo end-->   
                         <img src="{{ asset('frontend/images/mcq.jpg') }}" alt=""  class="img-fluid">         
                      </div>
                      <!--cmp-info end-->
                   </div>
                   <div class="col-md-7 col-12">
                      <div class="d-flex align-items-center h-100">
                         <div class="mcq-question">
                             
                            <?php if(!empty($mcqData[$language])){ ?>
                              <div class="headline-box">
                              <h2 class="headeing-text"> {{ __('messages.BECAUSE_WE_ARE_HERE_TO_HELP_YOU') }}!!! </h2>
                              <p class="description"> {{ __('messages.MCQ_TEXT') }}</p>
                            </div> 
                            <form role="form" method="post" id="mcqAns" action="{{url('candidate/screening-mcq-answer')}}">
                              <input type="hidden" name="total" value="{{count($mcqData[$language])}}" id="total"/>
                              @csrf
                            <?php foreach($mcqData[$language] as $key=>$val){ ?>
                            <input type="hidden" name="master_screening_questions_id_<?php echo $key;?>" value="<?php echo $val['question']['master_screening_questions_id'];?>"/>
                            <div class="mcq-question-holder">
                               <h4><?php echo $key+1 ;?>. <?php echo $val['question']['question'];?></h4>
                               <div class="mcq-radio">
                                  <input type="radio" value="1" id="op_one_<?php echo $key;?>" name="check_<?php echo $key;?>"/>
                                  <label for="op_one_<?php echo $key;?>" class="text-left"><?php echo $val['answer_options']['option_one'];?></label>
                               </div>
                               <div class="mcq-radio">
                                  <input type="radio" value="2" id="op_two_<?php echo $key;?>" name="check_<?php echo $key;?>"/>
                                  <label for="op_two_<?php echo $key;?>" class="text-left"><?php echo $val['answer_options']['option_two'];?></label>
                               </div>
                               <div class="mcq-radio">
                                  <input type="radio" value="3" id="op_three_<?php echo $key;?>" name="check_<?php echo $key;?>"/>
                                  <label for="op_three_<?php echo $key;?>" class="text-left"><?php echo $val['answer_options']['option_three'];?></label>
                               </div>
                               <span id="secAns_<?php echo $key;?>" class="error" style="color:red;"></span>
                            </div>
                          <?php } ?>
                            <!-- <div class="mcq-question-holder">
                               <h4>2. Lorem Ipsum is simply dummy text of the printing</h4>
                               <div class="mcq-radio">
                                  <input type="radio" value="None" id="c_g" name="check2"/>
                                  <label for="c_g">Select Option 1</label>
                               </div>
                               <div class="mcq-radio">
                                  <input type="radio" value="None" id="c_i" name="check2"/>
                                  <label for="c_i">Select Option 2</label>
                               </div>
                               <div class="mcq-radio">
                                  <input type="radio" value="None" id="c_j" name="check2"/>
                                  <label for="c_j">Select Option 3</label>
                               </div>
                            </div>
                            <div class="mcq-question-holder">
                               <h4>3. Lorem Ipsum is simply dummy text of the printing</h4>
                               <div class="mcq-radio">
                                  <input type="radio" value="None" id="c_a" name="check3"/>
                                  <label for="c_a">Select Option 1</label>
                               </div>
                               <div class="mcq-radio">
                                  <input type="radio" value="None" id="c_b" name="check3"/>
                                  <label for="c_b">Select Option 2</label>
                               </div>
                               <div class="mcq-radio">
                                  <input type="radio" value="None" id="c_c" name="check3"/>
                                  <label for="c_c">Select Option 3</label>
                               </div>
                            </div> -->
                            <div class="w-100 d-block">
                               <button  class="btn site-btn mcqAnsCls" type="button">{{ __('messages.CHECK_YOUR_ANSWERS_HERE_TO_COMPLETE_YOUR_PROFILE') }}</button>
                            </div>
                            </form>
                          <?php }?>
                         </div>
                         <!--login-sec end-->
                      </div>
                   </div>
                </div>
             </div>
             <!--signin-pop end-->
          </div>
          <!--signin-popup end-->
       </div>
       <!--sign-in-page end-->
    </div>
    <!--theme-layout end-->
 </div>
</main>
<!-- main End -->
@endsection