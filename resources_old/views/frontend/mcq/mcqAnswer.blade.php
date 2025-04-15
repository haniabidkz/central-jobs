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
                              <a href="index.html" class="logo-holder"><img src="{{ asset('frontend/images/logo-color.png') }}" alt="" class="img-fluid"></a>
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
                              <div class="headline-box">
                                <h2 class="headeing-text"> {{ __('messages.BECAUSE_WE_ARE_HERE_TO_HELP_YOU') }}!!! </h2>
                                <p class="description"> {{ __('messages.MCQ_TEXT') }}</p>
                              </div>  
                              <?php if(!empty($mcqData[$language])){
                              foreach($mcqData[$language] as $key=>$val){ ?>
                              <div class="mcq-question-holder">
                                 <h4><?php echo $key+1 ;?>. <?php echo $val['question']['question'];?></h4>
                                 <div class="mcq-radio <?php if($val['answer_options']['answer'] == 1){?>mcq-correct-ans <?php }else{?> mcq-wrong-ans <?php }?>">
                                    <input type="radio" value="1" id="op_one_<?php echo $key;?>" name="check_<?php echo $key;?>" <?php if(@$candidateChecked['check_'.$key] == 1){?>checked="" <?php }?>/>
                                    <label for="op_one_<?php echo $key;?>" class="text-left"><?php echo $val['answer_options']['option_one'];?></label>
                                    <div class="correct-wrong-text"> <?php echo $val['answer_options']['reason_one'];?></div> 
                                 </div>
                                 <div class="mcq-radio <?php if($val['answer_options']['answer'] == 2){?>mcq-correct-ans <?php }else{?> mcq-wrong-ans <?php }?>">
                                    <input type="radio" value="None" id="op_two_<?php echo $key;?>" name="check_<?php echo $key;?>" <?php if(@$candidateChecked['check_'.$key] == 2){?>checked="" <?php }?>/>
                                    <label for="op_two_<?php echo $key;?>" class="text-left"><?php echo $val['answer_options']['option_two'];?></label>
                                    <div class="correct-wrong-text"> <?php echo $val['answer_options']['reason_two'];?></div>
                                 </div>
                                 <div class="mcq-radio <?php if($val['answer_options']['answer'] == 3){?>mcq-correct-ans <?php }else{?> mcq-wrong-ans <?php }?>">
                                    <input type="radio" value="None" id="op_three_<?php echo $key;?>" name="check_<?php echo $key;?>" <?php if(@$candidateChecked['check_'.$key] == 3){?>checked="" <?php }?> />
                                    <label for="op_three_<?php echo $key;?>" class="text-left"><?php echo $val['answer_options']['option_three'];?></label>
                                    <div class="correct-wrong-text"> <?php echo $val['answer_options']['reason_three'];?></div>
                                 </div>
                              </div>
                            <?php } } ?>
                              <div class="w-100 d-block">
                                 <a href="{{url('candidate/success')}}" class="btn site-btn-color">{{ __('messages.CONCLUDE_MY_PROFILE') }}</a>
                              </div>
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