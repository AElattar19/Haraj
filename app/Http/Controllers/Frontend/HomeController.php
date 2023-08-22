<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Models\Gallery;
use App\Models\HomeSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Modules\Language\Models\Language;

class HomeController extends Controller
{
    public function index(Request $request)
    {

    }

    protected function change_local($code)
    {
        $language = Language::where('code', $code)->firstOrFail();
        if ($language) {
            session()->put('locale', $code);
            session()->put('rtl', $language['rtl']);
            App::setLocale($code);
        }

        return redirect()->back();
    }

    protected function contact_us(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:100', 'min:3', 'alpha'],
            'email' => 'required|email',
            'message' => 'required|min:3'
        ]);
        ContactUs::query()->create([
            'name' => $validator->validated()['name'],
            'email' => $validator->validated()['email'],
            'message' => $validator->validated()['message'],
        ]);
        return redirect('/')->with('success', t_('Your message has been sent successfully !'));

    }
}
