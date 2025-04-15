<?php 
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Service\CommonService;
class CommonComposer {

    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $users;
    protected $commonService;
    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(CommonService $commonService)
    {
        // Dependencies automatically resolved by service container...
       
        $this->commonService = $commonService;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $userProfInfo = $this->commonService->getUserSharedInfo(); 
        $adminEmail =  $this->commonService->getEmailId(); 
        $userNotification = $this->commonService->getUserNotification();
        $userNewNotificationCount = $this->commonService->getUserNewNotification();
        $view->with(compact('userProfInfo', 'adminEmail', 'userNotification','userNewNotificationCount'));
    }

}