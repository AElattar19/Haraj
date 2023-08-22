<?php

namespace App\Http\Controllers\Api\Core;

use App\Http\Controllers\Controller;
use App\Http\Resources\Core\FaqResource;
use App\Models\Faq;
use App\Models\Page;
use App\Support\Api\ApiResponse;
use Illuminate\Http\Request;

class CoreController extends Controller
{
    use ApiResponse;
    protected function getFaqs()
    {
        $this->body['questions'] = FaqResource::collection(Faq::all());
        return self::apiResponse('200', '', $this->body);
    }
    protected function getPage(Request $request){
        $pages = Page::all();
        $this->body['about'] = $pages->where('key', 'about')->first()?$pages->where('key', 'about')->first()->getTranslation('body',$request->header('Accept-Language')) : '';
        $this->body['terms'] = $pages->where('key', 'terms')->first()?$pages->where('key', 'terms')->first()->getTranslation('body',$request->header('Accept-Language')) : '';
        $this->body['privacy'] = $pages->where('key', 'privacy')->first()?$pages->where('key', 'privacy')->first()->getTranslation('body',$request->header('Accept-Language')) : '';
        $this->body['qasam'] = $pages->where('key', 'qasam')->first()?$pages->where('key', 'qasam')->first()->getTranslation('body',$request->header('Accept-Language')) : '';
        return self::apiResponse(200, '', $this->body);

    }
}
