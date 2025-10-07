<?php

namespace Modules\Account\Http\Requests;


class GroupRequest extends AbstractRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'  => 'required|string|min:5|max:25',
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
