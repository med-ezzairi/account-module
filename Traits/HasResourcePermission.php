<?php
namespace Modules\Account\Traits;

use Modules\Account\Permissions\ResourcePermission;


Trait HasResourcePermission {
    
    
    public function getResourcePermission() : ResourcePermission
    {
        if( !property_exists($this, 'resourcePermission' ) ){
            throw new \Exception( sprintf("attribute %s is not defined in %s", 'resourcePermission', get_class($this)));
        }
        
        return new $this->resourcePermission();
    }
    
    
}