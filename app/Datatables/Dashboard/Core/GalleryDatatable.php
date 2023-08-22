<?php

namespace App\Datatables\Dashboard\Core;

use App\Models\Gallery;
use App\Support\Datatables\BaseDatatable;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;

class GalleryDatatable extends BaseDatatable
{
    public function query(): Builder
    {
        return Gallery::query();
    }

    protected function getCustomColumns(): array
    {
        return [
            'title'       => function ($model) {
                $title = $model->title;

                return view('components.datatable.title', compact('title'));
            },

        ];
    }

    protected function getColumns(): array
    {
        return [

            Column::computed('title')->title(t_('Title')),

        ];
    }
}
