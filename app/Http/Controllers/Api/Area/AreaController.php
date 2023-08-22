<?php

namespace App\Http\Controllers\Api\Area;

use App\Http\Controllers\Controller;
use App\Http\Resources\Area\AreaChildrenResource;
use App\Http\Resources\Area\AreaResource;
use App\Models\Area;
use App\Support\Api\ApiResponse;


class AreaController extends Controller
{
    use ApiResponse;

    protected function getArea()
    {
        $areas = Area::query()->with('areas')->where('active', 1)->get();
        $this->body['area'] = AreaResource::collection($areas);
        return self::apiResponse(200, t_('get areas'), $this->body);
    }
    protected function getChildren($id)
    {
        $areas = Area::query()->with('areas')->where('parent_id', $id)->where('active', 1)->get();
        if (!$areas){
            return self::apiResponse(200, t_('area not found'), $this->body);
        }
        $this->body['area'] = AreaChildrenResource::collection($areas);
        return self::apiResponse(200, t_('get children for this area'), $this->body);
    }

}
