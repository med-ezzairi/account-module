<?php
namespace Modules\Account\Traits;


Trait GroupHasPermissions {
    
    protected $permissions_array = FALSE;
    
    /**
     * Grant/Allow the given permission
     * 
     * @param string $permission
     * @return mixed
     */
    public function grant( string $permission )
    {
        // TODO: add logic here;
        $permissions = json_decode( $this->permissions, TRUE );
        $permissions[$permission] = true;
        $this->permissions = json_encode( $permissions );
        $this->save();
        return $permissions;
    }
    
    /**
     * Deny the given permission
     * 
     * @param string $permission
     * @return mixed
     */
    public function deny( string $permission )
    {
        // TODO: add logic here;
        $permissions = json_decode( $this->permissions, TRUE );
        $permissions[$permission] = false;
        $this->permissions = json_encode( $permissions );
        return $permissions;
    }
    
    /**
     * Revoke/Remove/Inherit a permission
     * (reset the behivior to default. No deny nor allow)
     * 
     * @param string $permission
     * @return mixed
     */
    public function revoke( string $permission )
    {
        // TODO: add logic here;
        $permissions = json_decode( $this->permissions, TRUE );
        unset($permissions[$permission]);
        $this->permissions = json_encode( $permissions );
        return $permissions;
    }
    
    /**
     * Check if the given permission action (inherit|deny|allow)
     * 
     * @param string $perimission
     * @return string
     */
    public function getAction( string $perimission ) :string
    {
        if( $this->permissions_array === FALSE ){
            $this->permissions_array = json_decode( $this->permissions, TRUE );
        }
        $permissions = $this->permissions_array;
        if( !is_array( $permissions ) ){
            return 'inherit';
        }
        if( !array_key_exists( $perimission, $permissions ) ){
            return 'inherit';
        } elseif( $permissions[$perimission]) {
            return 'allow';
        }
        return 'deny';
    }
    
}