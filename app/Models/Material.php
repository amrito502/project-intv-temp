<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use App\Models\MaterialLiftingMaterial;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function price(){

        // get logged in company id
        $company_id = Auth::user()->company_id;

        // get company id wise lifting ids
        $lifting_ids = MaterialLifting::where('company_id', $company_id)->pluck('id');

        $allLiftingsAvg = MaterialLiftingMaterial::whereIn('material_lifting_id', $lifting_ids)->where('material_id', $this->id)->avg('material_rate');

        return $allLiftingsAvg;

    }

    public function materialUnit(): HasOne
    {
        return $this->hasOne(MaterialUnit::class, 'id', 'unit');
    }

    public function budgetheadInfo()
    {
        return BudgetHead::where('name', $this->name)->first();
    }

    public function ScopeGetRoleWiseAll($query)
    {
        if(Auth::user()->hasRole('Software Admin')){
            return $query;
        }else{
            return $query->where('company_id', Auth::user()->company_id)->orWhere('company_id', 0);
        }
    }

    public static function datatable()
    {
        $material = Material::where('company_id', Auth::user()->company_id)->orWhere('company_id', 0)->with(['materialUnit']);

        return DataTables::eloquent($material)
            ->addIndexColumn()
            ->addColumn('uom', function ($row) {
                return $row->materialUnit->name;
            })
            ->addColumn('remarks', function ($row) {

                $remarks = '';

                if($row->show_dashboard == 1){
                    $remarks .= 'Show in Dashboard,';
                }

                if($row->transportation_charge == 1){
                    $remarks .= ' Transportation Charge,';
                }

                if($row->budgetheadInfo()){
                    $remarks .= ' In BudgetHead';
                }

                return $remarks;

            })
            ->addColumn('action', function ($row) {

                $btn = '<div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';

                if (Auth::user()->can('edit material')) {
                    $btn = $btn . '<a href="' . route('material.edit', $row->id) . '" class="dropdown-item"><i class="fa fa-pencil" aria-hidden="true"></i>
                        Edit</a>';
                }

                if (Auth::user()->can('delete material')) {
                    $btn = $btn . "<button type='button' onclick='deleteRow(" . $row->id . ")' class='dropdown-item'><i class='fa fa-trash' aria-hidden='true'></i> Delete</button>";
                }

                $btn = $btn . '
                </div>
                </div>';

                if($row->company_id == 0){
                    return "";
                }

                return $btn;
            })
            ->toJson();
    }

}
