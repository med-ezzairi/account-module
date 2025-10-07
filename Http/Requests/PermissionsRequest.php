<?php

namespace Modules\Account\Http\Requests;


class PermissionsRequest extends AbstractRequest
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'permissions'       => 'required|array',
            'permissions.*'     => 'required|in:-1,0,1',
        ];
    }
    
    
    public function attributes() 
    {
        return $this->getTranslatedAttributes('account::account_group');
    }
    
    public function messages() 
    {
        return $this->getTranslatedAttributes('account::account_group');
    }
}
