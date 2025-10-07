<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    
    protected $module           = 'Account';
    protected $menu             = 'account';
    protected $sub_menu         = 'home';
    protected $partials         = 'partials';
    
    /**
     * This allow us to initialise some variables
     * and share some params 
     * 
     * Note: app_layout and app_section refers to the main layout name used 
     * by the application holding this module.
     * For more details check the home view
     */
    public function initialise() 
    {
        view()->share('app_layout', 'layouts.admin' );  // main application layout
        view()->share('app_section', 'content' );       // main application section-name
        view()->share('partials', $this->partials );
        app()->setLocale('fr');
    }
    
    /**
     * Display the home page of this Module.
     * 
     * @return Response
     */
    public function home()
    {
        return view('account::home');
    }
}
