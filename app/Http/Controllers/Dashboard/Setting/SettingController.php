<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Setting\ApiSettingRequest;
use App\Http\Requests\Dashboard\Setting\deductionSettingRequest;
use App\Http\Requests\Dashboard\Setting\EmailSettingRequest;
use App\Http\Requests\Dashboard\Setting\GeneralSettingRequest;
use App\Http\Requests\Dashboard\Setting\StyleSettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * assign roles.
     */
    public function __construct()
    {
        /*$this->middleware('can:view_setting', [
            'only' => [
                'index',
                'info_submit',
                'emails_submit',
                'reports_submit',
                'sms_submit',
                'whatsapp_submit',
                'api_keys_submit',
            ],
        ]);*/
    }

    public function index()
    {
        //general
        $settings = setting('info');
        //emails
        $emails_settings = setting('emails');
        //api keys
        $api_keys_settings = setting('api_keys');
        $free_package = setting('free_package');

        $deductions = setting('deductions');
        $page_name = t_('Settings');

        return view('dashboard.settings.index', get_defined_vars());
    }

    public function infoSubmit(GeneralSettingRequest $request)
    {
        cache()->clear();
        //old settings
        $old_settings = Setting::where('key', 'info')->first();
        $old_settings = $old_settings['value'];
        $settings = $request->except('logo', '_token');

        //update Header Background
        if ($request->hasFile('watermarkImage')) {
            $watermarkImage = $request->file('watermarkImage');
            $watermarkImage->move('img', 'watermark.png');
        }

        //update Header Background
        if ($request->hasFile('header_background')) {
            $left_logo = $request->file('header_background');
            $left_logo->move('img', 'header_background.png');
        }

        //update top_bar Logo
        if ($request->hasFile('top_left_logo')) {
            $left_logo = $request->file('top_left_logo');
            $left_logo->move('img', 'top_left_logo.png');
        }

        //update top_bar Logo
        if ($request->hasFile('top_right_logo')) {
            $right_logo = $request->file('top_right_logo');
            $right_logo->move('img', 'top_right_logo.svg');
        }

        //update logo
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logo->move('img', 'logo.png');
        }

        //update Preload Logo
        if ($request->hasFile('preloader_logo')) {
            $logo = $request->file('preloader_logo');
            $logo->move('img', 'preloader_logo.png');
        }

        //update Preload Logo
        if ($request->hasFile('fav_icon')) {
            $logo = $request->file('fav_icon');
            $logo->move('img', 'fav_icon.png');
        }

        //update reports logo
        if ($request->hasFile('email_logo')) {
            $image = base64_encode(file_get_contents($request->file('email_logo')));
            $request->file('email_logo')->move('img', 'email_logo.png');
            $settings['email_logo'] = $image;
        } else {
            $settings['email_logo'] = $old_settings['email_logo'];
        }

        $info = Setting::updateOrcreate(
            ['key' => 'info'],
            ['value' => $settings]
        );

        session()->flash('success', t_('Settings Updated successfully'));

        return redirect()->route('dashboard.setting.index');
    }

    public function emailsSubmit(EmailSettingRequest $request)
    {
        $settings = $request->except('_token');

        $settings['user_code']['active'] = ($request->has('user_code.active')) ? true : false;
        $settings['reset_password']['active'] = ($request->has('reset_password.active')) ? true : false;
        $settings['tests_notification']['active'] = ($request->has('tests_notification.active')) ? true : false;

        //update setting record in database

        $info = Setting::updateOrcreate(
            ['key' => 'emails'],
            ['value' => $settings]
        );
        cache()->clear();

        session()->flash('success', t_('Settings Updated successfully'));

        return redirect()->route('dashboard.setting.index');
    }

    public function apiKeysSubmit(ApiSettingRequest $request)
    {
        cache()->clear();

        $api_keys = [];
        $api_keys['google_api'] = $request['google_api'];
        $api_keys['yandex_translation_api'] = $request['yandex_translation_api'];

        $api_keys_setting = Setting::where('key', 'api_keys')->firstOrFail();
        $api_keys_setting->update([
            'value' => $api_keys,
        ]);

        session()->flash('success', t_('Settings Updated successfully'));

        return redirect()->route('dashboard.setting.index');
    }

    public function deductions(deductionSettingRequest $request)
    {

        $deduction = $request->except('_token');
        Setting::updateOrcreate(
            ['key' => 'deductions'],
            ['value' => $deduction]
        );
        cache()->clear();
        session()->flash('success', t_('Settings Updated successfully'));

        return redirect()->route('dashboard.setting.index');
    }

    public function certificate(Request $request)
    {
        $request->validate([
            'certificate' => 'required|image'
        ]);
        if ($request->hasFile('certificate')) {
            $certificate = $request->file('certificate');
            $certificate->move('img', 'certificate.png');
        }
        cache()->clear();
        session()->flash('success', t_('Settings Updated successfully'));

        return redirect()->route('dashboard.setting.index');
    }

    public function styleSubmit(StyleSettingRequest $request)
    {
        cache()->clear();
        $style_setting = Setting::where('key', 'style')->where('created_by', get_current_login())->first();
        if ($style_setting) {
            $style = $style_setting->value;
            if (isset($style[$request->type])) {
                if ($request->type === 'dark_mode') {
                    $style['dark_mode'] ? $style['dark_mode'] = false : $style['dark_mode'] = true;
                    $style_setting->update([
                        'value' => $style,
                    ]);
                    $data = ['success' => true, 'message' => t_('Mode_changed')];
                }
            } else {
                $style[$request->type] = true;
                $style_setting->update([
                    'value' => $style,
                ]);
            }
            $data = ['success' => true, 'message' => t_('Mode_changed')];
        } else {
            Setting::create([
                'key'     => 'style',
                'created_by' => get_current_login(),
                'value'   => [],
            ]);

            $data = ['success' => true, 'message' => t_('Style_array_Added_Successful')];
        }
        cache()->set('setting_style_' . auth(activeGuard())->id(), $style_setting);

        return response()->json($data, 200);
    }
}
