@extends('layouts.app_after_login_layout')
@section('content')
<script src="{{asset('backend/dist/js/bootstrap-datetimepicker.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('backend/dist/css/bootstrap-datetimepicker.css')}}">   
 <!-- main -->
 <main>
               <section class="banner banner-innerpage">
                    <div class="bannerimage">
                       <img src="{{asset(@$data[0]['page_content']['page_info']['banner_image']['location'])}}" alt="image">
                    </div>
                    <div class="bennertext">
                        <div class="innertitle">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12">
                                        <h2>{{strip_tags(@$data[5]['text'])}}</h2>                
                                    </div>
                                </div>
                            </div>
                        </div>                  
                    </div>
                </section>
                <section class="Company-overview service-text lg-bold-font">
                    <div class="container">
                        <div class="row">
                            <?php echo @$data[4]['text'];?>
                        </div>
                    </div>
                </section>
                <section class="section section-service">
                    <div class="container">
                        <div class="row">
                            <!-- <div class="col-md-12 col-12 headline-box text-center">
                            <?php echo @$data[3]['text'];?>
                            </div> -->
                            <!-- <div class="col-lg-4 col-12 mb-4">
                            <?php //echo @$data[2]['text'];?>
                            </div> -->
                            <!-- <div class="col-lg-4 col-12 mb-4">
                            <?php //echo @$data[1]['text'];?>
                            </div> -->
                            <div class="col-lg-8 mx-auto col-12 mb-4">
                            <?php echo @$data[0]['text'];?>
                            </div>                            
                        
                        </div>
                    </div>
                </section>                
            </main>

<!-- main End -->
<div class="modal custom-modal profile-modal prfexp" id="service-modal">
         <div class="modal-dialog">
            <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal"><i class="la la-times"></i></button>
               <div class="modal-body">
                  <div class="login-form">
                    <form name="form_service_info" id="form_service_info" action="{{ url('/candidate/store-service-info') }}" method="post">
                      
                     {{csrf_field()}}
                     <div class="row">
                        <div class="col-sm-12 details-panel-header">
                           <!-- <h4 class="text-left">{{__('messages.EDIT_PROFESSIONAL_EXPERIENCE')}}</h4>
                           <h6>{{__('messages.PROVIDE_THE_BASIC_INFORMATION_ABOUT_YOURSELF')}}</h6> -->
                        </div>
                        
                        <div class="col-12 col-sm-6 col-xl-6">
                           <div class="form-group">
                           <input type="hidden" name="subscription_id" id="subscription_id" value="3"/>
                              <select class="form-control" id="service_name" name="service_name" disabled>
                                 <option value="">{{__('messages.SERVICE_NAME')}}</option>
                                 @if(count($subscriptions) > 0)
                                @foreach($subscriptions as $key=>$val)
                                <option value="{{$val['id']}}" <?php if($val['id'] == 3){ echo 'selected';}?>>{{$val['title']}}</option>
                                @endforeach
                                @endif
                              </select>
                           </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-6">
                           <div class="form-group required">
                              <input class="form-control" placeholder="{{__('messages.CANDIDATE_NAME')}}" type="text" id="candidate_name" name="candidate_name" value="{{$name}}">
                           </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-6">
                           <div class="form-group required">
                              <input class="form-control" placeholder="{{__('messages.CANDIDATE_EMAIL')}}" type="text" id="candidate_email" name="candidate_email" value="{{$email}}">
                           </div>
                        </div>
                        
                        <div class="col-12 col-sm-6 col-xl-6">
                           <div class="form-group required">
                              <div class="select-dat">
                                 <input type="text" class="form-control" placeholder="{{__('messages.PROPOSE_DATE_TIME_ONE')}}" id="service_start_from" name="service_start_from"  value="" autocomplete="off">
                              </div>
                           </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-6">
                           <div class="form-group required">
                              <div class="select-dat">
                                    <input type="text" class="form-control" placeholder="{{__('messages.PROPOSE_DATE_TIME_TWO')}}" id="propose_date_2" name="propose_date_2"  value="" autocomplete="off">
                              </div>
                           </div>   
                        </div>
                        <div class="col-12 col-sm-6 col-xl-6">
                           <div class="form-group required">
                              <div class="select-dat">
                                    <input type="text" class="form-control" placeholder="{{__('messages.PROPOSE_DATE_TIME_THREE')}}" id="propose_date_3" name="propose_date_3"  value="" autocomplete="off">
                              </div>
                           </div>   
                        </div>
                        <div class="col-12">
                            <label class="check-style">{{ __('messages.I_HAVE_READ_AND_AGREE_TO_THE') }} <a href="{{url('terms-use')}}" target="_blank" >{{ __('messages.TERMS_OF_USE') }}</a>.
                            <input id="terms_conditions_status" type="checkbox" name="terms_conditions_status">
                            <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="col-12">
                            <label class="check-style">{{ __('messages.I_HAVE_READ_AND_AGREE_WITH_THE') }} <a href="{{url('privacy-policy')}}" target="_blank" >{{ __('messages.PRIVACY_POLICY') }}</a>.
                            <input id="privacy_policy_status" type="checkbox" name="privacy_policy_status">
                            <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="col-12">
                            <label class="check-style">{{ __('messages.I_HAVE_READ_AND_AGREE_WITH_THE') }} <a href="{{url('terms-use')}}" target="_blank" >{{ __('messages.COOKIES_POLICY') }}</a>.
                            <input id="cookies_policy_status" type="checkbox" name="cookies_policy_status">
                            <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="col-12">
                           <div class="form-group">
                              <button class="site-btn btn submit-service-btn" type="submit" >{{__('messages.SUBMIT')}}</button>
                           </div>
                        </div>
                     </div>
                   </form>
                  </div>
               </div>
            </div>
         </div>
      </div>

