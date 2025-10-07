<?php 
namespace Modules\Account\Traits;

use Modules\Account\Entities\Group;
use Modules\Account\Entities\UserPermission;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

Trait UserUsingGroupsAndPermissions {
    
    use UserHasPermissions;
    
    
    /**
     * 
     * @return BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'acl_group_user', 'user_id', 'group_id')
        ->withTimestamps();
    }
    
    /**
     * 
     * @return HasOne
     */
    public function permissions() 
    {
        return $this->hasOne( UserPermission::class, 'user_id', 'id');
    }
    
    
    public function getPermissions() 
    {
        $session_key = 'acl_permissions';
        
        $cached_permissions = session($session_key, null );
        if( $cached_permissions && !is_null( $cached_permissions ) ){
            return $cached_permissions;
        }
        $permissions = [];
        
        //-- permissions via groups 
        $groups = $this->groups;
        foreach( $groups as $group ) {
            $permissions = array_merge( $permissions, json_decode( $group->permissions, TRUE ) );
        }
        
        //-- permissions direct
        $permissions = array_merge( $permissions, json_decode( $this->permissions->permissions ?? '{}', TRUE ) );
        session()->put($session_key, $permissions );
        return $permissions;
        
    }
    
}