<?php

use App\Models\Setting;
use App\Models\TemporaryUpload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Modules\Translation\Models\Translation;

if (! function_exists('dotted_string')) {
    function dotted_string(string $name): string
    {
        if ($name === '') {
            return $name;
        }

        $base = str_replace(['[', ']'], ['.', ''], $name);
        if ($base[strlen($base) - 1] === '.') {
            return substr($base, 0, -1);
        }

        return $base;
    }
}
if (! function_exists('uploadImage')) {

    function uploadImage($name, $file, $model)
    {
        $model->clearMediaCollection($name);

        return $model->addMedia($file)->toMediaCollection($name);
    }
}
if (! function_exists('uploadMedia')) {
    function uploadMedia($name, $files, ?Model $model, $clearMedia = true)
    {
        if ($clearMedia) {
            $model?->clearMediaCollection($name);
        }
        if (is_array($files)) {
            foreach ($files as $file) {
                $model->addMedia($file)->toMediaCollection($name);
            }
        }
        if ($files instanceof UploadedFile) {
            $model->addMedia($files)->toMediaCollection($name);
        }
    }
}







if (! function_exists('moveTempImage')) {

    function moveTempImage(array $collections_name, ?Model $toModel, $newCollectionName, $disk = 'public')
    {
        foreach ($collections_name as $collection_name) {
            $array_id_collection = explode('|', $collection_name);
            if (is_array($array_id_collection) && count($array_id_collection) === 2) {
                $fromModel = TemporaryUpload::findOrFail($array_id_collection[0]);
                $mediaItem = $fromModel->getMedia($array_id_collection[1])->first();
                $mediaItem && $mediaItem->move($toModel, $newCollectionName, $disk);
                $mediaItem && $fromModel->clearMediaCollection($collection_name);
            }
        }
    }
}

if (! function_exists('edit_separator')) {
    function edit_separator($path): array|string
    {
        return str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $path);
    }
}

if (! function_exists('locale_field')) {
    function locale_field(string $name, $locale = 'ar'): ?string
    {
        if ($model = Form::getModel()) {
            return $model->getTranslation($name, $locale);
        }

        return old("$name.$locale");
    }
}

if (! function_exists('toMap')) {
    function toMap(Traversable $iterator, string $key = 'id', string $value = 'name'): array
    {
        $result = [];
        foreach ($iterator as $item) {
            $result[$item[$key]] = $item[$value];
        }

        return $result;
    }
}

if (! function_exists('toMaps')) {
    function toMaps(Traversable $iterator, string $key = 'id', string $value1 = 'name', string $value2 = 'name'): array
    {
        $result = [];
        if ($iterator) {
            foreach ($iterator as $item) {
                $result[$item[$key]] = [$item[$value1], $item[$value2]];
            }
        }

        return $result;
    }
}

//get Data With no style
if (! function_exists('remove_style')) {
    function remove_style($data)
    {
        return preg_replace('/(<[^>]+) style=".*?"/i', '$1', strip_tags($data));
    }
}

if (! function_exists('route_group')) {
    function route_group(string|array $prefix, callable $callback): void
    {
        $prefixValue = is_array($prefix) ? $prefix['prefix'] : $prefix;
        $as = Str::of($prefixValue)->snake()->lower()->append('.');
        $namespace = Str::of($prefixValue)->singular()->studly();
        $middleware = [];

        if (is_array($prefix)) {
            $as = $prefix['as'] ?? $as;
            $namespace = $prefix['namespace'] ?? $namespace;
            $middleware = $prefix['middleware'] ?? $middleware;
        }

        \Illuminate\Support\Facades\Route::group([
            'prefix'     => $prefixValue,
            'as'         => $as,
            'namespace'  => $namespace,
            'middleware' => $middleware,
        ], $callback);
    }
}

if (! function_exists('is_update_request')) {
    function is_update_request(): bool
    {
        return request()->isMethod('PUT');
    }
}

if (! function_exists('request_rules')) {
    function request_rules(array $rules, ?callable $ifUpdate = null): bool
    {
        if ($ifUpdate && is_update_request()) {
            $rules = $ifUpdate($rules);
        }

        return $rules;
    }
}

if (! function_exists('t_')) {
    function t_($Line,
        array $replace = [],
        $locale = null): array|string|\Illuminate\Contracts\Translation\Translator|\Illuminate\Contracts\Foundation\Application|null
    {
        $Line = strtolower($Line);
        if (config('custom.APP_HZ_TRANSLATION', false)) {

            $default = preg_replace('/[^a-zA-Z0-9-:-]/', ' ', $Line);
            if (! empty($replace)) {
                $shouldReplace = [];
                foreach ($replace as $key => $value) {
                    $shouldReplace[':'.$key] = "{:{$key}}";
                }
                $Line = strtr($Line, $shouldReplace);
            }
            $check = Translation::where('key', '=', $Line)->first();

            if ($check == null && $Line != null && $Line != '') {

                Translation::create([
                    'key'     => $Line,
                    'default' => '<p class="text-blue" >'.$default.'</p>',
                    'en'      => $default,
                    't_'      => [],
                ]);

                return $Line;
            }
        }

        return trans($Line, $replace, $locale);
    }
}

// Active Guard Function
if (! function_exists('activeGuard')) {
    function activeGuard($guard = null): bool|int|string|null
    {
        if ($guard) {
            return auth($guard)->check();
        }
        foreach (array_keys(config('auth.guards')) as $grd) {
            if (auth()->guard($grd)->check()) {
                return $grd;
            }
        }

        return null;
    }
}

// Active Guard Function
if (! function_exists('updatePageConfig')) {
    function updatePageConfig($pageConfigs)
    {
        $demo = 'custom';
        $custom = 'custom';

        if (isset($pageConfigs)) {
            if (count($pageConfigs) > 0) {
                foreach ($pageConfigs as $config => $val) {
                    Config::set($demo.'.'.$custom.'.'.$config, $val);
                }
            }
        }
    }
}

//get json setting as array
if (! function_exists('setting')) {

    function setting($key)
    {
        $setting = cache('setting_'.$key.'_'.auth(activeGuard())->id());

        if (! $setting) {
            $setting = Setting::where('key', $key)
                              ->where('created_by', auth(activeGuard())->id())
                              ->first();
            // Insert User setting if not found
            cache()->set('setting_'.$key.'_'.auth(activeGuard())->id(), $setting);
        }

        if ($setting) {
            $setting = $setting['value'];
        } else {
            $setting = cache('setting_'.$key);

            if ($setting) {
                $setting = $setting['value'];
            } else {
                $setting = Setting::where('key', $key)->first();
                // Insert setting n cache if not found
                cache()->set('setting_'.$key, $setting);

                if ($setting) {
                    $setting = $setting['value'];
                } else {
                    $setting = [];
                }
            }
        }

        return $setting;
    }
}

if (! function_exists('get_current_lang')) {
    function get_current_lang()
    {
        return App::getLocale();
    }
}

if (! function_exists('get_current_login')) {
    function get_current_login()
    {
        return auth(activeGuard())->id();
    }
}

if (! function_exists('week_days')) {
    function week_days(): array
    {
        return ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
    }
}