<?php if((Auth::user() && (Auth::user()->user_type == 2)) || (Auth::user() == false)){?>   
<script>
$(document).on('click','.get-service',function(event){
    $('#service-modal').modal('show');
});

$(document).ready(function(){
    //DATEPICKER1
    $(function () {    
            //custom date filter 
        jQuery.validator.addMethod(
            "dateTime",
    
        function (value, element, params) {
            if (!/Invalid|NaN/.test(new Date(value))) {
                return true;
            }
    
            return false;
        },
            'Must be in YYYY-MM-DD HH:mm format.');
        //end custom date filter
        var nowDate = new Date();
        var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), nowDate.getHours(),  nowDate.getMinutes());
        //$('#service_start_from').datepicker({  format: 'yyyy/mm/dd' , startDate : today });
        $("#service_start_from").datetimepicker({
            format: 'yyyy-mm-dd hh:ii', 
            startDate : today,
            autoclose: true
        });
        $("#propose_date_2").datetimepicker({
            format: 'yyyy-mm-dd hh:ii', 
            startDate : today,
            autoclose: true
        });
        $("#propose_date_3").datetimepicker({
            format: 'yyyy-mm-dd hh:ii', 
            startDate : today,
            autoclose: true
        });
    });


    $.validator.addMethod("laxEmail", function(value, element) {
              // allow any non-whitespace characters as the host part
              var re = /[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/igm;
              return this.optional( element ) || re.test( value );
            }, 'Please enter a valid email address.');
    $.validator.addMethod("noSpace", function(value, element) { 
    if(value != ''){
        value = $.trim(value);
        if(value == ''){
            return false;
        }else{
            return true;
        }	
    }

    //return value.indexOf(" ",1) < 0 && value != ""; 
    }, $this.lanFilter($this.lanFilter(allMsgText.NO_SPACE_PLEASE_AND_DONT_LEAVE_IT_EMPTY)));
    $("#form_service_info").validate({
        rules: {
            candidate_name: {
                required: true,	
                noSpace: true																			
            },
            candidate_email: {
                required: true,	
                laxEmail: true																			
            },
            service_start_from:{
                required: true
            },
            terms_conditions_status:{
                required: true
            },
            privacy_policy_status:{
                required: true
            },
            cookies_policy_status:{
                required: true
            }
        },
        messages: {
            candidate_name: $this.lanFilter(allMsgText.PLEASE_PROVIDE_CANDIDATE_NAME),
            candidate_email: $this.lanFilter(allMsgText.PLEASE_PROVIDE_CANDIDATE_EMAIL),
            service_start_from: $this.lanFilter(allMsgText.PLEASE_PROVIDE_PROPOSE_DATE_TIME_ONE),
            terms_conditions_status: $this.lanFilter(allMsgText.PLEASE_AGREE_TO_TERMS_AND_CONDITIONS),
            privacy_policy_status: $this.lanFilter(allMsgText.PLEASE_AGREE_TO_PRIVACY_POLICY),
            cookies_policy_status: $this.lanFilter(allMsgText.PLEASE_AGREE_TO_COOKIES_POLICY),
        },
        submitHandler : function(form){	
                document.body.style.cursor = "progress";
				$('.submit-service-btn').prop('disabled', true);	
                $('#form_service_info').submit();														   					
                return false;
        }
    });
});
</script>
<?php }?>
@endsection