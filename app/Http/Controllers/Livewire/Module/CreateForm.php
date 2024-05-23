<?php

namespace App\Http\Livewire\Module;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Helper\Ui\FlashMessageGenerator;
use Spatie\Permission\Models\Permission;

class CreateForm extends Component
{

    public $module;

    protected $rules = [
        'module.name' => 'required|unique:permissions,name',
    ];

    public function save()
    {

        if (!Auth::user()->can('create module')) {
            return redirect(route('home'));
        }

        $this->validate();

        // save
        Permission::create([
            'name' => $this->module['name'],
        ]);

        FlashMessageGenerator::generate('primary', 'Module Successfully Added');

        return redirect(route('module.index'));

    }

    public function render()
    {
        return view('livewire.module.create-form');
    }
}
