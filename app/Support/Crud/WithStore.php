<?php

namespace App\Support\Crud;

trait WithStore
{
    protected function storeAction(array $validated)
    {

        ($this->model)::create($validated);

        return null;
    }

    public function store()
    {

        $validated = $this->validationAction();
        $action = $this->storeAction($validated);

        return $action ?? $this->successfulRequest();
    }
}
