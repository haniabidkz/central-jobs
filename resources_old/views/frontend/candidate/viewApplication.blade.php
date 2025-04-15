@extends('layouts.app_after_login_layout')
@section('content')
<script src="{{asset('frontend/js/sweetalert.min.js')}}"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<section class="section profile-account-setting">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-myprofile">
                    <div class="table_responsive">
                        <table class="table">
                            @if(count($appliedJobs) > 0)
                            <tr>
                                <th>{{ __('messages.JOB_POSITION') }}</th>
                                <th>{{ __('messages.JOB_COMPANY') }}</th>
                                <th></th>
                            </tr>
                                @foreach($appliedJobs as $job)

                                    @if(isset($job->jobPost->status) && $job->jobPost->status != 2)
                                    <tr>
                                        <td>
                                            {{ $job->jobPost->title }}
                                        </td>
                                        <td>
                                            {{ $job->jobPost->company->company_name }}
                                        </td>
                                        <td>
                                            @if($job->applied_status == 2)
                                            <a class="action_btn edit_action" href="{{ url('candidate/edit-application') }}/{{ encrypt($job->job_id) }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                            @else
                                            <a class="action_btn edit_action" href="{{ url('candidate/apply-job') }}/{{ encrypt($job->job_id) }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                            @endif
                                            <a class="action_btn delete_action" data-id="{{$job['job_id']}}"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            @else
                                No Applied Jobs is presents.
                            @endif
                        </table>
                       
                    </div>
                </div>
                <p style="color:red">{!! __('messages.SEE_APPLICATION_OPTIONS') !!}</p>
            </div>
        </div>
    </div>
</div>
<script>
    function lanFilter (str){
        var res = str.split("|");
        if(res[1] != undefined){
            str = str.replace("|","'");
            return str;
        }else{
            return str;
        }
    }
    function showSuccessMsg (msg){
        let msgBox = $(".alert-holder-success");
        msgBox.addClass('success-block');
        msgBox.find('.alert-holder').html(msg);
        setTimeout(function(){ msgBox.removeClass('success-block')},5000);
    }
    $(document).on('click','.delete_action',function(){
        var id = $(this).attr("data-id");
        try{
            swal({
                title: lanFilter(allMsgText.ARE_YOU_SURE),
                text: lanFilter('Do you want to delete this application?'),
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                    url: _BASE_URL+"/candidate/delete-application",
                    data:{'id':id},
                    method:'POST',
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response){
                        let msg = lanFilter("your job application has deleted successfully");
                        showSuccessMsg(msg);
                        window.location.reload();
                    },
                    error: function(){
                            alert("Something happend wrong.Please try again");
                    }	
                }).done(function() {
                            
                });			
                                                                                            
                }
            });	
                                                                
        
        }catch(error){
            console.log('storeProfileDataAjax function :: '+error);
        }
    });
</script>
@endsection