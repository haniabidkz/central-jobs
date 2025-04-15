@extends('layouts.app_after_login_layout')
@section('content')

<main>
   <section class="section section-dashboard">
      <div class="container">
         <div class="row">
            <div class="col-12 col-lg-10 col-xl-8 mx-auto">
               <div class="login-form">
                  <div class="row mb-4">
                     <div class="col-12">

                        <?php if($postData){
                           foreach($postData as $key=>$val){ 
                        ?>
                        <div class="post-block">
                           <div class="media">
                              <div class="user-profile">
                              <?php if($val['company']['profileImage'] != null){?>
                                 <img src="{{asset($val['company']['profileImage']['location'])}}" alt="">
                              <?php }else{ ?>
                                 <img src="{{asset('frontend/images/user-pro-img-demo.png')}}" alt="">
                              <?php }?>
                              </div>
                              <div class="media-body">
                                 <h5 class="post-name"><?php echo $val['company']['first_name'].' '.$val['company']['last_name']; ?></h5>
                                 <p class="post-location"><?php echo $val['company']['profile']['profile_headline'];?> at <?php if($val['company']['user_type']==2){echo $val['company']['currentCompany']['company_name'];}else{ echo $val['company']['company_name'];}?></p>
                                 <p class="post-location"><span class="no-follow"><?php if($val['company']['followers'] != null){ echo $val['company']['followers']->count();}else{ echo 0;}?> Followers</span></p>
                              </div>
                              <div class="dropdown msg-dropdown">
                                 <button class="btn site-btn-color dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                 <i class="fa fa-ellipsis-v"></i>
                                 </button>
                                 <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Copy Link</a>
                                    <a class="dropdown-item" href="#">Delete</a>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#report-modal">Report</a>
                                 </div>
                              </div>
                           </div>
                           <div class="post-body">
                              <p><?php echo $val['description'];?></p>
                              <?php if($val['category_id'] == 3){?>
                                 <img src="{{ asset($val['upload']['location']) }}" class="img-fluid">
                              <?php }else if($val['category_id'] == 4){?>
                                 <img src="{{ asset($val['upload']['location']) }}" class="img-fluid">
                              <?php }?>
                           </div>
                           <div class="like-comment-box">
                              <div class="d-flex only-like-comment">
                                 <div class=""><span>2</span> like </div> 
                                 <div class=""><span>2</span> Comments</div>
                              </div>
                              <ul class="d-flex justify-content-between">
                                 <li> <a href=""><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Like </a> </li>
                                 <li> <a class="comments-link" data-toggle="modal" data-target="#comment-post-modal"><i class="fa fa-commenting-o" aria-hidden="true"></i> Comment </a> </li>
                                 <li> <a class="share-link"  data-toggle="modal" data-target="#share-post-modal"><i class="fa fa-share-alt" aria-hidden="true"></i> Share </a> </li>
                              </ul>       
                           </div>
                        </div>
                        <?php } }?>

                     </div> 

                  </div> 
               </div>   
            </div>                      
         </div>
      </div>
   </section>
</main>
@endsection