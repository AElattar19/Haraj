<?php

namespace App\Support\Datatables;

use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

abstract class BaseDatatable extends DataTable
{
    protected string $route = '';

    protected ?string $actionable = 'edit|delete';

    protected bool $indexer = true;

    protected function getCustomColumns(): array
    {
        return [];
    }

    public function dataTable($query)
    {
        $datatable = datatables()->eloquent($query)->addIndexColumn();
        $customColumns = collect($this->prepareCustomColumns());

        $customColumns->each(fn (\Closure $i, $key) => $datatable->addColumn($key, $i));

        collect($this->getFilters())
            ->each(fn (\Closure $i, $key) => $datatable->filterColumn($key, $i));

        collect($this->getOrders())
            ->each(fn (\Closure $i, $key) => $datatable->orderColumn($key, $i));

        return $datatable->rawColumns($customColumns->keys()->all());
    }

    protected function getFilters(): array
    {
        return [];
    }

    protected function getActions($model): array
    {
        return [];
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $url = config('custom.FORCE_HTTPS') ?
            str_replace('http:', 'https:', secure_url(url()->full())) : url()->full();

        return $this->builder()
                    ->setTableId('base-table')
                    ->columns($this->prepareColumns())
                    ->orderBy(1)
                    ->minifiedAjax($url)
                    ->responsive()
                    ->language($this->translation())
                    ->fixedHeader(true)
                    ->dom('lfrtip')
                    ->pageLength();
    }

    private function translation(): array
    {
        return [
            'sEmptyTable'     => t_('no data available in table'),
            'sInfo'           => t_('Showing').' _START_ '.t_('to').' _END_ '.t_('of').' _TOTAL_ '.t_('records'),
            'sInfoEmpty'      => t_('Showing').' 0 '.t_('to').' 0 '.t_('of').' 0 '.t_('records'),
            'sInfoFiltered'   => '('.t_('filtered').' '.t_('from').' _MAX_ '.t_('total').' '.t_('records').')',
            'sInfoPostFix'    => '',
            'sInfoThousands'  => ',',
            'sLengthMenu'     => t_('show').' _MENU_ '.t_('records'),
            'sLoadingRecords' => t_('loading...'),
            'sProcessing'     => t_('processing...'),
            'sSearch'         => t_('search').' : ',
            'sZeroRecords'    => t_('no matching records found'),
            'oPaginate'       => [
                'sFirst'    => t_('first'),
                'sLast'     => t_('last'),
                'sNext'     => t_('next'),
                'sPrevious' => t_('previous'),
            ],
        ];
    }

    public function getIndex()
    {
        $indexColumn = $this->builder()->config->get('datatables.index_column', 'DT_RowIndex');

        return new Column([
            'data'       => $indexColumn,
            'name'       => $indexColumn,
            'title'      => '#',
            'orderable'  => false,
            'searchable' => false,
        ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [];
    }

    protected function column(string $name, string $title, $searchable = true): Column
    {
        return Column::make($name)
                     ->title($title)
                     ->orderable(false)
                     ->searchable($searchable)
                     ->content('---');
    }

    protected function getOrders()
    {
        return [];
    }

    private function prepareColumns()
    {
        $list = [];

        if ($this->indexer) {
            $list[] = $this->getIndex();
        }

        $list = array_merge($list, $this->getColumns());

        if ($this->actionable !== '') {
            $list[] = Column::computed('action')
                            ->title(t_('Actions'))
                            ->searchable(false)
                            ->exportable(false)
                            ->printable(false)
                            ->width(50)
                            ->addClass('text-center');
        }

        return $list;
    }

    public static function create(string $route): static
    {
        $instance = new static();
        $instance->route = $route;

        return $instance;
    }

    private function prepareCustomColumns()
    {
        $customs = $this->getCustomColumns();

        if ($this->actionable !== '') {
            $customs['action'] = function ($model) {
                $allActions = array_merge(
                    $this->getActions($model), $this->prepareActionsButtons($model)
                );
                $actions = implode('', $allActions);

                return "<div class='btn-group'>{$actions}</div>";
            };
        }

        return $customs;
    }

    private function prepareActionsButtons($model)
    {
        $currentActions = explode('|', $this->actionable);
        $actions = [];

        if (in_array('show', $currentActions)) {
            $editRoute = route($this->route.'.show', $model);
            $actions[] = <<<HTML
                 <a href='$editRoute' class="mr-2 btn btn-outline-success btn-sm"><i class="las la-eye la-2x "></i>  </a>
            HTML;
        }

        if (in_array('edit', $currentActions)) {
            $editRoute = route($this->route.'.edit', $model);
            $actions[] = <<<HTML
                 <a href='$editRoute' class="mr-2 btn btn-outline-warning btn-sm"><i class="las la-edit la-2x"></i> </a>
            HTML;
        }

        if (in_array('delete', $currentActions)) {
            $actions[] = <<<HTML
                      <a href='javascript:;' data-id='{$model->getKey()}' class="mr-2 btn btn-outline-danger btn-delete btn-sm"> 
                            <i class="las la-trash la-2x"></i> 
                      </a>
            HTML;
        }

        return $actions;
    }
}
