<?php

namespace App\Support\Crud;

trait WithCrud
{
    use WithDatatable, WithForm, WithStore, WithUpdate, WithDestroy;
}
