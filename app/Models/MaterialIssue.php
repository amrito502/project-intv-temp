<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialIssue extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function totalQty()
    {
        $total_qty = 0;

        foreach ($this->issuedMaterials as $issuedMaterial) {
            $total_qty += $issuedMaterial->receive_qty;
        }

        return $total_qty;
    }

    public function totalAmount()
    {
        $total_qty = 0;

        foreach ($this->issuedMaterials as $issuedMaterial) {
            $total_qty += $issuedMaterial->receive_qty * $issuedMaterial->material->price();
        }

        return $total_qty;
    }

    public function issuedMaterials(): HasMany
    {
        return $this->hasMany(MaterialIssueItem::class, 'material_issue_id', 'id');
    }

    public function SourceProject(): HasOne
    {
        return $this->hasOne(Project::class, 'id', 'source_project_id');
    }

    public function project(): HasOne
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    public function unit(): HasOne
    {
        return $this->hasOne(Unit::class, 'id', 'unit_id');
    }

    public function tower(): HasOne
    {
        return $this->hasOne(ProjectTower::class, 'id', 'tower_id');
    }

    public static function datatable()
    {

        $materialissues = MaterialIssue::where('company_id', Auth::user()->company_id)
        ->with(['issuedMaterials', 'issuedMaterials.material', 'project'])
        ->orderBy('issue_date', 'desc');

        if (request()->project_id) {
            $materialissues = $materialissues->where('project_id', request()->project_id);
        }

        if (!Auth::user()->hasRole(['Software Admin', 'SuperAdmin', 'Company Admin'])) {
            $materialissues = $materialissues->whereIn('project_id', Auth::user()->userProjectIds());
        }


        return DataTables::eloquent($materialissues)
            ->addIndexColumn()
            ->addColumn('materials', function ($row) {

                $materials = '';

                foreach ($row->issuedMaterials as $issuedMaterial) {
                    $materials .= $issuedMaterial->material->name . ' (' . $issuedMaterial->material->materialUnit->name . ') - '. $issuedMaterial->material_qty . "<br>";
                }

                return rtrim($materials, ', ');

                // $materials = $row->issuedMaterials->map(function ($item) {
                //     return $item->material->name . '(' . $item->material_qty . ')';
                // })->implode(', ');

                // return $materials;

            })
            ->addColumn('source_project_name', function ($row) {
                return $row?->SourceProject?->project_name;
            })
            ->addColumn('issue_project_name', function ($row) {

                $project = $row?->project?->project_name;
                $tower = $row?->tower?->name;

                $output = $project;

                if ($tower) {
                    $output .= ' - ' . $tower;
                }

                return $output;
            })
            ->addColumn('vouchar_date_formatted', function ($row) {
                return date('d-m-Y', strtotime($row->issue_date));
            })
            ->addColumn('action', function ($row) {

                $btn = '<div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';

                if (Auth::user()->can('edit materialissue')) {
                    $btn = $btn . '<a href="' . route('materialissue.edit', $row->id) . '" class="dropdown-item"><i class="fa fa-pencil" aria-hidden="true"></i>
                        Edit</a>';
                }

                if (Auth::user()->can('print materialissue')) {
                    $btn = $btn . '<a href="' . route('materialissue.print', $row->id) . '" class="dropdown-item"><i class="fa fa-print" aria-hidden="true"></i>
                        Print</a>';
                }

                if (Auth::user()->can('delete materialissue')) {
                    $btn = $btn . "<button type='button' onclick='deleteRow(" . $row->id . ")' class='dropdown-item'><i class='fa fa-trash' aria-hidden='true'></i> Delete</button>";
                }

                $btn = $btn . '
                </div>
                </div>';

                return $btn;
            })
            ->rawColumns(['action', 'materials'])
            ->toJson();
    }

    public static function receiveDatatable()
    {

        $materialissues = MaterialIssue::where('company_id', Auth::user()->company_id)
            ->with(['issuedMaterials', 'issuedMaterials.material', 'issuedMaterials.material.materialUnit', 'project'])
            ->orderBy('issue_date', 'desc');


        if (!Auth::user()->hasRole(['Software Admin', 'SuperAdmin', 'Company Admin'])) {
            $materialissues = $materialissues->whereIn('project_id', Auth::user()->userProjectIds());
        }

        return DataTables::eloquent($materialissues)
            ->addIndexColumn()
            ->addColumn('project_name', function ($row) {
                return $row?->project?->project_name;
            })
            ->addColumn('vouchar_date_formatted', function ($row) {
                return date('d-m-Y', strtotime($row->issue_date));
            })
            ->addColumn('materials', function ($row) {

                $materials = '';

                foreach ($row->issuedMaterials as $issuedMaterial) {
                    $materials .= $issuedMaterial->material->name . ' (' . $issuedMaterial->material->materialUnit->name . ') - '. $issuedMaterial->material_qty . '<br>';
                }

                return rtrim($materials, ', ');
            })
            ->addColumn('action', function ($row) {

                $btn = '<div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';

                $btn = $btn . '<a href="' . route('material.receiveDetails', $row->id) . '" class="dropdown-item"> Receive</a>';

                $btn = $btn . '
                </div>
                </div>';

                if ($row->status == "Received") {
                    $btn = "";
                }

                return $btn;
            })
            ->rawColumns(['action', 'materials'])
            ->toJson();
    }
}
