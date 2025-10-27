<?php

namespace Modules\Account\Http\Requests;


class UserGroupsRequest extends AbstractRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'userEmail'     => 'required|email|max:125',
            'groups'        => 'required|array',
            'groups.*'      => 'required|exists:acl_groups,id',
            //'groups.*'      => 'required|string',
        ];
    }
    
    
    public function attributes() 
    {
        return $this->getTranslatedAttributes('account::account_user');
    }
    
    public function messages() 
    {
        return $this->getTranslatedMessages('account::account_user');
    }
    
}
