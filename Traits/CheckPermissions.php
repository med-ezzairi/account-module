<?php

namespace Modules\Account\Traits;

use Modules\Account\Contracts\Gate;

trait CheckPermissions
{
    
    /**
     * TODO: Rename this to a convenient method name to keep the laravel original one
     * 
     * @param $ability
     * @param array $arguments
     * @return response()
     * @throws \Exception
     */
    public function hasPermission( string $permission, $arguments = [] ) 
    {
        return app(Gate::class)->authorize($permission, $arguments);
    }
}

