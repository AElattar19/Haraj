<?php

namespace App\Http\Controllers\Dashboard\Core;

use App\Datatables\Dashboard\Core\AreaDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Core\AreaRequest;
use App\Models\Area;
use App\Support\Crud\WithDestroy;
use App\Support\Crud\WithForm;
use App\Support\Crud\WithStore;
use App\Support\Crud\WithUpdate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class AreaController extends Controller
{
    use  WithForm, WithStore, WithUpdate, WithDestroy;

    protected string $path = 'dashboard.core.areas';

    protected string $datatable = AreaDatatable::class;

    protected string $model = Area::class;

    public function index()
    {
        $area = $this->model::find(request('id'));
        $this->handleDatatableBackAction($area);

        return $this->datatable::create($this->path)->render("{$this->path}.index", [
            'route' => $this->path,
            'title' => "{$this->areaLevelName($area ? $area->level + 1 : 0)} $area?->title",
        ]);
    }

    protected function storeAction(array $validated)
    {
        $flag = Arr::pull($validated, 'flag');
        $area = $this->model::find($validated['parent_id']);
        $validated['level'] = $area ? $area->level + 1 : 0;
        $area = $this->queryBuilder()->create($validated);
        $flag && uploadImage('flag', $flag, $area);

        return $this->successfulRequest("{$this->path}.index", ['id' => $validated['parent_id']]);
    }

    protected function updateAction(array $validated, Model $model)
    {
        $flag = Arr::pull($validated, 'flag');
        $model->update($validated);
        $flag && uploadImage('flag', $flag, $model);

        return $this->successfulRequest("{$this->path}.index", ['id' => $validated['parent_id']]);
    }

    protected function validationAction(): array
    {
        return app(AreaRequest::class)->validated();
    }

    protected function formData(?Model $model = null): array
    {
        $area = $this->model::find(request('id'));

        return [
            'title'     => $this->areaLevelName($area ? $area->level + 1 : 0),
            'parent_id' => $area?->id,
        ];
    }

    private function areaLevelName($level_number)
    {

        return [
            $level_number => t_('unknown'),
            0             => t_('Country'),
            1             => t_('Governorates'),
            2             => t_('Cities'),
            3             => t_('Regions'),
            4             => t_('Districts'),
            5             => t_('streets'),
        ][$level_number];
    }

    private function handleDatatableBackAction($area)
    {
        session()->forget('parentAreaId');
        if ($area?->parent_id) {
            session()->put('parentAreaId', $area->parent_id);
        }
    }
}
