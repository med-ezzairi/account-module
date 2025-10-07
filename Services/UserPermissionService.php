<?php

namespace Modules\Account\Services;

use App\User;
use Illuminate\Http\Request;

class UserPermissionService {
    
    
    public static function getUsers(Request $request ) 
    {
        
        $users = User::select('id', 'email', 'nom', 'prenom')->paginate( $request->per_page ?? 25 );
        return $users;
    }
    
    
}