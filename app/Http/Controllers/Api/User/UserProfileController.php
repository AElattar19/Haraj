<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\User\UserResource;
use App\Support\Api\ApiResponse;
use Illuminate\Http\JsonResponse;

class UserProfileController extends Controller
{
    use ApiResponse;
    protected function UserProfile(): JsonResponse
    {
        $user = auth()->user();
        $this->body['user'] = UserResource::make($user);
        $this->body['user_posts'] = PostResource::collection($user->posts);
        return self::apiResponse('200', '', $this->body);
    }
}
