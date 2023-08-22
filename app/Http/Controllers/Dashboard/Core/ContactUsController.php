<?php

namespace App\Http\Controllers\Dashboard\Core;

use App\Datatables\Dashboard\Core\ContactsDatatable;
use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Support\Crud\WithCrud;

class ContactUsController extends Controller
{
    use WithCrud;

    protected string $path = 'dashboard.core.contacts';

    protected string $model = ContactUs::class;

    protected string $datatable = ContactsDatatable::class;

    public function show($id)
    {
        $contact = ContactUs::findOrFail($id);

        return view($this->path.'.show', ['contact' => $contact]);
    }
}
