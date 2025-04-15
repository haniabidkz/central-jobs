@extends('layouts.app_after_login_layout')
@section('content')
<style>
    #cover-spin {
    position:fixed;
    width:100%;
    left:0;right:0;top:0;bottom:0;
    background-color: rgba(255,255,255,0.7);
    z-index:9999;
    display:none;
  }
  
  @-webkit-keyframes spin {
  from {-webkit-transform:rotate(0deg);}
  to {-webkit-transform:rotate(360deg);}
  }
  
  @keyframes spin {
  from {transform:rotate(0deg);}
  to {transform:rotate(360deg);}
  }
  
  #cover-spin::after {
    content:'';
    display:block;
    position:absolute;
    left:48%;top:40%;
    width:40px;height:40px;
    border-style:solid;
    border-color:black;
    border-top-color:transparent;
    border-width: 4px;
    border-radius:50%;
    -webkit-animation: spin .8s linear infinite;
    animation: spin .8s linear infinite;
  }
  </style>

<main>

   <!-- pricing table  -->
   <div class="price-apart">
      <div class="container pric-top">
         <div class="m-0 row">
            <div class="bg-white col-12 p-title">
               <h1>Complete Your Payment Process</h1>
            </div>
         </div>
         <div class="m-0 row justify-content-center">
            <div class="bg-white col-12"></div>

            <!-- wraper-trams- -->
            <section class="wraper-default-innerpage">
                <div class="container">
                        <div class="row justify-content-center">                                
                            <div class="col-12 ">
                                <!-- <img src="images/contact-img.jpg" alt=""> -->
                                <div class="default-main whitebg">
                                <form id="form_contact_us" method="post" action="{{url('company/payment-process')}}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="plan_id" value = {{$id}}>
                                    <div class="login-form mw-100">
                                        
                                        <div class="form-group">
                                            <input class="form-control" name="name" value = "{{$user->first_name}} {{$user->last_name}}" placeholder="{{__('messages.NAME')}}" type="text" readonly/>
                                        </div>
                                        <div class="form-group required">
                                            <input class="form-control" name="email" value = "{{$user->email}}" placeholder="{{__('messages.EMAIL')}}" type="text" readonly/>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" name="card" id="card" placeholder="Card Number" type="text" required/>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input class="form-control" name="cvc" id="cvc" placeholder="CVC" type="text" required/>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input class="form-control" name="exp_month" id="exp_month" placeholder="Expire Month" type="text" required/>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input class="form-control" name="exp_year" id="exp_year" placeholder="Expire Year" type="text" required/>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="social-btnlist">
                                            <button class="w-100 btn site-btn-color contact_us_btn finalPayment" type="submit">{{__('messages.SUBMIT_REQUEST')}} <i class="fa fa-caret-right ml-2" aria-hidden="true"></i></button>
                                        </div> 
                                        
                                    </div>
                                </form>    
                            </div>
                            
                        </div>
                    </div>
                </div>       
            </section>
            
         </div> 
      </div>
      
   </div>
    <!-- end priceing table -->    
</main>
<!-- main End -->


@endsection
