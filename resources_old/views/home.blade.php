@extends('layouts.app_before_login_layout')
@section('content')
<script src="{{asset('frontend/js/sweetalert.min.js')}}"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="{{ asset('frontend/css/select2.min.css')}}">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('frontend/js/select2.min.js')}}"></script>
<script src="{{ asset('frontend/js/BsMultiSelect.js')}}"></script>

<?php 
$typ = old('user_type'); 
$seg = request()->segment(count(request()->segments())); 
if($seg == 'joinus'){ $typ = 3;}?>
<?php 
if( ((Session::get('regSuccessMsg') != '') && (Session::get('regSuccessMsg') != null)) || ((Session::get('status') != '') && (Session::get('status') != null)) ){
   if((Session::get('regSuccessMsg') != '') && (Session::get('regSuccessMsg') != null)){
      $regSuccessMsg = Session::get('regSuccessMsg');
      $title = Session::get('title');
   } 

   if((Session::get('status') != '') && (Session::get('status') != null)){
      $regSuccessMsg = Session::get('status');
      $title = 'Registration';
   }

?>
<script>
var data = '<?php echo strip_tags($regSuccessMsg);?>';
var title = '<?php echo strip_tags($title);?>';
//swal(title, data, "success");
swal({
  title: title,
   icon: "success",
   text: data,
  //showConfirmButton: false,
  //html: true,
  className: "swal-email-notification"
});
</script>
<?php } ?>
<script>
$(document).ready(function() {

$('ul.step-one-cls span li').click(function() {
   $('.step-one-text-cls').show(); 
});
$('ul.step-one-cls li#step-one-cls-hide').click(function() {
   $('.step-one-text-cls').hide(); 
});
});
$(document).on('click','.step-one-cls',function(){
   $('.step-one-text-cls').show(); 
});
$(document).on('click','.step-one-cls-hide',function(){
   $('.step-one-text-cls').hide(); 
});
</script>

