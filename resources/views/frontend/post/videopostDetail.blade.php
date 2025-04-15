<div class="post-block">
                                       <div class="media">
                                          <div class="user-profile user_profile_id" id="user_profile_id_{{$postData['id']}}"> 
                                          <a href="{{url($postedUser.'/profile/'.$postData['user']['slug'])}}"> 
                                          <?php if($postData['user']['profileImage'] != null){?>
                                             <img src="{{asset($postData['user']['profileImage']['location'])}}" alt="">
                                          <?php }else{ ?>
                                             <img src="{{asset('frontend/images/user-pro-img-demo.png')}}" alt="">
                                          <?php }?>
                                          </a>
                                          </div>
                                          <div class="media-body media_body_id" id="media_body_id_{{$postData['id']}}">
                                             <h5 class="post-name">
                                             <?php 
                                             if($postData['user']['user_type'] == 2){ 
                                                echo $postData['user']['first_name'].' '.$postData['user']['last_name'];
                                             }else if($postData['user']['user_type'] == 3){
                                                echo $postData['user']['company_name'];
                                             } 
                                             ?>
                                             </h5>
                                             <?php if($postData['user']['user_type'] == 2){?>
                                             <p class="post-location"><?php  echo $postData['user']['currentCompany']['title'];?> at <?php echo $postData['user']['currentCompany']['company_name'];?></p>
                                             <?php }elseif($postData['user']['user_type'] == 3){?>
                                             <p class="post-location"><span class="no-follow"><?php echo count($postData['user']['followers'])?> {{ __('messages.FOLLOWERS') }}</span></p>
                                             <?php }?>
                                          </div>
                                       </div>
                                       <div class="post-body post_body_id" id="post_body_id_{{$postData['id']}}">
                                          <p>{{$postData['title']}}</p>
                                          <div class="video-holder-div">
                                             <video controls>
                                             <source src="{{$path}}">                                           
                                             </video>
                                          </div>
                                       </div>                                       
                                       <div class="like-comment-box">
                                          <div class="d-flex only-like-comment">
                                             <div class=""><span id="total-like-{{$postData['id']}}">{{count($postData['likes'])}}</span> {{ __('messages.LIKE') }} </div> 
                                             <div class=""><span> 
                                             <?php $comment = 0;
                                             if(!empty($postData['comments'])){ 
                                                foreach($postData['comments'] as $key=>$val){
                                                   $reportedChk = 0;
                                                   if(count($val['reported']) > 0){
                                                      foreach($val['reported'] as $key1=>$val1){
                                                         if($val1['user_id'] == Auth::user()->id){
                                                            $reportedChk++;
                                                         }
                                                      }
                                                   }

                                                   if((count($val['reported']) == 0) || ($reportedChk == 0)){
                                                      $comment++;
                                                   }
                                                }
                                             }
                                             echo $comment;
                                             ?></span> {{ __('messages.COMMENTS') }}</div>
                                          </div>
                                          <?php if((Auth::user()) && (Auth::user()->user_type != 1)){?>
                                          <ul class="d-flex justify-content-between">
                                             <li> <a class="like-post-{{$postData['id']}} {{$addClassLike}}" id="like-post-id" data-like="{{count($postData['likes'])}}" data-id="{{$postData['id']}}"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> {{ __('messages.LIKE') }} </a> </li>
                                             <li> <a id="comment-post-modal-id" data-id="{{$postData['id']}}"><i class="fa fa-commenting-o" aria-hidden="true"></i> {{ __('messages.COMMENT') }} </a> </li>
                                             <li> <a id="share-post-modal-id" data-id="{{$postData['id']}}"><i class="fa fa-share-alt" aria-hidden="true"></i> {{ __('messages.SHARE') }} </a> </li>
                                          </ul>
                                          <?php }else{?>   
                                          <ul class="d-flex justify-content-between">
                                          <li> <a class="" href="{{url('/')}}"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> {{ __('messages.LIKE') }} </a> </li>
                                          <li> <a href="{{url('/')}}"><i class="fa fa-commenting-o" aria-hidden="true"></i> {{ __('messages.COMMENT') }} </a> </li>
                                          <li> <a class="share-link" href="{{url('/')}}"><i class="fa fa-share-alt" aria-hidden="true"></i> {{ __('messages.SHARE') }} </a> </li>
                                       </ul>  
                                       <?php }?> 
                                       </div>
                                    </div>