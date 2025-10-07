<?php
namespace Modules\Account\Traits;


Trait UserHasPermissions {
    
    
    public function grant( string $permission )
    {
        $user_permission = $this->permissions;
        $permissions = json_decode( $user_permission->permissions ?? '{}', TRUE );
        $permissions[$permission] = true;
        if( $user_permission ){
            $user_permission->update(['permissions' => json_encode($permissions )] );
        } else {
            $this->permissions()->create(['permissions' => json_encode($permissions )] );
        }
        $this->updateCachedPermissions($permissions);
        return $permissions;
    }
    
    
    public function deny( string $permission )
    {
        $user_permission = $this->permissions;
        $permissions = json_decode( $user_permission->permissions ?? '{}', TRUE );
        $permissions[$permission] = false;
        if( $user_permission ){
            $user_permission->update(['permissions' => json_encode($permissions )] );
        } else {
            $this->permissions()->create(['permissions' => json_encode($permissions )] );
        }
        $this->updateCachedPermissions($permissions);
        return $permissions;
    }
    
    
    public function revoke( string $permission )
    {
        $user_permission = $this->permissions;
        $permissions = json_decode( $user_permission->permissions ?? '{}', TRUE );
        unset($permissions[$permission]);
        if( $user_permission ){
            $user_permission->update(['permissions' => json_encode($permissions )] );
        }
        $this->updateCachedPermissions($permissions);
        return $permissions;
    }
    
    
    private function updateCachedPermissions( array $permissions ) 
    {
        // TODO: logic;
    }
    
}