<?php

namespace App\Http\Controllers\Dashboard\Core;

use App\Http\Controllers\Controller;
use App\Models\TemporaryUpload;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FileController extends Controller
{
    protected string $path = 'dashboard.core.files';

    protected string $model = TemporaryUpload::class;

    public function uploadFile(Request $request)
    {
        $collection = uniqid('collection_hz_'.rand(1111, 9999).'_');
        $file = $request->file('file');
        $model = $this->model::create();
        $this->body['file'] = uploadImage($collection, $file, $model);
        $this->body['url'] = $model->getFirstMediaUrl($collection);
        $this->body['collection'] = "{$model->id}|$collection";
        $this->code = 200;
        $this->message = 'successfully uploaded file';

        return self::apiResponse($this->code, t_($this->message), $this->body);
    }

    public function deleteFile(Request $request)
    {
        if ($request->filename){
            $file = Media::query()->where('file_name', $request->file_name)->first();
        }else{
            $file = Media::query()->where('uuid', $request->id)->first();
        }
        if ($file) {
            $path = storage_path('app/public/').$file->id.'/'.$file->file_name;
            if (file_exists($path)) {
                unlink($path);
            }
            $file->delete();
            return self::apiResponse(200, t_('success'), $this->body);
        }
        return self::apiResponse($this->code, t_($this->message), $this->body);
    }

    public function deleteFileByUUID(Request $request)
    {
        $uuid = $request->get('uuid');
        $file = Media::where('uuid', $uuid)->firstOrFail();
        $file->delete();
        $this->code = 200;
        $this->message = 'successfully delete file';

        return self::apiResponse($this->code, t_($this->message), $this->body);
    }
}
