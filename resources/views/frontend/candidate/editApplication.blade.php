@extends('layouts.app_after_login_layout')
@section('content')
<script type="text/javascript">
   var jobId = '<?php echo $jobId; ?>';
</script>
  
<script src="{{asset('frontend/js/applyJob.js')}}"></script>
<script src="{{asset('ckeditor/ckeditor.js')}}"></script> 
<script src="{{asset('frontend/js/sweetalert.min.js')}}"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
<main>

    <?php 
      $jobAppliedId =  isset($appliedJob) ? $appliedJob['job_applied_id'] : '';
    ?>

    <section class="section section-applyjob">
        <div class="container">
            <div class="row">
                <div class="col-12"> 
                    <div class="section-myprofile">
                        <div class="mb-5 col-sm-12 details-panel-header">
                                <h3 class="mt-0 text-center font-22 ">{{__('messages.APPLY_TO')}} {{$companyName}}</h3>
                        </div>
                        <form id="step_one" action="" method="post">
                            {{ csrf_field() }}
                            <div class="login-form" id="apply-job-company"> 
                            <input name="job_applied_id" id="job_applied_id" value="{{$jobAppliedId}}" type="hidden"/>
                            <input name="job_id" id="job_id" value="{{$jobId}}" type="hidden"/>
                            <div class="row">
                                <div class="col-sm-12 col-xl-12 apply-job-holder">
                                    <div class="form-group">
                                        <label class="question-label">{{__('messages.COVER_LETTER')}}:</label>
                                        <textarea  id="cover_letter" rows="100" name="cover_letter">{{isset($appliedJob) ? $appliedJob['cover_letter'] : ''}}</textarea>
                                        <label class="error descErr" style="display:none;"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 mb-5 row browse-f-sec">
                            <div class="col-12 col-md-12">
                                <label>Upload Curriculum</label>
                                <div class="p-0 mb-2 mr-sm-2 col-sm-12 wrap-input-container form-inline">
                                    <label class="custom-file-upload form-control {{ isset($uploadedCV) ? 'active':'' }}">
                                        <i class="fa fa-cloud-upload"></i>{{ isset($uploadedCV) ? $uploadedCV->org_name : 'click here to upload your cv' }}
                                    </label>
                                    <input class="file-upload" name="file" type="file">
                                    <button class="btn-clear" type="button" data-role="remove" id="removeCV">
                                        <i class="fa fa-times"></i>
                                    </button>
                                    <input type="hidden" id="is_delete_cv" name="is_delete_cv" value="0">
                                </div>
                                @if(isset($uploadedCV))
                                <div>
                                    <label><a href="{{ url($uploadedCV->location) }}" target="_blank">Downnload Your CV</a></label>
                                </div>
                                @endif
                            </div>
                            {{-- <div class="col-12 col-md-6">
                                <label>Additional Documents</label>
                                @if(isset($uploadOtherDoc))
                                @foreach($uploadOtherDoc as $doc)
                                <div data-role="dynamic-fields">
                                    <div class="form-inline form-row">             
                                        <!-- file upload start-->
                                        <div class="mb-2 mr-sm-2 col-10 col-sm-10 col-md-10 col-lg-11 wrap-input-container">
                                            <label class="custom-file-upload form-control active">
                                            <i class="fa fa-cloud-upload"></i> {{ $doc->org_name }}
                                            </label>
                                            <input class="file-upload" name="additional_doc[]" type="file">
                                            <input type="hidden" name="additional_doc_id[]" value="{{ $doc->id }}">
                                        </div>
                                        <!-- file upload ends-->                
                                                        
                                        <button class="mb-2 btn btn-sm btn-danger btn-cross" data-role="remove">
                                        <i class="fa fa-times"></i>
                                        </button>
                                        <button class="mb-2 btn btn-sm btn-primary" data-role="add">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                        <div class="mb-2">
                                            <label><a href="{{ url($doc->location) }}" target="_blank">Downnload Your {{ $doc->org_name }}</a></label>
                                        </div>
                                    </div>  <!-- /div.form-inline -->
                                </div>  <!-- /div[data-role="dynamic-fields"] --> 
                                @endforeach
                                @endif
                                <div data-role="dynamic-fields">
                                    <div class="form-inline form-row">             
                                        <!-- file upload start-->
                                        <div class="mb-2 mr-sm-2 col-10 col-sm-10 col-md-10 col-lg-11 wrap-input-container">
                                            <label class="custom-file-upload form-control">
                                            <i class="fa fa-cloud-upload"></i> click here to upload document
                                            </label>
                                            <input class="file-upload" name="additional_doc[]" type="file">
                                        </div>
                                        <!-- file upload ends-->                
                                                        
                                        <button class="mb-2 btn btn-sm btn-danger btn-cross" data-role="remove">
                                        <i class="fa fa-times"></i>
                                        </button>
                                        <button class="mb-2 btn btn-sm btn-primary" data-role="add">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>  <!-- /div.form-inline -->
                                </div>  <!-- /div[data-role="dynamic-fields"] --> 
                                </div>
                            </div> --}}
                            @if(Auth::user() && Auth::user()->is_payment_done == 2)
                            <!-- <div class="mt-4 mb-4 row align-items-center justify-content-between">
                                <div class="mb-2 col-12 form-group">
                                    <label for="staticEmail2">Highlight sentence</label>
                                </div>
                                <div class="mb-0 col-12 form-group">
                                    <input type="text" class="form-control" id="inputPassword2" placeholder="Enter your choice" name="highlight_sentence" value="{{ isset($profile) ? $profile->highlight_sentence : '' }}">
                                </div>
                            </div> -->
                            @endif
                            <div class="mt-4 row">
                                <div class="text-center col-sm-12">
                                    <button class="btn site-btn-color update-job-application-doc" id="save-as-draft" type="button" @if(Auth::user() == NULL) disabled @endif>{{__('messages.UPDATE_JOB')}}</button>
                                </div>
                            </div>
                            </div> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- main End -->
