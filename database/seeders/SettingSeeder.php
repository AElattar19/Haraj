<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::truncate();

        Setting::insert([
            [
                'key'   => 'info',
                'value' => '{"name": {"ar": "اسم الموقع", "en": "Site name"}, "email": "cahyfenofe@mailinator.com", "phone": "+1 (357) 346-5683", "author": "Non qui voluptas eve", "address": {"ar": "عنوان", "en": "address"}, "socials": {"phone": "+1 (226) 967-5693", "email1": "xohonodeqy@mailinator.com", "email2": "rydyc@mailinator.com", "twitter": "Dolor est in possimu", "youtube": "Voluptas inventore s", "facebook": "Provident soluta ex", "linkedin": "Facere vel qui delec", "instagram": "Ea et enim in sit ne", "google_location": "https://www.goki.org.au"}, "website": "https://www.zoci.net", "ios_link": "Recusandae Accusant", "timezone": "Asia/Riyadh", "copyright": {"ar": "جميع الحقوق محفوظه", "en": "copyright"}, "email_logo": [], "android_link": "Quisquam blanditiis", "version_number": "66"}',
            ],
            [
                'key'   => 'reports',
                'value' => '{"footer": "user footer", "font-size": "12", "margin-top": "0", "font-family": "sans-serif", "margin-left": "20", "show_footer": true, "show_header": true, "margin-right": "20", "margin-bottom": "20", "show_signature": true, "content-margin-top": "230", "content-margin-bottom": "220"}',
            ],
            [
                'key'   => 'emails',
                'value' => '{"host": "smtp.mailtrap.io", "port": "587", "password": "b5456568542ad5", "username": "b657a77f38864b", "from_name": "No Replay", "user_code": {"active": false}, "encryption": "null", "active_user": {"body": null, "active": "on", "subject": null}, "footer_color": "#363636", "from_address": "admin@gmail.com", "header_color": "#c43e00", "reset_password": {"body": null, "active": true, "subject": "Reset Password"}, "tests_notification": {"active": false}}',
            ],
            [
                'key'   => 'sms',
                'value' => '{"sid": "", "from": "", "token": "", "user_code": {"active": false, "message": "welcome {user_name} , your user code is {user_code}"}, "users_notification": {"active": false, "message": "welcome {user_name} , your users are ready now .. you can check users by using your user code : {user_code}"}}',
            ],
            [
                'key'   => 'whatsapp',
                'value' => '{"report": {"active": false, "message": "welcome {user_name} , user report link is {user_link}"}, "receipt": {"active": false, "message": "welcome {user_name} , receipt link is {receipt_link}"}}',
            ],
            [
                'key'   => 'api_keys',
                'value' => '{"google_api": "", "yandex_translation_api": ""}',
            ], [
                'key'   => 'style',
                'value' => '{"dark_mode": false}',
            ],
        ]);
    }
}
