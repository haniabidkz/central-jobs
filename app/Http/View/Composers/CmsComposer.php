<?php

namespace App\Http\View\Composers;

use App\Service\CmsService;
use Illuminate\View\View;

class CmsComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $cmsService;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(CmsService $cmsService)
    {
        // Dependencies automatically resolved by service container...
        $this->cmsService = $cmsService;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        
        //dd($view['id']);
        $view->with('id',$view['id']);
    }
}