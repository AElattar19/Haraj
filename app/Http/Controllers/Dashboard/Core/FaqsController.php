<?php

namespace App\Http\Controllers\Dashboard\Core;

use App\Datatables\Dashboard\Core\FaqsDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Core\FaqRequest;
use App\Models\Faq;
use App\Support\Crud\WithCrud;
use Illuminate\Support\Arr;

class FaqsController extends Controller
{
    use WithCrud;

    protected string $path = 'dashboard.core.faqs';

    protected string $model = Faq::class;

    protected string $datatable = FaqsDatatable::class;

    protected function validationAction(): array
    {
        return app(FaqRequest::class)->validated();
    }
}
