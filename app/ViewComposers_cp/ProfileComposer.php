<?php

namespace App\ViewComposers;

use Illuminate\View\View;
//use App\Repositories\CategoryRepository;

class ProfileComposer
{
    //protected $categories;

    /**
     * Create a new categories composer.
     *
     * @param  CategoryRepository $categories
     * @return void
     */
    // public function __construct(CategoryRepository $categories)
    // {
    //     $this->categories = $categories;
    // }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('user', 'dlkjfdljf;dsjlf;');
    }
}