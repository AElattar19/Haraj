<?php

namespace App\Datatables\Dashboard\Core;

use App\Models\Category;
use App\Support\Datatables\BaseDatatable;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;

class CategoryDataTable extends BaseDatatable
{
    protected ?string $actionable = 'delete|edit';

    public function query(): Builder
    {
        $query = Category::query();
        $query->when(!request('id'), function ($query) {
            $query->whereNull('parent_id');
        });
        $query->when(request('id'), function ($query) {
            $cat = Category::query()->find(request('id'));
            $query->where('parent_id', $cat?->id);
        });
        return $query;
    }

    protected function getCustomColumns(): array
    {
        return [

            'title' => function ($model) {
                $title = $model->title;

                return view('components.datatable.title', compact('title'));
            },

            'active' => function ($model) {

                return view('components.datatable.active', ['active' => $model->active]);
            },
        ];
    }

    protected function getColumns(): array
    {
        return [

            Column::computed('title')->title(t_('Title')),
            Column::computed('active')->title(t_('Status')),
        ];
    }

    protected function getActions($model): array
    {
        $action = [
        ];
        $backRoute = route($this->route . '.index', ['id' => $model]);
        $action['view'] = <<<HTML
                 <a href='$backRoute' class="mr-2 btn btn-outline-success btn-sm"><i class="las la-plus la-2x "></i>  </a>
            HTML;
        return $action;
    }
}
