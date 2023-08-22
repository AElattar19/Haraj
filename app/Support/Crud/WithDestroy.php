<?php

namespace App\Support\Crud;

use Illuminate\Database\Eloquent\Model;

trait WithDestroy
{
    protected function destroyAction(Model $model)
    {
        $model->delete();

        return null;
    }

    public function destroy($id)
    {
        $model = ($this->model)::findOrFail($id);
        $action = $this->destroyAction($model);

        return $action ?? $this->successfulRequest(asJson: true);
    }
}
