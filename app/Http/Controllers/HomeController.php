<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Service\CmsService;
use App\Service\Candidate\CandidateService;
use App\Service\BestAdvertisementService;
use App\Service\StateService;
use App\Http\Model\State;
use App\Http\Model\City;
use DB;
use Newsletter;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $cmsServices; 
    protected $candidateService;
    protected $stateService;
    protected $bestAdvertisementService;
    public function __construct(
        CmsService $cmsService,
        CandidateService $candidateService,
        StateService $stateService,
        BestAdvertisementService $bestAdvertisementService
    )
    {
        //$this->middleware('auth');
        $this->cmsServices = $cmsService;
        $this->candidateService = $candidateService;
        $this->stateService = $stateService;
        $this->bestAdvertisementService = $bestAdvertisementService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::check() && Auth::user()->user_type == 1){
            // if(Auth::user()->user_type == 3){ // company
            //     return redirect('/company/dashboard');
            // }
            if(Auth::user()->user_type == 1){ // admin
                return redirect('/admin/dashboard');
            }
            
        }else{
            $data = [];
            $data['id'] = $id = 6;
            $data['data'] = $this->cmsServices->getCmsDataForHome($id);
            $data['position'] = $this->candidateService->positionFor();
            $selectedCountry = 14;
            $selectedCountry1 = 14;
            $data['states'] = $states = $this->stateService->getStateById($selectedCountry);
            $data['states1'] = $states1 = $this->stateService->getStateById($selectedCountry1);
            foreach($states as $key => $state)
            {
                $stateIds [] = $state->id;
            }
            $stateIds = array_filter(array_unique($stateIds));
            $cities = $this->stateService->getAllSelectedCity($stateIds);
            $data['best_advertise'] = $this->bestAdvertisementService->getBestAdvertise();
            $data['cities'] = $cities;
      
            return view('home', $data);


            // UPDATE `page_content_text` SET `text` = '<h4>Social responsibility:</h4>\n\n<p>At <strong>CENTRAL JOBS</strong> we believe in the power of solidarity.</p>\n\n<p>For this reason, we allocate part of our profits to charitable institutions!</p>' WHERE `page_content_text`.`id` = 67;


            // UPDATE `page_content_text` SET `text` = '<h4>Soziale Verantwortung:</h4>\n\n<p>Bei<strong> CENTRAL JOBS</strong> glauben wir an die Kraft der Solidarität.</p>\n\n<p>Aus diesem Grund spenden wir einen Teil unserer Gewinne an wohltätige Organisationen!</p>' WHERE `page_content_text`.`id` = 68;


            // UPDATE `page_content_text` SET `text` = '<section class=\"aboutfirst-section\"> <div class=\"container\"> <div class=\"row\"> <div class=\"col-12 col-lg-12 d-flex align-items-center\"> <div> <div class=\"mission-inner\"> <h2 class=\"title-about\">INTERVIEW</h2> <p>When you receive an invitation for an interview or job offer, always verify that the company actually exists. Be cautious of offers promising unusually high salaries (above market average). Ensure that there are no fees for psychological tests or resume writing.</p> <p>Central Jobs does not partner with companies that charge candidates to participate in selection processes. We highly recommend researching the company online to confirm its legitimacy.</p> <p>If you encounter a potential scam, please report the company through the “Contact” section at the bottom of our Home Page. We are committed to keeping this website safe!</p> </div> </div> </div> </div> </div> </section> <section class=\"mission-section\"> <div class=\"container\"> <div class=\"row\"> <div class=\"col-12 col-lg-6\"> <div class=\"img-holder\"><img alt=\"image\" class=\"img-fluid\" src=\"https://central-jobs.com/pages/tips.png\" /></div> </div> <div class=\"col-12 col-lg-6 d-flex align-items-center\"> <div class=\"ml-0 ml-lg-5\"> <div class=\"mission-inner\"> <h2 class=\"title-about\">DURING THE INTERVIEW</h2> <ul class=\"mission-list\"> <li>In today\'s fast-paced world, staying up to date is essential—even when preparing for job interviews. Traditional advice, such as researching the company and dressing professionally, is no longer enough. </li> <li>Companies are increasingly looking for creative individuals with strong problem-solving skills. Here are some unexpected questions you might encounter and tips on how to prepare for them:</li> </ul> </div> </div> </div> </div> </div> </section> <section class=\"our-values-section\"> <div class=\"container\"> <div class=\"row\"> <div class=\"col-12 d-flex align-items-center\"> <div class=\"our-value-section\"> <h2 class=\"title-about\">If you were an animal or a tree, which kind of animal or tree would you be?</h2> <p>If you decide to choose a tree, pick a tree that is strong and maybe adored by many people, like an oak, but not something weak. In case you choose an animal, select an animal that is intelligent and strong, like a lion or tiger. Never pick animals that are cuddly or fluffy.</p> <h2 class=\"title-about\">If you were a Star Wars or Star Trek character, who would you be?</h2> <p>This question is straightforward, but also tricky at the same time since they want to test your personalities. Therefore, whenever such kind of question pops up, ensure that you select a character who is a leader and a risk taker. Characters like Captain Kirk, Spock, Luke Skywalker, Han Solo, Sarek and other related characters are the perfect answers for such kind questions.</p> <h2 class=\"title-about\">If aliens visited you and asked you for anything you wish for or gave you a position on their home planet, what can you choose?</h2> <p><span>The answer you give tell your employer more about your professional goals as well as your creativity.</span></p> <h2 class=\"title-about\">Who is your favorite, your dad or mom?</h2> <p>You should be careful when answering this question. NEVER give an answer which indicates the challenges in your family, preferential treatment or gender preference during the interview. Your answer should pinpoint what each parent has taught you, and how they have helped you to become the person you are now.</p> <h2 class=\"title-about\">What´s your favorite color?</h2> <p>Choose a color that you can explain something about it and associate to a positive aspect of your life.</p> <h2 class=\"title-about\">Describe the color yellow to some who is blind:</h2> <p>The idea is to see your creativity. Yellow is like spring. It is a light and warm color that makes me feel happy.</p> </div> </div> <div class=\"col-12\"> <div class=\"img-holder\"><img alt=\"image\" class=\"img-fluid\" src=\"https://central-jobs.com/frontend/images/TIPS_PAGE_picture.png\" style=\"width: 1432px; height: 733px;\" /></div> </div> </div> </div> </section> <section class=\"About-Your-future\"> <div class=\"container\"> <div class=\"row\"> <div class=\"col-12 d-flex align-items-center justify-content-between\"> <div class=\"img-holder\"><img alt=\"image\" class=\"img-fluid\" src=\"https://central-jobs.com/frontend/images/logo-color-3.png\" /></div> <div>Your future <a class=\"ml-1\" href=\"http://dev107.developer24x7.com/cnp1356/public\"> starts here</a></div> </div> </div> </div> </section> <section class=\"About-company-team\"> <div class=\"container\"> <div class=\"row\"> <div class=\"col-12\"> <div class=\"img-holder\"><img alt=\"image\" class=\"img-fluid\" src=\"https://central-jobs.com/frontend/images/About-us-img-3.jpg\" /></div> </div> </div> </div> </section>' WHERE `page_content_text`.`id` = 22;




            // UPDATE `page_content_text` SET `text` = '<section class=\"aboutfirst-section\"> <div class=\"container\"> <div class=\"row\"> <div class=\"col-12 col-lg-12 d-flex align-items-center\"> <div> <div class=\"mission-inner\"> <h2 class=\"title-about\">VOR DEM VORSTELLUNGSGESPRÄCH</h2> <p><br /> Wenn Sie eine Einladung zu einem Vorstellungsgespräch oder ein Jobangebot erhalten, vergewissern Sie sich, dass das Unternehmen tatsächlich existiert. Seien Sie vorsichtig bei Angeboten mit ungewöhnlich hohen Gehältern (über dem Marktdurchschnitt). Achten Sie darauf, dass keine Gebühren für psychologische Tests oder das Verfassen Ihres Lebenslaufs anfallen.</p> <p>Central-Jobs arbeitet nicht mit Unternehmen zusammen, die von Bewerbern Gebühren für die Teilnahme an Auswahlverfahren verlangen. Wir empfehlen Ihnen, sich stets online über das Unternehmen zu informieren, um dessen Legitimität zu überprüfen.</p> <p>Falls Sie einen Betrugsversuch bemerken, melden Sie das Unternehmen bitte über das „Kontakt“-Feld am unteren Rand unserer Startseite. Wir tun unser Bestes, um diese Website sicher zu halten!</p> </div> </div> </div> </div> </div> </section> <section class=\"mission-section\"> <div class=\"container\"> <div class=\"row\"> <div class=\"col-12 col-lg-6\"> <div class=\"img-holder\"><img alt=\"image\" class=\"img-fluid\" src=\"https://central-jobs.com/pages/tips.png\" /></div> </div> <div class=\"col-12 col-lg-6 d-flex align-items-center\"> <div class=\"ml-0 ml-lg-5\"> <div class=\"mission-inner\"> <h2 class=\"title-about\">WÄHREND DES VORSTELLUNGSGESPRÄCHS&nbsp;</h2> <ul class=\"mission-list\"> <li> <p>In der heutigen schnelllebigen Welt ist es wichtig, sich auch in Bezug auf Vorstellungsgespräche stets weiterzuentwickeln!</p> </li> <li> <p>Traditionelle Tipps, wie das Sammeln von Informationen über das Unternehmen oder die Wahl einer professionellen Kleidung, sind nicht mehr ausreichend.</p> </li> <li> <p>Unternehmen suchen zunehmend nach kreativen Mitarbeitenden, die Probleme schnell lösen können. Im Folgenden finden Sie einige ungewöhnliche Fragen, die in Vorstellungsgesprächen gestellt werden, sowie Tipps, wie Sie darauf vorbereitet sein können.</p> </li> </ul> <p>&nbsp;</p> <p>&nbsp;</p> </div> </div> </div> </div> </div> </section> <section class=\"our-values-section\"> <div class=\"container\"> <div class=\"row\"> <div class=\"col-12 d-flex align-items-center\"> <div class=\"our-value-section\"> <h2 class=\"title-about\">Wenn Sie ein Tier oder ein Baum wären, welches Tier oder welcher Baum würden Sie sein?</h2> <p>Wenn Sie einen Baum wählen, wählen Sie einen Baum, der stark ist und den die Menschen im Allgemeinen mögen. Wenn Sie ein Tier wählen, wählen Sie ein Tier, das schlau und stark ist, z. B. einen Löwen oder einen Tiger. Vermeiden Sie es, Tiere zu wählen, die zu niedlich sind.</p> <h2 class=\"title-about\">Wenn Sie ein Star-Wars- oder Star-Trek-Charakter wären, wen würden Sie wählen?</h2> <p>Bei dieser Frage geht es um Informationen über Ihre Persönlichkeit. Wir empfehlen, immer einen Charakter zu wählen, der bereit ist, Risiken einzugehen, und der ein Anführer ist. Gute Antworten auf diese Frage wären: Captain Kirk, Spock, Luke Skywalker, Sarek.</p> <h2 class=\"title-about\">Wenn Außerirdische Ihnen ein Geschenk oder eine Anstellung auf ihrem Planeten anbieten, welches von beiden würden Sie wählen?</h2> <p><span>Ihre Antwort gibt dem Fragesteller Auskunft über Ihre beruflichen Ziele und auch über Ihre Kreativität!</span></p> <h2 class=\"title-about\">Wer ist Ihr Favorit: Ihre Mutter oder Ihr Vater?</h2> <p>Bei der Beantwortung dieser Frage müssen Sie aufpassen. Antworten Sie niemals in einer Weise, die auf Streitigkeiten oder Meinungsverschiedenheiten in Ihrer Familie hinweist oder eine Vorliebe für ein Geschlecht andeutet. Ihre Antwort sollte auf die Person hinweisen, die zu Ihrer Ausbildung und Ihren ethischen Werten beigetragen hat, die Sie zu dem Profi gemacht haben, der Sie heute sind.</p> <h2 class=\"title-about\">Was ist Ihre Lieblingsfarbe?</h2> <p>Wählen Sie eine Farbe, zu der Sie etwas erklären können. Vorzugsweise einen positiven Aspekt, der mit Ihrem Leben zu tun hat!</p> <h2 class=\"title-about\">Beschreiben Sie die Farbe Gelb einer Person, die blind ist.</h2> <p>Hier geht es darum, Ihre Kreativität zu zeigen. Gelb ist die Farbe des Frühlings, warm und macht uns glücklich (zum Beispiel).</p> </div> </div> <div class=\"col-12\"> <div class=\"img-holder\"><img alt=\"image\" class=\"img-fluid\" src=\"https://central-jobs.com/frontend/images/TIPS_PAGE_picture.png\" /></div> </div> </div> </div> </section> <section class=\"About-Your-future\"> <div class=\"container\"> <div class=\"row\"> <div class=\"col-12 d-flex align-items-center justify-content-between\"> <div class=\"img-holder\"><img alt=\"image\" class=\"img-fluid\" src=\"https://central-jobs.com/frontend/images/logo-color-3.png\" /></div> <div>Your future <a class=\"ml-1\" href=\"http://dev107.developer24x7.com/cnp1356/public\"> starts here</a></div> </div> </div> </div> </section> <section class=\"About-company-team\"> <div class=\"container\"> <div class=\"row\"> <div class=\"col-12\"> <div class=\"img-holder\"><img alt=\"image\" class=\"img-fluid\" src=\"https://central-jobs.com/frontend/images/About-us-img-3.jpg\" /></div> </div> </div> </div> </section>' WHERE `page_content_text`.`id` = 23;
        }
        
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function login()
    {
        
        if(Auth::check()){
            if(Auth::user()->user_type == 2){ // candidate
                return redirect('/candidate/dashboard');
            }
            if(Auth::user()->user_type == 3){ // company
                return redirect('/company/dashboard');
            }
            if(Auth::user()->user_type == 1){ // admin
                return redirect('/admin/dashboard');
            }
            
        }else{
            $id = 6;
            $data = $this->cmsServices->getCmsDataForHome($id);
            return view('login',compact('id','data'));
        }
        
    }
    public function emailVerification($id)
    {
        $pageTitle = "Email verification require";
        return view('frontend.home.emailVerificationRequire',compact('pageTitle'));
    }
    public function pendingAdminVerification($id)
    {
        $pageTitle = "Pending Admin Approval";
        return view('frontend.home.pendingAdminApproval',compact('pageTitle'));
    }
    public function blockedByAdmin(Request $request,$id)
    {
        $request->session()->invalidate();
        $pageTitle = "Blocked by admin";
        return view('frontend.home.blockedByAdmin',compact('pageTitle'));
    }
    public function getDetails(Request $request){
        $email = $request['email'];
        $data = User::where([['email',base64_encode($email)]])->first();
        echo json_encode($data);
    }
    public function rejectedAdminVerification($id){
        $pageTitle = "Rejected Admin Approval";
        return view('frontend.home.rejectedAdminApproval',compact('pageTitle'));
    }
    public function activateUser(Request $request,$id)
    {
        //dd(base64_decode($id));
        $request->session()->invalidate();
        $pageTitle = "Activate User";
        return view('frontend.home.activateUser',compact('pageTitle','id'));
    }
    // public function newsletter(Request $request){
    //     $email = $request['email'];
    //     Newsletter::subscribe($email);
    //     request()->session()->flash('success-msg', __('messages.YOUR_EMAIL_SUBSCRIBED_SUCCESSFULLY') );
    //     return redirect()->back();
    // }

    public function companySignup(){
    
        $id = 6;
        $data = $this->cmsServices->getCmsDataForHome($id);
        return view('companySignup',compact('id','data'));
    }
}
