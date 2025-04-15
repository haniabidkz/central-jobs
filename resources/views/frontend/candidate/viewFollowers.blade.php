@extends('layouts.app_after_login_layout')
@section('content')
<script src="{{asset('frontend/js/viewFollower.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- main -->
<main>
<section class="section section-follower">
   <div class="container">
      <div class="row">
         <div class="col-12 col-md-12 col-lg-10 mx-auto">
            <div class="profile-side-panel mb-0">
               <div class="followers-holder">
                  <div class="followers-title">
                     <h3> <span>{{ __('messages.TOTAL_FOLLOWERS') }} <b class="ml-2"><?php echo count($allFollowers);?></b></span> </h3>
                  </div>
                  <!--sd-title end-->
                  <div class="followers-list">
                     <?php if(!empty($allFollowers)){ 
                        foreach($allFollowers as $key=>$val){ 
                           if($val['user']['user_type'] == 2){ 
                              $type = 'candidate';
                              }elseif($val['user']['user_type'] == 3){ 
                                 $type = 'company';
                              }
                     ?>
                     <div class="media">
                       
                        <?php if($val['user']['profileImage'] != null){?>
                           <img src="{{asset($val['user']['profileImage']['location'])}}" alt="">
                        <?php }else{ ?>
                            <img src="{{asset('frontend/images/user-pro-img-demo.png')}}" alt="">
                        <?php }?>
                        <div class="media-body">
                        <h4><a href="{{url($type.'/profile/'.$val['user']['slug'])}}"> <?php echo $val['user']['first_name'].' '.$val['user']['last_name']; ?></a></h4>
                           <span><?php echo $val['user']['profile']['profile_headline']; ?></span>
                        </div>
                        <div class="d-flex align-items-center profile-btn-holder">
                           <div class="dropdown msg-dropdown mr-2">
                              <!-- <button class="btn site-btn-color  dropdown-toggle" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                              Follow
                              </button> -->
                             
                           </div> 
                           <div class="dropdown msg-dropdown">
                        <!-- <button class="btn site-btn-color dropdown-toggle block_user" type="button" data-id="{{$val['user']['id']}}" <?php //if($val['user']['isUserBlockedByLogedInUser'] != null){?> data-block="0" <?php //}else{?> data-block="1" <?php// }?> id="block_user_{{$val['user']['id']}}">
                        <?php //if($val['user']['isUserBlockedByLogedInUser'] != null){ 
                          // echo  __('messages.UN_BLOCK') ;
                        //}else{
                          // echo  __('messages.BLOCK');
                        //}?> 
                              </button> -->
                              <!-- <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                 <a class="dropdown-item" href="#">Un-Block</a>
                              </div> -->
                           </div>
                        </div>
                     </div>
                    <?php }
                        echo $allFollowers->appends(request()->query())->links() ;
                  }?>
                     
                  </div>
                  <!--suggestions-list end-->
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
</main>
<!-- main End -->
@endsection