<!--footer start-->
<script src="{{ asset('frontend/js/dropzone.min.js')}}"></script>
<script src="{{ asset('frontend/js/aos.js')}}"></script>
<script src="{{ asset('frontend/js/jquery.easing.min.js')}}"></script>
<script src="{{ asset('frontend/js/BsMultiSelect.js')}}"></script>
<script src="{{ asset('frontend/js/tagsinput.js')}}"></script> 
<script src="{{ asset('frontend/js/swiper.min.js')}}"></script>
<!--footer end-->

<script type="text/javascript">
    function showSuccessMsg(msg){
        let msgBox = $(".alert-holder-success");
        msgBox.addClass('success-block');
        msgBox.find('.alert-holder').html(msg);
        setTimeout(function(){ msgBox.removeClass('success-block')},5000);
    }
   $(document).on('change', '.file-upload', function(){
       //var files = $(this).prop("files");
      // console.log(files);
       if ($(this).prop("files")) {
         $(this).siblings('.custom-file-upload').addClass('active');
       }else{
         $(this).siblings('.custom-file-upload').removeClass('active');
       }
   });
   $(document).on('click','.update-job-application-doc',function(){
        var jobId = {{ $jobId }};
        var desc = CKEDITOR.instances['cover_letter'].getData( ).replace( /<[^>]*>/gi, '' ).length;
        if(desc > 2000){
            $('.descErr').css('display','block');
            $('.descErr').text($this.lanFilter(allMsgText.COVER_LETTER_SHOULD_NOT_GREATER_1000_WORDS));
            return false;
        }
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
           
        var form_profile_info = document.getElementById("step_one");
        var fd = new FormData(form_profile_info);	
        // fd.append('cover_letter',CKEDITOR.instances['cover_letter'].getData());
        //console.log($('#cover_letter').val());
        $.ajax({
                url: _BASE_URL+"/candidate/edit-application/"+jobId,
                data:fd,
                method:'POST',
                dataType:'json',
                cache : false,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
                    console.log(response);
                    let msg = '';
                    if(response.success == 0){
                        msg = response.message;
                        showSuccessMsg(msg);
                        window.location.href = _BASE_URL+"/candidate/see-application";
                    }else{
                        console.log('111');
                    }
                }
            }).done(function() {
        });
    });
</script>
@endsection
