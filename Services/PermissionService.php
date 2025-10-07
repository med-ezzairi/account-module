<?php 
namespace Modules\Account\Services;

use Modules\Account\Entities\Group;
use Modules\Account\Http\Requests\PermissionsRequest;
use Nwidart\Modules\Facades\Module;

class PermissionService {
    
    
    protected const ACTION_ALLOW    = '1';
    protected const ACTION_DENY     = '0';
    protected const ACTION_INHERIT  = '-1';
    
    /**
     * Get all possible permissions as array for all modules and/or other permissions config files
     * 
     * To add more permissions use a config file (see Account\Config\permissions.php config file for more details)
     * 
     * @return mixed[]|\Illuminate\Config\Repository[]
     */
    public static function getAllModulesPermissions() 
    {
        $permissions = [];
        foreach (Module::allEnabled() as $module) {
            $config = config( $module->getLowerName().'.permissions');
            if (! is_null($config)) {
                $permissions[$module->getName()] = $config;
            }
        }
        
        //-- include more permissions from other placements
        $permissions = array_merge($permissions, ['Core' => config('permissions') ] );
        
        
        return $permissions;
    }
    
    /**
     *
     * @param mixed $id
     */
    public static function setGroupPermissions(string $groupId, PermissionsRequest $request )
    {
        
        try {
            
            $group = Group::findById($groupId);
            if( !$group ){
                return false;
                //return $this->responseError( __(self::TRANS_PREFIX.'no_item_was_found') );
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
            return $group->save();
            
            //return $this->responseOperationSuccess();
            
        } catch (\Exception $ex) {
            throw new $ex;
            /*
            report($ex);
            return $this->responseException();
            */
        }
        
    }
}