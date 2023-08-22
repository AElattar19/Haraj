<?php

namespace App\Http\Controllers\Dashboard\Core;

use App\Datatables\Dashboard\Core\CategoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Core\CategoryRequest;
use App\Models\Category;
use App\Support\Crud\WithCrud;
use Arr;
use Illuminate\Database\Eloquent\Model;

class CategoryController extends Controller
{
    use WithCrud;

    protected string $path = 'dashboard.core.categories';

    protected string $model = Category::class;

    protected string $datatable = CategoryDataTable::class;

    public function index()
    {
        $cat = $this->model::find(request('id'));
        $this->handleDatatableBackAction($cat);
        return $this->datatable::create($this->path)->render("{$this->path}.index", [
            'route' => $this->path,
            'title' => $cat?->title,
        ]);
    }
    protected function storeAction(array $validated)
    {
        $image = Arr::pull($validated, 'image');
        $category = $this->queryBuilder()->create($validated);
        $image && uploadImage('image', $image, $category);
    }

    protected function updateAction(array $validated, Model $model)
    {
        $image = Arr::pull($validated, 'image');
        $model->update($validated);
        $image && uploadImage('image', $image, $model);
    }

    protected function formData(?Model $model = null): array
    {
        $category = $this->model::find(request('id'));
        return [
            'parent_id' => $category? $category->id : '',
        ];
    }
    protected function validationAction(): array
    {
        return app(CategoryRequest::class)->validated();
    }
    private function handleDatatableBackAction($cat)
    {
        session()->forget('parentCategoryId');
        if ($cat?->parent_id) {
            session()->put('parentCategoryId', $cat->parent_id);
        }
    }
}
