<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function ScopeGetRoleWiseAll($query)
    {
        if(Auth::user()->hasRole('Software Admin')){
            return $query;
        }else{
            return $query->where('company_id', Auth::user()->company_id);
        }
    }

    public static function datatable()
    {

        $branch = Branch::where('company_id', Auth::user()->company_id);

        if (!Auth::user()->hasRole(['Software Admin', 'SuperAdmin', 'Company Admin'])) {
            $branch = $branch->whereIn('id', Auth::user()->userBranches->pluck('branch_id')->toArray());
        }

        return DataTables::eloquent($branch)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $btn = '<div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';

                if (Auth::user()->can('edit branch')) {
                    $btn = $btn . '<a href="' . route('branch.edit', $row->id) . '" class="dropdown-item"><i class="fa fa-pencil" aria-hidden="true"></i>
                        Edit</a>';
                }

                if (Auth::user()->can('delete branch')) {
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
