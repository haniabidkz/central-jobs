
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
                                                            Dear {{$user}},
                                                            <span style="display:block;font-size:13px;font-weight:normal;color:#999">Here are your password reset instructions.</span>
                                                         </h1>
                                                      </td>
                                                      <!-- <td width="58" align="right">
                                                         <a  href=""><img alt="profile img" src="{{$imgPath}}" style="height:auto;line-height:100%;outline:none;text-decoration:none;display:inline;width:48px;border-radius:50%;border:0;"  width="48" height="48"> </a>
                                                      </td> -->
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </div>
                                          <p style="font-size:14px;line-height:1.7;color:#6a6a6a">A request to reset your password has been made. If you did not make this request, simply ignore this email. If you did make this request, 
                                          please reset your password:</p> </br></br>
                                          <p style="font-size:14px;line-height:1.7;color:#6a6a6a">NOTE : Password reset link is valid for 30 minutes.</p>
                                          <table style="border-spacing:0;border-collapse:collapse;margin:auto;" cellspacing="0" cellpadding="0" border="0" align="center">
                                             <tbody>
                                                <tr>
                                                   <td style="border-radius:3px;" bgcolor="#ffc00" align="center">
                                                      <a href="{{url('admin/reset-password',$RememberToken)}}" style="padding: 0.8rem 1.2rem; text-decoration: none; display: inline-block; font-size: 14px; border-radius: 3px; color: #0b0001; border:none; background: #ffc000; ">Reset password</a>    
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
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

