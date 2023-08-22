<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
               'title' => [
                    'ar' => 'خصم 30% على اول 3 اوردرات من خلالنا يلا اطلب اوردرك الان مستنى اى !! خصم 30% على اول 3 اوردرات من خلالنا يلا اطلب اوردرك الان مستنى اى !!',
                    'en' => "30% discount on the first 3 orders through us. Let's order your order now, waiting for any!! 30% off the first 3 Order through us. Let's order your order now. Wait for any!!"
                ],
                'description' => [
                    'ar' => 'أي حاجة أي حاجة أي حاجة أي حاجة ',
                    'en' => 'anything anything anything anything '
                ]
            ],
            [
                'title' => [
                    'ar' => 'خصم 30% على اول 3 اوردرات من خلالنا يلا اطلب اوردرك الان مستنى اى !! خصم 30% على اول 3 اوردرات من خلالنا يلا اطلب اوردرك الان مستنى اى !!',
                    'en' => "30% discount on the first 3 orders through us. Let's order your order now, waiting for any!! 30% off the first 3 Order through us. Let's order your order now. Wait for any!!"
                ],
                'description' => [
                    'ar' => 'أي حاجة أي حاجة أي حاجة أي حاجة ',
                    'en' => 'anything anything anything anything '
                ]
            ],
            [
                'title' => [
                    'ar' => 'خصم 30% على اول 3 اوردرات من خلالنا يلا اطلب اوردرك الان مستنى اى !! خصم 30% على اول 3 اوردرات من خلالنا يلا اطلب اوردرك الان مستنى اى !!',
                    'en' => "30% discount on the first 3 orders through us. Let's order your order now, waiting for any!! 30% off the first 3 Order through us. Let's order your order now. Wait for any!!"
                ],
                'description' => [
                    'ar' => 'أي حاجة أي حاجة أي حاجة أي حاجة ',
                    'en' => 'anything anything anything anything '
                ]
            ],
            [
                'title' => [
                    'ar' => 'خصم 30% على اول 3 اوردرات من خلالنا يلا اطلب اوردرك الان مستنى اى !! خصم 30% على اول 3 اوردرات من خلالنا يلا اطلب اوردرك الان مستنى اى !!',
                    'en' => "30% discount on the first 3 orders through us. Let's order your order now, waiting for any!! 30% off the first 3 Order through us. Let's order your order now. Wait for any!!"
                ],
                'description' => [
                    'ar' => 'أي حاجة أي حاجة أي حاجة أي حاجة ',
                    'en' => 'anything anything anything anything '
                ]
            ],
        ];
        foreach ($data as $d){
            Gallery::create($d);
        }
    }
}
