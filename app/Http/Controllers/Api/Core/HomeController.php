<?php

namespace App\Http\Controllers\Api\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Core\ContactRequest;
use App\Http\Resources\Core\Category\CategoryResource;
use App\Http\Resources\Core\Gallery\GalleryResource;
use App\Http\Resources\Post\PostResource;
use App\Models\Category;
use App\Models\ContactUs;
use App\Models\Gallery;
use App\Models\Post;
use App\Support\Api\ApiResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use ApiResponse;

    protected function index(){

        $galleries = GalleryResource::collection(Gallery::all());
        $categories = Category::query()->whereNull('parent_id')->get();
        $categories = CategoryResource::collection($categories);

        $this->body['sliders'] = $galleries;
        $this->body['categories'] = $categories;

        return self::apiResponse(200, $this->message, $this->body);
    }
    protected function filter(Request $request){

        if (!$request->category_id && !$request->lat && !$request->long){
            $posts = Post::query()->latest()->paginate(20);
            $posts = PostResource::collection($posts);
            $this->body['posts_count'] = $posts->count();
            $this->body['posts'] = $posts;
            return self::apiResponse(200, $this->message, $this->body);
        }
        $category = Category::query()->findOrFail($request->category_id);
        $categories_ids = $category->getDescendants($category);
        $posts = Post::query()->whereIn('posts.category_id', $categories_ids)
            ->join('categories', 'categories.id', 'posts.category_id')
            ->select('posts.*')
            ->latest()->paginate(20);
        $posts = PostResource::collection($posts);
        $this->body['posts_count'] = $posts?->count();
        $this->body['posts'] = $posts;
        return self::apiResponse(200, $this->message, $this->body);
    }
    protected function search(Request $request){
        $posts = Post::query()
            ->where('title', 'LIKE', '%'.$request->title.'%')->latest()->paginate(20);
        if ($posts->isNotEmpty()){
            $this->body['posts_count'] = $posts->count();
            $this->body['posts'] = PostResource::collection($posts);
            return self::apiResponse(200, null, $this->body);
        }
        return self::apiResponse(200, t_('No Posts was found.'), $this->body);
    }
    protected function ContactUs(ContactRequest $request)
    {
        $this->body['contact'] = ContactUs::create($request->all());
        return self::apiResponse(200, t_('Your Message Has Been Sent Successfully'), $this->body);

    }

}
