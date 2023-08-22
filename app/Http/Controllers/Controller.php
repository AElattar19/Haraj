<?php

namespace App\Http\Controllers;

use App\Support\Api\ApiResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ApiResponse;

    protected string $path;

    protected string $model;

    protected string $datatable;

    protected int $code = 400;

    protected string $message = '';

    protected string $info = '';

    protected array $body = [];

    protected int $per_page = 10;

    protected int $page = 1;

    protected bool $pagination = true;

    /**
     * @description List of rules to validate the incoming requests
     *
     * @return array
     */
    protected function rules()
    {
        return [];
    }

    public function successfulRequest(
        ?string $route = null,
        ?array $routeParams = [],
        bool $asJson = false
    ): RedirectResponse|JsonResponse {

        if ($asJson) {
            return response()->json([
                'status'  => true,
                'message' => t_('Request executed successfully'),
            ]);
        }
        toast(t_('Request executed successfully'), 'success');

        return redirect()->route($route ?: "{$this->path}.index", $routeParams);
    }

    protected function validationAction(): array
    {

        return request()->validate($this->rules());
    }

    protected function queryBuilder(): Builder
    {
        return ($this->model)::query();
    }

    public function validation(Request $request)
    {
        $class = $request->class;
        $class = str_replace('.', '\\', $class);
        $my_request = new $class();
        $validator = Validator::make($request->all(), $my_request->rules(), $my_request->messages(), ['method' => $request->getMethod()]);

        $validator->setAttributeNames($my_request->attributes());
        if ($request->ajax()) {
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->getMessageBag()->toArray(),
                ]);
            }

            return response()->json([
                'status' => true,
            ]);
        }
    }
}
