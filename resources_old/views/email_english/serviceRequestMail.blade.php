
<table style="border-spacing:0;border-collapse:collapse;margin:0 auto;" width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#f0f0f0">
   <tbody>
      <tr>
         <td valign="top">
            <center style="width:100%">
               <div style="max-width:600px;margin:20px auto">
                  <table style="border-spacing:0;border-collapse:collapse;max-width:600px; margin:0px auto 0" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                     <tbody>
                        <tr>
                           <td style="font-family: Verdana,Arial, Helvetica,Tahoma,sans-serif; color:#999;font-size:13px;line-height:1.6; padding:20px 0" align="center">
                               <a href="{{env('APP_URL')}}" target="_blank"><img src="{{ asset('frontend/images/logo-color.png') }}" alt="logo" style="max-width: 180px"></a>
                           </td>
                        </tr>
                     </tbody>
                  </table>
                  <table style="border-spacing:0;border-collapse:collapse;max-width:600px;margin:0 auto" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" align="center">
                     <tbody>
                        <tr>
                           <td>
                              <table style="border-spacing:0;border-collapse:collapse;margin:0 auto" width="100%" cellspacing="0" cellpadding="30" border="0">
                                 <tbody>
                                    <tr>
                                       <td style="font-family: Verdana,Arial, Helvetica,Tahoma,sans-serif; color:#444;font-size:14px;line-height:150%" valign="top">
                                          <div style="margin-bottom:20px;padding-bottom:25px;border-bottom-width:1px;border-bottom-color:#eee;border-bottom-style:solid">
                                             <table style="border-spacing:0;border-collapse:collapse;margin:0 auto" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                   <tr>
                                                      <td>
                                                         <h1 style="font-family: Verdana,Arial, Helvetica,Tahoma,sans-serif;color:#444; display:block; font-size:15px; font-weight:600;line-height:1.5; margin:0">
                                                         Hi Admin,
                                                         </h1>
                                                      </td>
                                                     
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </div>
                                          
                                          <p style="font-size:14px;line-height:1.7;color:#6a6a6a">New subscription request for {{$orderInfo['service_name']}} service on Meu RH. Subscription details are as following:</p></br>

                                          <p style="font-size:14px;line-height:1.7;color:#6a6a6a">Subscription ID: {{$orderInfo['subscription_code']}}</p></br>
                                          <p style="font-size:14px;line-height:1.7;color:#6a6a6a">Service Name: {{$orderInfo['service_name']}}</p></br>
                                          <p style="font-size:14px;line-height:1.7;color:#6a6a6a">Registered email ID: {{$orderInfo['candidate_email']}}</p></br>
                                          <p style="font-size:14px;line-height:1.7;color:#6a6a6a">Candidate Name: {{$orderInfo['candidate_name']}}</p></br>
                                          <?php if($orderInfo['service_start_from'] != '' || ($orderInfo['service_start_from'] != NULL)){?>
                                          <p style="font-size:14px;line-height:1.7;color:#6a6a6a">Proposed Date-time 1: {{date('Y-m-d H:i:s',strtotime($orderInfo['service_start_from']))}}</p></br>
                                          <?php }?>
                                          <?php if($orderInfo['propose_date_2'] != '' || ($orderInfo['propose_date_2'] != NULL)){?>
                                          <p style="font-size:14px;line-height:1.7;color:#6a6a6a">Proposed Date-time 2: {{date('Y-m-d H:i:s',strtotime($orderInfo['propose_date_2']))}}</p></br>
                                          <?php }?>
                                          <?php if($orderInfo['propose_date_3'] != '' || ($orderInfo['propose_date_3'] != NULL)){?>
                                          <p style="font-size:14px;line-height:1.7;color:#6a6a6a">Proposed Date-time 3: {{date('Y-m-d H:i:s',strtotime($orderInfo['propose_date_3']))}}</p></br>
                                          <?php }?>
                                          
                                          <p style="font-size:14px;line-height:1.5;color:#555">Best Regards,<br>
                                          MeuRH team
                                          </p>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </center>
         </td>
      </tr>
   </tbody>
</table>

