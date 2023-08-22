<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Post\PostRequest;
use App\Http\Resources\Area\AreaResource;
use App\Http\Resources\Core\Category\CategoryResource;
use App\Http\Resources\Post\PostDetailsResource;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\Post\ReplyResource;
use App\Models\Area;
use App\Models\Category;
use App\Models\Post;
use App\Models\Reply;
use App\Support\Api\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    use ApiResponse;

    protected function getCategory()
    {
        $Categories = Category::query()->with('categories')->where('active', 1)->get();
        $this->body['category'] = CategoryResource::collection($Categories);
        return self::apiResponse(200, t_('Your Post Has Been Added Successfully'), $this->body);
    }

}
