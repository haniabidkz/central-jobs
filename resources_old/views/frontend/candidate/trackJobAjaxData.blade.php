<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="{{asset('frontend/js/sweetalert.min.js')}}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<?php $count = count($jobList) ; 
if($jobList){ 
 foreach($jobList as $key=>$value){ ?>
<div class="col-12 col-md-6 col-lg-6 col-xl-4" id="rmv_job_from_save_{{$value['jobPost']['id']}}">
    <div class="track-job-box">
        <div class="media">
        <div class="user-img">
        <?php if($value['jobPost']['company']['profileImage'] != null){?>
                <img src="{{asset($value['jobPost']['company']['profileImage']['location'])}}" alt="">
        <?php }else{ ?>
                <img src="{{asset('frontend/images/user-pro-img-demo.png')}}" alt="">
        <?php }?>
        </div>
        <div class="media-body ml-3">
        <h6><a <?php if($search['status'] != 2){ 
            $toDay = strtotime(date('Y-m-d'));
            if((strtotime($value['jobPost']['start_date']) <= $toDay) && (strtotime($value['jobPost']['end_date']) >= $toDay)){
                if($value['jobPost']['applied_by'] == 1){ ?>
                 href="{{url('candidate/apply-job/'.encrypt($value['jobPost']['id']))}}" target="_blank" 
                 <?php }else{ ?> 
                    href="{{$value['jobPost']['website_link']}}" target="_blank" 
                    <?php } }else{ ?> 
                        href="javascript:void(0);" id="exp-alert-msg-{{$value['jobPost']['id']}}" onClick="reply_click({{$value['jobPost']['id']}})" 
                        <?php } }else{?> 
                            href="javascript:void(0);" style="cursor:default"
                            <?php }?>
                             class="total-sub-title-black">{{$value['jobPost']['title']}}
                            </a>
                        </h6>
            <p><i class="fa fa-building-o" aria-hidden="true"></i><a href="{{url('company/profile/'.$value['jobPost']['company']['slug'])}}" target="_blank">{{$value['jobPost']['company']['company_name']}}</a></p>
            <!-- Visible only in case of applied job -->
            <?php if($search['status'] == 2){?>
            <p><i class="fa fa-map-marker" aria-hidden="true"></i>{{$value['appliedUserInfo']['state']['name']}} , {{$value['appliedUserInfo']['country']['name']}}</p>
            <?php }?>
            <p><i class="fa fa-clock-o" aria-hidden="true"></i><?php $toDay = strtotime(date('Y-m-d')); if((strtotime($value['jobPost']['start_date']) <= $toDay) && (strtotime($value['jobPost']['end_date']) >= $toDay)){ echo __('messages.ONGOING') ;}else if(strtotime($value['jobPost']['end_date']) < $toDay){ echo __('messages.CLOSED');}else if(strtotime($value['jobPost']['start_date']) > $toDay){ echo __('messages.PENDING_PUBLICATION');}?> </p>
            <!-- Visible only in case of applied job -->
            <?php if($search['status'] == 2){?>
            <p><i class="fa fa-calendar" aria-hidden="true"></i>{{ __('messages.APPLIED_ON') }}: <span>{{date('d-m-Y',strtotime($value['apply_date']))}}</span></p>
            <?php }?>
            <?php if($search['status'] == 0){?>
             <button class="btn site-btn-color saveJobCls" id="save-job-{{$value['jobPost']['id']}}" data-id="{{$value['jobPost']['id']}}" data-type="0"> {{ __('messages.REMOVE') }} </button>  
            <?php }?>
            <!-- Visible only in case of saved jobs -->
        </div>
        </div>
    </div>
</div>
<!-- <script> var jobId = <?php //echo $value['jobPost']['id'];?>;
$(document).ready(function() {
    
console.log(jobId);
$( "#exp-alert-msg-"+jobId ).on( "click", function() {
        swal($this.lanFilter(allMsgText.SORRY_THIS_JOB_IS_EXPIRED));
        return false; 
    });
});
</script> -->
<?php } } if($count == 0){?>
    <div class="col-12">
            <div class="nodata-found-holder">
               <img src="{{ asset('frontend/images/warning-icon.png') }}" alt="notification" class="img-fluid"/>
               <h4>{{ __('messages.SORRY_NO_JOBS_FOUND') }}</h4> 
            </div>
         </div> 
<?php }?>

<script>
$(document).ready(function() {
    
    $( ".saveJobCls" ).on( "click", function() {
        var $this = this;
        var jobId = $($this).attr("data-id");
        var saveType = $($this).attr("data-type");
        $.ajax({
            method: "POST",
            url: _BASE_URL+"/candidate/save-job",
            data: {'id': jobId, 'saveType' : saveType},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                if(saveType == 0){
                    $("#rmv_job_from_save_"+jobId).remove();
                    if(res == 0){
                        var nodataHtml = '<div class="col-12"><div class="nodata-found-holder"><img src="'+_BASE_URL+'/frontend/images/warning-icon.png" alt="notification" class="img-fluid"/><h4>{{ __('messages.SORRY_NO_JOBS_FOUND') }}</h4></div></div>';
                        $("#post-data").html(nodataHtml);
                    }
                    
                }
                
            }
        }); 
    }); 

    
});
function reply_click(clicked_id)
  {
    swal($this.lanFilter(allMsgText.SORRY_THIS_JOB_IS_EXPIRED));
        return false; 
  }
</script>