
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
                                                            Sehr geehrte {{$user['first_name']}},
                                                         </h1>
                                                      </td>
                                                      <!-- <td width="58" align="right">
                                                         <a href=""><img alt="profile img" src="{{$imgPath}}" style="height:auto;line-height:100%;outline:none;text-decoration:none;display:inline;width:48px;border-radius:50%;border:0"  width="48" height="48"> </a>
                                                      </td> -->
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </div>
                                          
                                          @if($user['profile']['approve_status'] == 1)
                                          <p style="margin-top:30px;margin-bottom:30px;font-size:14px;line-height:1.7;color:#6a6a6a">Dies dient der Bestätigung, dass Ihre Anmeldung eingegangen ist.</p>
                                          <p style="margin-top:30px;margin-bottom:30px;font-size:14px;line-height:1.7;color:#6a6a6a">Sobald dies vom Admin genehmigt wird, erhalten Sie eine E-Mail mit der Bestätigung (in der Regel dauert es nicht mehr als 1 Tag).</p>
                                          {{-- <p style="margin-top:30px;margin-bottom:30px;font-size:14px;line-height:1.7;color:#6a6a6a"><a href="{{env('APP_URL')}}">Clique aqui </a>para acessar nosso site Meu-RH.</p> --}}
                                          <p style="margin-top:30px;margin-bottom:30px;font-size:14px;line-height:1.7;color:#6a6a6a">Bitte zögern Sie nicht, uns zu kontaktieren, wenn Sie Fragen haben.</p> 
                                          @elseif($user['profile']['approve_status']== 2)
                                          <p style="margin-top:30px;margin-bottom:30px;font-size:14px;line-height:1.7;color:#6a6a6a">Wir bedauern, Ihnen mitteilen zu müssen, dass Ihre Registrierung nicht vom Admin genehmigt wurde. "{{$reason}}".</p>
                                          <p style="margin-top:30px;margin-bottom:30px;font-size:14px;line-height:1.7;color:#6a6a6a">Sollten Sie Fragen haben, lassen Sie es uns wissen!</p>
                                          @endif
                                          <p style="margin-top:15px;margin-bottom:0px;font-size:14px;line-height:1.5;color:#555">Mit freundlichen Grüßen,<br>
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

