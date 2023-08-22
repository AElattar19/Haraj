<?php

namespace App\Http\Controllers\Api\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Post\PostRequest;
use App\Http\Resources\Post\PostDetailsResource;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\Post\ReplyResource;
use App\Models\Post;
use App\Models\Reply;
use App\Support\Api\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    use ApiResponse;

    protected function addPost(PostRequest $request)
    {
        $request->validated();
        $post = Post::query()->create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'phone' => $request->phone,
            'category_id' => $request->category_id,
            'hide_number' => $request->hide_number,
            'area_id' => $request->area_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'user_id' => auth()->user()->id,
            'status' => $request->status
        ]);
        $request->images_collection && uploadMedia('images', $request->images_collection, $post);
        foreach ($post->getMedia('images') as $image) {
            $img = \Spatie\Image\Image::load(Storage::path('public/'.$image->id.'/'.$image->file_name));
            $img->watermark('dashboard/img/media/login.png');
            $img->save(Storage::path('public/'.$image->id.'/'.$image->file_name));
        }
        $this->body['post'] = PostDetailsResource::make($post);
        return self::apiResponse(200, t_('Your Post Has Been Added Successfully'), $this->body);
    }

    protected function show($id): JsonResponse
    {
        $post = Post::with('replies')->findOrFail($id);
        $catId = $post->category->MainParent ? $post->category->MainParent->id : $post->category->id;
        $similar = Post::query()->where('category_id', $catId)->whereNot('id', $post->id)->get();
        $comments = Reply::query()->with('childReply')->whereNull('parent_id')->where('post_id', $post->id)->get();


        $this->body['post'] = PostDetailsResource::make($post);
        $this->body['comments'] = ReplyResource::collection($comments);
        $this->body['similar'] = PostResource::collection($similar);
        return self::apiResponse(200, $this->message, $this->body);
    }

    protected function addComment(Request $request): JsonResponse
    {
        $rules = [
            'body' => 'required|max:500',
            'post_id' => 'required'
        ];
        $post = Post::findOrFail($request->post_id);
        $request->validate($rules);
        Reply::query()->create([
            'body' => $request->body,
            'post_id' => $request->post_id,
            'user_id' => auth()->user()->id,
            'parent_id' => $request->comment_id
        ]);
        $replies = ReplyResource::collection($post->replies);
        $this->body['post_comments'] = $replies;

        return self::apiResponse(200, t_('commented successfully'), $this->body);

    }
}
