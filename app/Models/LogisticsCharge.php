<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogisticsCharge extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function project(): HasOne
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(LogisticsChargeItem::class, 'logistics_charge_id', 'id');
    }


    public static function datatable()
    {
        $LogisticsCharge = LogisticsCharge::with(['project'])->where('company_id', Auth::user()->company_id);

        return DataTables::eloquent($LogisticsCharge)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $btn = '<div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';

                if (Auth::user()->can('edit logistics charge')) {
                    $btn = $btn . '<a href="' . route('logisticCharge.edit', $row->id) . '" class="dropdown-item"><i class="fa fa-pencil" aria-hidden="true"></i>
                        Edit</a>';
                }

                if (Auth::user()->can('delete logistics charge')) {
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
