<?php

namespace App\Datatables\Dashboard\User;

use App\Models\Contact;
use App\Support\Datatables\BaseDatatable;
use Illuminate\Database\Eloquent\Builder;

class ContactDatatable extends BaseDatatable
{
    public function query(): Builder
    {
        return Contact::with('user')->orderBy('id', 'DESC')->withoutGlobalScopes();
    }

    protected function getColumns(): array
    {
        return [
            $this->column('user.name', t_('User')),
            $this->column('name', t_('Name')),
            $this->column('phone', t_('Phone')),
            $this->column('email', t_('Email')),

            $this->column('created_at', t_('Created At')),
            $this->column('updated_at', t_('updated At')),
        ];
    }

    protected function getCustomColumns(): array
    {
        return [
            'description' => function ($model) {
                $description = $model->description;

                return view('components.datatable._description', compact('description'));
            },
            'created_at'  => function ($model) {
                return $model->created_at->format('d, F, Y');
            },

            'updated_at' => function ($model) {
                return $model->updated_at->diffForHumans();
            },
        ];
    }
}
