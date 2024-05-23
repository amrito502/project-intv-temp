<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnitConfiguration extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function unit(): HasOne
    {
        return $this->hasOne(Unit::class, 'id', 'unit_id');
    }

    public function project(): HasOne
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    public static function datatable()
    {

        $unitconfiguration = UnitConfiguration::where('company_id', Auth::user()->company_id)
        ->with(['unit', 'project'])
        ->orderBy('project_id')
        ->orderBy('unit_id');

        if(request()->project_id){
            $unitconfiguration = $unitconfiguration->where('project_id', request()->project_id);
        }

        if (!Auth::user()->hasRole(['Software Admin', 'SuperAdmin', 'Company Admin'])) {
            $unitconfiguration = $unitconfiguration->whereIn('project_id', Auth::user()->userProjectIds());
        }

        return DataTables::eloquent($unitconfiguration)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $btn = '<div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';

                if (Auth::user()->can('edit unitconfiguration')) {
                    $btn = $btn . '<a href="' . route('unitconfiguration.edit', $row->id) . '" class="dropdown-item"><i class="fa fa-pencil" aria-hidden="true"></i>
                        Edit</a>';
                }

                if (Auth::user()->can('delete unitconfiguration')) {
                    $btn = $btn . "<button type='button' onclick='deleteRow(" . $row->id . ")' class='dropdown-item'><i class='fa fa-trash' aria-hidden='true'></i> Delete</button>";
                }

                $btn = $btn . '
                </div>
                </div>';

                return $btn;
            })
            ->toJson();
    }
}
