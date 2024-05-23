<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function state(): HasMany
    {
        return $this->hasMany(State::class, 'country_id', 'id');
    }

    public function ScopeEnabled($query)
    {
        return $query->where('status', 1);
    }


    public function toggleStatus()
    {
        if ($this->status) {
            $this->status = False;
        } else {
            $this->status = True;
        }

        $this->save();
    }

    public static function dataTableAjax()
    {
        $country = Country::query();

        return DataTables::eloquent($country)
            ->addIndexColumn()
            ->addColumn('status_ui', function ($row) {
                $status = $row->status;
                $checked = "";

                if ($status) {
                    $checked = "checked";
                }

                $slide_button = '<div class="toggle">
                  <label>
                    <input onclick="toggleStatus(' . $row->id . ')" type="checkbox" ' . $checked . '><span class="button-indecator"></span>
                  </label>
                </div>';

                if (Auth::user()->can('status country')) {
                    return $slide_button;
                }
                return "";
            })

            ->addColumn('action', function ($row) {

                $btn = "";

                if (Auth::user()->can('view country')) {
                    $btn = $btn . '<a href="' . route('country.show', $row->id) . '" class="edit btn btn-info btn-sm m-1"><i class="fa fa-eye" aria-hidden="true"></i>
                        View</a> &nbsp;';
                }

                if (Auth::user()->can('edit country')) {
                    $btn = $btn . '<a href="' . route('country.edit', $row->id) . '" class="edit btn btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i>
                                Edit</a> &nbsp;';
                }

                if (Auth::user()->can('delete country')) {
                    $btn = $btn . "<button type='button' onclick='deleteRow(" . $row->id . ")' class='edit btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i>Delete</button>";
                }


                return $btn;
            })
            ->rawColumns(['status_ui', 'action'])
            ->toJson();
    }
}
