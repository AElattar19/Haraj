<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Post\PostResource;
use App\Models\FavouriteUser;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    protected function add_to_fav(Request $request): JsonResponse
    {
        $post = Post::query()->where('id', $request->post_id)->first();
        if ($post){
            $fav_user = FavouriteUser::query()->where('post_id', $post->id)
                ->where('user_id', auth()->user()->id)->first();
            if ($fav_user){
                $fav_user->delete();
                return self::apiResponse(200, t_('Removed from from favourites successfully !'), $this->body);
            }else{
                FavouriteUser::query()->create([
                    'post_id' => $post->id,
                    'user_id' => auth()->user()->id
                ]);
                return self::apiResponse(200, t_('Added to favourites successfully !'), $this->body);
            }
        }else {
            return self::apiResponse(400, t_('Post not founded or an error occurred !'), $this->body);
        }

    }

    protected function favourites(): JsonResponse
    {
        $any = auth()->user()->favourites;
        if ($any){
            $this->body['posts'] = PostResource::collection($any);
            return self::apiResponse(200, null, $this->body);
        }
        return self::apiResponse(400, 'There is no favourites, yet!', $this->body);
    }
}
