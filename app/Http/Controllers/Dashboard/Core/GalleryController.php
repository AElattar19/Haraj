<?php

namespace App\Http\Controllers\Dashboard\Core;

use App\Datatables\Dashboard\Core\GalleryDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Core\SliderRequest;
use App\Models\Gallery;
use App\Support\Crud\WithCrud;
use Arr;
use Illuminate\Database\Eloquent\Model;

class GalleryController extends Controller
{
    use WithCrud;

    protected string $path = 'dashboard.core.galleries';

    protected string $model = Gallery::class;

    protected string $datatable = GalleryDatatable::class;

    protected function storeAction(array $validated)
    {
        $category = $this->queryBuilder()->create($validated);
        $image = Arr::pull($validated, 'image');
        $image && uploadImage('image', $image, $category);
    }

    protected function updateAction(array $validated, Model $model)
    {
        $image = Arr::pull($validated, 'image');
        $model->update($validated);
        $image && uploadImage('image', $image, $model);
    }
    protected function validationAction(): array
    {
        return app(SliderRequest::class)->validated();
    }
}
