<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Account\Entities\Group;
use Modules\Account\Http\Requests\GroupRequest;
use Modules\Account\Http\Requests\PermissionsRequest;
use Modules\Account\Services\PermissionService;

class GroupController extends AccountController
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
    public function index()
    {
        $groups = Group::withCount('users')->paginate();
        view()->share('items', $groups );
        
        return view( self::VIEW_PATH.'index');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(GroupRequest $request)
    {
        try {
            if( $request->filled('id') ){
                $group = Group::_update( $request->id, $request->name );
            }else{
                $group = Group::_create( $request->name );
            }
            if( $group ){
                return $this->responseOperationSuccess();
            }
            return $this->responseOperationFailure();
        } catch (\Exception $ex) {
            report($ex);
            return $this->responseException();
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id, Request $request)
    {
        $group = Group::findById($id);
        if( !$group ){
            $this->flashError( __(self::TRANS_PREFIX.'no_item_was_found'));
            return redirect()->route(self::ROUTE_PREFIX.'index');
        }
        
        if(  $request->element == 'members' ){
            $group->load('users');
            
            view()->share('element', 'members' );
            
        } else {
            
            view()->share('permissions', PermissionService::getAllModulesPermissions() );
            view()->share('element', 'permissions' );
        }
        
        view()->share('item', $group );
        view()->share('group_permissions', json_decode( $group->permissions, TRUE ) );
        
        return view( self::VIEW_PATH.'show');
    }

    /**
     * 
     * @param mixed $id
     */
    public function permissions(string $groupId, PermissionsRequest $request )
    {
        
        try {
            
            $group = Group::findById($groupId);
            if( !$group ){
                return $this->responseError( __(self::TRANS_PREFIX.'no_item_was_found') );
            }
            
            $group_permissions = json_decode( $group->permissions, TRUE );
            if( !is_array( $group_permissions ) ){
                $group_permissions = [];
            }
            
            foreach ($request->validated()['permissions'] as $permission => $action ){
                
                if( $action == self::ACTION_INHERIT && isset( $group_permissions[$permission] ) ){
                    unset( $group_permissions[$permission] );
                }elseif( $action == self::ACTION_DENY ){
                    $group_permissions[$permission] = false;
                }elseif ( $action == self::ACTION_ALLOW ){
                    $group_permissions[$permission] = true;
                }
            }
            $group->permissions = json_encode( $group_permissions );
            $group->save();
            return $this->responseOperationSuccess();
            
        } catch (\Exception $ex) {
            report($ex);
            return $this->responseException();
        }
        
    }
    
    /**
     * Remove the specified resource from storage.
     * 
     * @param int $id
     * @return Response
     */
    public function destroy(string $id)
    {
        try {
            
            $group = Group::findById($id);
            if( !$group ){
                return $this->responseError( __(self::TRANS_PREFIX.'no_item_was_found') );
            }
            $group->load('users');
            if( $group->users->isNotEmpty() ){
                return $this->responseOperationFailure();
            }
            $group->delete();
            return $this->responseOperationSuccess();
            
        } catch (\Exception $ex) {
            report($ex);
            return $this->responseException();
        }
    }
    
    
}
