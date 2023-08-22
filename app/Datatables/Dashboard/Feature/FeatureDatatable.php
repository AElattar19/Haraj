<?php

namespace App\Datatables\Dashboard\Feature;

use App\Models\Area;
use App\Models\Feature;
use App\Support\Datatables\BaseDatatable;
use App\Support\Datatables\CustomFilters;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;

class FeatureDatatable extends BaseDatatable
{
    protected ?string $actionable = 'edit|delete';

    public function query(): Builder
    {
        return Feature::query();
    }

    protected function getActions($model): array
    {
        $viewRoute = route($this->route.'.index', ['id' => $model]);
        $action = [
            'view' => <<<HTML
                 <a href='$viewRoute' class="mr-2 btn btn-outline-success btn-sm"><i class="las la-eye la-2x "></i>  </a>

            HTML
            ,
        ];
        if (session('parentAreaId')) {
            $backRoute = route($this->route.'.index', ['id' => session('parentAreaId')]);
            $action['back'] = <<<HTML
                 <a href='$backRoute' class='mr-2 btn btn-outline-success btn-sm'><i class='las la-undo la-2x '></i>  </a>
            HTML;
        } elseif (request()->has('id')) {
            $backRoute = route($this->route.'.index');
            $action['back'] = <<<HTML
                 <a href='$backRoute' class='mr-2 btn btn-outline-success btn-sm'><i class='las la-undo la-2x '></i>  </a>
            HTML;
        }

        return $action;
    }

    protected function getCustomColumns(): array
    {
        return [
            'flag' => function ($model) {
                $image = $model->getFirstMediaUrl('flag');

                return view('components.datatable.image', compact('image'));
            },

            'active' => function ($model) {

                return view('components.datatable.active', ['active' => $model->active]);
            },
        ];
    }

    protected function getColumns(): array
    {
        return [
            $this->column('title.'.app()->getLocale(), __('Name')),
            Column::computed('flag')->title(t_('flag')),
            Column::computed('active')->title(t_('status')),
        ];
    }

    protected function getFilters(): array
    {
        return [
            'title.'.app()->getLocale() => CustomFilters::translated('title'),
        ];
    }
}
