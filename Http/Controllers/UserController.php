<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Account\Services\UserService;

class UserController extends AccountController
{
    
    const VIEW_PATH     	= 'account::groups.';
    const TRANS_PREFIX  	= 'account::roles.';
    const ROUTE_PREFIX      = 'account.groups.';
    
    protected $sub_menu     = 'groups';
    
    protected const ACTION_ALLOW    = '1';
    protected const ACTION_DENY     = '0';
    protected const ACTION_INHERIT  = '-1';
    
    
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        return UserService::getUsers($request)->toJson();
    }

}
