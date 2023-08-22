<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Modules\Language\Models\Language;
use Modules\Translation\Models\Translation;
use SplFileInfo;

class TranslationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected array $newWords = [];

    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Translation::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $languages = Language::get();
        if (count($languages)) {
            foreach ($languages as $language) {

                app()->setLocale($language->code);

                $translationsArray = file_exists(lang_path('/').get_current_lang().'.json') ? json_decode(file_get_contents(lang_path('/').get_current_lang().'.json')) : [];
                foreach ($translationsArray as $key => $value) {
                    $value = strtolower($value);

                    $translation = Translation::where('key', '=', $key)->first();
                    if (! $translation) {
                        $default = preg_replace('/[^a-zA-Z0-9-]/', ' ', $key);
                        $translation = Translation::create([
                            'key'     => $key,
                            'default' => '<p class="text-blue" >'.$default.'</p>',
                            'en'      => $default,
                            't_'      => '[]',
                        ]);
                    }

                    if ($translation) {
                        if ($translation->t_ != null && $translation->t_ != '[]' && $translation->t_ != '') {

                            $transarray = $translation->t_;
                            foreach ($transarray as $num => $trans) {
                                if (in_array($language->code, $trans, true)) {
                                    $trans['value'] = $value;
                                    $data = [
                                        't_' => $transarray,
                                    ];
                                    $translation->update($data);
                                    //echo $translation['key']." \n" ?? "not defiend";
                                } else {
                                    $transarray[] = [
                                        'language' => $language->code, 'value' => $value,
                                    ];

                                    $data = [
                                        't_' => $transarray,
                                    ];

                                    $translation->update($data);
                                    //echo $translation['key']." \n" ?? "not defiend";

                                }
                            }
                        } else {
                            $x_title = [];

                            $x_title[] = [
                                'language' => $language->code,
                                'value'    => $value,
                            ];

                            $data = [
                                't_' => $x_title,
                            ];
                            $translation->update($data);
                            //echo $translation['key']." \n" ?? "not defiend";

                        }
                    }
                }

                $files = $this->getAllFiles();
                $regex = collect([
                    "/__\(['\"].*?['\"]\)/",
                    "/t_\(['\"].*?['\"]\)/",
                    "/trans\(['\"].*?['\"]\)/",
                    "/@lang\(['\"].*?['\"]\)/",
                ]);
                $files->each(function (SplFileInfo $file) use ($regex) {
                    $regex->each(fn (string $i) => $this->extractor($file, $i));
                });

                foreach ($this->newWords as $key => $value) {
                    $value = strtolower($value);
                    $translation = Translation::where('key', '=', $key)->first();
                    if (! $translation) {
                        $default = preg_replace('/[^a-zA-Z0-9-]/', ' ', $key);
                        $translation = Translation::create([
                            'key'     => $key,
                            'default' => '<p class="text-blue" >'.$default.'</p>',
                            'en'      => $default,
                            't_'      => '[]',
                        ]);
                    }
                }
            }
        }
    }

    private function getAllFiles(): Collection
    {
        return collect([
            app_path(),
            public_path('dashboard'),
            config_path(),
            resource_path('views'),
        ])
            ->transform(fn ($folder) => File::allFiles($folder))
            ->flatten(1)
            ->reject(fn ($file) => $file->getFileName() === 'LocalizeCommand.php');
    }

    private function extractor($file, $regex): void
    {
        $handler = function (string $line) {
            $word = (string) Str::of($line)
                                ->replace("@lang('", '')
                                ->replace('@lang("', '')
                                ->replace("__('", '')
                                ->replace("')", '')
                                ->replace('__("', '')
                                ->replace('")', '')
                                ->replace("t_('", '')
                                ->replace("')", '')
                                ->replace('t_("', '')
                                ->replace('")', '')
                                ->replace("trans('", '')
                                ->replace("')", '')
                                ->replace('trans("', '')
                                ->replace('")', '');

            if (! isset($this->currentWords[$word])) {
                $this->newWords[$word] = $word;
            }
        };

        Str::of($file->getContents())->matchAll($regex)->each($handler);
    }
}
