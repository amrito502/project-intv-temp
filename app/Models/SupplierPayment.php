<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplierPayment extends Model
{
    use HasFactory;
    protected $guarded = [];

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

    public function item(): HasMany
    {
        return $this->hasMany(SupplierPaymentItem::class, 'supplier_payment_id', 'id');
    }

    public function paymentTotal()
    {
        $total = 0;

        foreach($this->item as $item){
            $total += $item->amount;
        }


        return $total;
    }

    public static function datatable()
    {

        $supplierPayment = SupplierPayment::where('company_id', Auth::user()->company_id)->with(['project']);

        return DataTables::eloquent($supplierPayment)
            ->addIndexColumn()
            ->addColumn('project_name', function ($row) {
                return $row->project?->project_name;
            })
            ->addColumn('payment_amount', function ($row) {
                return $row->paymentTotal();
            })
            ->addColumn('action', function ($row) {

                $btn = '<div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';

                if (Auth::user()->can('edit supplierpayment')) {
                    $btn = $btn . '<a href="' . route('supplierpayment.edit', $row->id) . '" class="dropdown-item"><i class="fa fa-pencil" aria-hidden="true"></i>
                        Edit</a>';
                }

                $btn = $btn . '
                </div>
                </div>';

                return $btn;
            })
            ->toJson();
    }
}
