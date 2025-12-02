<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CandidateAuth\LoginController as CandidateLoginController;
use App\Http\Controllers\CandidateAuth\RegisterController as CandidateRegisterController;
use App\Http\Controllers\WebBlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Cms\Cms;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Candidate\Candidate as CandidateController;
use App\Http\Controllers\Candidate\Mcq;
use App\Http\Controllers\Company\Company as CompanyController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['checkCountry']], function () {
    Route::get('locale/{locale}', function ($locale) {

        // Cookie::queue('locale', $locale, (1440 * 30));
        // app()->setLocale($locale);
        Cookie::queue('locale', $locale, (1440 * 30));
        return redirect()->back();
    });
    //Auth::routes();//this is for Laravel Auth route like login,logout,reset password
    Route::get('home', [HomeController::class, 'index']);
    Route::get('/home', [HomeController::class, 'index']);
    Route::get('/', [HomeController::class, 'index']);
    Route::post('get-details', [HomeController::class, 'getDetails']);

    // Authentication Routes...

    Route::get('login', [HomeController::class, 'login'])->name('candidate.login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('joinus', [HomeController::class, 'companySignup'])->name('joinus');
    Route::any('logout', [LoginController::class, 'logout'])->name('logout');

    //Route::get('logout', 'Auth\LoginController@logout')->name('logout');
    Route::post('subscribe-email', [HomeController::class, 'newsletter']);
    // Registration Routes...
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
    Route::get('resend-email/{email}', [RegisterController::class, 'sentEmailVarificationLink'])->name('resend-email');
    Route::get('verify-user-email/{token}', [RegisterController::class, 'verifyUserEmail']);

    // Direct Authentication Routes From Apply Job...
    Route::post('candidate/login', [CandidateLoginController::class, 'login']);
    Route::post('candidate/register', [CandidateRegisterController::class, 'register']);
    Route::get('payments', [PaymentController::class, 'index']);
    Route::get('candidate/payments', [PaymentController::class, 'index']);
    Route::post('payments', [PaymentController::class, 'payment']);


    //For testing Stripe payment only 
    Route::get('testCharge', [PaymentController::class, 'testCharge']);
    Route::post('payment-process', [PaymentController::class, 'paymentProcess']);


    //Static CMS page
    Route::get('contact-us', [Cms::class, 'contactUs']);
    Route::post('contact-us', [Cms::class, 'contactUs']);
    Route::get('about-us', [Cms::class, 'aboutUs']);
    Route::get('tips', [Cms::class, 'tips']);
    Route::get('home-page', [Cms::class, 'homePage']);
    Route::get('terms-use', [Cms::class, 'terms']);
    Route::get('cookies-policy', [Cms::class, 'cookiesPolicy']);
    Route::get('privacy-policy', [Cms::class, 'privacy']);
    Route::get('service', [Cms::class, 'service']);
    Route::get('set-language', [Cms::class, 'setLanguage']);
    Route::get('/training-category-list', [TrainingController::class, 'index']);
    Route::get('/training-details/{id}', [TrainingController::class, 'details']);
    Route::get('/training-details/{catid}/{videoid}', [TrainingController::class, 'details']);

    Route::get('blogs', [WebBlogController::class, 'index']);
    // routes/web.php
    Route::get('blogs/{slug}', [WebBlogController::class, 'detail'])->name('blogs.detail');

    // Password Reset Routes...
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

    Route::get('/subscription-payment/{id}', [UserController::class, 'payment']);

    // Email Verification Routes...
    Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify'); // v6.x
    /* Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify'); // v5.x */
    Route::get('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
    //Admin routes Before Login
    Route::prefix('admin')->group(function () {
        // Login
        Route::get('/login', [\App\Http\Controllers\Admin\AdminController::class, 'login'])->name('admin.login');
        Route::post('/login', [\App\Http\Controllers\Admin\AdminController::class, 'login'])->name('admin.login.submit');

        // Forgot / Reset Password
        Route::get('/forgot-password', [\App\Http\Controllers\Admin\AdminController::class, 'forgotPassword'])->name('admin.password.request');
        Route::post('/verify-email', [\App\Http\Controllers\Admin\AdminController::class, 'verifyEmail'])->name('admin.password.email');
        Route::get('/reset-password/{token}', [\App\Http\Controllers\Admin\AdminController::class, 'resetPassword'])->name('admin.password.reset');
        Route::post('/reset-password/{token}', [\App\Http\Controllers\Admin\AdminController::class, 'resetPassword'])->name('admin.password.update');
    });

    //Admin routes After Login
    //Logout
    Route::post('/admin/logout', [\App\Http\Controllers\Admin\AdminController::class, 'logout']);
    Route::get('/admin/logout', [\App\Http\Controllers\Admin\AdminController::class, 'logout']);
    Route::prefix('admin')->middleware(['adminAuth'])->group(function () {
        //Dashboard
        Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index']);
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index']);
        //Change Password
        Route::get('/change-password', [\App\Http\Controllers\Admin\AdminController::class, 'passwordUpdate']);
        Route::post('/password-update', [\App\Http\Controllers\Admin\AdminController::class, 'passwordUpdateProcess']);
        //Admin Home


        //Candidate
        Route::get('/candidate-list', [\App\Http\Controllers\Admin\CandidateController::class, 'index']);
        Route::delete('candidate/destroy/{id}', [\App\Http\Controllers\Admin\CandidateController::class, 'destroy'])->name('candidate.destroy');
        Route::post('/candidate-change-status', [\App\Http\Controllers\Admin\CandidateController::class, 'changeStatus']);
        Route::get('/view-candidate-details/{id}', [\App\Http\Controllers\Admin\CandidateController::class, 'viewDetails']);
        Route::post('/candidate-get-state', [\App\Http\Controllers\Admin\CandidateController::class, 'getState']);
        //Company
        Route::get('/company-list', [\App\Http\Controllers\Admin\CompanyController::class, 'index']);
        Route::delete('company/destroy/{id}', [\App\Http\Controllers\Admin\CompanyController::class, 'destroy'])->name('company.destroy');
        Route::post('/company-change-status', [\App\Http\Controllers\Admin\CompanyController::class, 'changeStatus']);
        Route::get('/view-company-details/{id}', [\App\Http\Controllers\Admin\CompanyController::class, 'viewDetails']);
        Route::post('/company-get-state', [\App\Http\Controllers\Admin\CompanyController::class, 'getState']);
        Route::post('/company-approve-status', [\App\Http\Controllers\Admin\CompanyController::class, 'approveCompany']);
        Route::post('/company-get-details', [\App\Http\Controllers\Admin\CompanyController::class, 'companyGetDetails']);
        Route::post('/company-report-details', [\App\Http\Controllers\Admin\CompanyController::class, 'companyReportList']);
        Route::get('/company-job-list/{id}', [\App\Http\Controllers\Admin\CompanyController::class, 'jobList']);
        Route::get('/company-report-list/{id}', [\App\Http\Controllers\Admin\CompanyController::class, 'companyReportAllList']);


        //Blogs
        Route::get('/blogs', [BlogController::class, 'index']);
        Route::get('/blogs/add', [BlogController::class, 'add']);
        Route::post('/blogs/store', [BlogController::class, 'store']);
        Route::get('/blogs/edit/{id}', [BlogController::class, 'edit']);
        Route::post('/blogs/update/{id}', [BlogController::class, 'update']);
        Route::delete('/blogs/delete/{id}', [BlogController::class, 'destroy']);
        //CMS Page
        // Route::get('/cms-page', 'AdminController@cmsPages');
        // Route::get('/cms-edit/{id}', 'AdminController@cmsEdit');
        // Route::post('/cms-edit/{id}', 'AdminController@cmsEdit');
        Route::get('/page-list', [\App\Http\Controllers\Admin\CmsController::class, 'index']);
        Route::get('/add-page', [\App\Http\Controllers\Admin\CmsController::class, 'add']);
        Route::post('/store-page', [\App\Http\Controllers\Admin\CmsController::class, 'store']);
        Route::delete('page/destroy/{id}', [\App\Http\Controllers\Admin\CmsController::class, 'destroy'])->name('page.destroy');
        Route::get('/update-page/{id}', [\App\Http\Controllers\Admin\CmsController::class, 'update']);
        Route::post('/update-page-info', [\App\Http\Controllers\Admin\CmsController::class, 'updatePageInfo']);
        Route::post('/page-change-status', [\App\Http\Controllers\Admin\CmsController::class, 'pageChangeStatus']);


        Route::get('/page-content-reference/{id}', [\App\Http\Controllers\Admin\CmsController::class, 'pageContentRef']);
        Route::get('/add-page-content-reference/{id}', [\App\Http\Controllers\Admin\CmsController::class, 'pageContentRef']);
        Route::get('/add-page-reference', [\App\Http\Controllers\Admin\CmsController::class, 'addPageReference']);
        Route::post('/store-page-reference', [\App\Http\Controllers\Admin\CmsController::class, 'storePageReference']);

        Route::get('/page-content-reference/{id}', [\App\Http\Controllers\Admin\CmsController::class, 'pageContentRef']);
        Route::get('/add-page-reference/{id}', [\App\Http\Controllers\Admin\CmsController::class, 'addPageReference']);
        Route::post('/store-page-reference/{id}', [\App\Http\Controllers\Admin\CmsController::class, 'storePageReference']);
        Route::delete('/delete-page-ref/destroy/{id}', [\App\Http\Controllers\Admin\CmsController::class, 'deletePageReference']);
        Route::get('/update-page-cont-ref/{id}', [\App\Http\Controllers\Admin\CmsController::class, 'updatePageContentRef']);
        Route::post('/update-page-cont-ref-info/{id}', [\App\Http\Controllers\Admin\CmsController::class, 'updatePageContRefInfo']);
        Route::post('/content-ref-change-status', [\App\Http\Controllers\Admin\CmsController::class, 'contentRefChangeStatus']);

        Route::get('/get-page-content-text/{id}', [\App\Http\Controllers\Admin\CmsController::class, 'getPageContentText']);
        Route::post('/add-page-content-text', [\App\Http\Controllers\Admin\CmsController::class, 'addPageContentText']);
        Route::get('/edit-page-content-text/{id}', [\App\Http\Controllers\Admin\CmsController::class, 'editPageContentText']);
        Route::post('/edit-page-content-text-post', [\App\Http\Controllers\Admin\CmsController::class, 'editPageContentTextPost']);
        Route::post('/banner-img-delete', [\App\Http\Controllers\Admin\CmsController::class, 'bannerImageDelete']);


        //Job Management

        Route::get('/jobs', [\App\Http\Controllers\Admin\JobController::class, 'jobs']);
        Route::get('/jobs/{id}/detail', [\App\Http\Controllers\Admin\JobController::class, 'jobDetail'])->name('detail_job');
        Route::post('/jobs/{id}/accept', [\App\Http\Controllers\Admin\JobController::class, 'acceptJob'])->name('accept_job');
        Route::delete('/jobs/{id}/reject', [\App\Http\Controllers\Admin\JobController::class, 'rejectJob'])->name('reject_job');





        Route::get('/job-list', [\App\Http\Controllers\Admin\JobController::class, 'index']);
        // Route::get('/job-list/{id}', 'JobController@index');
        Route::post('/job-change-status', [\App\Http\Controllers\Admin\JobController::class, 'changeStatus']);
        Route::get('/job-add', [\App\Http\Controllers\Admin\JobController::class, 'jobAdd']);
        Route::post('/job-add', [\App\Http\Controllers\Admin\JobController::class, 'jobAddPost']);
        Route::get('/job-edit/{id}', [\App\Http\Controllers\Admin\JobController::class, 'jobEdit']);
        Route::post('/job-edit/{id}', [\App\Http\Controllers\Admin\JobController::class, 'jobEditPost']);
        Route::get('/job-view/{id}', [\App\Http\Controllers\Admin\JobController::class, 'jobView']);
        Route::delete('job/destroy/{id}', [\App\Http\Controllers\Admin\JobController::class, 'destroy']);
        Route::post('/get-state', [\App\Http\Controllers\Admin\JobController::class, 'getState']);
        Route::get('/users-applied/{id}', [\App\Http\Controllers\Admin\JobController::class, 'usersApplied']);
        //Post Management
        Route::get('/post-list', [\App\Http\Controllers\Admin\PostController::class, 'index']);
        Route::get('/post-view/{id}', [\App\Http\Controllers\Admin\PostController::class, 'postView']);
        Route::get('/post-edit/{id}', [\App\Http\Controllers\Admin\PostController::class, 'postEdit']);
        Route::post('/post-edit/{id}', [\App\Http\Controllers\Admin\PostController::class, 'postEditPost']);
        Route::get('/post-add', [\App\Http\Controllers\Admin\PostController::class, 'postAdd']);
        Route::get('/post-add/{job}', [\App\Http\Controllers\Admin\PostController::class, 'postAdd']);
        Route::post('/post-add-post', [\App\Http\Controllers\Admin\PostController::class, 'postAddPost']);
        //Reported Post
        Route::get('/reported-post-list', [\App\Http\Controllers\Admin\PostController::class, 'reportedPostList']);
        Route::post('/get-report-details', [\App\Http\Controllers\Admin\PostController::class, 'getReportDetails']);
        Route::post('/post-change-status', [\App\Http\Controllers\Admin\PostController::class, 'postChangeStatus']);
        Route::get('/view-report-details/{id}', [\App\Http\Controllers\Admin\PostController::class, 'viewReportDetails']);
        Route::post('/reported-post-abuse', [\App\Http\Controllers\Admin\PostController::class, 'reportedPostAbuse']);
        Route::post('/reported-post-ignore', [\App\Http\Controllers\Admin\PostController::class, 'reportedPostIgnore']);
        //Reported Comment
        Route::get('/reported-comment-list', [\App\Http\Controllers\Admin\PostController::class, 'reportedCommentList']);
        Route::get('/view-comment-report-details/{id}', [\App\Http\Controllers\Admin\PostController::class, 'viewCommentReportDetails']);
        Route::post('/reported-comment-abuse', [\App\Http\Controllers\Admin\PostController::class, 'reportedCommentAbuse']);
        Route::post('/reported-comment-ignore', [\App\Http\Controllers\Admin\PostController::class, 'reportedCommentIgnore']);
        //Training Category
        Route::get('/training-category-list', [\App\Http\Controllers\Admin\TrainingController::class, 'index']);
        Route::get('/training-category-add', [\App\Http\Controllers\Admin\TrainingController::class, 'categoryAdd']);
        Route::post('/training-category-post', [\App\Http\Controllers\Admin\TrainingController::class, 'categoryAddPost']);
        Route::get('/training-category-edit/{id}', [\App\Http\Controllers\Admin\TrainingController::class, 'categoryEdit']);
        Route::post('/training-category-edit/{id}', [\App\Http\Controllers\Admin\TrainingController::class, 'categoryEditPost']);
        Route::post('/training-category-change-status', [\App\Http\Controllers\Admin\TrainingController::class, 'categoryChangeStatus']);
        Route::delete('training-category/destroy/{id}', [\App\Http\Controllers\Admin\TrainingController::class, 'destroy']);
        //Training Video
        Route::get('/training-video-list', [\App\Http\Controllers\Admin\TrainingController::class, 'videoList']);
        Route::get('/training-video-add', [\App\Http\Controllers\Admin\TrainingController::class, 'videoAdd']);
        Route::post('/training-video-post', [\App\Http\Controllers\Admin\TrainingController::class, 'videoAddPost']);
        Route::get('/training-video-edit/{id}', [\App\Http\Controllers\Admin\TrainingController::class, 'videoEdit']);
        Route::post('/training-video-edit/{id}', [\App\Http\Controllers\Admin\TrainingController::class, 'videoEditPost']);
        Route::post('/training-video-change-status', [\App\Http\Controllers\Admin\TrainingController::class, 'videoChangeStatus']);
        Route::delete('training-video/destroy/{id}', [\App\Http\Controllers\Admin\TrainingController::class, 'videoDestroy']);
        //Subscription
        Route::get('/subscription-list', [\App\Http\Controllers\Admin\SubscriptionController::class, 'index']);
        Route::post('/subscription-change-status', [\App\Http\Controllers\Admin\SubscriptionController::class, 'SubscriptionChangeStatus']);
        Route::delete('subscription/destroy/{id}', [\App\Http\Controllers\Admin\SubscriptionController::class, 'subscriptionDestroy']);
        Route::get('/view-subscription-details/{id}', [\App\Http\Controllers\Admin\SubscriptionController::class, 'viewSubscriptionDetails']);
        Route::get('/add-subscription', [\App\Http\Controllers\Admin\SubscriptionController::class, 'subscriptionAdd']);
        Route::post('/add-subscription-post', [\App\Http\Controllers\Admin\SubscriptionController::class, 'subscriptionAddPost']);
        Route::get('/edit-subscription/{id}', [\App\Http\Controllers\Admin\SubscriptionController::class, 'subscriptionEdit']);
        Route::post('/edit-subscription-post', [\App\Http\Controllers\Admin\SubscriptionController::class, 'subscriptionEditPost']);

        //Order
        Route::get('/order-list', [\App\Http\Controllers\Admin\OrderController::class, 'index']);
        Route::post('/view-order-details', [\App\Http\Controllers\Admin\OrderController::class, 'viewOrderDetails']);
        Route::post('/order-change-status', [\App\Http\Controllers\Admin\OrderController::class, 'orderChangeStatus']);
        Route::get('/add-subscription-order', [\App\Http\Controllers\Admin\OrderController::class, 'addSubscriptionOrder']);
        Route::get('/edit-subscription-order/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'editSubscriptionOrder']);
        Route::post('/store-subscription-info', [\App\Http\Controllers\Admin\OrderController::class, 'storeSubscriptionInfo']);
        Route::post('/update-subscription-info', [\App\Http\Controllers\Admin\OrderController::class, 'updateSubscriptionInfo']);
        Route::delete('order/destroy/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'destroy']);
        //Payment
        Route::get('/payment-list', [\App\Http\Controllers\Admin\PaymentController::class, 'index']);
        Route::get('/payment-details-download', [\App\Http\Controllers\Admin\PaymentController::class, 'downloadDetails']);

        //Screening Question
        Route::get('/screening-question-list', [\App\Http\Controllers\Admin\ScreeningQuestionController::class, 'index']);
        Route::get('/screening-question-add', [\App\Http\Controllers\Admin\ScreeningQuestionController::class, 'addQuestionAnswer']);
        Route::post('/screening-question-add-post', [\App\Http\Controllers\Admin\ScreeningQuestionController::class, 'addQuestionAnswerPost']);
        Route::get('/screening-question-edit/{id}', [\App\Http\Controllers\Admin\ScreeningQuestionController::class, 'editQuestionAnswer']);
        Route::post('/screening-question-edit-post', [\App\Http\Controllers\Admin\ScreeningQuestionController::class, 'editQuestionAnswerPost']);
        Route::post('/screening-change-status', [\App\Http\Controllers\Admin\ScreeningQuestionController::class, 'changeStatusQuestion']);
        Route::delete('/screening-question/destroy/{id}', [\App\Http\Controllers\Admin\ScreeningQuestionController::class, 'deleteQuestion']);

        //Advertisement
        Route::get('/advertise-list', [\App\Http\Controllers\Admin\AdvertisementController::class, 'index']);
        Route::get('/advertise-add', [\App\Http\Controllers\Admin\AdvertisementController::class, 'add']);
        Route::post('/advertise-add-post', [\App\Http\Controllers\Admin\AdvertisementController::class, 'addPost']);
        Route::get('/advertise-edit/{id}', [\App\Http\Controllers\Admin\AdvertisementController::class, 'edit']);
        Route::post('/advertise-edit-post', [\App\Http\Controllers\Admin\AdvertisementController::class, 'editPost']);
        Route::delete('advertisement/destroy/{id}', [\App\Http\Controllers\Admin\AdvertisementController::class, 'advertiseDestroy']);
        Route::post('/advertise-change-status', [\App\Http\Controllers\Admin\AdvertisementController::class, 'changeStatus']);

        //Best Advertisement
        Route::get('/best-advertise-list', [\App\Http\Controllers\Admin\BestAdvertisementController::class, 'index']);
        Route::get('/best-advertise-add', [\App\Http\Controllers\Admin\BestAdvertisementController::class, 'add']);
        Route::post('/best-advertise-add', [\App\Http\Controllers\Admin\BestAdvertisementController::class, 'addPost']);
        Route::get('/best-advertise-edit/{id}', [\App\Http\Controllers\Admin\BestAdvertisementController::class, 'edit']);
        Route::post('/best-advertise-edit', [\App\Http\Controllers\Admin\BestAdvertisementController::class, 'editPost']);
        Route::post('/best-advertise-change-status', [\App\Http\Controllers\Admin\BestAdvertisementController::class, 'changeStatus']);
        Route::delete('best-advertise/destroy/{id}', [\App\Http\Controllers\Admin\BestAdvertisementController::class, 'destroy']);

        //Payments
        Route::get('/payment-cms-list', [\App\Http\Controllers\Admin\PaymentController::class, 'list']);
        Route::get('/payment-cms-edit/{id}', [\App\Http\Controllers\Admin\PaymentController::class, 'edit']);
        Route::post('/payment-cms-edit', [\App\Http\Controllers\Admin\PaymentController::class, 'editPost']);

        Route::get('highlight/{candidateId}/{val}', [\App\Http\Controllers\Admin\PaymentController::class, 'updateHighlights']);
        // STRIPE PRODUCTS 
        Route::get('/product-list', [\App\Http\Controllers\Admin\PaymentController::class, 'productList']);
        Route::get('/product-list-edit/{id}', [\App\Http\Controllers\Admin\PaymentController::class, 'editProductList']);
        Route::get('/product-list-edit-active/{id}/{status}', [\App\Http\Controllers\Admin\PaymentController::class, 'changeProductActiveStatus']);
        Route::post('/product-list-edit', [\App\Http\Controllers\Admin\PaymentController::class, 'editProduct']);
        Route::get('/product-add', [\App\Http\Controllers\Admin\PaymentController::class, 'createProduct']);
        Route::post('/product-store', [\App\Http\Controllers\Admin\PaymentController::class, 'addProduct']);

        // TRANSACTION HISTORY 
        Route::get('/CandidateTransaction', [\App\Http\Controllers\Admin\PaymentController::class, 'CandidatetransactionList']);
        Route::get('/CompanyTransaction', [\App\Http\Controllers\Admin\PaymentController::class, 'CompanyTransactionList']);
    });
    //comon route call

    Route::namespace('Candidate')->prefix('candidate')->group(function () {
        Route::get('/get-country-states/{id}', [CandidateController::class, 'getCountryStates']);
        Route::get('my-jobs', [CandidateController::class, 'jobList']);
        Route::get('my-jobs/{id}', [CandidateController::class, 'jobList']);
        Route::post('my-jobs', [CandidateController::class, 'jobList']);
        Route::get('/view-job-post/{id}', [CandidateController::class, 'viewJobPost']);
        Route::get('/view-job-post/{id}/{notiId}', [CandidateController::class, 'viewJobPost']);
        Route::get('apply-job/{id}', [CandidateController::class, 'applyJob']);
    });
    // Validated User Routes
    Route::namespace('Candidate')->prefix('candidate')->middleware(['auth'])->group(function () {

        Route::get('/dashboard', [CandidateController::class, 'dashboard']);
        //Candidate Edit Profile

        Route::get('/edit-profile', [CandidateController::class, 'editProfile']);
        Route::get('/my-profile', [CandidateController::class, 'editProfile']);
        Route::get('/view-followers', [CandidateController::class, 'viewFollowers']);
        Route::get('/view-followers/{id}', [CandidateController::class, 'viewFollowers']);
        Route::get('/screening-mcq', [Mcq::class, 'screeningMcq']);
        Route::post('/screening-mcq-answer', [Mcq::class, 'screeningMcqAnswer']);
        Route::get('/screening-mcq-answer', [Mcq::class, 'screeningMcqAnswer']);
        Route::get('/manage-profile', [CandidateController::class, 'manageProfile']);
        Route::post('/manage-profile-post', [CandidateController::class, 'manageProfilePost']);
        Route::post('/upload-profille-img', [CandidateController::class, 'uploadProfileImg']);
        Route::post('/upload-banner-img', [CandidateController::class, 'uploadBannerImage']);
        Route::post('/upload-lib-banner-img', [CandidateController::class, 'uploadBannerImageFromLibrary']);
        Route::get('/success', [CandidateController::class, 'successRegistration']);
        Route::post('/store-profile-info', [CandidateController::class, 'storeProfileInfo']);
        Route::post('/store-hobbies', [CandidateController::class, 'storeHobbies']);
        Route::post('/store-cv-summary', [CandidateController::class, 'storeCvSummary']);
        Route::post('/store-cv', [CandidateController::class, 'storeCv']);
        Route::post('/delete-cv', [CandidateController::class, 'deleteCv']);
        Route::post('/remove-banner-img', [CandidateController::class, 'removeBannerImg']);
        Route::post('/remove-prfl-img', [CandidateController::class, 'removeProfileImg']);
        Route::post('/store-skills', [CandidateController::class, 'storeSkills']);
        Route::post('/get-professional-info', [CandidateController::class, 'getProfessionalInfo']);
        Route::post('/store-professional-info', [CandidateController::class, 'storeProfessionalInfo']);
        Route::post('/store-intro-video', [CandidateController::class, 'storeIntroVideo']);
        Route::post('/get-educational-info', [CandidateController::class, 'getEducationalInfo']);
        Route::post('/store-educational-info', [CandidateController::class, 'storeEducationalInfo']);
        Route::post('/store-language-info', [CandidateController::class, 'storeLanguageInfo']);
        Route::post('/remove-intro-video', [CandidateController::class, 'removeIntroVideo']);
        Route::post('/delete-language-info', [CandidateController::class, 'deleteLanguageInfo']);
        Route::post('/delete-professional-info', [CandidateController::class, 'deleteProfessionalInfo']);
        Route::post('/delete-educational-info', [CandidateController::class, 'deleteEducationalInfo']);
        Route::get('/search-profile', [CandidateController::class, 'searchProfile']);
        Route::get('/search-company-profile', [CandidateController::class, 'searchCompanyProfile']);
        Route::post('/delete-user-post', [CandidateController::class, 'deleteUserPost']);
        Route::get('/list-user-post-comment', [CandidateController::class, 'listUserPostComment']);
        Route::post('/report-comment', [CandidateController::class, 'reportComment']);
        Route::post('/follow-unfollow-user', [CandidateController::class, 'followUnfollowUser']);
        Route::get('/my-network', [CandidateController::class, 'myNetwork']);
        Route::get('/my-network/{id}', [CandidateController::class, 'myNetwork']);
        Route::get('/following-list', [CandidateController::class, 'followingList']);
        Route::get('/company-following-list', [CandidateController::class, 'companyFollowingList']);
        Route::post('/report-company', [CandidateController::class, 'reportCompany']);
        // Route::get('my-jobs','Candidate@jobList');
        // Route::get('my-jobs/{id}','Candidate@jobList');
        // Route::post('my-jobs','Candidate@jobList');
        Route::get('job-details', [CandidateController::class, 'jobDetails']);
        Route::post('job-alert', [CandidateController::class, 'jobAlert']);
        // Route::get('apply-job/{id}','Candidate@applyJob');
        Route::post('apply-job/{id}', [CandidateController::class, 'applyJob']);
        Route::post('apply-job-store-info', [CandidateController::class, 'applyJobStoreInfo']);
        Route::post('save-job', [CandidateController::class, 'saveJob']);
        Route::post('apply-job-store-specific-ans', [CandidateController::class, 'applyJobStoreSpecificAns']);
        Route::post('apply-job-store-all-info', [CandidateController::class, 'applyJobStoreAllInfo']);
        Route::get('track-job', [CandidateController::class, 'trackJob']);
        Route::get('job-alert-setting', [CandidateController::class, 'jobAlertSetting']);
        Route::post('delete-job-alert', [CandidateController::class, 'deleteJobAlert']);
        //Get City
        Route::get('/get-states-city/{id}', [CandidateController::class, 'getStatesCity']);
        //Interview Answer
        Route::post('/store-interview-video-answer', [CandidateController::class, 'storeInterviewVideoAnswer']);
        Route::post('/delete-interview-video', [CandidateController::class, 'deleteInterviewVideo']);
        Route::post('/store-interview-attempt', [CandidateController::class, 'storeInterviewAttempt']);
        Route::post('/get-selected-video', [CandidateController::class, 'getSelectedVideo']);

        Route::get('/view-post/{id}', [CandidateController::class, 'viewPost']);
        Route::get('/view-post/{id}/{notiId}', [CandidateController::class, 'viewPost']);
        // Route::get('/view-job-post/{id}','Candidate@viewJobPost');
        // Route::get('/view-job-post/{id}/{notiId}','Candidate@viewJobPost');
        Route::post('/delete-user-comment', [CandidateController::class, 'deleteUserComment']);
        Route::post('/set-job-alert-history', [CandidateController::class, 'setJobAlertHistory']);
        Route::post('apply-job-discard-info', [CandidateController::class, 'applyJobDiscardInfo']);

        Route::get('/see-application', [CandidateController::class, 'viewApplication']);
        Route::get('/edit-application/{id}', [CandidateController::class, 'editApplication']);
        Route::post('/edit-application/{id}', [CandidateController::class, 'updateApplication']);
        Route::post('/delete-application', [CandidateController::class, 'deleteApplication']);
    });


    Route::prefix('company')->middleware(['companyAuth'])->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Company\Company::class, 'dashboard']);
        Route::get('/view-followers', [\App\Http\Controllers\Company\Company::class, 'viewFollowers']);
        Route::get('/manage-profile', [\App\Http\Controllers\Company\Company::class, 'manageProfile']);
        Route::post('/manage-profile-post', [\App\Http\Controllers\Company\Company::class, 'manageProfilePost']);
        Route::get('/edit-profile', [\App\Http\Controllers\Company\Company::class, 'editProfile']);
        Route::get('/my-profile', [\App\Http\Controllers\Company\Company::class, 'editProfile']);
        Route::post('/upload-profille-img', [\App\Http\Controllers\Company\Company::class, 'uploadProfileImg']);
        Route::post('/upload-banner-img', [\App\Http\Controllers\Company\Company::class, 'uploadBannerImage']);
        Route::post('/upload-lib-banner-img', [\App\Http\Controllers\Company\Company::class, 'uploadBannerImageFromLibrary']);
        Route::get('/get-country-states/{id}', [\App\Http\Controllers\Company\Company::class, 'getCountryStates']);
        Route::post('/store-profile-info', [\App\Http\Controllers\Company\Company::class, 'storeProfileInfo']);
        Route::post('/remove-prfl-img', [\App\Http\Controllers\Company\Company::class, 'removeProfileImg']);
        Route::post('/remove-banner-img', [\App\Http\Controllers\Company\Company::class, 'removeBannerImg']);
        Route::get('/find-candidates', [\App\Http\Controllers\Company\Company::class, 'findCandidates']);
        Route::post('/check-unique-company', [\App\Http\Controllers\Company\Company::class, 'checkUniqueCompany']);
        Route::post('/delete-user-post', [\App\Http\Controllers\Company\Company::class, 'deleteUserPost']);
        Route::get('/list-user-post-comment', [\App\Http\Controllers\Company\Company::class, 'listUserPostComment']);
        Route::post('/report-comment', [\App\Http\Controllers\Company\Company::class, 'reportComment']);
        Route::get('/post-job/{id?}', [\App\Http\Controllers\Company\Company::class, 'postJob']);
        Route::post('/post-job-post', [\App\Http\Controllers\Company\Company::class, 'postJobPost']);
        Route::any('/upload-job-desc-image', [\App\Http\Controllers\Company\Company::class, 'uploadJobDescImage'])->name('ckeditor.upload_job_desc_image');
        Route::get('my-jobs', [\App\Http\Controllers\Company\Company::class, 'jobList']);
        Route::post('my-jobs', [\App\Http\Controllers\Company\Company::class, 'jobList']);
        Route::get('city_by_state', [\App\Http\Controllers\Company\Company::class, 'cityByState']);
        Route::get('job-details', [\App\Http\Controllers\Company\Company::class, 'jobDetails']);
        Route::get('applied-candidates/{id}', [\App\Http\Controllers\Company\Company::class, 'appliedCandidates']);
        Route::get('/my-network', [\App\Http\Controllers\Company\Company::class, 'myNetwork']);
        Route::get('/my-network/{id}', [\App\Http\Controllers\Company\Company::class, 'myNetwork']);
        Route::post('jobs/destroy/{id}', [\App\Http\Controllers\Company\Company::class, 'deleteJob']);
        Route::get('/edit-job/{id}', [\App\Http\Controllers\Company\Company::class, 'editJob']);
        Route::post('/edit-job/{id}', [\App\Http\Controllers\Company\Company::class, 'editJobPost']);
        //Get City
        Route::get('/get-states-city/{id}', [\App\Http\Controllers\Company\Company::class, 'getStatesCity']);

        Route::get('/view-post/{id}', [\App\Http\Controllers\Company\Company::class, 'viewPost']);
        Route::get('/view-post/{id}/{notiId}', [\App\Http\Controllers\Company\Company::class, 'viewPost']);
        Route::get('/view-job-post/{id}', [\App\Http\Controllers\Company\Company::class, 'viewJobPost']);
        Route::get('/view-job-post/{id}/{notiId}', [\App\Http\Controllers\Company\Company::class, 'viewJobPost']);
        Route::post('/delete-user-comment', [\App\Http\Controllers\Company\Company::class, 'deleteUserComment']);

        // Company payment process
        Route::get('payment-details', [\App\Http\Controllers\Company\PaymentController::class, 'jobAdvertisement']);
        Route::any('payment-details/{id}', [\App\Http\Controllers\Company\PaymentController::class, 'CompanyPayment']);
        Route::post('payment-process', [\App\Http\Controllers\Company\PaymentController::class, 'CompanyPaymentProcess']);
    });

    //for non validate page
    Route::get('/email-verification-pending/{id}', [HomeController::class, 'emailVerification']);
    Route::get('/pending-admin-approval/{id}', [HomeController::class, 'pendingAdminVerification']);
    Route::get('/rejected-admin-approval/{id}', [HomeController::class, 'rejectedAdminVerification']);
    Route::get('/blocked-by-admin/{id}', [HomeController::class, 'blockedByAdmin']);
    Route::get('/deactivated-user/{id}', [HomeController::class, 'activateUser']);
    Route::get('active-user/{id}', [PostController::class, 'activeYourAccount']);
    //Route::post('active-user/{id}','Company\Company@activeYourAccount');
    Route::get('candidate/profile/{slug}', [CandidateController::class, 'publicProfile']);
    Route::get('company/profile/{slug}', [CompanyController::class, 'publicProfile']);
    Route::post('/get-state', [CompanyController::class, 'getState']);
    Route::post('/get-multistates-multicity', [CompanyController::class, 'getMultistatesMulticity']);
    //post routes
    Route::post('/store-text-post', [PostController::class, 'storeTextPost']);
    Route::post('/store-image-post', [PostController::class, 'storeImagePost']);
    Route::post('/store-video-post', [PostController::class, 'storeVideoPost']);
    Route::post('/store-any-post', [PostController::class, 'storeAnyPost']);
    //Post Details
    // Route::get('/candidate/view-post/{id}','PostController@viewPost');
    // Route::get('/company/view-post/{id}','PostController@viewPost');
    // Route::get('/candidate/view-post/{id}/{notiId}','PostController@viewPost');
    // Route::get('/company/view-post/{id}/{notiId}','PostController@viewPost');
    // Route::get('/candidate/view-job-post/{id}','PostController@viewJobPost');
    // Route::get('/company/view-job-post/{id}','PostController@viewJobPost');
    // Route::get('/candidate/view-job-post/{id}/{notiId}','PostController@viewJobPost');
    // Route::get('/company/view-job-post/{id}/{notiId}','PostController@viewJobPost');
    //messages
    Route::get('/candidate/message/{id}', [MessageController::class, 'index']);
    Route::get('/company/message/{id}', [MessageController::class, 'index']);
    Route::get('/candidate/message/{id}/{msgId}', [MessageController::class, 'index']);
    Route::get('/company/message/{id}/{msgId}', [MessageController::class, 'index']);
    Route::post('/store-message/{id}', [MessageController::class, 'storeMsg']);
    Route::post('/candidate/create-post', [CandidateController::class, 'createPost']);
    Route::post('/delete-message-from', [MessageController::class, 'deleteMsgFrom']);
    Route::post('/block-message-contact', [MessageController::class, 'blockContactMsg']);
    //Route::post('/upload-message-files','MessageController@uploadMsgFile');
    Route::post('/upload-message-data-files', [MessageController::class, 'uploadMsgFileData']);
    Route::post('/remove-message', [MessageController::class, 'removeMessage']);
    //Route::post('/download-message-file','MessageController@downloadMessageFile');
    Route::get('/candidate/download-message-file/{file}', [MessageController::class, 'downloadMessageFile']);
    Route::get('/company/download-message-file/{file}', [MessageController::class, 'downloadMessageFile']);
    //Likes
    Route::post('/post-like', [PostController::class, 'postLike']);
    Route::post('/post-comment', [PostController::class, 'postComment']);
    Route::post('/report-post', [PostController::class, 'reportPost']);
    //Shares
    Route::post('/post-share', [PostController::class, 'postShare']);
    Route::post('/post-share-data', [PostController::class, 'postShareData']);
    //Connect
    Route::post('/send-connection-request', [PostController::class, 'sendConnectionRequest']);
    Route::post('/accept-reject-connection', [PostController::class, 'acceptRejectConnection']);
    //Block User
    Route::post('/block-unblock-user', [PostController::class, 'blockUnblockUser']);
    //CHECK USER LOGIN
    Route::post('/check-user-status', [PostController::class, 'chkUserStatus']);
    Route::post('/check-session-user-status', [PostController::class, 'chkSessionUserStatus']);
    //CHK UNIQUE EMAIL
    Route::post('/check-unique-email', [\App\Http\Controllers\Company\Company::class, 'checkUniqueEmail']);
    //CHECK USER JOB APPLIED STATUS
    Route::post('/check-job-apply-status', [PostController::class, 'chkUserJobAppliedStatus']);
    Route::post('/check-user-status-job', [PostController::class, 'chkUserStatusJob']);
    Route::post('candidate/store-service-info', [CandidateController::class, 'storeServiceInfo']);
});
Route::get('/migrate', function () {
    Artisan::call('migrate', ['--path' => '/database/migrations/2022_01_19_131552_add_order_to_cities_table.php']);
});
