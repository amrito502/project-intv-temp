<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailyExpense extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "daily_expenses";

    public function items(): HasMany
    {
        return $this->hasMany(DailyExpenseItem::class, 'daily_expense_id', 'id');
    }

    public function project(): HasOne
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    public function unit(): HasOne
    {
        return $this->hasOne(Unit::class, 'id', 'unit_config_id');
    }

    public function tower(): HasOne
    {
        return $this->hasOne(ProjectTower::class, 'id', 'tower_id');
    }

    public function createdby(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function thisSerial()
    {
        return date('dmY') . $this->id;
    }

    public static function nextSerial()
    {
        $cr = self::latest()->first();
        $lastRow = 0;
        if ($cr) {
            $lastRow = $cr->id;
        }
        return date('dmY') . $lastRow + 1;
    }

    public function TotalAmount()
    {
        $total = 0;

        foreach ($this->items as $item) {
            $total += $item->amount;
        }

        return $total;
    }

    public static function datatable()
    {

        $dailyexpenses = self::where('company_id', Auth::user()->company_id)->with(['project', 'unit', 'tower', 'unit']);

        if (!Auth::user()->hasRole(['Software Admin', 'SuperAdmin', 'Company Admin'])) {
            $dailyexpenses = $dailyexpenses->whereIn('project_id', Auth::user()->userProjectIds());
        }

        return DataTables::eloquent($dailyexpenses)
            ->addIndexColumn()
            ->addColumn('date_formatted', function ($row) {
                return date('d-m-Y', strtotime($row->date));
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
            ->addColumn('expense_list', function ($row) {
                $list = "";

                foreach ($row->items as $item) {
                    $list .= $item->budgethead->name . " - " . $item->amount . "<br>";
                }

                return $list;

            })
            ->addColumn('action', function ($row) {

                $btn = '<div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';

                if (Auth::user()->can('edit dailyexpense')) {
                    $btn = $btn . '<a href="' . route('dailyexpense.edit', $row->id) . '" class="dropdown-item"><i class="fa fa-pencil" aria-hidden="true"></i>
                        Edit</a>';
                }

                if (Auth::user()->can('delete dailyexpense')) {
                    $btn = $btn . "<button type='button' onclick='deleteRow(" . $row->id . ")' class='dropdown-item'><i class='fa fa-trash' aria-hidden='true'></i> Delete</button>";
                }

                $btn = $btn . '<a href="' . route('dailyexpense.print', $row->id) . '" class="dropdown-item"><i class="fa fa-print" aria-hidden="true"></i>
                        Print</a>';

                $btn = $btn . '
                </div>
                </div>';

                return $btn;
            })
            ->rawColumns(['action', 'expense_list'])
            ->toJson();
    }
}
