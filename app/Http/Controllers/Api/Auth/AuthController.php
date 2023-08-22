<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\ChangePasswordRequest;
use App\Http\Requests\Api\Auth\ForgetPasswordRequest;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\ProfileUpdateRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Models\Setting;
use App\Models\User;
use App\Support\Api\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    use ApiResponse;
    public function __construct()
    {
        $this->middleware('localize');
    }
    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();
        if (is_numeric($validated['email'])) {
            $cred = ['phone' => $validated['email'], 'password' => $validated['password']];
        }else{
            $cred = ['email' => $validated['email'], 'password' => $validated['password']];
        }
        if (Auth::attempt($cred)) {
            $user = Auth::user();

            $user->update(['fcm_token' => $request->fcm_token]);

            $this->message = t_('login successfully');
            $this->body['user'] = UserResource::make($user);
            $this->body['accessToken'] = $user->createToken('user-token')->plainTextToken;

            return self::apiResponse(200, $this->message, $this->body);

        } else {

            $this->message = t_('auth failed');
            return self::apiResponse(400, $this->message, $this->body);
        }

    }

    public function register(RegisterRequest $request): JsonResponse
    {

        $validator = $request->validated();
        $user = User::create($validator);

        $this->message = t_('Register successfully');
        $this->body['user'] = UserResource::make($user);
        $this->body['accessToken'] = $user->createToken('user-token')->plainTextToken;

        return self::apiResponse(200, $this->message, $this->body);

    }

    public function change_password(ChangePasswordRequest $request)
    {
        $hashedPassword = auth()->user('sanctum')->password;
        if (Hash::check($request->oldPassword, $hashedPassword)) {

            $user = auth()->user('sanctum');
            $user->update(['password' => Hash::make($request->newPassword)]);

            $this->message = t_('Update Password successfully');
            $this->body['user'] = UserResource::make($user);

            return self::apiResponse(200, $this->message, $this->body);

        } else {
            $this->message = t_('Your old password not correct');
            return self::apiResponse(400, $this->message, $this->body);
        }

    }
    protected function forget_outside(Request $request){
        $request->validate([
            'phone' => 'required',
            'newPassword' => 'required|min:6',
            'newPasswordConfirmation' => 'required|min:6|same:newPassword',
        ]);
        $user = User::query()->where('phone', $request->phone)->first();
        if ($user){
            $user->password = Hash::make($request->newPassword);
            $user->save();
            $this->message = t_('Update Password successfully');
            $this->body['user'] = UserResource::make($user);

            return self::apiResponse(200, $this->message, $this->body);
        }else{
            return self::apiResponse(400, t_('An error occurred'), $this->body);
        }
    }
    public function forget(ForgetPasswordRequest $request)
    {
        $validator = $request->validated();
        $user = User::where('phone', $validator['phone'])->first();

        if ($user != null) {
            $to   = $validator['phone'];
            $code = random_int(100000,999999);
            $msg1 = 'activate code: ' . $code;
//            $sms = new HiSms($to, $msg1);
//            $sms->sendSms();




            Mail::send('dashboard.core.email.forgetPasswordNew',["code"=>$code], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Reset Password');
            });


            $this->message = t_('the message was send to your mail , please activate');
            $this->body['code'] = $code;

            return self::apiResponse(200, $this->message, $this->body);
        } else {

            $this->message = t_('wrong number');
            return self::apiResponse(400, $this->message, $this->body);

        }
    }

    public function edit_profile(ProfileUpdateRequest $request)
    {
        $validator = $request->validated();
        $user = auth()->user('sanctum');
        $user->update($validator);
        $image = Arr::pull($validator, 'image');
        $image && uploadImage('image', $image, $user);
        $this->body['user'] = UserResource::make($user);
        $this->message = t_('update profile successfully');

        return self::apiResponse(200, $this->message, $this->body);
    }

    public function user()
    {
        $user = auth()->user('sanctum');
        $this->body['user'] = UserResource::make($user);
        return self::apiResponse(200, null, $this->body);
    }

    public function logout(Request $request)
    {
        auth()->user('sanctum')->tokens()->delete();
        $this->message = t_('Logged out');

        return self::apiResponse(200, $this->message, $this->body);

    }
    protected function delete_acc(Request $request){
        $id = auth()->user()->id;
        auth()->user('sanctum')->tokens()->delete();
        User::query()->where('id', $id)->first()->delete();
        $this->message = t_('Account deleted, hope we see you again.');
        return self::apiResponse(200, $this->message, $this->body);
    }
    protected function delete_acc_button(): JsonResponse
    {
        $delete_acc = Setting::where('key', 'delete_acc')->first();
        $this->body['delete_account_button_status'] = $delete_acc->value;
        return self::apiResponse(200, '', $this->body);
    }
}
