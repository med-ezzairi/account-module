<?php

namespace Modules\Account\Entities;


class UserPermission extends AbstractAccountModel
{
    
    protected $table = 'acl_user_permission';
    
    protected $guarded = [];
    
    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('account.table_names.table_name_user_permission') ?: parent::getTable();
    }
    
}