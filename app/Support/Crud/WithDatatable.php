<?php

namespace App\Support\Crud;

trait WithDatatable
{
    public function index()
    {
        return $this->datatable::create($this->path)->render("{$this->path}.index", [
            'route' => $this->path,
        ]);
    }
}
