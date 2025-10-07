<?php

namespace Modules\Account\Entities;

use App\User;
use Modules\Account\Traits\GroupHasPermissions;

class Group extends AbstractAccountModel
{
    
    use GroupHasPermissions;
    
    protected $keyType     = 'string';
    
    protected $guarded  = [];
    
    public static $rules = [
    ];
    
    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('account.table_names.table_name_groups') ?: parent::getTable();
    }
    
    public function users()
    {
        $table_name_group_user = config('account.table_names.table_name_group_user');
        return $this->belongsToMany(User::class, $table_name_group_user, 'group_id', 'user_id');
    }
    
    public static function findById( string $id  )
    {
        return Group::where('id', $id )->first();
    }
    
    public static function _create( string $name ) 
    {
        return self::create([
            'id'        => str_slug( $name, '_'),
            'name'      => $name
        ]);
    }
    
    public static function _update( string $id, string $name )
    {
        $new_id = str_slug( $name, '_');
        if( $id != $new_id && self::where('id', str_slug( $name, '_') )->first() ){
            return false;
        }
        return self::where('id', $id )
        ->update([
            'id'        => $new_id,
            'name'      => $name
        ]);
    }
    
    
    public function getPermissionsCountAttribute() 
    {
        $permissions = $this->attributes['permissions'];
        if( empty( $permissions ) ){
            $permissions = '{}';
        }
        return count( json_decode( $permissions, TRUE ));
    }
}
