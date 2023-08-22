<?php

namespace App\Http\Controllers\Dashboard\Post;

use App\Datatables\Dashboard\Post\PostDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Post\PostRequest;
use App\Models\Area;
use App\Models\Category;
use App\Models\Post;
use App\Support\Crud\WithCrud;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PostController extends Controller
{
    use WithCrud;
    protected string $path = 'dashboard.post.posts';

    protected string $datatable = PostDatatable::class;

    protected string $model = Post::class;

    protected function storeAction(array $validated)
    {
        $images = Arr::pull($validated, 'images_collection');
        Arr::pull($validated, 'cat_id');
        $validated['category_id'] = last(request()->cat_id);
        $validated['area_id'] = last(request()->area_id);
        $model = $this->queryBuilder()->create($validated);
//        $image = Arr::pull($validated, 'cover');
//        $image && uploadImage('cover', $image, $model);
        $images && moveTempImage($images, $model, 'images');
    }
    protected function updateAction(array $validated, Model $model)
    {

        $images = Arr::pull($validated, 'images_collection');
        Arr::pull($validated, 'cat_id');
        $validated['category_id'] = last(request()->cat_id);
        $validated['area_id'] = last(request()->area_id);
        $images && moveTempImage($images, $model, 'images');
//        $data = Arr::except($validated, 'additions');
        $model->update($validated);

//        $image = Arr::pull($validated, 'cover');
//        $image && uploadImage('cover', $image, $model);

//        Arr::exists($validated, 'additions') ? $model->additions()->sync($validated['additions']) : $model->additions()->sync([]);
    }
    protected function formData(?Model $model = null): array
    {

        return [
            'jsValidator' => PostRequest::class,
            'areas'   => Area::with('areas')->where('active', 1)->get(),
            'categories'  => Category::with('categories')->where('active', 1)->get()
        ];
    }
    protected function validationAction(): array
    {
        return app(PostRequest::class)->validated();
    }
    protected function loadAreas(Request $request): JsonResponse
    {
        return response()->json(Area::with('areas')->where('active', 1)->where('parent_id', $request->area_1_id)->get());
    }
    protected function loadCats(Request $request): JsonResponse
    {
        return response()->json(Category::with('categories')->where('active', 1)->where('parent_id', $request->cat_1_id)->get());
    }
}
