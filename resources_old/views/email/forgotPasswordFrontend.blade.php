
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
                               <a href="{{env('APP_URL')}}" target="_blank"><img src="{{ asset('frontend/images/logo-color.png') }}" alt="" style="max-width: 180px"></a>
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
                                                            Sehr geehrte {{$user['name']}},
                                                         </h1>
                                                      </td>
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </div>
                                          <p style="font-size:14px;line-height:1.7;color:#6a6a6a">Eine Anfrage zum Zurücksetzen Ihres Passworts wurde gestellt. Wenn Sie diese Anfrage nicht gestellt haben, ignorieren Sie einfach diese E-Mail. Wenn Sie diese Anfrage gestellt haben, setzen Sie bitte Ihr Passwort zurück:</p> 
                                          <p style="font-size:14px;line-height:1.7;color:#6a6a6a">HINWEIS: Der Link zum Zurücksetzen des Passworts ist 30 Minuten lang gültig.</p>
                                          <table style="border-spacing:0;border-collapse:collapse;margin:auto;" cellspacing="0" cellpadding="0" border="0" align="center">
                                             <tbody>
                                                <tr>
                                                   <td style="border-radius:3px;" bgcolor="#ffc00" align="center">
                                                      <a href="{{url('password/reset/'.$RememberToken.'?email='.$user['email'])}}" style="padding: 0.8rem 1.2rem; text-decoration: none; display: inline-block; font-size: 14px; border-radius: 3px; color: #0b0001; border:none; background: #ffc000; ">Passwort zurücksetzen</a>    
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                          <p style="font-size:14px;line-height:1.5;color:#555">Mit besten Grüßen,<br>
                                             Central Jobs Team
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

