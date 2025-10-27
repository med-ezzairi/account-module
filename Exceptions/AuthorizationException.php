<?php

namespace Modules\Account\Exceptions;

/**
 * This class is used with Requests (to check authorization)
 * 
 * @author med-ezzairi
 */
use Illuminate\Auth\Access\AuthorizationException as ParentAuthorizationException;

class AuthorizationException extends ParentAuthorizationException
{
    
    
    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        // Determine if the exception needs custom reporting...
        $userId = auth()->user()->id ?? 'null';
        info("Operation denied for user", ['user' => $userId, 'action' => 'tod:add-action-info'] );
        return false;
    }
    
    public function render($request)
    {
        if( $request->ajax() ){
            return response()->json(['status' => 'error', 'message' => trans('account::global.operation_denied')]);
        }
        throw $this;
    }
}
