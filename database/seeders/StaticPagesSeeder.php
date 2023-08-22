<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class StaticPagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->loadStaticPages();
    }

    public function loadStaticPages(): void
    {
        Page::query()->truncate();
        $baseBody = [
            'ar' => 'محتوي الصفحة فارغ حاليا',
            'en' => 'page content is empty',
        ];
        $data = [
            [
                'key'   => Page::Qsm,
                'title' => [
                    'ar' => 'القسم',
                    'en' => 'Qsm',
                ],
                'body'  => [
                    'ar' => 'والله العظيم هقول الحق',
                    'en' => 'والله العظيم هقول الحق',
                ],
            ],
            [
                'key'   => Page::TERMS,
                'title' => [
                    'ar' => 'القواعد والشروط',
                    'en' => 'Terms and conditions',
                ],
                'body'  => $baseBody,
            ],
            [
                'key'   => Page::PRIVACY,
                'title' => [
                    'ar' => 'سياسة الخصوصية',
                    'en' => 'Privacy Policy',
                ],
                'body'  => $baseBody,
            ],
            [
                'key'   => Page::ABOUT,
                'title' => [
                    'ar' => 'من نحن',
                    'en' => 'About us',
                ],
                'body'  => $baseBody,
            ],
        ];
        collect($data)->each(fn ($i) => Page::updateOrCreate(['key' => $i['key']], $i));
        echo 'Pages Created Successfully'.PHP_EOL;
    }
}
