<div class="post-block" id="rmv-post-{{$postRow['id']}}">
                                       <div class="media">
                                          <div class="user-profile user_profile_id" id="user_profile_id_{{$postRow['id']}}">
                                             <a href="{{url($postedUser.'/profile/'.$postRow['user']['slug'])}}"> 
                                          <?php if($postRow['user']['profileImage'] != null){?>
                                             <img src="{{asset($postRow['user']['profileImage']['location'])}}" alt="">
                                          <?php }else{ ?>
                                             <img src="{{asset('frontend/images/user-pro-img-demo.png')}}" alt="">
                                          <?php }?>
                                          </a>
                                          </div>
                                          <div class="media-body media_body_id" id="media_body_id_{{$postRow['id']}}">
                                          <a href="{{url($user_type.'/view-post/'.encrypt($postRow['id']))}}">
                                             <h5 class="post-name">
                                             <?php 
                                             if($postRow['user']['user_type'] == 2){ 
                                                echo $postRow['user']['first_name'].' '.$postRow['user']['last_name'];
                                             }else if($postRow['user']['user_type'] == 3){
                                                echo $postRow['user']['company_name'];
                                             } ?>
                                             </h5>
                                             <?php if($postRow['user']['user_type'] == 2){?>
                                             <p class="post-location"><?php  echo $postRow['user']['currentCompany']['title'];?> <?php if($postRow['user']['currentCompany']['title'] != ''){?>at<?php }?> <?php echo $postRow['user']['currentCompany']['company_name'];?></p>
                                             <?php }elseif($postRow['user']['user_type'] == 3){?>
                                             <p class="post-location"><span class="no-follow"><?php echo count($postRow['user']['followers'])?> {{ __('messages.FOLLOWERS') }}</span></p>
                                             <?php }?>
                                             </a>
                                          </div>
                                          <div class="dropdown msg-dropdown">
                                             <button class="btn site-btn-color dropdown-toggle" type="button" id="dropdownMenuButto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                             <i class="fa fa-ellipsis-v"></i>
                                             </button>
                                             <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item copy_link_id_{{$postRow['id']}}" href="{{url($user_type.'/view-post/'.encrypt($postRow['id']))}}" id="copyButton" data-id="{{$postRow['id']}}">{{ __('messages.COPY_LINK') }}</a>
                                                <?php if(Auth::user()->id == $postRow['user']['id']){?>
                                                <a class="dropdown-item post-remove-data" href="javascript:void(0);" id="post-delete-id" data-id="{{$postRow['id']}}">{{ __('messages.DELETE_POST') }}</a>
                                                <?php }?>
                                                <?php if(Auth::user()->id != $postRow['user']['id']){?>
                                                <a class="dropdown-item" href="javascript:void(0);" id="report-post-id" data-id="{{$postRow['id']}}">{{ __('messages.REPORT') }}</a>
                                                <?php }?>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="post-body pt-2 post_body_id" id="post_body_id_{{$postRow['id']}}">
                                       <a href="{{url($user_type.'/view-post/'.encrypt($postRow['id']))}}">
                                          <p><?php echo substr($postRow['title'],0,260) ; if(strlen($postRow['title']) > 260){ echo '...'.__('messages.READ_MORE');}?></p>
                                          
                                          <img src="{{$path}}" class="img-fluid" alt="banner">
                                       </a>
                                       </div>
                                       <div class="like-comment-box">
                                          <div class="d-flex only-like-comment">
                                             <div class=""><span id="total-like-{{$postRow['id']}}">{{count($postRow['likes'])}}</span> {{ __('messages.LIKE') }} </div> 
                                             <div class=""><span>
                                             <?php $comment = 0;
                                             if(!empty($postRow['comments'])){ 
                                                foreach($postRow['comments'] as $key=>$val){
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
                                             ?>
                                             </span> {{ __('messages.COMMENTS') }}</div>
                                          </div>
                                          <ul class="d-flex justify-content-between">
                                             <li> <a class="like-post-{{$postRow['id']}} {{$addClassLike}}" id="like-post-id" data-like="{{count($postRow['likes'])}}" data-id="{{$postRow['id']}}"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> {{ __('messages.LIKE') }} </a> </li>
                                             <li> <a class="comments-link" data-toggle="modal" id="comment-post-modal-id" data-id="{{$postRow['id']}}"><i class="fa fa-commenting-o" aria-hidden="true"></i> {{ __('messages.COMMENT') }} </a> </li>
                                             <li> <a class="share-link" data-toggle="modal" id="share-post-modal-id" data-id="{{$postRow['id']}}"><i class="fa fa-share-alt" aria-hidden="true"></i> {{ __('messages.SHARE') }} </a> </li>
                                          </ul>       
                                       </div>
                                    </div>