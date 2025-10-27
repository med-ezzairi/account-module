<?php

namespace Modules\Account\Services;

use Modules\Account\Entities\Group;

class GroupService {
    
    
    public static function getAll()
    {
        return Group::select('*')->get();
    }
    
    
    /**
     * Add a User or list of Users to a Goupr
     * 
     * @param string $groupId
     * @param $userId
     */
    public static function addUser( string $groupId, $userId ) 
    {
        try {
            $group = Group::findOrFail( $groupId );
            return  $group->users()->attach( $userId );
        } catch (\Exception $ex) {
            report($ex);
            return false;
        }
    }
    
    /**
     * Remove a User or list of Users from a Group
     * 
     * @param string $groupId
     * @param mixed $userId
     * @return number|boolean
     */
    public static function removeUser( string $groupId, $userId )
    {
        try {
            $group = Group::findOrFail( $groupId );
            return  $group->users()->detach( $userId );
        } catch (\Exception $ex) {
            report($ex);
            return false;
        }
    }
    
}