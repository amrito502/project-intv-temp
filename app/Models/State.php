<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class State extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the country that owns the State
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
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
        $state = State::query();

        return DataTables::eloquent($state)
            ->addIndexColumn()
            ->addColumn('country', function ($row) {
                $country = Country::findOrFail($row->country_id);

                return $country->name;
            })
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

                if (Auth::user()->can('status state')) {
                    return $slide_button;
                }
                return "";
            })

            ->addColumn('action', function ($row) {

                $btn = "";

                if (Auth::user()->can('view state')) {
                    $btn = $btn . '<a href="' . route('state.show', $row->id) . '" class="edit btn btn-info btn-sm m-1"><i class="fa fa-eye" aria-hidden="true"></i>
                        View</a> &nbsp;';
                }

                if (Auth::user()->can('edit state')) {
                    $btn = $btn . '<a href="' . route('state.edit', $row->id) . '" class="edit btn btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i>
                                Edit</a> &nbsp;';
                }

                if (Auth::user()->can('delete state')) {
                    $btn = $btn . "<button type='button' onclick='deleteRow(" . $row->id . ")' class='edit btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i>Delete</button>";
                }


                return $btn;
            })
            ->rawColumns(['status_ui', 'action'])
            ->toJson();
    }
}
