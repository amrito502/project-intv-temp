<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BudgetHead extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function project(): HasOne
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    public function materialInfo()
    {
        return Material::where('name', $this->name)->with(['materialUnit'])->first();
    }


    public function ScopeGetRoleWiseAll($query)
    {
        if (Auth::user()->hasRole('Software Admin')) {
            return $query;
        } else {
            return $query->where(function ($query) {
                $query->where('company_id', Auth::user()->company_id)
                    ->orWhere('company_id', 0);
            });
        }
    }

    public static function datatable()
    {
        $budgethead = BudgetHead::where('company_id', Auth::user()->company_id)->orWhere('company_id', 0)->orderBy('type');

        return DataTables::eloquent($budgethead)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $btn = '<div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';

                if (Auth::user()->can('edit budgethead')) {
                    $btn = $btn . '<a href="' . route('budgethead.edit', $row->id) . '" class="dropdown-item"><i class="fa fa-pencil" aria-hidden="true"></i>
                        Edit</a>';
                }

                if (Auth::user()->can('delete budgethead')) {
                    $btn = $btn . "<button type='button' onclick='deleteRow(" . $row->id . ")' class='dropdown-item'><i class='fa fa-trash' aria-hidden='true'></i> Delete</button>";
                }

                $btn = $btn . '
                </div>
                </div>';

                if ($row->company_id == 0) {
                    return "";
                }

                return $btn;
            })
            ->toJson();
    }
}
