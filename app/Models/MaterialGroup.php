<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialGroup extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function datatable()
    {
        $materialgroup = MaterialGroup::where('company_id', Auth::user()->company_id);

        return DataTables::eloquent($materialgroup)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $btn = '<div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';

                if (Auth::user()->can('edit material group')) {
                    $btn = $btn . '<a href="' . route('materialgroup.edit', $row->id) . '" class="dropdown-item"><i class="fa fa-pencil" aria-hidden="true"></i>
                        Edit</a>';
                }

                if (Auth::user()->can('delete material group')) {
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