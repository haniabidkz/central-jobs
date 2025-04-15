
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
                               <a href="{{env('APP_URL')}}" target="_blank"><img src="{{ asset('frontend/images/OFFICIAL_LOGO_emails.jpeg') }}" alt="" style="max-width: 180px"></a>
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
                                                            Sehr geehrte <?php if($userInfo['user_type'] == 2){?>Kandidat<?php }else if($userInfo['user_type'] == 3){?><?php }?>,
                                                         </h1>
                                                      </td>
                                                     
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </div>
                                          <?php if($userInfo['user_type'] == 2){
                                          ?>
                                             <p style="font-size:14px;line-height:1.7;color:#6a6a6a">Willkommen im Central Jobs portal!</p>
                                             <!-- <p style="font-size:14px;line-height:1.7;color:#6a6a6a">Dies dient der Bestätigung, dass Sie Ihre E-Mail-ID erfolgreich verifiziert haben. Jetzt können Sie mit der Anwendung beginnen.</p> -->
                                             <p style="font-size:14px;line-height:1.7;color:#6a6a6a">Sie haben Ihre E-Mail-ID erfolgreich verifiziert. Jetzt können Sie mit der Anwendung beginnen.</p>
                                             </br>
                                             <p style="font-size:14px;line-height:1.7;color:#6a6a6a"><a href="{{env('APP_URL')}}">Klicken Sie hier</a> um Central Jobs zu besuchen.</p>
                                             <p style="font-size:14px;line-height:1.7;color:#6a6a6a">Bitte zögern Sie nicht, uns zu kontaktieren, wenn Sie Fragen haben.</p>
                                             <p style="font-size:14px;line-height:1.5;color:#555">Mit besten Grüßen,<br>
                                                Central Jobs Team
                                             </p>
                                          <?php 
                                             }else if($userInfo['user_type'] == 3){
                                          ?>
                                             <p style="font-size:14px;line-height:1.7;color:#6a6a6a">Willkommen bei Central Jobs!</p>
                                             <p style="font-size:14px;line-height:1.7;color:#6a6a6a">Wir bestätigen, dass Ihre Registrierung vom Admin genehmigt wurde und Sie unsere Website nutzen können!</p>
                                             </br>
                                             <p style="font-size:14px;line-height:1.7;color:#6a6a6a"><a href="{{env('APP_URL')}}">Klicken Sie hier</a>, um zur Website Central Jobs zu gelangen.</p>
                                             <p style="font-size:14px;line-height:1.7;color:#6a6a6a">Sollten Sie Fragen haben, lassen Sie es uns wissen!</p>
                                             <p style="font-size:14px;line-height:1.5;color:#555">Mit freundlichen Grüßen,<br>
                                                Central Jobs Team
                                             </p>
                                          <?php 
                                             }
                                          ?>
                                          
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

