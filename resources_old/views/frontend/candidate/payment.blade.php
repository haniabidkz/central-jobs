@extends('layouts.app_after_login_layout')

@section('content')

<main>
   <div class="content-wrapper">
      <!-- Message Bar Container -->
      @include('layouts._partials.messagebar')
      <!-- /Message Bar Container -->
   </div>
   <!-- pricing table  -->
   <div class="price-apart">
      <div class="container pric-top">
         <div class="m-0 row">
            <div class="bg-white col-12 p-title">
               <h1>{{ __('messages.PAYMENT_PAGE_HEADING') }}</h1>
            </div>
         </div>
         <div class="m-0 row">
            <div class="bg-white col-12 col-lg-3"></div>
            <div class="col-12 col-lg-9 hgh-bg">
              {{-- <h2>Highlight your curriculum</h2> --}}
            </div>
         </div> 
      </div>
      <section id="pricing-tables">
         <div class="container">
               <div class="col-md-6 col-lg-3 col-sm-6 col-xs-12 color-1" >
                  <div class="text-center f-plan single-table">
                     <div class="plan-header">
                           <h3>{{ __('messages.FREE_PLAN_TOP_HEADING') }}</h3>
                           {{-- <p>plan for basic user</p> --}}
                           <label>{{ __('messages.FREE_PLAN_BOTTOM_HEADING') }} <br /> {{ __('messages.FREE_PLAN_BOTTOM_SUBHEADING') }}</label>
                     </div>
                     <h4 class="plan-price">{{ __('messages.FREE_PLAN_PRICE_HEADING') }}</h4>

                     <ul class="text-center">
                           <li>{{ __('messages.FREE_PLAN_PRICE_SUBHEADING') }}</li>
                     </ul>
                     <form role="form" method="post" action="{{ url('payments') }}">
                     @csrf
                     @if(isset($data['previous_url']))
                     <input type="hidden" value="{{ $data['previous_url'] }}" name="previous_url">
                     @endif
                     <input type="hidden" value="1" name="id">
                     <button class="plan-submit hvr-bubble-float-right" type="submit">{{ __('messages.FREE_PLAN_PRICE_BOTTOM_HEADING') }}</button>
                     </form>
                  </div>
               </div>
               @foreach ($plans as $plan)
                  <div class="col-md-6 col-lg-3 col-sm-6 col-xs-12 color-2">
                     <div class="text-center single-table">
                    {{-- @if (isset($user))
                        @if ($user->subscription_plan_id == $plan['id'])
                           style="background: #a2d2a4;"
                        @endif
                     @endif --}}
                     
                        <div class="plan-header">
                              <h3>{{$plan['name']}}</h3>
                              @if (isset($plan['product']['metadata']['General']) && trim($plan['product']['metadata']['General'])!="")
                                 <p>{{$plan['product']['metadata']['General']}}</p>
                              @endif
                              {{-- this is the part that needs to be highlighted (+1 Month Free) section --}}
                              @if (isset($plan['product']['metadata']['Free']) && trim($plan['product']['metadata']['Free'])!="")
                                 <p class="yellow">{{$plan['product']['metadata']['Free']}}</p>
                              @endif

                              <label> 
                                 @if ($plan['product']['description'])
                                    {{$plan['product']['description']}}
                                 @endif
                                 @if (isset($plan['product']['metadata']['Below Description']) && trim($plan['product']['metadata']['Below Description'])!="")
                                       <br/>{{$plan['product']['metadata']['Below Description']}}
                                 @endif
                              </label>
                              {{-- <label>Apply ilimited during <br/> 1 month</label> --}}
                              {{-- <label> {{$plan['product']['description']}}</label> --}}
                             
                        </div>
                        <h4 class="plan-price">€{{ number_format(($plan['amount'])/100,2,'.','')}}</h4>

                        <ul class="text-center">
                           <li>{{ __('messages.PLAN_PRICE_SUBHEADING') }}</li>
                        </ul>
                        <form role="form" method="post" action="{{ url('payments') }}">
                        @csrf
                        @if(isset($data['previous_url']))
                        <input type="hidden" value="{{ $data['previous_url'] }}" name="previous_url">
                        @endif
                        <input type="hidden" value="{{ $plan['id']}}" name="id">
                        <button class="plan-submit hvr-bubble-float-right" type="submit">{{ __('messages.PLAN_PRICE_BOTTOM_HEADING') }}</button>
                        </form>
                     </div>
                  </div>
               @endforeach
               {{-- <div class="col-md-6 col-lg-3 col-sm-6 col-xs-12 color-2">
                  <div class="text-center single-table" @if ($user->subscription_plan_id == $data['payment_values']['data'][2]['id'])
                     style="background: #a2d2a4;"
                  @endif>
                     <div class="plan-header">
                           <h3>1 month</h3>
                           <p>plan for basic user</p>
                           <label>Apply ilimited during <br/> 1 month</label>
                     </div>
                     <h4 class="plan-price">€{{ number_format(($data['payment_values']['data'][2]['amount'])/100,2,'.','')}}</h4>

                     <ul class="text-center">
                        <li>Highlight your CV</li>
                     </ul>
                     <form role="form" method="post" action="{{ url('payments') }}">
                     @csrf
                     @if(isset($data['previous_url']))
                     <input type="hidden" value="{{ $data['previous_url'] }}" name="previous_url">
                     @endif
                     <input type="hidden" value="{{ $data['payment_values']['data'][2]['id']}}" name="id">
                     <button class="plan-submit hvr-bubble-float-right" type="submit">Select here</button>
                     </form>
                  </div>
               </div> --}}
               {{-- <div class="col-md-6 col-lg-3 col-sm-6 col-xs-12 color-3">
                  <div class="text-center single-table" @if ($user->subscription_plan_id == $data['payment_values']['data'][1]['id'])
                     style="background: #a2d2a4;"
                  @endif>
                     <div class="plan-header">
                           <h3>2 months</h3>
                           <p class="yellow">+ 1 Month free</p>
                           <label>Apply ilimited during <br/> 2 month (+ 1 free)</label>
                     </div>

                     <h4 class="plan-price">€{{ number_format(($data['payment_values']['data'][1]['amount'])/100,2,'.','')}}</h4>
                     <ul class="text-center">
                           <li>Highlight your CV</li>
                     </ul>
                     <form role="form" method="post" action="{{ url('payments') }}">
                     @csrf
                     @if(isset($data['previous_url']))
                     <input type="hidden" value="{{ $data['previous_url'] }}" name="previous_url">
                     @endif
                     <input type="hidden" value="{{ $data['payment_values']['data'][1]['id']}}" name="id">
                     <button class="plan-submit hvr-bubble-float-right" type="submit">Select here</button>
                     </form>
                  </div>
               </div> --}}
               {{-- <div class="col-md-6 col-lg-3 col-sm-6 col-xs-12 color-4">
                  <div class="text-center single-table" @if ($user->subscription_plan_id == $data['payment_values']['data'][0]['id'])
                     style="background: #a2d2a4;"
                  @endif>
                     <div class="plan-header">
                           <h3>3 months</h3>
                           <p class="yellow">+ 1 Month free</p>
                           <label>Apply ilimited during <br/> 3 month (+ 1 free)</label>
                     </div>
                     <h4 class="plan-price">€{{ number_format(($data['payment_values']['data'][0]['amount'])/100,2,'.','')}}</h4>

                     <ul class="text-center">
                     <li>Highlight your CV</li>
                     </ul>
                     <form role="form" method="post" action="{{url('payments') }}">
                     @csrf
                     @if(isset($data['previous_url']))
                     <input type="hidden" value="{{ $data['previous_url'] }}" name="previous_url">
                     @endif
                     <input type="hidden" value="{{ $data['payment_values']['data'][0]['id']}}" name="id">
                     <button class="plan-submit hvr-bubble-float-right" type="submit">Select here</button>
                     </form>
                  </div>
               </div> --}}
               <div class="col-lg-3"></div>
               <div class="col-lg-9 bottom-table">
                  <div class="bottom-table_in">
                     <p class="text-center text"><strong>{{ __('messages.PAYMENT_HIGHLIGHTED_TOP_HEADING_1') }}</strong></p>
                     <p class="text text-center"><strong>{{ __('messages.PAYMENT_HIGHLIGHTED_TOP_HEADING_2') }}</strong></p>
                     @php
                        $static = "{highlighted}";
                        $dynamic = __('messages.PAYMENT_HIGHLIGHTED_TOP_HEADING_3_BOLD');
                        $newBottomHeading = str_replace($static, $dynamic, __('messages.PAYMENT_HIGHLIGHTED_TOP_HEADING_3')); 
                     @endphp
                     <p class="text-center text"><strong>{!! $newBottomHeading !!}</strong></p>
                     <div class="field_highlight_rap">
                        <div class="field-highlightSec">
                           <div class="field_highlight">
                              <p>Ana kahunasy</p>
                              <span><strong>Highlight:</strong> 7 years experience</span>
                           </div>
                           <div class="field_highlight">
                              <p>David Muller</p>
                              <span><strong>Highlight:</strong> certified DPO</span>
                              <span class="curved-arrow"><img src="{{ asset('frontend/images/curved-arrow.png') }}" alt="" /></span>
                           </div>
                           <div>
                              <p>Sarah Schmidt</p>
                              <!-- <span><strong>Highlight:</strong> certified DPO</span> -->
                           </div>
                           <div>
                              <p>Loah Mayer</p>
                              <!-- <span><strong>Highlight:</strong> certified DPO</span> -->
                           </div>
                           <div>
                              <p>Alexander Weber</p>
                              <!-- <span><strong>Highlight:</strong> certified DPO</span> -->
                           </div>
                           
                           
                           
                        </div>
                        <div class="field_highlight_help_txt">
                           @php
                              $static = "{field}";
                              $dynamic = __('messages.PAYMENT_HIGHLIGHTED_SIDE_HEADING_BOLD');
                              $newHeading = str_replace($static, $dynamic, __('messages.PAYMENT_HIGHLIGHTED_SIDE_HEADING')); 
                           @endphp
                           <p>{!! $newHeading !!}</p>
                        </div>
                     </div>
                  </div>
               </div>
         </div>
      </section>
   </div>
    <!-- end priceing table -->    
</main>
<!-- main End -->
@endsection