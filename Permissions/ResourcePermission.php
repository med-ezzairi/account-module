<?php 

namespace Modules\Account\Permissions;


abstract class ResourcePermission {
    
    /**
     * Check if the given user has the given permission on the given resource
     * 
     * @param object $user
     * @param string $permission
     * @param object $resource
     * @return boolean
     */
    public function isAuthorized($user, string $permission, $resource)
    {
        
        $action = $this->getActionFromPermission($permission);
        
        return ( $action && method_exists($this, $action) && $this->$action($user, $resource) ) ?? false;
        
    }
    
    /**
     * Get the action name from a resource
     * 
     * @param string $permission
     * @return NULL|mixed
     */
    public function getActionFromPermission(string $permission)
    {
        $array = explode('.', $permission );
        return $array[count($array)-1] ?? null;
    }
    
    
}