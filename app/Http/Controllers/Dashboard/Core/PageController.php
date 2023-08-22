<?php

namespace App\Http\Controllers\Dashboard\Core;

use App\Datatables\Dashboard\Core\PagesDatatable;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Support\Crud\WithCrud;

class PageController extends Controller
{
    use WithCrud;

    protected string $path = 'dashboard.core.pages';

    protected string $model = Page::class;

    protected string $datatable = PagesDatatable::class;

    protected function rules()
    {
        return ['body.*' => 'required'];
    }
}
