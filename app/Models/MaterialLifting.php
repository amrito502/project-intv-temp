<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialLifting extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function vendor(): HasOne
    {
        return $this->hasOne(Vendor::class, 'id', 'vendor_id');
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

    public function liftingMaterials(): HasMany
    {
        return $this->hasMany(MaterialLiftingMaterial::class, 'material_lifting_id', 'id');
    }

    public function item(): HasMany
    {
        return $this->hasMany(MaterialLiftingMaterial::class, 'material_lifting_id', 'id');
    }

    public function totalQty()
    {
        $total_qty = 0;

        foreach ($this->liftingMaterials as $liftingMaterial) {
            $total_qty += $liftingMaterial->material_qty;
        }

        return $total_qty;
    }

    public function totalAmount()
    {
        $total_amount = 0;

        foreach ($this->liftingMaterials as $liftingMaterial) {
            $total_amount += $liftingMaterial->material_qty * $liftingMaterial->material_rate;
        }

        return round($total_amount, 2);
    }

    public static function datatable()
    {

        $materialliftings = MaterialLifting::where(function ($q) {
            $q->where('company_id', Auth::user()->company_id)
                ->orWhere('company_id', 0);
        })->with(['vendor', 'liftingMaterials', 'liftingMaterials.material'])->orderBy('id', 'desc');

        if (request()->project_id) {
            $materialliftings = $materialliftings->where('project_id', request()->project_id);
        }

        if (!Auth::user()->hasRole(['Software Admin', 'SuperAdmin', 'Company Admin'])) {
            $materialliftings = $materialliftings->whereIn('project_id', Auth::user()->userProjectIds());
        }

        return DataTables::eloquent($materialliftings)
            ->addIndexColumn()
            ->addColumn('vendor_name', function ($row) {
                $vendorName = $row?->vendor?->name;

                if(!$vendorName){
                    $vendorName = $row->lifting_type;
                }

                return $vendorName;
            })
            ->addColumn('materials', function ($row) {

                $materials = '';

                foreach ($row->liftingMaterials as $liftingMaterial) {
                    $materials .= $liftingMaterial?->material?->name . ' (' . $liftingMaterial?->material?->materialUnit?->name . ') - '. $liftingMaterial->material_qty .' <br>';
                }

                return $materials;
            })
            ->addColumn('vouchar_date_formatted', function ($row) {
                return date('d-m-Y', strtotime($row->vouchar_date));
            })
            ->addColumn('total_amount', function ($row) {
                $total_amount = $row->totalAmount();

                return $total_amount;
            })
            ->addColumn('action', function ($row) {

                $btn = '<div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';

                if (Auth::user()->can('edit materiallifting')) {
                    $btn = $btn . '<a href="' . route('materiallifting.edit', $row->id) . '" class="dropdown-item"><i class="fa fa-pencil" aria-hidden="true"></i>
                        Edit</a>';
                }

                if (Auth::user()->can('print materiallifting')) {
                    $btn = $btn . '<a href="' . route('materiallifting.print', $row->id) . '" class="dropdown-item"><i class="fa fa-print" aria-hidden="true"></i>
                        Print</a>';
                }

                if (Auth::user()->can('delete materiallifting')) {
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
}
