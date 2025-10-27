<?php

namespace Modules\Account\Http\Requests;


class UserSearchRequest extends AbstractRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'  => 'required|email|max:125',
            //'email'  => 'required|email|min:5|max:125',
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
