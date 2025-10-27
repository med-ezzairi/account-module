<?php

namespace Modules\Account\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Account\Http\Requests\PermissionsRequest;
use Modules\Account\Http\Requests\UserGroupsRequest;
use Modules\Account\Http\Requests\UserSearchRequest;
use Modules\Account\Services\PermissionService;

class AffectationController extends AccountController
{
    
    const VIEW_PATH     	= 'account::affectations.';
    const TRANS_PREFIX  	= 'account::account_user.';
    const ROUTE_PREFIX      = 'account.users.';
    
    protected $sub_menu     = 'affectations';
    
    
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        //allowed('account.affectations.index');
        
        return view(self::VIEW_PATH . 'index' );
    }
    
    /**
     * Search a user by email
     * 
     * @param UserSearchRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(UserSearchRequest $request)
    {
        //allowed('account.affectations.search');
        
        $user  = User::where('email', $request->email )->first();
        if( !$user ){
            return $this->responseError( __(self::TRANS_PREFIX.'global.no_item_was_found'));
        }
        
        $groups = [];
        foreach( $user->groups as $group ){
            $groups[] = [
                'id'    => $group->id,
                //'name'    => $group->name,
            ];
        }
        $userData = [
            'name'  		=> [ 
                'ar' => $user->nom_ar.' '.$user->prenom_ar, 
                'fr' => $user->nom.' '.$user->prenom
            ],
            'email' 		=> $user->email,
            'groups'        => $groups,
            'permissions'   => $user->permissions ? json_decode( $user->permissions->permissions, TRUE ) : [],
        ];
        return $this->responseSuccess( __(self::TRANS_PREFIX.'global.item_found' ), ['user' => $userData ]);
        
    }

    /**
     * Set/Affect a user to group(s)
     * 
     * @param UserGroupsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function groups(UserGroupsRequest $request)
    {
        
        //allowed('account.affectations.groups');
        
        try {
            
            $item = User::with('groups')->where('email', $request->userEmail )->first();
            if( !$item ){
                return $this->responseError( __(self::TRANS_PREFIX.'global.no_item_was_found') );
            }
            
            
            $item->groups()->sync( $request->groups );
            
            return $this->responseOperationSuccess();
            
        } catch (\Exception $ex) {
            report($ex);
            return $this->responseException();
        }
        
        
    }
    
    /**
     * Set/Affect user's permissions
     * 
     * @param PermissionsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function permissions(PermissionsRequest $request)
    {
        
        //allowed('account.affectations.permissions');
        
        try {
            
            $item = User::with('permissions')->where('email', $request->userEmail )->first();
            if( !$item ){
                return $this->responseError( __(self::TRANS_PREFIX.'global.no_item_was_found') );
            }
            
            $itemPermissions    = [];
            $userHasPermissions = false;
            if( $item->permissions ){
                $itemPermissions = json_decode( $item->permissions->permissions, TRUE );
                $userHasPermissions = true;
            }
            
            $allModulesPermissions = PermissionService::getAllModulesPermissionsAsArray();
            
            foreach ($request->validated()['permissions'] as $permission => $action ){
                
                if( !in_array( $permission, $allModulesPermissions) ){
                    continue;
                }
                
                if( $action == PermissionService::ACTION_INHERIT && isset( $itemPermissions[$permission] ) ){
                    unset( $itemPermissions[$permission] );
                }elseif( $action == PermissionService::ACTION_DENY ){
                    $itemPermissions[$permission] = false;
                }elseif ( $action == PermissionService::ACTION_ALLOW ){
                    $itemPermissions[$permission] = true;
                }
            }
            
            if( $userHasPermissions ){
                $item->permissions()->update(['permissions' => json_encode( $itemPermissions ) ]);
            } else {
                $item->permissions()->create(['permissions' => json_encode( $itemPermissions ) ]);
            }
            return $this->responseOperationSuccess();
            
        } catch (\Exception $ex) {
            report($ex);
            return $this->responseException();
        }
    }
}
