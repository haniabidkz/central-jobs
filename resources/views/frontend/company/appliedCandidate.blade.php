@extends('layouts.app_after_login_layout')
@section('content')
<style>
   .cv-row p span {
      font-size: 18px;
      margin-right: 20px;
   }

   .doc-row p span {
      font-size: 18px;
      margin-right: 15px;
   }
   .doc-row p a {
      display: inline-block;
      margin: 0 10px;
   }
</style>   
<script src="{{asset('frontend/js/sweetalert.min.js')}}"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('frontend/js/job.js')}}"></script>
<main>
   <section class="section section-myjob">
      <div class="container">
         <div class="row">
            <div class="col-12">
               <div class="login-form section-myprofile">
                  <form id="search-applied-candidate" action="" method="get">
                      {{csrf_field()}}
                     <div class="row">
                           <div class="col-12 d-flex input-search-holder "> 
                              <div class="input-search">
                              <div class="form-group multiple-select  required">
                                 <select name="language[]" data-placeholder="{{ __('messages.LANGUAGE') }}" id="language" class="form-control multi-select-language"  multiple="multiple" style="display: none;">
                                 <?php if($language){
                                 foreach($language as $key=>$value){
                                 ?>
                                 <option value="{{$value['id']}}" <?php if((isset($search['language'])) && (@$search['language'] != null) && in_array($value['id'],@$search['language'])){ echo 'selected';}?>>{{$value['name']}}</option>
                                 <?php } } ?>
                                 </select>
                              </div>  
                              </div>    
                              <div class="input-search">
                                 <div class="form-group">
                                    <select class="form-control" name="country_id" id="country_id">
                                    <option value="">{{ __('messages.COUNTRY') }}</option>
                                    <?php if($countries){ ?>
                                    <?php foreach ($countries as $key => $value) {
                                    ?>
                                    <option value="<?php echo $value['id']; ?>" <?php if(@$search['country_id']  == $value['id']){ echo 'selected';}?>>{{$value['name']}}</option>
                                    <?php } } ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="input-search">
                                 <div class="form-group">
                                 <select name="state_id" data-placeholder="{{ __('messages.STATE') }}" id="state_id" class="form-control">
                                 <option value="">{{ __('messages.STATE') }} </option>
                                 <?php if($states){
                                       foreach ($states as $key => $value) {
                                       ?>
                                    <option value="{{$value['id']}}" <?php if((isset($search['state_id'])) && (@$search['state_id'] != null) && ($value['id'] == @$search['state_id'])){ echo 'selected';}?>>{{$value['name']}}</option>
                                    <?php } } ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="input-search">
                                 <div class="form-group multiple-select required">
                                  <input class="form-control select-city-area" id="city" name="city" type="text" value="<?php if(@$search['city'] != ''){ echo @$search['city'];}?>" placeholder="{{ __('messages.CITY') }}"/> 
                              </div>
                              </div>                            
                              <div class="input-search">
                                 <div class="form-group d-flex">
                                 <button class="btn site-btn-color mr-2"> {{ __('messages.SEARCH') }}</button>
                                 <?php unset($search['id']); if(!empty($search)){?>
                                 <a class="btn site-btn-color" href="{{ url('company/applied-candidates/'.encrypt($searchResult['id'])) }}"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                                 <?php }?>
                                 </div>
                              </div>
                           </div> 
                     </div>
                  </form> 
               </div> 
            </div>   
         </div>  
         <div class="row">
            <div class="col-12"> 
               <h2 class="font-22">{{$searchResult['title']}}</h2>
            </div>
         </div>   
         <?php if(($searchResult != null) || !empty($searchResult['totalAppliedJob'])){
            foreach($searchResult['totalAppliedJob'] as $key=>$val){ //dd($val);
            ?>
            <div class="row mb-4 @if(($val['user']['is_payment_done'] == 2)&&($val['user']['highlight_cv'] == 1))highlighted @endif">                
               <div class="col-12 col-xl-12">
                  <div class="track-job-box whitebg mb-0">
                     <div class="media"> 
                        <div class="user-img">
                        <?php if($val['user']['profileImage'] != null){?>
                           <img src="{{asset($val['user']['profileImage']['location'])}}" alt="">
                        <?php }else{ ?>
                           <img src="{{asset('frontend/images/user-pro-img-demo.png')}}" alt="">
                        <?php }?>
                        </div>
                        <div class="media-body ml-3">  
                           <div class="row"> 
                              <div class="col-12 col-sm-12 col-xl-6">  
                                 <div class="media align-center"> 
                                    <div class="media-body">
                                       <h3  class="total-title mt-0" >
                                          {{-- <a href="{{url('candidate/profile/'.$val['user']['slug'])}}"> --}}
                                              {{base64_decode($val['user']['first_name'])}}
                                          {{-- </a> --}}
                                       </h3> 
                                       <p><i class="fa fa-building-o" aria-hidden="true"></i>
                                       {{ isset($val['user']['profile']) ? $val['user']['profile']['profile_headline'] : ''}} {{ __('messages.AT') }} {{ isset($val['user']['currentCompany']) ? $val['user']['currentCompany']['company_name'] : '' }}</p>
                                       <p><i class="fa fa-map-marker" aria-hidden="true"></i>{{$val['user']['city_id']}} <?php if($val['user']['city_id'] != ''){ echo ',';}?> {{ isset($val['user']['state']) ? $val['user']['state']['name'] : ''}} <?php if(isset($val['user']['state'])){if($val['user']['state']['name'] != ''){ echo ',';}}?> {{ isset($val['user']['country']) ? $val['user']['country']['name'] : ''}} </p>
                                       {{-- <p><i class="fa fa-map-marker" aria-hidden="true"></i>Location applying for : {{$val['appliedUserInfo']['user_city']}} <?php if($val['appliedUserInfo']['user_city'] != ''){ echo ',';}?> {{$val['appliedUserInfo']['state']['name']}} <?php if($val['appliedUserInfo']['state']['name'] != ''){ echo ',';}?> {{$val['appliedUserInfo']['country']['name']}} </p>
                                       <p><i class="fa fa-phone"></i> {{$val['appliedUserInfo']['user_phone']}} </p> --}}
                                       <?php if($val['appliedUserInfo']['cover_letter'] != ''){?>
                                       <div class="des-text mb-4">
                                          <p>{!!$val['appliedUserInfo']['cover_letter']!!}</p>
                                       </div>
                                       <?php }?>      
                                       {{-- <p><i class="fa fa-file-text" aria-hidden="true"></i>{{ __('messages.RESUME') }}  <?php //if($val['user']['uploadedCV']['location'] != ''){ ?><a class="download-btn" href="{{asset($val['user']['uploadedCV']['location'])}}" download><i class="fa fa-download ml-3" aria-hidden="true"></i></a><?php //}else{ echo __('messages.IS_NOT_UPLOADED');}?></p> --}}
                                       <?php if($val['appliedAnswer']){
                                          foreach($val['appliedAnswer'] as $key=>$value){ if($value['specificQuestion']['type'] == 1){?>
                                       <div class="form-group">
                                          <label class="question-label"> {{$value['specificQuestion']['question']}} </label>
                                          <p><i class="fa fa-paper-plane-o" aria-hidden="true"></i>{{$value['answer']}}</p>
                                       </div>
                                       <?php } } }?>
                                    </div>
                                    <div>
                                       <?php $result = Helper::chkUserBlockByMe($val['user']['id']); 
                                          if(empty($result)){
                                          ?>
                                         {{-- <a href="{{url('/company/message/')}}/{{encrypt($val['user']['id'])}}" class="btn site-btn-color"><i class="fa fa-comments" aria-hidden="true"></i></a> --}}
                                          <?php }else{?>
                                             <button class="btn site-btn-color block_user" data-id="{{$val['user']['id']}}" data-block="0" id="block_user_{{$val['user']['id']}}">{{__('messages.UN_BLOCK')}}</button>    
                                       <?php }?>   
                                    </div> 
                                 </div>
                              </div> 
                              <div class="col-12 col-sm-12 col-xl-6"> 
                                   @if(isset($val['uploaded_cv']))
                                       <div class="cv-row">
                                             <p><span>Curriculum</span>
                                                <a href="{{ asset($val['uploaded_cv']['location']) }}" download><i class="fa fa-download" aria-hidden="true"></i>user_cv</a>
                                             </p>
                                       </div>   
                                    @endif
      
                                    @if($val->uploaded_other_doc->count() > 0)
                                       <div class="doc-row">
                                          <p><span>Docs Attached</span>
                                          @foreach($val['uploaded_other_doc'] as $doc)
                                             <a href="{{ asset($doc['location']) }}" download><i class="fa fa-download" aria-hidden="true"></i>user_other_doc</a>
                                          @endforeach
                                          </p>
                                       </div>
                                    @endif
                                 @if($val['user']['is_payment_done'] == 2)
                                 <h6 class="hgh-txt">Highlight: {{ $val['user']['profile']['highlight_sentence'] }}</h6>
                                 @endif
                                    <?php 
                                    $firstUrl = ''; $secondUrl = ''; $thirdUrl = '';
                                    if($val['appliedAnswer']){
                                       $j=0;
                                       foreach($val['appliedAnswer'] as $key=>$value){ if($value['specificQuestion']['type'] == 2){ 
                                                if($j == 0){
                                                   $question1 = $value['specificQuestion']['question'];
                                                   $firstUrl = $value['answer'];
                                                   //$firstUrl = $value['upload']['location'];
                                                   //S3 BUCKET IMG
                                                   /* $adapter = Storage::disk('s3')->getDriver()->getAdapter();       
                                                   $command = $adapter->getClient()->getCommand('GetObject', [
                                                   'Bucket' => $adapter->getBucket(),
                                                   'Key'    => $adapter->getPathPrefix(). '' . $value['upload']['name']
                                                   ]);
                                                   $img = $adapter->getClient()->createPresignedRequest($command, '+'.env('AWS_FILE_PATH_EXP_TIME').' minute');
                                                   $firstUrl = (string)$img->getUri(); */
                                                }
                                                if($j == 1){
                                                   $question2 = $value['specificQuestion']['question'];
                                                   //$secondUrl = $value['upload']['location'];
                                                   //S3 BUCKET IMG
                                                   $adapter = Storage::disk('s3')->getDriver()->getAdapter();       
                                                   $command = $adapter->getClient()->getCommand('GetObject', [
                                                   'Bucket' => $adapter->getBucket(),
                                                   'Key'    => $adapter->getPathPrefix(). '' . $value['upload']['name']
                                                   ]);
                                                   $img = $adapter->getClient()->createPresignedRequest($command, '+'.env('AWS_FILE_PATH_EXP_TIME').' minute');
                                                   $secondUrl = (string)$img->getUri();
                                                }
                                                if($j == 2){
                                                   $question3 = $value['specificQuestion']['question'];
                                                   //$thirdUrl = $value['upload']['location'];
                                                   //S3 BUCKET IMG
                                                   $adapter = Storage::disk('s3')->getDriver()->getAdapter();       
                                                   $command = $adapter->getClient()->getCommand('GetObject', [
                                                   'Bucket' => $adapter->getBucket(),
                                                   'Key'    => $adapter->getPathPrefix(). '' . $value['upload']['name']
                                                   ]);
                                                   $img = $adapter->getClient()->createPresignedRequest($command, '+'.env('AWS_FILE_PATH_EXP_TIME').' minute');
                                                   $thirdUrl = (string)$img->getUri();
                                                }
                                                $j++;
                                             } 
                                          } 
                                       } 
                                    ?>
                                    <?php if($firstUrl != ''){?>
                                 <div class="intro-video mb-2 mt-2">
                                    <h6 class="video-title-qu"> {{$question1}} </h6>
                                   <!--  <iframe  height="200" src="{{asset($firstUrl)}}"  allow="accelerometer;  encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
 -->
                                    <video style="display:none" id='video-player'  preload='metadata' controls>
                                      <source src="{{asset($firstUrl)}}" type="video/mp4">
                                    </video>

                                    <iframe
src="https://embed.myinterview.com/player.v4.html?apiKey=dy7lpre2xi44rq2l5oibv8ie&hashTimestamp=timestamp&hash=calculatedHash&video={{$firstUrl}}"
width="100%" height="300" frameborder="0" allowfullscreen webkitallowfullscreen mozallowfullscreen oallowfullscreen msallowfullscreen></iframe>

                                 </div>
                                    <?php } if($secondUrl != '' || $thirdUrl != ''){?>

                                 
                                      <?php if($secondUrl != ''){?>
                                          <div class="intro-video mb-2">
                                             <h6 class="video-title-qu"> {{$question2}}</h6>
                                            <!--  <iframe  height="200" src="{{asset($secondUrl)}}" allow="accelerometer;  encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->

                                              <video  id='video-player'  preload='metadata' controls>
                                               <source src="{{asset($secondUrl)}}" type="video/mp4">
                                             </video>

                                          </div> 
                                       <?php } if($thirdUrl != ''){?>
                                          <div class="intro-video mb-2">
                                             <h6 class="video-title-qu"> {{$question3}} </h6>
                                            <!--  <iframe  height="200" src="{{asset($thirdUrl)}}"  allow="accelerometer;  encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
                                              <video id='video-player'  preload='metadata' controls>
                                               <source src="{{asset($thirdUrl)}}" type="video/mp4">
                                             </video>
                                          </div>   
                                       <?php }?>                                            
                                 
                                 <?php }?>
                              </div> 

                           </div>      

                                                           
                           
                        </div>   
                        
                     </div>
                  </div>
               </div>   
            </div>
         <?php } }?>
         <?php if(($searchResult == null) || (($searchResult != null) && ($searchResult['totalAppliedJob']->count() == 0))){?>
            <div class="row mb-4"> 
         <div class="col-12">
            <div class="nodata-found-holder">
               <img src="{{ asset('frontend/images/warning-icon.png') }}" alt="notification" class="img-fluid"/>
               <h4>{{ __('messages.SORRY_NO_RESULT_FOUND') }}</h4> 
            </div>
         </div> 
         </div>
         <?php }?>
      </div>
   </section>
</main>
<script type="text/javascript">
          $(".multiple-select select.multi-select-states").bsMultiSelect();
          $(".multiple-select select.multi-select-language").bsMultiSelect(); 
          $(".multiple-select select.multi-select-city").bsMultiSelect(); 
          $(document).ready(function() {
            var  city = [
               {
                  "id": "1",
                  "name": "Mumbai",
                  "state": "Maharashtra"
               },
               {
                  "id": "2",
                  "name": "Delhi",
                  "state": "Delhi"
               },
               {
                  "id": "3",
                  "name": "Bengaluru",
                  "state": "Karnataka"
               }
            ];
            var arr= new Array();
            $.each( city, function(key, obj){
                arr.push(obj.name);
            });
            $( "#city" ).autocomplete({
              source: arr
            });

        });
      </script>
@endsection