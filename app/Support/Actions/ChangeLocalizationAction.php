<?php

namespace App\Support\Actions;

use Illuminate\Support\Facades\App;
use Modules\Language\Models\Language;

class ChangeLocalizationAction
{
    public function __invoke($code)
    {

        $language = Language::where('code', $code)->firstOrFail();
        if ($language) {
            session()->put('locale', $code);
            session()->put('rtl', $language['rtl']);
            App::setLocale($code);
        }

        return redirect()->back();
    }
}
