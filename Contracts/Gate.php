<?php
namespace Modules\Account\Contracts;

interface Gate
{
    public function check($permission, $resource = null);
    
    public function authorize($permission, $resource = null);
}