<!--  Custome login View  -->
 <!-- main -->
            <main>
               <section class="home-section2">
                  <div class="logo-section">
                     <div class="container">
                        <div class="row">
                           <div class="text-center col-12">
                              <div class="w-100">
                                 <a class="home-logo home-page-logo" href="{{ url('/') }}">
                                    <!-- <img src="{{ asset('frontend/images/logo-color-2.png') }}" alt="Logo" class="img-fluid"> -->
                                    <!-- <div class="logo-bg-holder">
                                       <img src="{{ asset('frontend/images/logo-white.png') }}" alt="Logo" class="img-fluid">
                                    </div> -->
                                    <div class="logo-bg-holder">
                                       <img src="{{ asset('frontend/images/logo.png') }}" alt="Logo" class="img-fluid">
                                    </div>
                                    <h2><span>CENTRAL</span> Jobs</h2>
                                    
                                 </a>
                                 
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col">
                              <div class="text-center alert alert-danger step-one-text-cls" role="alert" style="display:none;">
                                 <?php if(isset($data[1]['text'])){ echo strip_tags($data[1]['text']);} ?>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="section-home-container home-new-container">
                     <div class="container">  
                        <div class="row justify-content-between ">
                           <div class="p-0 col-lg-12 home-leftpanel d-flex justify-content-start">
                              <form class="w-100" method="get" action="{{ url('candidate/my-jobs') }}">
                                 <input type="hidden" name="company" value="1">
                                 <div class="login-sec login-sec-new form-home">
                                    <div class="row">
                                       <div class="col-12 col-md-3">
                                          <!-- <input type="text" class="form-control" placeholder="Reference"> -->
                                          <input type="text" class="form-control" placeholder="{{ __('messages.REFERENCE') }}" name="job_id" id="job_id" value="{{@$search['job_id']}}">
                                       </div>
                                       <div class="col-12 col-md-3">
                                          @php if(isset($search['position_name']) && $search['position_name'] != ''){
                                             foreach($search['position_name'] as $key=>$value){
                                                if(!in_array($value,$position)){
                                                   array_push($position,$value);
                                                }
                                             }
                                             
                                          }
                                          @endphp
                                          <!-- <input type="text" class="form-control" placeholder="Key-word"> -->
                                          <div class="input-search">
                                             <div class="form-group required">
                                                <select name="position_name[]" id="position_name" data-placeholder="{{ __('messages.KEYWORD') }}" id="itskills" class="form-control js-example-tags" multiple="multiple" style="display: none;">
                                                   @if($position) 
                                                   @foreach($position as $key=>$val)
                                                   <option value="{{$val}}" @if((isset($search['position_name'])) && in_array($val,$search['position_name'], TRUE))selected @endif>{{$val}}</option>
                                                   @endforeach
                                                   @endif
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-12 col-md-3">
                                          <!-- <input type="text" class="form-control" placeholder="Austria"> -->
                                          <!-- <div class="input-search">
                                             <div class="form-group  multi-select-states-area">
                                                <select name="state"  id="state" data-placeholder="{{ __('messages.STATE') }}"  class="form-control">
                                                   <option value="">{{ __('messages.STATE') }} </option>
                                                   @if($states)
                                                   @foreach ($states as $key => $value)
                                                   @if($value['name'] == 'Austria')
                                                   <option value="{{$value['id']}}" @if($value['id'] == @$search['state'])selected @endif>{{$value['name']}}</option>
                                                   @endif
                                                   @endforeach
                                                   @endif
                                                </select>   
                                             </div>
                                          </div> -->
                                          <div class="input-search">
                                             <div class="form-group  multi-select-states-area">
                                                <select name="country"  id="country" data-placeholder="{{ __('messages.COUNTRY') }}"  class="form-control">
                                                   <option value="14">Austria</option>
                                                </select>   
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-12 col-md-3">
                                          <!-- <input type="text" class="form-control" placeholder="City"> -->
                                          <div class="input-search">
                                             <div class="form-group">
                                                
                                                <select name="cityy_comp"  id="cityy_comp" class="form-control select-city-area city-dropdown">
                                                   <option value="">{{ __('messages.CITY') }} </option>
                                                   <option value="7156">Wien - Vienna</option>
                                                   <?php if($cities){
                                                      foreach ($cities as $key => $city) { 
                                                         if($city->id == 7157 || $city->id == 7156)  {
                                                            continue;
                                                         }
                                                      ?>
                                                      {{$city->id}}
                                                      <option value="{{$city->id}}" <?php if($city->id == @$search['cityy_comp']){ echo 'selected';} ?>>{{$city->name}}</option>
                                                      <?php  } } ?>
                                                </select>

                                                {{-- <input type="text" class="form-control" placeholder="{{ __('messages.CITY') }}" name="city_comp" id="city_comp" value="{{@$search['city_comp']}}"> --}}
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="mt-4 row">
                                    <div class="col-12 d-flex justify-content-end">
                                       <button type="submit" class="login-btn">{{ __('messages.SEARCH') }}</button>
                                    </div>
                                 </div>
                              </form>
                           </div>
                        </div>
                        
                     </div>
                     <div class="bg-black-home"></div>
                  </div>
                  <div class="bottom-part">
                     <div class="container">  
                        <div class="row">
                           <div class="col-12 col-lg-5 video_part_home video-home-new d-flex justify-content-start align-items-center">
                              <div class="laptop-video-div">
                                 <div class="text-center login-max-width img-with-laptop-holder">
                                    <img src="{{ asset('frontend/images/laptop-bgimg.png') }}">
                                    <div class="img-with-laptop">
                                       <img src="{{ asset('frontend/images/laptop_picture_original.jpg') }}">
                                       <div class="laptop-text"><h2>Jobs &amp;<br> Karriere</h2></div>
                                       {{-- <video autoplay muted="">
                                          <source src="{{ asset('frontend/video/video_home.mp4') }}" type="video/mp4">
                                          <source src="{{ asset('frontend/video/video_home.ogg') }}" type="video/ogg">
                                          Your browser does not support the video tag.
                                       </video> --}}
                                    </div>
                                 </div>
                              </div>    
                           </div>
                           <div class="col-12 col-lg-7 best-text">
                              {{-- <h4>The Best companies</h4>
                              <h5>advertise here!</h5> --}}
                              <h4>{{ __('messages.THE_BEST_COMPANIES_ADVERTISE_HERE')}}</h4>
                              <h2>{{ __('messages.YOUR_NEW_JOB_IS_HERE')}}</h2>
                           </div>
                        </div>
                        <div class="p-5 bg-white b-radius row justified-content-center">
                           @foreach($best_advertise as $add)
                           <div class="text-center col-12 col-md-3">
                              <label>{{ $add['initial_text'] }}</label>
                              <h2>{{ $add['position'] }}</h2>
                              <p>{{ $add['requirment'] }}</p>
                              <span>{{ $add['ref_no'] }}</span>
                           </div>
                           @endforeach
                           <!-- <div class="text-center col-12 col-md-3">
                              <label>Logistics company is looking for:</label>
                              <h2>Engineer</h2>
                              <p>3 years experience</p>
                              <span>Ref: 66474984</span>
                           </div>
                           <div class="text-center col-12 col-md-3">
                              <label>Logistics company is looking for:</label>
                              <h2>Manager</h2>
                              <p>3 years experience</p>
                              <span>Ref: 66474984</span>
                           </div>
                           <div class="text-center col-12 col-md-3">
                              <label>Logistics company is looking for:</label>
                              <h2>Analyst</h2>
                              <p>3 years experience</p>
                              <span>Ref: 66474984</span>
                           </div> -->
                        </div>
                        <div class="text-right home_foot_cntns">
                           <?php  if(isset($data[3]['text'])){ echo $data[3]['text']; }?>
                        </div>
                     </div> 
                  </div>     
               </section>
            </main>
            <!-- main End -->
<script>
   $(".js-example-tags").select2({tags: true,width:'100%'});
</script>     
@endsection
<!-- End Custom Login View -->
