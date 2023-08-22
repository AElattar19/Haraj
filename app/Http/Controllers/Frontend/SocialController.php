<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function socialRedirect($driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    public function loginWithSocial($driver)
    {
        try {

            $user = Socialite::driver($driver)->user();
            $socialUser = User::withoutGlobalScopes()->where('social_id', $user->id)->first();
            if ($socialUser && $socialUser->active) {
                Auth::login($socialUser);

                return redirect()->intended('/');
            }
            $emailUser = User::withoutGlobalScopes()->where('email', $user->email)->first();
            if ($emailUser && $emailUser->active) {
                $emailUser->update([
                    'social_id' => $user->id,
                ]);
                Auth::login($emailUser);

                return redirect()->intended('/');
            }
            if (! $emailUser || ! $socialUser) {
                $createUser = User::create(
                    [
                        'name'      => $user->name, 'email' => $user->email,
                        'social_id' => $user->id,
                        'active'    => true,
                    ]);
                if ($createUser && $createUser->active) {
                    Auth::login($createUser);

                    return redirect()->intended('/');
                }
            }

            session()->flash('error_toastr', 'Your Account not Activated');

            return redirect()->intended('/');
        } catch (Exception $e) {

            session()->flash('error_toastr', 'This Service Not available now');

            return redirect(url('/?'.$e->getMessage()));
        }
    }
}
