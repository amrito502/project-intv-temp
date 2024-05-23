<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailyUses extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function createdBy(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by');
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

    public function items(): HasMany
    {
        return $this->hasMany(DailyUseItems::class, 'daily_use_id', 'id');
    }


    public function grandTotalUseQty()
    {
        $total = 0;

        if($this->items){

            foreach ($this->items as $item) {
                $total += $item->use_qty;
            }
        }

        return $total;
    }

    public function grandTotalUseAmount()
    {
        $total = 0;

        if($this->items){

            foreach ($this->items as $item) {
                $total += $item->use_qty * $item?->budgetHead?->materialInfo()?->price();
            }
        }

        return $total;
    }


    public static function datatable()
    {

        $branch = DailyUses::where('company_id', Auth::user()->company_id)->with(['project', 'unit', 'tower'])->orderBy('date', 'desc');

        if(request()->project_id){
            $branch = $branch->where('project_id', request()->project_id);
        }

        if (!Auth::user()->hasRole(['Software Admin', 'SuperAdmin', 'Company Admin'])) {
            $branch = $branch->whereIn('project_id', Auth::user()->userProjectIds());
        }

        return DataTables::eloquent($branch)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $btn = '<div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';

                if (Auth::user()->can('edit daily use')) {
                    $btn = $btn . '<a href="' . route('dailyuses.edit', $row->id) . '" class="dropdown-item"><i class="fa fa-pencil" aria-hidden="true"></i>
                        Edit</a>';
                }

                if (Auth::user()->can('print daily use')) {
                    $btn = $btn . '<a target="_blank" href="' . route('dailyuses.print', $row->id) . '" class="dropdown-item"><i class="fa fa-print" aria-hidden="true"></i>
                        Print</a>';
                }

                if (Auth::user()->can('delete daily use')) {
                    $btn = $btn . "<button type='button' onclick='deleteRow(" . $row->id . ")' class='dropdown-item'><i class='fa fa-trash' aria-hidden='true'></i> Delete</button>";
                }

                $btn = $btn . '
                </div>
                </div>';

                return $btn;
            })
            ->addColumn('project_name', function ($row) {
                return $row->project?->project_name;
            })
            ->addColumn('unit_name', function ($row) {
                return $row->unit?->name;
            })
            ->addColumn('tower_name', function ($row) {
                return $row->tower?->name;
            })
            ->addColumn('material_list', function ($row) {
                $html = '';
                foreach ($row->items as $item) {

                    if($item->budgetHead){
                        $html = $html . '<p>' . $item->budgetHead->name . ' (' . $item->budgetHead->materialInfo()->materialUnit->name . ') - ' . $item->use_qty . '</p>';
                    }
                }

                return $html;
            })
            ->addColumn('date', function ($row) {
                return date('d-m-Y', strtotime($row->date));
            })
            ->rawColumns(['action', 'material_list'])
            ->toJson();
    }

}
