<?php

namespace App\Http\Requests\Dashboard\Setting;

use Illuminate\Foundation\Http\FormRequest;

class EmailSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'host'=>'required',
            'port'=>'required|numeric',
            'username'=>'required',
            'password'=>'required',
            'encryption'=>'required',
            'from_address'=>'required|email',
            'from_name'=>'required',
            //            'user_code.subject'=>'required',
            //            'user_code.body'=>'required|regex:/{user_code}/|regex:/{user_name}/',
            //            'tests_notification.subject'=>'required',
            //            'tests_notification.body'=>'required|regex:/{user_code}/|regex:/{user_name}/',
            'reset_password.subject'=>'required',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'user_code.subject' => 'User code mail subject',
            'user_code.body' => 'User code mail body',
            'tests_notification.subject' => 'Tests notification  mail subject',
            'tests_notification.body' => 'Tests notification mail body',
            'reset_password.subject' => 'Resetting password mail subject',
        ];
    }
}
