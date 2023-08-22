<?php

namespace App\Datatables\Dashboard\Post;

use App\Models\Post;
use App\Support\Datatables\BaseDatatable;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;

class PostDatatable extends BaseDatatable
{
//    protected ?string $actionable = 'edit|delete';

    public function query(): Builder
    {
        return Post::query();
    }


    protected function getCustomColumns(): array
    {
        return [
            'title' => function ($model) {
                $title = $model->title;
                return view('components.datatable.title', compact('title'));
            },
            'created_at' => function ($model) {
                $title = $model->created_at;
                return view('components.datatable.title', compact('title'));
            },
        ];
    }

    protected function getColumns(): array
    {
        return [
            Column::computed('title')->title(t_('Title')),
            Column::computed('created_at')->title(t_('Created at')),
        ];
    }
}
