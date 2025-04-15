<?php $count = count($candidate) ; if($candidate){ 
 foreach($candidate as $key=>$value){?>
<div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 mb-3 mb-md-4 text-center">
<div class="profile-whitebox">
    <div class="profile-img-holder">
    <div class="profile-bg-img">
    <a href="{{url('candidate/profile/'.$value['followingUser']['slug'])}}"> 
    <?php if($value['followingUser']['bannerImage'] != null){?>
            <img src="{{asset($value['followingUser']['bannerImage']['location'])}}" alt="">
    <?php }else{ ?>
            <img src="{{asset('frontend/images/user-pro-bg-img.jpg')}}" alt="">
    <?php }?>
    </a>
    </div>
    <div class="profile-img">
    <a href="{{url('candidate/profile/'.$value['followingUser']['slug'])}}">    
    <?php if($value['followingUser']['profileImage'] != null){?>
            <img src="{{asset($value['followingUser']['profileImage']['location'])}}" alt="">
    <?php }else{ ?>
            <img src="{{asset('frontend/images/user-pro-img-demo.png')}}" alt="">
    <?php }?>
    </a>
    </div>
    </div>   
    <div class="profile-text-holder">
    <h3 class="h3-profile"><a href="{{url('candidate/profile/'.$value['followingUser']['slug'])}}"> {{$value['followingUser']['first_name']}}</a></h3>
    <h6><?php echo $value['followingUser']['currentCompany']['title']; if($value['followingUser']['currentCompany']['title'] != ''){ echo ' at '.$value['followingUser']['currentCompany']['company_name'];}?></h6>
    </div>
</div>
</div>
<?php } } if($count == 0){?>
    <div class="col-12">
            <div class="nodata-found-holder">
               <img src="{{ asset('frontend/images/warning-icon.png') }}" alt="notification" class="img-fluid"/>
               <h4>Sorry! No profile found.</h4> 
            </div>
         </div> 
<?php }?>