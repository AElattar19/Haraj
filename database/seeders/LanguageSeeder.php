<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Language\Models\Language;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::truncate();
        Language::insert([
            [
                'name'      => 'العربية',
                'flag'      => 'storage/language/ar/ar-sa-large.png',
                'code'      => 'ar',
                'local'     => 'ar-SA',
                'direction' => 'rtl',
                'rtl'       => true,
                'sort'      => '1',
                'col'       => '1',
                'active'    => true,
                'lock'      => true,
            ],
            [
                'name'      => 'English',
                'flag'      => 'storage/language/en/en-us-large.png',
                'code'      => 'en',
                'local'     => 'en-US',
                'direction' => 'ltr',
                'rtl'       => false,
                'sort'      => '2',
                'col'       => '2',
                'active'    => true,
                'lock'      => true,
            ],

        ]);
    }
}
