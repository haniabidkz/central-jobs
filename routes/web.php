<?php
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
Route::group(['middleware'=> ['checkCountry'] ], function() {
Route::get('locale/{locale}', function ($locale){

    // Cookie::queue('locale', $locale, (1440 * 30));
    // app()->setLocale($locale);
    Cookie::queue('locale', $locale, (1440 * 30)); 
    return redirect()->back();

});
//Auth::routes();//this is for Laravel Auth route like login,logout,reset password
Route::get('/home','HomeController@index');
Route::get('/','HomeController@index');
Route::post('get-details','HomeController@getDetails');

// Authentication Routes...
Route::get('login', 'HomeController@login')->name('candidate.login');
Route::post('login', 'Auth\LoginController@login');
Route::get('joinus', 'HomeController@companySignup')->name('joinus');
Route::any('logout', 'Auth\LoginController@logout')->name('logout');
//Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::post('subscribe-email', 'HomeController@newsletter');
// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
Route::get('resend-email/{email}', 'Auth\RegisterController@sentEmailVarificationLink')->name('resend-email');

Route::get('verify-user-email/{token}','Auth\RegisterController@verifyUserEmail');

// Direct Authentication Routes From Apply Job...
Route::post('candidate/login', 'CandidateAuth\LoginController@login');
Route::post('candidate/register', 'CandidateAuth\RegisterController@register');
Route::get('payments', 'PaymentController@index');
Route::get('candidate/payments', 'PaymentController@index');
Route::post('payments', 'PaymentController@payment');


//For testing Stripe payment only 
Route::get('testCharge','PaymentController@testCharge');
Route::post('payment-process','PaymentController@paymentProcess');


//Static CMS page
Route::get('contact-us', 'Cms\Cms@contactUs');
Route::post('contact-us', 'Cms\Cms@contactUs');
Route::get('about-us', 'Cms\Cms@aboutUs');
Route::get('tips', 'Cms\Cms@tips');
Route::get('home-page', 'Cms\Cms@homePage');
Route::get('terms-use', 'Cms\Cms@terms');
Route::get('cookies-policy', 'Cms\Cms@cookiesPolicy');
Route::get('privacy-policy', 'Cms\Cms@privacy');
Route::get('service', 'Cms\Cms@service');
Route::get('set-language', 'Cms\Cms@setLanguage');
Route::get('/training-category-list', 'TrainingController@index');
Route::get('/training-details/{id}', 'TrainingController@details');
Route::get('/training-details/{catid}/{videoid}', 'TrainingController@details');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

Route::get('/subscription-payment/{id}','UserController@payment');

// Email Verification Routes...
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify'); // v6.x
/* Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify'); // v5.x */
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
//Admin routes Before Login
Route::namespace('Admin')->prefix('admin')->group(function () {
    //Login
   // Route::get('/admin', 'AdminController@login')->name('login');
    Route::post('/', 'AdminController@login')->name('login');
    Route::get('/login', 'AdminController@login')->name('login');
    Route::post('/login', 'AdminController@login')->name('login');
    //Forgot Password
    Route::get('/forgot-password', 'AdminController@forgotPassword');
    Route::post('/verify-email', 'AdminController@verifyEmail');
    Route::get('/reset-password/{token}', 'AdminController@resetPassword');
    Route::post('/reset-password/{token}', 'AdminController@resetPassword');
});

//Admin routes After Login
 //Logout
    Route::post('/admin/logout', 'Admin\AdminController@logout');
    Route::get('/admin/logout', 'Admin\AdminController@logout');
Route::namespace('Admin')->prefix('admin')->middleware(['adminAuth'])->group(function () {
    //Dashboard
	Route::get('/', 'DashboardController@index');
    Route::get('/dashboard', 'DashboardController@index');
    //Change Password
    Route::get('/change-password', 'AdminController@passwordUpdate');
    Route::post('/password-update', 'AdminController@passwordUpdateProcess');
    //Admin Home
   
   
    //Candidate
    Route::get('/candidate-list', 'CandidateController@index');
    Route::delete('candidate/destroy/{id}', 'CandidateController@destroy')->name('candidate.destroy');
    Route::post('/candidate-change-status', 'CandidateController@changeStatus');
    Route::get('/view-candidate-details/{id}', 'CandidateController@viewDetails');
    Route::post('/candidate-get-state', 'CandidateController@getState');
    //Company
    Route::get('/company-list', 'CompanyController@index');
    Route::delete('company/destroy/{id}', 'CompanyController@destroy')->name('company.destroy');
    Route::post('/company-change-status', 'CompanyController@changeStatus');
    Route::get('/view-company-details/{id}', 'CompanyController@viewDetails');
    Route::post('/company-get-state', 'CompanyController@getState');
    Route::post('/company-approve-status', 'CompanyController@approveCompany');
    Route::post('/company-get-details', 'CompanyController@companyGetDetails');
    Route::post('/company-report-details', 'CompanyController@companyReportList');
    Route::get('/company-job-list/{id}', 'CompanyController@jobList');
    Route::get('/company-report-list/{id}', 'CompanyController@companyReportAllList');
    //CMS Page
   // Route::get('/cms-page', 'AdminController@cmsPages');
   // Route::get('/cms-edit/{id}', 'AdminController@cmsEdit');
   // Route::post('/cms-edit/{id}', 'AdminController@cmsEdit');
    Route::get('/page-list', 'CmsController@index');
    Route::get('/add-page', 'CmsController@add');
    Route::post('/store-page', 'CmsController@store');
    Route::delete('page/destroy/{id}', 'CmsController@destroy')->name('page.destroy');
    Route::get('/update-page/{id}', 'CmsController@update');
    Route::post('/update-page-info', 'CmsController@updatePageInfo');
    Route::post('/page-change-status', 'CmsController@pageChangeStatus');


    Route::get('/page-content-reference/{id}', 'CmsController@pageContentRef');
    Route::get('/add-page-content-reference/{id}', 'CmsController@pageContentRef');
    Route::get('/add-page-reference', 'CmsController@addPageReference');
    Route::post('/store-page-reference', 'CmsController@storePageReference');

    Route::get('/page-content-reference/{id}', 'CmsController@pageContentRef');    
    Route::get('/add-page-reference/{id}', 'CmsController@addPageReference');
    Route::post('/store-page-reference/{id}', 'CmsController@storePageReference');
    Route::delete('/delete-page-ref/destroy/{id}', 'CmsController@deletePageReference');
    Route::get('/update-page-cont-ref/{id}', 'CmsController@updatePageContentRef');
    Route::post('/update-page-cont-ref-info/{id}', 'CmsController@updatePageContRefInfo');
    Route::post('/content-ref-change-status', 'CmsController@contentRefChangeStatus');

    Route::get('/get-page-content-text/{id}', 'CmsController@getPageContentText');
    Route::post('/add-page-content-text', 'CmsController@addPageContentText');
    Route::get('/edit-page-content-text/{id}', 'CmsController@editPageContentText');
    Route::post('/edit-page-content-text-post', 'CmsController@editPageContentTextPost');
    Route::post('/banner-img-delete', 'CmsController@bannerImageDelete');
    

    //Job Management
    Route::get('/job-list', 'JobController@index');
    // Route::get('/job-list/{id}', 'JobController@index');
    Route::post('/job-change-status', 'JobController@changeStatus');
    Route::get('/job-add', 'JobController@jobAdd');
    Route::post('/job-add', 'JobController@jobAddPost');
    Route::get('/job-edit/{id}', 'JobController@jobEdit');
    Route::post('/job-edit/{id}', 'JobController@jobEditPost');
    Route::get('/job-view/{id}', 'JobController@jobView');
    Route::delete('job/destroy/{id}', 'JobController@destroy');
    Route::post('/get-state', 'JobController@getState');
    Route::get('/users-applied/{id}', 'JobController@usersApplied');
    //Post Management
    Route::get('/post-list', 'PostController@index');
    Route::get('/post-view/{id}', 'PostController@postView');
    Route::get('/post-edit/{id}', 'PostController@postEdit');
    Route::post('/post-edit/{id}', 'PostController@postEditPost');
    Route::get('/post-add', 'PostController@postAdd');
    Route::get('/post-add/{job}', 'PostController@postAdd');
    Route::post('/post-add-post', 'PostController@postAddPost');
    //Reported Post
    Route::get('/reported-post-list', 'PostController@reportedPostList');
    Route::post('/get-report-details', 'PostController@getReportDetails');
    Route::post('/post-change-status', 'PostController@postChangeStatus');
    Route::get('/view-report-details/{id}', 'PostController@viewReportDetails');
    Route::post('/reported-post-abuse', 'PostController@reportedPostAbuse');
    Route::post('/reported-post-ignore', 'PostController@reportedPostIgnore');
    //Reported Comment
    Route::get('/reported-comment-list', 'PostController@reportedCommentList');
    Route::get('/view-comment-report-details/{id}', 'PostController@viewCommentReportDetails');
    Route::post('/reported-comment-abuse', 'PostController@reportedCommentAbuse');
    Route::post('/reported-comment-ignore', 'PostController@reportedCommentIgnore');
    //Training Category
    Route::get('/training-category-list', 'TrainingController@index');
    Route::get('/training-category-add', 'TrainingController@categoryAdd');
    Route::post('/training-category-post', 'TrainingController@categoryAddPost');
    Route::get('/training-category-edit/{id}', 'TrainingController@categoryEdit');
    Route::post('/training-category-edit/{id}', 'TrainingController@categoryEditPost');
    Route::post('/training-category-change-status', 'TrainingController@categoryChangeStatus');
    Route::delete('training-category/destroy/{id}', 'TrainingController@destroy');
    //Training Video
    Route::get('/training-video-list', 'TrainingController@videoList');
    Route::get('/training-video-add', 'TrainingController@videoAdd');
    Route::post('/training-video-post', 'TrainingController@videoAddPost');
    Route::get('/training-video-edit/{id}', 'TrainingController@videoEdit');
    Route::post('/training-video-edit/{id}', 'TrainingController@videoEditPost');
    Route::post('/training-video-change-status', 'TrainingController@videoChangeStatus');
    Route::delete('training-video/destroy/{id}', 'TrainingController@videoDestroy');
    //Subscription
    Route::get('/subscription-list', 'SubscriptionController@index');
    Route::post('/subscription-change-status', 'SubscriptionController@SubscriptionChangeStatus');
    Route::delete('subscription/destroy/{id}', 'SubscriptionController@subscriptionDestroy');
    Route::get('/view-subscription-details/{id}', 'SubscriptionController@viewSubscriptionDetails');
    Route::get('/add-subscription', 'SubscriptionController@subscriptionAdd');
    Route::post('/add-subscription-post', 'SubscriptionController@subscriptionAddPost');
    Route::get('/edit-subscription/{id}', 'SubscriptionController@subscriptionEdit');
    Route::post('/edit-subscription-post', 'SubscriptionController@subscriptionEditPost');
    
    //Order
    Route::get('/order-list', 'OrderController@index');
    Route::post('/view-order-details', 'OrderController@viewOrderDetails');
    Route::post('/order-change-status', 'OrderController@orderChangeStatus');
    Route::get('/add-subscription-order', 'OrderController@addSubscriptionOrder');
    Route::get('/edit-subscription-order/{id}', 'OrderController@editSubscriptionOrder');
    Route::post('/store-subscription-info', 'OrderController@storeSubscriptionInfo');
    Route::post('/update-subscription-info', 'OrderController@updateSubscriptionInfo');
    Route::delete('order/destroy/{id}', 'OrderController@destroy');
     //Payment
    Route::get('/payment-list', 'PaymentController@index');
    Route::get('/payment-details-download', 'PaymentController@downloadDetails');

    //Screening Question
    Route::get('/screening-question-list', 'ScreeningQuestionController@index');
    Route::get('/screening-question-add', 'ScreeningQuestionController@addQuestionAnswer');
    Route::post('/screening-question-add-post', 'ScreeningQuestionController@addQuestionAnswerPost');
    Route::get('/screening-question-edit/{id}', 'ScreeningQuestionController@editQuestionAnswer');
    Route::Post('/screening-question-edit-post', 'ScreeningQuestionController@editQuestionAnswerPost');
    Route::Post('/screening-change-status', 'ScreeningQuestionController@changeStatusQuestion');
    Route::delete('/screening-question/destroy/{id}', 'ScreeningQuestionController@deleteQuestion');

    //Advertisement
    Route::get('/advertise-list', 'AdvertisementController@index');
    Route::get('/advertise-add', 'AdvertisementController@add');
    Route::post('/advertise-add-post', 'AdvertisementController@addPost');
    Route::get('/advertise-edit/{id}', 'AdvertisementController@edit');
    Route::post('/advertise-edit-post', 'AdvertisementController@editPost');
    Route::delete('advertisement/destroy/{id}', 'AdvertisementController@advertiseDestroy');
    Route::post('/advertise-change-status', 'AdvertisementController@changeStatus');
    
    //Best Advertisement
    Route::get('/best-advertise-list', 'BestAdvertisementController@index');
    Route::get('/best-advertise-add', 'BestAdvertisementController@add');
    Route::post('/best-advertise-add', 'BestAdvertisementController@addPost');
    Route::get('/best-advertise-edit/{id}', 'BestAdvertisementController@edit');
    Route::post('/best-advertise-edit', 'BestAdvertisementController@editPost');
    Route::post('/best-advertise-change-status', 'BestAdvertisementController@changeStatus');
    Route::delete('best-advertise/destroy/{id}', 'BestAdvertisementController@destroy');
    
    //Payments
    Route::get('/payment-cms-list', 'PaymentController@list');
    Route::get('/payment-cms-edit/{id}', 'PaymentController@edit');
    Route::post('/payment-cms-edit', 'PaymentController@editPost');

    Route::get('highlight/{candidateId}/{val}','PaymentController@updateHighlights');
    // STRIPE PRODUCTS 
    Route::get('/product-list', 'PaymentController@productList');
    Route::get('/product-list-edit/{id}', 'PaymentController@editProductList');
    Route::get('/product-list-edit-active/{id}/{status}', 'PaymentController@changeProductActiveStatus');
    Route::post('/product-list-edit', 'PaymentController@editProduct');
    Route::get('/product-add', 'PaymentController@createProduct');
    Route::post('/product-store', 'PaymentController@addProduct');

    // TRANSACTION HISTORY 
    Route::get('/CandidateTransaction','PaymentController@CandidatetransactionList');
    Route::get('/CompanyTransaction','PaymentController@CompanyTransactionList');
    
});
//comon route call

Route::namespace('Candidate')->prefix('candidate')->group(function () {
        Route::get('/get-country-states/{id}', 'Candidate@getCountryStates');
        Route::get('my-jobs','Candidate@jobList');
        Route::get('my-jobs/{id}','Candidate@jobList');
        Route::post('my-jobs','Candidate@jobList');
        Route::get('/view-job-post/{id}','Candidate@viewJobPost');
        Route::get('/view-job-post/{id}/{notiId}','Candidate@viewJobPost');
        Route::get('apply-job/{id}','Candidate@applyJob');
        
});
// Validated User Routes
Route::namespace('Candidate')->prefix('candidate')->middleware(['auth'])->group(function () {

        Route::get('/dashboard', 'Candidate@dashboard');
        //Candidate Edit Profile

        Route::get('/edit-profile','Candidate@editProfile');
        Route::get('/my-profile','Candidate@editProfile');
        Route::get('/view-followers', 'Candidate@viewFollowers');
        Route::get('/view-followers/{id}', 'Candidate@viewFollowers');
        Route::get('/screening-mcq', 'Mcq@screeningMcq');
        Route::post('/screening-mcq-answer', 'Mcq@screeningMcqAnswer');
        Route::get('/screening-mcq-answer', 'Mcq@screeningMcqAnswer');
        Route::get('/manage-profile','Candidate@manageProfile');
        Route::post('/manage-profile-post','Candidate@manageProfilePost');
        Route::post('/upload-profille-img', 'Candidate@uploadProfileImg');
        Route::post('/upload-banner-img', 'Candidate@uploadBannerImage');
         Route::post('/upload-lib-banner-img', 'Candidate@uploadBannerImageFromLibrary');
        Route::get('/success', 'Candidate@successRegistration');
        Route::post('/store-profile-info', 'Candidate@storeProfileInfo');        
        Route::post('/store-hobbies', 'Candidate@storeHobbies');
        Route::post('/store-cv-summary', 'Candidate@storeCvSummary');
        Route::post('/store-cv', 'Candidate@storeCv');
        Route::post('/delete-cv', 'Candidate@deleteCv');
        Route::post('/remove-banner-img', 'Candidate@removeBannerImg');
        Route::post('/remove-prfl-img', 'Candidate@removeProfileImg');
        Route::post('/store-skills', 'Candidate@storeSkills');
        Route::post('/get-professional-info', 'Candidate@getProfessionalInfo');
        Route::post('/store-professional-info', 'Candidate@storeProfessionalInfo');
        Route::post('/store-intro-video', 'Candidate@storeIntroVideo');
        Route::post('/get-educational-info', 'Candidate@getEducationalInfo');
        Route::post('/store-educational-info', 'Candidate@storeEducationalInfo');
        Route::post('/store-language-info', 'Candidate@storeLanguageInfo');
        Route::post('/remove-intro-video', 'Candidate@removeIntroVideo');
        Route::post('/delete-language-info', 'Candidate@deleteLanguageInfo');
        Route::post('/delete-professional-info', 'Candidate@deleteProfessionalInfo');
        Route::post('/delete-educational-info', 'Candidate@deleteEducationalInfo');
        Route::get('/search-profile', 'Candidate@searchProfile');
        Route::get('/search-company-profile', 'Candidate@searchCompanyProfile');
        Route::post('/delete-user-post','Candidate@deleteUserPost');
        Route::get('/list-user-post-comment','Candidate@listUserPostComment');
        Route::post('/report-comment','Candidate@reportComment');
        Route::post('/follow-unfollow-user','Candidate@followUnfollowUser');
        Route::get('/my-network','Candidate@myNetwork');
        Route::get('/my-network/{id}','Candidate@myNetwork');
        Route::get('/following-list', 'Candidate@followingList');
        Route::get('/company-following-list', 'Candidate@companyFollowingList');
        Route::post('/report-company','Candidate@reportCompany');
        // Route::get('my-jobs','Candidate@jobList');
        // Route::get('my-jobs/{id}','Candidate@jobList');
        // Route::post('my-jobs','Candidate@jobList');
        Route::get('job-details','Candidate@jobDetails');
        Route::post('job-alert','Candidate@jobAlert');
        // Route::get('apply-job/{id}','Candidate@applyJob');
        Route::post('apply-job/{id}','Candidate@applyJob');
        Route::post('apply-job-store-info','Candidate@applyJobStoreInfo');
        Route::post('save-job','Candidate@saveJob');
        Route::post('apply-job-store-specific-ans','Candidate@applyJobStoreSpecificAns');
        Route::post('apply-job-store-all-info','Candidate@applyJobStoreAllInfo');
        Route::get('track-job','Candidate@trackJob');
        Route::get('job-alert-setting','Candidate@jobAlertSetting');
        Route::post('delete-job-alert','Candidate@deleteJobAlert');
        //Get City
        Route::get('/get-states-city/{id}','Candidate@getStatesCity');
        //Interview Answer
        Route::post('/store-interview-video-answer', 'Candidate@storeInterviewVideoAnswer');
        Route::post('/delete-interview-video', 'Candidate@deleteInterviewVideo');
        Route::post('/store-interview-attempt', 'Candidate@storeInterviewAttempt');
        Route::post('/get-selected-video', 'Candidate@getSelectedVideo');

        Route::get('/view-post/{id}','Candidate@viewPost');
        Route::get('/view-post/{id}/{notiId}','Candidate@viewPost');
        // Route::get('/view-job-post/{id}','Candidate@viewJobPost');
        // Route::get('/view-job-post/{id}/{notiId}','Candidate@viewJobPost');
        Route::post('/delete-user-comment','Candidate@deleteUserComment');
        Route::post('/set-job-alert-history','Candidate@setJobAlertHistory');
        Route::post('apply-job-discard-info','Candidate@applyJobDiscardInfo');

        Route::get('/see-application','Candidate@viewApplication');
        Route::get('/edit-application/{id}','Candidate@editApplication');
        Route::post('/edit-application/{id}','Candidate@updateApplication');
        Route::post('/delete-application','Candidate@deleteApplication');
});


Route::namespace('Company')->prefix('company')->middleware(['companyAuth'])->group(function () {
        Route::get('/dashboard', 'Company@dashboard');
        Route::get('/view-followers', 'Company@viewFollowers');
        Route::get('/manage-profile','Company@manageProfile');
        Route::post('/manage-profile-post','Company@manageProfilePost');
        Route::get('/edit-profile','Company@editProfile');
        Route::get('/my-profile','Company@editProfile');
        Route::post('/upload-profille-img', 'Company@uploadProfileImg');
        Route::post('/upload-banner-img', 'Company@uploadBannerImage');
        Route::post('/upload-lib-banner-img', 'Company@uploadBannerImageFromLibrary');
        Route::get('/get-country-states/{id}', 'Company@getCountryStates');
        Route::post('/store-profile-info', 'Company@storeProfileInfo');
        Route::post('/remove-prfl-img', 'Company@removeProfileImg');
        Route::post('/remove-banner-img', 'Company@removeBannerImg');
        Route::get('/find-candidates', 'Company@findCandidates');
        Route::post('/check-unique-company', 'Company@checkUniqueCompany');
        Route::post('/delete-user-post','Company@deleteUserPost');
        Route::get('/list-user-post-comment','Company@listUserPostComment');
        Route::post('/report-comment','Company@reportComment');
        Route::get('/post-job/{id?}','Company@postJob');
        Route::post('/post-job-post','Company@postJobPost');
        Route::any('/upload-job-desc-image', 'Company@uploadJobDescImage')->name('ckeditor.upload_job_desc_image');
        Route::get('my-jobs','Company@jobList');
        Route::post('my-jobs','Company@jobList');
        Route::get('city_by_state','Company@cityByState');
        Route::get('job-details','Company@jobDetails');
        Route::get('applied-candidates/{id}','Company@appliedCandidates');
        Route::get('/my-network','Company@myNetwork');
        Route::get('/my-network/{id}','Company@myNetwork');
        Route::post('jobs/destroy/{id}', 'Company@deleteJob');
        Route::get('/edit-job/{id}','Company@editJob');
        Route::post('/edit-job/{id}', 'Company@editJobPost');
        //Get City
        Route::get('/get-states-city/{id}','Company@getStatesCity');

        Route::get('/view-post/{id}','Company@viewPost');
        Route::get('/view-post/{id}/{notiId}','Company@viewPost');
        Route::get('/view-job-post/{id}','Company@viewJobPost');
        Route::get('/view-job-post/{id}/{notiId}','Company@viewJobPost');
        Route::post('/delete-user-comment','Company@deleteUserComment');

        // Company payment process
        Route::get('payment-details','PaymentController@jobAdvertisement');
        Route::any('payment-details/{id}','PaymentController@CompanyPayment');
        Route::post('payment-process','PaymentController@CompanyPaymentProcess');

});

//for non validate page
Route::get('/email-verification-pending/{id}', 'HomeController@emailVerification');
Route::get('/pending-admin-approval/{id}', 'HomeController@pendingAdminVerification');
Route::get('/rejected-admin-approval/{id}', 'HomeController@rejectedAdminVerification');
Route::get('/blocked-by-admin/{id}', 'HomeController@blockedByAdmin');
Route::get('/deactivated-user/{id}', 'HomeController@activateUser');
Route::get('active-user/{id}','PostController@activeYourAccount');
//Route::post('active-user/{id}','Company\Company@activeYourAccount');
Route::get('candidate/profile/{slug}','Candidate\Candidate@publicProfile');
Route::get('company/profile/{slug}','Company\Company@publicProfile');
Route::post('/get-state','Company\Company@getState');
Route::post('/get-multistates-multicity','Company\Company@getMultistatesMulticity');
//post routes
Route::post('/store-text-post','PostController@storeTextPost');
Route::post('/store-image-post','PostController@storeImagePost');
Route::post('/store-video-post','PostController@storeVideoPost');
Route::post('/store-any-post','PostController@storeAnyPost');
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
Route::get('/candidate/message/{id}','MessageController@index');
Route::get('/company/message/{id}','MessageController@index');
Route::get('/candidate/message/{id}/{msgId}','MessageController@index');
Route::get('/company/message/{id}/{msgId}','MessageController@index');
Route::post('/store-message/{id}','MessageController@storeMsg');
Route::post('/candidate/create-post', 'Candidate@createPost');
Route::post('/delete-message-from','MessageController@deleteMsgFrom');
Route::post('/block-message-contact','MessageController@blockContactMsg');
//Route::post('/upload-message-files','MessageController@uploadMsgFile');
Route::post('/upload-message-data-files','MessageController@uploadMsgFileData');
Route::post('/remove-message','MessageController@removeMessage');
//Route::post('/download-message-file','MessageController@downloadMessageFile');
Route::get('/candidate/download-message-file/{file}','MessageController@downloadMessageFile');
Route::get('/company/download-message-file/{file}','MessageController@downloadMessageFile');
//Likes
Route::post('/post-like','PostController@postLike');
Route::post('/post-comment','PostController@postComment');
Route::post('/report-post','PostController@reportPost');
//Shares
Route::post('/post-share','PostController@postShare');
Route::post('/post-share-data','PostController@postShareData');
//Connect
Route::post('/send-connection-request','PostController@sendConnectionRequest');
Route::post('/accept-reject-connection','PostController@acceptRejectConnection');
//Block User
Route::post('/block-unblock-user','PostController@blockUnblockUser');
//CHECK USER LOGIN
Route::post('/check-user-status','PostController@chkUserStatus');
Route::post('/check-session-user-status','PostController@chkSessionUserStatus');
//CHK UNIQUE EMAIL
Route::post('/check-unique-email', 'Company\Company@checkUniqueEmail');
//CHECK USER JOB APPLIED STATUS
Route::post('/check-job-apply-status','PostController@chkUserJobAppliedStatus');
Route::post('/check-user-status-job','PostController@chkUserStatusJob');
Route::post('candidate/store-service-info','Candidate\Candidate@storeServiceInfo');
});
Route::get('/migrate', function(){
    Artisan::call('migrate', ['--path' => '/database/migrations/2022_01_19_131552_add_order_to_cities_table.php']);
});

