@extends('layouts.app_after_login_layout')
@section('content')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
                        <div class="col-12 col-sm-12">
                            <h2>{{strip_tags(@$data[0]['text'])}}</h2>                
                        </div>
                    </div>
                </div>
            </div>                  
        </div>
    </section>
       <!-- wraper-trams- -->
    <section class="wraper-default-innerpage">
        <div class="container">
            <div class="row">                                
               <div class="col-12">
               <div class="container mb-2">
                        <div class="d-flex justify-content-between">  
                           <div class="text-holder">
                             
                           </div>
                           <div class=""> 
                              <div class="d-flex">
                                 <button class="btn coockies_consent site-btn-color mr-3 coockies-accept"> {{ __('messages.COOKIES_ACCEPT_POLICY_BUTTON') }} </button>
                                 <button class="btn site-btn" id="cookies-close"> {{ __('messages.REJECT') }} </button>
                              </div>
                           </div>   
                        </div> 
                  </div> 
                  <div class="default-main whitebg cookies-text">
                      <?php echo @$data[1]['text']; ?>
                  </div>
               </div>
            </div>
        </div>       
    </section>
</main>
<!-- main End -->
<?php if(Auth::user()){?>
<script>
$(document).ready(function(){
    $(document).on('click','.consent_withdraw',function(){
        <?php if(Auth::user()->user_type == 2){?>
            var usertype = 'candidate';
        <?php }else if(Auth::user()->user_type == 3){?>
            var usertype = 'company';
       <?php } ?>
        var text = allMsgText.WITHDRAWING_THE_CONSENT_WILL_DISABLE_SOME_FEATURES_IN_THE_WEBSITE;
        swal({
            //title: allMsgText.ARE_YOU_SURE,
            text: text,
            buttons: [allMsgText.CANCEL, allMsgText.PROCEED],
        })
        .then((willDelete) => {
            if(willDelete){
                window.location.href = _BASE_URL+'/'+usertype+'/manage-profile';
            }
            
        });
    });
});
</script>
<?php }else{?>
<script>
   $(document).ready(function(){
        $(document).on('click','.consent_withdraw',function(){
            var text = allMsgText.PLEASE_LOGIN_TO_YOUR_ACCOUNT_TO_WITHDRAW_YOUR_CONSENT;
            swal({
                //title: allMsgText.ARE_YOU_SURE,
                text: text,
                cancel: true,
            })
            .then((willDelete) => {
                
            });
        });
    });
</script>
<?php }?>
@endsection