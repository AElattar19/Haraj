<?php

namespace App\Http\Controllers\Dashboard\Core\Administration;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Administration\AdminRequest;
use Collective\Html\FormFacade;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class AdminProfileController extends Controller
{
    protected string $path = 'dashboard.core.administration.admins';

    public function index(): View
    {
        FormFacade::setModel(auth()->user());

        return view("{$this->path}.profile");
    }

    public function update(AdminRequest $request)
    {

        $validated = $request->validated();

        $model = Auth::user();
        $model->update($validated);
        $avatar = Arr::pull($validated, 'avatar');

        $avatar && uploadImage('avatar', $avatar, $model);

        toast(t_('Updated Successfully'), 'success');

        return redirect()->route('dashboard.home');
    }
}
