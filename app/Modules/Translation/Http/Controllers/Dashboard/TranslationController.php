<?php

namespace Modules\Translation\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Modules\Language\Models\Language;
use Modules\Translation\Models\Translation;

class TranslationController extends Controller
{
    protected array $newKey = [];

    public function index()
    {

        $languages = Language::get();
        $page_name = t_('Translations');

        return view('Translation::dashboard.index', compact('languages', 'page_name'));
    }

    public function listData()
    {
        $languages = Language::get();

        $Translation = Translation::orderBy('created_at', 'desc')->get();

        $no = 0;
        $data = [];
        foreach ($Translation as $trans) {
            $no++;
            $row = [];
            /*            $row[] = '
                        <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="Trans[]"  class="custom-control-input" id="customCheck'.$trans->id.'">
                                                              <label class="custom-control-label" for="customCheck'.$trans->id.'">&nbsp;</label>
                                                            </div>  ';*/

            $row[] = $no;
            $row[] = '<textarea class="form-control Translation_Value" dir="ltr" readonly>'.$trans->key.' </textarea>';
            $row[] = $trans->default;

            foreach ($languages as $lang) {
                $translation_array = $trans->t_;
                $row[$lang->col + 2] = '<textarea  id="Trans_'.$lang->local.'_'.$trans->id.'" class="form-control Translation_Value" dir="'.$lang->direction.'" data-lang_local="'.$lang->code.'" data-default_value="'.$trans->en.'"  data-trans_key="'.$trans->key.'" placeholder='.t_('enter the translation in the correct language for the column').'></textarea>';

                if ($translation_array != '[]' && $translation_array != '' && $translation_array != null) {
                    foreach ($translation_array as $translation_language) {

                        if ($translation_language['language'] == $lang->code) {
                            if ($translation_language['value']) {
                                $row[$lang->col + 2] = '<textarea id="Trans_'.$lang->local.'_'.$trans->id.'" class="form-control bg-muted Translation_Value" dir="'.$lang->direction.'" data-lang_local="'.$lang->code.'" data-default_value="'.$trans->en.'"  data-trans_key="'.$trans->key.'" placeholder='.t_('enter the translation in the correct language for the column').'>'.$translation_language['value'].'</textarea>';
                            } else {
                                $row[$lang->col + 2] = '<textarea id="Trans_'.$lang->local.'_'.$trans->id.'" class="form-control Translation_Value" dir="'.$lang->direction.'" data-lang_local="'.$lang->code.'" data-default_value="'.$trans->en.'"  data-trans_key="'.$trans->key.'" placeholder='.t_('enter the translation in the correct language for the column').'></textarea>';
                            }
                        }
                    }
                } else {
                    $row[$lang->col + 2] = '<textarea id="Trans_'.$lang->local.'_'.$trans->id.'" class="form-control Translation_Value" dir="'.$lang->direction.'" data-lang_local="'.$lang->code.'" data-default_value="'.$trans->en.'"  data-trans_key="'.$trans->key.'" placeholder='.t_('enter the translation in the correct language for the column').'></textarea>';
                }
            }

            $row[] = '<a href="javascript:void(0);" onclick="deleteData('.$trans->id.')" class="action-icon"> <i class="fa fa-trash text-danger"></i></a>';

            $data[] = $row;
        }

        $output = ['data' => $data];

        return response()->json($output);
    }

    public function update(Request $request)
    {

        $validator = $request->validate([
            'lang_local'       => 'required',
            'translation_key'  => 'required',
            'lang_local_value' => 'required',
        ]);
        $x_title = [];

        $translation = Translation::where('key', '=', $validator['translation_key'])->first();

        if ($translation->t_ != '[]' && $translation->t_ != '' && $translation->t_ != null) {

            $transarray = $translation->t_;

            foreach ($transarray as $k => $trans) {
                if ($trans['language'] == $validator['lang_local']) {
                    $transarray[$k]['value'] = $validator['lang_local_value'];
                    $data = [
                        't_' => $transarray,
                    ];
                    $translation->update($data);
                    $res['success'] = true;
                    $res['message'] = t_('translation_updated_successfully');

                    return $res;
                }
            }
            $transarray[] = [
                'language' => $validator['lang_local'],
                'value'    => $validator['lang_local_value'],
            ];
            $data = [
                't_' => $transarray,
            ];
            //            return $data;
            $translation->update($data);
            $res['success'] = true;
            $res['message'] = t_('translation_updated_successfully');

            return $res;
        } else {
            $x_title[] = [
                'language' => $request['lang_local'],
                'value'    => $request['lang_local_value'],
            ];

            $data = [
                't_' => $x_title,
            ];

            $translation->update($data);

            $res['success'] = true;
            $res['message'] = t_('translation_updated_successfully');

            return $res;
        }
    }

    public function generateLangFiles()
    {

        $languages = Language::get();

        foreach ($languages as $lang) {

            $ds = DIRECTORY_SEPARATOR;

            $path = base_path()."{$ds}resources{$ds}lang{$ds}";

            if (! file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $data = [];
            $translations = Translation::all();
            foreach ($translations as $tr) {
                $translation_array = $tr->t_;

                $translation = '';
                if (is_array($translation_array)) {
                    foreach ($translation_array as $translation_language) {
                        if ($translation_language['language'] == $lang->code) {
                            $translation = $translation_language['value'];
                        }
                    }
                } else {
                    //dump($translation_array);
                }
                $data[strtolower($tr->key)] = addslashes($translation);
            }
            if (! $path."{$lang->code}.json") {
                touch("{$lang->code}.json");
            }
            $fh = fopen($path."{$lang->code}.json", 'w');

            fwrite($fh, json_encode($data));
            fclose($fh);
        }

        $res['success'] = true;
        $res['message'] = t_('translation_file_generated_successfully');

        return $res;
    }

    public function createTranslationTable(Request $request)
    {
        Artisan::call('db:seed', ['--class' => 'TranslationsSeeder']);
        session()->flash('success', t_('All Translations created successfully'));
        $res['success'] = true;
        $res['message'] = t_('table created successful');

        return $res;
    }

    public function add(Request $request)
    {
        $key = strtolower($request->key);
        $check = Translation::where('key', $key)->get();
        $default = preg_replace('/[^a-zA-Z0-9-]/', ' ', $request->key);

        if ($check->count() < 1) {
            Translation::create([
                'key'     => $key,
                'default' => '<p class="text-blue" >'.$default.'</p>',
                'en'      => $default,
                't_'      => [],
            ]);

            return $key;
        }
    }

    public function destroy($id)
    {
        $trans = Translation::findOrFail($id);
        $trans->delete();
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
                                ->replace('")', '');

            if (! isset($this->currentWords[$word])) {
                $this->newKey[$word] = $word;
            }
        };

        Str::of($file->getContents())->matchAll($regex)->each($handler);
    }

    private function getAllFiles(): Collection
    {
        return collect([
            resource_path('views'),
            app_path(),
            config_path(),
            resource_path('views'),
        ])
            ->transform(fn ($folder) => File::allFiles($folder))
            ->flatten(1)
            ->reject(fn ($file) => $file->getFileName() === 'LocalizeCommand.php');
    }
}
