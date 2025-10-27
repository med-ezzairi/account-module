<?php

namespace Modules\Account\Http\Requests;


class PermissionsRequest extends AbstractRequest
{
    
    // route name, as this Request is used for two things (Group's Permissions and Uers's permissions)
    protected $routeName = '';
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->routeName =  $this->route()->getName();
        
        $rules = [
            'permissions'       => 'required|array',
            'permissions.*'     => 'required|in:-1,0,1',
        ];
        if( $this->routeName == 'account.users.permissions' ){
            $rules['userEmail'] = 'required|email|max:125';
        }
        return $rules;
    }
    
    
    public function attributes() 
    {
        if( $this->routeName == 'account.users.permissions' ){
            return $this->getTranslatedAttributes('account::account_user');
        }
        return $this->getTranslatedAttributes('account::account_group');
        
    }
    
    public function messages() 
    {
        if( $this->routeName == 'account.users.permissions' ){
            return $this->getTranslatedMessages('account::account_user');
        }
        return $this->getTranslatedMessages('account::account_group');
    }
}
