<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\EmailVerifyLinkSent;
use App\Mail\WelcomeEmailSent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Model\Profile;
use App\Service\Candidate\CandidateService;
use App\Service\CmsService;
use Newsletter;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    /**
     * candidate service to create slug.
     *
     * @var string
     */
    protected $candidateService;
    protected $cmsServices;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CandidateService $candidateService, CmsService $cmsService)
    {

        $this->middleware('guest');
        $this->candidateService = $candidateService;
        $this->cmsServices = $cmsService;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        if ($data['user_type'] == 2) { //candidate
            return $this->validateCandidate($data);
        } else if ($data['user_type'] == 3) { //company
            return $this->validateCompany($data);
        } else {
            return false;
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        if ((isset($data['is_newsletter_subscribed'])) && $data['is_newsletter_subscribed'] == "on") {
            $data['is_newsletter_subscribed'] = 1;
        } else {
            $data['is_newsletter_subscribed'] = 0;
        }
        if ($data['privacy_policy_status'] == "on") {
            $data['privacy_policy_status'] = 1;
        }
        $cookies_policy_status = 0;
        if ((isset($data['cookies_policy_status'])) && $data['cookies_policy_status'] == "on") {
            $data['cookies_policy_status'] = 1;
        }
        $terms_conditions_status = 0;
        if ($data['terms_conditions_status'] == "on") {
            $data['terms_conditions_status'] = 1;
        }
        if ($data['user_type'] == 2) { //candidate
            return $this->insertCandidateData($data);
        } else if ($data['user_type'] == 3) { //company
            return $this->insertCompanyData($data);
        } else {
            return false;
        }
    }

    /**
     * Function to insert info for company
     * @param array $data
     * return mix
     */
    public function insertCompanyData($data)
    {
        $slug = $this->candidateService->getUniqueSlug($data['first_name'] ?? '');
        $insertData = User::create([
            'first_name' => $data['first_name'] ?? '',
            'slug' => $slug,
            'company_name' => $data['company_name'],
            'telephone' => $data['telephone'] ?? '',
            'email' => $data['email_com'],
            'cnpj' => $data['cnpj'],
            'user_type' => $data['user_type'],
            'password' => Hash::make($data['password']),
            'is_newsletter_subscribed' => $data['is_newsletter_subscribed'],
            'terms_conditions_status' => $data['terms_conditions_status'],
            'privacy_policy_status' => $data['privacy_policy_status'],
            'cookies_policy_status' => 0,
        ]);

        $email = $data['email_com'];
        if ($insertData) {
            $userId = $insertData->id;
            $profile = Profile::create([
                'user_id' => $userId,
                'approve_status' => 0
            ]);
            if ($data['is_newsletter_subscribed'] == 1) {
                Newsletter::subscribe($email);
            }

            $this->sentEmailVarificationLink($email);
        }
        return $insertData;
    }
    /**
     * Function to insert info for company
     * @param array $data
     * return mix
     */
    public function insertCandidateData($data)
    {
        $slug = $this->candidateService->getUniqueSlug($data['first_name']);
        $insertData = User::create([
            'first_name' => $data['first_name'],
            'slug' => $slug,
            'email' => $data['email'],
            'user_type' => $data['user_type'],
            'password' => Hash::make($data['password']),
            'is_newsletter_subscribed' => $data['is_newsletter_subscribed'],
            'terms_conditions_status' => $data['terms_conditions_status'],
            'privacy_policy_status' => $data['privacy_policy_status'],
            'cookies_policy_status' => 0
        ]);
        if ($insertData) {
            $userId = $insertData->id;
            $profile = Profile::create([
                'user_id' => $userId,
                'approve_status' => 0
            ]);
            if ($data['is_newsletter_subscribed'] == 1) {
                $email = $data['email'];
                Newsletter::subscribe($email);

                // SEND PULSE START
                // GET ACCESS TOKEN
                $ch = curl_init('https://api.sendpulse.com/oauth/access_token');
                $postData = array(
                    "grant_type" => 'client_credentials',
                    "client_id" => "f735481720637ed8eda1b3f06885aa91",
                    "client_secret" => "5ebc1d1508d3bbf1f88900e6ca9537f4",
                );
                curl_setopt_array($ch, array(
                    CURLOPT_POST => TRUE,
                    CURLOPT_RETURNTRANSFER => TRUE,
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json'
                    ),
                    CURLOPT_POSTFIELDS => json_encode($postData)
                ));
                $responseToken = curl_exec($ch);
                $decodedToken = json_decode($responseToken);
                //END-- GET ACCESS TOKEN

                // START ADD EMAILS TO A MAILING LIST
                $ch = curl_init('https://api.sendpulse.com/addressbooks/348575/emails');
                $postDataForEmails = [
                    "emails" => [
                        [
                            "email" => $email,
                            "variables" => [
                                "name" => $data['first_name'],
                            ]
                        ]
                    ]
                ];
                curl_setopt_array($ch, array(
                    CURLOPT_POST => TRUE,
                    CURLOPT_RETURNTRANSFER => TRUE,
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer ' . $decodedToken->access_token,
                        'Content-Type: application/json'
                    ),
                    CURLOPT_POSTFIELDS => json_encode($postDataForEmails)
                ));
                $response = curl_exec($ch);
                //-- END ADD EMAILS TO A MAILING LIST
                //-- END SEND PULSE END
            }

            /*   //Mail chip code
            $postData = array(
                "email_address" => $data['email'],
                "status" => "subscribed",
                "merge_fields" => array(
                    "FNAME"=> $data['first_name'],
                    "PHONE"=> '',
                    "COMMENT" => ''
                )
            );
            $authToken='497a4f90b657f56cc10352b2acdd2bde-us14';
            // Setup cURL
            $ch = curl_init('https://us14.api.mailchimp.com/3.0/lists/077546b6a1/members/');
            curl_setopt_array($ch, array(
                CURLOPT_POST => TRUE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_HTTPHEADER => array(
                    'Authorization: apikey '.$authToken,
                    'Content-Type: application/json'
                ),
                CURLOPT_POSTFIELDS => json_encode($postData)
            ));
            // Send the request
            $response = curl_exec($ch);//dd($response);
            //Mail chimp end          */

            $this->sentEmailVarificationLink($insertData->email);
        }
        return $insertData;
    }
    /**
     * Function to validate candidate
     * @param arrray $data
     * @return mix
     */
    public function validateCandidate($data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            //'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms_conditions_status' => ['required']
        ]);
    }
    /**
     * Function to validate company
     * @param arrray $data
     * @return mix
     */
    public function validateCompany($data)
    {
        return Validator::make($data, [
            // 'first_name' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255', 'unique:users'],
            // 'telephone' => ['required', 'numeric'],
            // 'email' => ['name:email_com', 'required', 'string', 'email', 'max:255', 'unique:users'],
            'cnpj' => ['required', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms_conditions_status' => ['required']
        ]);
    }

    /**
     * Function to sent email varification link to user's email
     * @param arrray $data
     * @param int $userId
     * @return mix
     */
    public function sentEmailVarificationLink($email)
    {

        $data = User::where('email', base64_encode($email))->first();
        if (empty($data)) {
            request()->session()->flash('status', "Something went wrong!");
            return redirect('home');
        }
        $emailVerifyToken = microtime();
        $encryptEmailVerifyToken =  encrypt($emailVerifyToken);
        $data['email_verify_token'] = $encryptEmailVerifyToken;
        $update = [];
        $update['email_verify_token'] = $encryptEmailVerifyToken;
        $update['email_verify_token_created'] = date('Y-m-d H:i'); //Fomat Date and time;
        User::where([['id', $data['id']]])
            ->update($update);
        $imgPath = env('APP_URL') . 'public/backend/dist/img/user.png';
        $logoPath = env('APP_URL') . 'public/frontend/images/logo-color.png';
        $data['imgPath'] = $imgPath;
        $data['logoPath'] = $logoPath;

        try {
            Mail::to($email)->send(new EmailVerifyLinkSent($data));
        } catch (Exception $ex) {
            // Debug via $ex->getMessage();
            //return "We've got errors!";
        }
        if ($data['user_type'] == 3) {
            $regSuccessMsg = '';
            $title = '';
            $id = 6;
            $data = $this->cmsServices->getCmsDataForHome($id);

            if (isset($data[2]['text'])) {
                $regSuccessMsg = $data[2]['text'];
                $title = $data[4]['text'];
            }
            $this->redirectTo = '/joinus';
            //echo 1; exit;
            return redirect('joinus')->with(['regSuccessMsg' => $regSuccessMsg, 'title' => $title]);
        } else {
            $message['message'] = __('messages.EMAIL_VERIFICATION_LINK_HAS_BEEN_SENT_TO_YOUR_REGISTERED_EMAIL');
            $message['image'] = asset('/frontend/images/SPAM_check.jpg');
            request()->session()->flash('statusRegistration', $message);
            
            //request()->session()->flash('status', __('messages.EMAIL_VERIFICATION_LINK_HAS_BEEN_SENT_TO_YOUR_REGISTERED_EMAIL'));
            return redirect('home');
        }
    }

    /**
     * Function to sent email varification link to user's email
     * @param arrray $data
     * @param int $userId
     * @return mix
     */
    public function verifyUserEmail(Request $request)
    {
        $token = $request['token'];
        $user = User::where([['email_verify_token', $token]])->first();
        $createdAt = strtotime($user['email_verify_token_created']);
        $expTime = 86400; // 24 hours in sec 
        $currentTime = time();
        if (($currentTime - $createdAt) <= $expTime) {
            $update['status'] = 1;
            $update['is_email_verified'] = 1;
            User::where([['email_verify_token', $token]])
                ->update($update);
            $admin = User::where([['id', 1]])->first();
            $user['admin_email'] = $admin['email'];
            $imgPath = env('APP_URL') . 'public/backend/dist/img/user.png';
            $logoPath = env('APP_URL') . 'public/frontend/images/logo-color.png';
            $user['imgPath'] = $imgPath;
            $user['logoPath'] = $logoPath;
            Mail::to($user['email'])->send(new WelcomeEmailSent($user));
            if ($user['user_type'] == 2) {
                $this->guard()->login($user);
                return redirect('candidate/payments');
            } elseif ($user['user_type'] == 3) {
                //$this->guard()->login($user);
                request()->session()->flash('status', __('messages.YOU_EMAIL_HAS_BEEN_VERIFIED_SUCCESSFULL'));
                return redirect('joinus');
            }
        } else {
            request()->session()->flash('status', __('messages.SORRY_THIS_EMAIL_VERIFICATION_LINK_HAS_BEEN_EXPIRED'));
            return redirect('home');
        }
    }
}
