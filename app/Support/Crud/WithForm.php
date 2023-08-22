<?php

namespace App\Support\Crud;

use Collective\Html\FormFacade;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

trait WithForm
{
    public function create(): View
    {
        return $this->formPage();
    }

    public function edit($id)
    {
         $model = ($this->model)::findOrFail($id);

        return $this->formPage(model: $model);
    }

    public function formPage(array $data = [], ?Model $model = null): View
    {
        $model && FormFacade::setModel($model);
        $data['model'] = $model;
        $data['route'] = $this->path;

        return view("{$this->path}.form", array_merge($this->formData($model), $data));
    }

    protected function formData(?Model $model = null): array
    {
        return [];
    }
}
