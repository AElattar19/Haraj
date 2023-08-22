<?php

namespace App\Support\Crud;

use Illuminate\Database\Eloquent\Model;

trait WithUpdate
{
    protected function updateAction(array $validated, Model $model)
    {
        $model->update($validated);

        return null;
    }

    public function update($id)
    {
        $model = ($this->model)::findOrFail($id);
        $validated = $this->validationAction();

        $action = $this->updateAction($validated, $model);

        return $action ?? $this->successfulRequest();
    }
}
