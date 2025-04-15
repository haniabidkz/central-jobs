@extends('layouts.app_after_login_layout')
@section('content')
<script src="{{asset('frontend/js/sweetalert.min.js')}}"></script>
<script src="{{ asset('frontend/js/job.js')}}"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<main>
<section class="section section-myjob">
<div class="container">
   <div class="row">
      <div class="col-12">
         <form>
            <div class="section-myprofile">
               <div class="login-form">
                  <div class="row mb-4">
                     <div class="col-12 col-sm-8">
                        <h4 class="page-title">{{ __('messages.SEARCH_PREVIOUS_JOB_POST_HERE') }}</h4> 
                     </div>
                     <div class="col-12 col-sm-4 text-sm-right">
                        <?php if(Auth::user()->user_type == 3){?>
                        <a class="btn site-btn-color" href="{{ url('company/payment-details') }}">{{ __('messages.POST_JOB') }}</a>
                        <?php }?>
                     </div>
                  </div>
                  <form id="search-job" action="{{ url('company/my-jobs') }}" method="post">
                  {{csrf_field()}}
                  <div class="row">   
                     <div class="col-12 col-sm-6 col-xl-4">
                        <div class="form-group">
                           <div class="select-dat">
                              <input type="text" class="form-control" placeholder="{{ __('messages.START_DATE') }}" id="start_date" name="start_date" autocomplete="off" value="{{@$search['start_date']}}">
                           </div>
                        </div>
                     </div>
                     <div class="col-12 col-sm-6 col-xl-4">
                        <div class="form-group">
                           <div class="select-dat">
                                 <input type="text" class="form-control" placeholder="{{ __('messages.END_DATE') }}" id="end_date" name="end_date" autocomplete="off" value="{{@$search['end_date']}}">
                                 <label class="error error-end-date" style="display:none;"></label>
                           </div>
                        </div>   
                     </div>
                     <div class="col-12 col-sm-6 col-xl-4">
                        <div class="form-group">
                           <input type="text" class="form-control" placeholder="{{ __('messages.POSITION_NAME') }}" id="title" name="title" value="{{@$search['title']}}">
                        </div>
                     </div>
                     
                     <!-- <div class="col-12 col-sm-6 col-xl-4">
                        <div class="form-group  multi-select-states-area required">
                           <select name="state"  id="state" class="form-control">
                           <option value="">{{ __('messages.STATE') }} </option>
                           <?php if($states){
                                 foreach ($states as $key => $value) {
                                 ?>
                                 <option value="{{$value['id']}}" <?php if($value['id'] == @$search['state']){ echo 'selected';} ?>>{{$value['name']}}</option>
                                 <?php } } ?>
                           </select>
                        </div>
                     </div> -->
                     <div class="col-12 col-sm-6 col-xl-4">
                        <div class="form-group">


                           <select name="city"  id="city" class="form-control select-city-area">
                              <option value="">{{ __('messages.CITY') }} </option>
                              <?php if($cities){
                                 foreach ($cities as $key => $city) {   
                                 ?>
                                 <option value="{{$city->id}}" <?php if($city->id == @$search['city']){ echo 'selected';} ?>>{{$city->name}}</option>
                              <?php  } } ?>
                              
                           {{-- <input class="form-control select-city-area" name="city" id="city"/>
                           <input type="hidden" class="form-control select-city-area" name="city" id="city" />  --}}
                        </select>
                         
                        </div>
                     </div> 
                     
                     <div class="col-12 col-sm-6 col-xl-4">
                        <div class="form-group required">
                           <input type="text" class="form-control" placeholder="{{ __('messages.REFERENCE') }}" name="job_id" id="job_id" value="{{@$search['job_id']}}">
                        </div>
                     </div>
                     <div class="col-12 col-sm-6 col-xl-4">
                        <div class="form-group">
                           <select class="form-control" name="status" id="status">
                              <option value=""> {{ __('messages.STATUS') }}</option>
                              <option value="1" <?php if(@$search['status'] == 1){ echo 'selected';}?>>{{ __('messages.ONGOING') }}</option>
                              <option value="2" <?php if(@$search['status'] == 2){ echo 'selected';}?>>{{ __('messages.CLOSED') }}</option>
                              <option value="3" <?php if(@$search['status'] == 3){ echo 'selected';}?>>{{ __('messages.PENDING_PUBLICATION') }}</option>
                           </select>
                           
                        </div>
                     </div> 
                     
                     <div class="col-12">
                     <label class="error error-required-search" style="display:none;"></label>
                        <div class="form-group d-flex">
                           <button class="site-btn btn search-cls mr-2" type="submit">{{ __('messages.SEARCH') }}</button>
                           <?php $searchCop = $search ; if(!empty($searchCop) && (isset($searchCop['_token']) && $searchCop['_token'] != '') ){?>
                           <a class="btn site-btn-color" href="{{ url('company/my-jobs') }}"><i class="fa fa-refresh" aria-hidden="true"></i></a>                 
                           <?php } ?>
                        </div>
                     </div>
                  </div>
                  </form>
               </div>
            </div>
         </form>
      </div>
   </div>
   <div class="row">
      
      <?php if($jobList->count() != 0){ 
         ?>
            <!-- /.card-header -->
            <div class="col-12">
               <div class="table-responsive job-tbl-cls"> 
                     <table class="table custom-table" id="candidateList">
                        <thead class="custom-thead">
                           <tr>
                                 <th>#<!-- {{ __('messages.SL_NO') }} --></th>
                                 <th>{{ __('messages.REFERENCE') }}</th>
                                 <th>{{ __('messages.TITLE') }}</th>
                                <!--  <th>{{ __('messages.STATE') }}</th> -->
                                 <th>{{ __('messages.CITY') }}</th>
                                <!--  <th>{{ __('messages.POSITION') }}</th> -->
                                 <th>{{ __('messages.TYPE') }}</th>
                                 <th>{{ __('messages.START') }}</th>
                                 <th>{{ __('messages.END') }}</th>
                                 <th>{{ __('messages.STATUS') }}</th>
                                 <th>{{ __('messages.TOTAL_APPLICANT') }}</th>
                                 <th>{{ __('messages.ACTION') }}</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $lastParam = app('request')->input('page');
                           if($lastParam == '' || $lastParam == 1){
                                 $i = 0; 
                           }
                           else{ 
                                 $i= (($lastParam-1) * env('FRONTEND_PAGINATION_LIMIT'));
                           } 
                           foreach($jobList as $key=>$job){ 
                              $i++ ;
                              if($job['city'] != ''){
                              $citiesArr = explode(",",$job['city']);
                              if(!empty($citiesArr)){
                                 $city = $citiesArr[0];
                              }
                           }
                              ?>

                           <tr>
                                 <td><?php echo $i;?></td>
                                 <td>{{$job['job_id']}}</td>
                                 <td>{{$job['title']}}</td>
                                <!--  <td><?php if(count($job['postState']) > 0){ echo $job['postState'][0]['state']['name'];}?></td> -->
                                 <td>{{$city}}</td>
                                 <!-- <td>
                                    <?php 
                                    if($job['cmsBasicInfo']){ 
                                       foreach($job['cmsBasicInfo'] as $key=>$val){
                                             if($val['type'] == 'seniority'){
                                                echo isset($val['masterInfo']['name']) ? $val['masterInfo']['name'] : '';
                                             }
                                       }
                                    }
                                    ?>
                                 </td> -->
                                 <td>
                                 <?php 
                                    if($job['cmsBasicInfo']){ 
                                       foreach($job['cmsBasicInfo'] as $key=>$val){
                                             if($val['type'] == 'employment_type'){
                                                echo $val['masterInfo']['name'];
                                             }
                                       }
                                    }
                                    ?>
                                 </td>
                                 <td>{{date('Y-m-d',strtotime($job['start_date']))}}</td>
                                 <td>{{date('Y-m-d',strtotime($job['end_date']))}}</td>
                                 <td>
                                 <?php $status=''; $status_color=''; $toDay = strtotime(date('Y-m-d')); 
                                 if((strtotime($job['start_date']) <= $toDay) && (strtotime($job['end_date']) >= $toDay)){ 
                                       $status =  __('messages.ONGOING');
                                       $status_color = 'btn-success';
                                    }else if(strtotime($job['end_date']) < $toDay){ 
                                       $status = __('messages.CLOSED');
                                       $status_color = 'btn-danger';
                                    }else if(strtotime($job['start_date']) > $toDay){ 
                                       $status = __('messages.PENDING');
                                       $status_color = 'btn-warning';
                                    }?>
                                 <button type="button" class="btn {{$status_color}} btn-lg disable-cursor">{{$status}}</button>
                                 </td>
                                 <td style="text-align:center;">
                                 <?php  $result = Helper::getAppliedCandidateCount($job['id']); echo $result;?>
                                 </td>
                                 <td>
                                 
                                 <div class="dropdown">
                                    <button class="btn site-btn-color btn-sm dropdown-toggle" type="button"  data-toggle="dropdown"  id="aaaaa">{{ __('messages.ACTIONS') }} </button>
                                       <ul class="dropdown-menu" id="bag" style="list-style-type: none;">
                                          
                                             <li><a class="dropdown-item" href="{{url('company/view-job-post/'.encrypt($job['id']))}}">{{ __('messages.VIEW') }}</a></li>
                                             <?php if($result == 0){?>
                                             <li><a class="dropdown-item" href="{{url('company/edit-job/'.encrypt($job['id']))}}">{{ __('messages.EDIT') }}</a></li>
                                             <?php }?>
                                             <li><a  href="javascript:void(0);" class="dropdown-item delete_item" data-id="{{encrypt($job['id'])}}">{{ __('messages.DELETE') }}</a></li>
                                             <li><a href="{{ url('company/applied-candidates/'.encrypt($job['id'])) }}" class="dropdown-item">{{ __('messages.VIEW_APPLICANT') }} </a></li>
                                             
                                       </ul>
                                 </div>
                                 </td>
                           </tr>
                                 <?php }?>
                        </tbody>   
                     </table>
               </div>    
            </div>
            <!-- /.card-body -->

            <div class="col-12  mt-3">
            <?php //echo $jobList->appends(request()->query())->links() ;?>
            </div>
            <?php }?>
      
      <?php if($jobList->count() == 0){?>
      <div class="col-12">
         <div class="nodata-found-holder">
            <img src="{{ asset('frontend/images/warning-icon.png') }}" alt="notification" class="img-fluid"/>
            <h4>{{ __('messages.SORRY_NO_JOBS_FOUND') }}</h4> 
         </div>
      </div> 
      <?php }?>
   </div>
</div>
</section>
</main>
<script>
$(".multiple-select select.multi-select-states").bsMultiSelect();
$(document).ready(function() {
   $( "#start_date" ).datepicker({
         dateFormat: "yy-mm-dd",
         //maxDate: '0',
         onSelect: function(selected) {
         $("#end_date").datepicker("option","minDate", selected)
      }
   });
      
   $('#end_date').datepicker({
         dateFormat: "yy-mm-dd",
         //maxDate: '0',
         onSelect: function(selected) {
         $("#start_date").datepicker("option","maxDate", selected)
         }
   });
});

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
$(document).on('click','.delete_item',function(){
   var id = $(this).attr("data-id");
   try{
      swal({
            title: lanFilter(allMsgText.ARE_YOU_SURE),
            text: lanFilter('Do you want to delete the Job posts?'),
            icon: "warning",
            buttons: true,
            dangerMode: true,
      })
      .then((willDelete) => {
            if (willDelete) {
               $.ajax({
               url: _BASE_URL+"/company/jobs/destroy/"+id,
               data:{'id':id},
               method:'DELETE',
               headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
               success: function(response){
                  console.log(response);
                  let msg = lanFilter("Your job posts has deleted successfully.");
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
@push('sub-page-script')
<script>
</script>
@endpush