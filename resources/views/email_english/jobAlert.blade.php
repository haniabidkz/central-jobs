
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
                               <a href="{{env('APP_URL')}}" target="_blank"><img src="{{ asset('frontend/images/OFFICIAL_LOGO_emails.jpeg') }}" alt="logo" style="max-width: 180px"></a>
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
                                                            Dear {{$userData['details']['toUser']['first_name']}},
                                                         </h1>
                                                      </td>
                                                      
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </div>
                                          <p style="font-size:14px;line-height:1.7;color:#6a6a6a">This is to inform you that {{$userData['details']['fromUser']['company_name']}} has posted a new job.</p> </br>
                                          <?php foreach($userData['job_details'] as $key=>$val){?>
                                          <p style="font-size:14px;line-height:1.7;color:#6a6a6a">{{$val['title']}}</p> </br>
                                          <p style="font-size:14px;line-height:1.7;color:#6a6a6a">{{$val['company']['company_name']}}: {{$val['country']['name']}}, <?php foreach($val['post_state'] as $key=>$valstate){ echo $valstate['state']['name'].', ';}?>{{$val['city']}} </p> </br>
                                          <p style="font-size:14px;line-height:1.7;color:#6a6a6a"><?php if($val['cms_basic_info']){ foreach($val['cms_basic_info'] as $key=>$val1){ if($val1['type'] == 'seniority'){ echo $val1['master_info']['name'];} }}?>-<?php if($val['cms_basic_info']){ foreach($val['cms_basic_info'] as $key=>$val2){ if($val2['type'] == 'employment_type'){ echo $val2['master_info']['name'];} }}?></p> </br>
                                          <p style="font-size:14px;line-height:1.7;color:#6a6a6a">{{substr($val['description'],0,200)}}</p> </br>
                                          <p style="font-size:14px;line-height:1.7;color:#6a6a6a">Posted On:{{date('Y-m-d',strtotime($val['start_date']))}}</p> </br>
                                          <?php }?>
                                          <p style="font-size:14px;line-height:1.7;color:#6a6a6a"><a href="{{env('APP_URL')}}">View Job</a></p> </br>
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

