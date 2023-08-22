<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            //                SqlFileSeeder::class,
            DashboardRolesSeeder::class,
            SettingSeeder::class,
            LanguageSeeder::class,
            StaticPagesSeeder::class,
            TranslationsSeeder::class,

        ]);
    }
}
