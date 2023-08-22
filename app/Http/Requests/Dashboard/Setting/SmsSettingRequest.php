<?php

namespace App\Http\Requests\Dashboard\Setting;

use Illuminate\Foundation\Http\FormRequest;

class SmsSettingRequest extends FormRequest
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
            'sid'=>'required',
            'token'=>'required',
            'from'=>'required',
            'user_code.message'=>'regex:/{user_code}/|regex:/{user_name}/',
            'tests_notification.message'=>'regex:/{user_code}/|regex:/{user_name}/',
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
            'sid'=>'Twilio sid',
            'token'=>'Twilio token',
            'from' => 'Twilio from number',
            'user_code.message' => 'User code sms message',
            'tests_notification.message' => 'Tests notification sms message',
        ];
    }
}
