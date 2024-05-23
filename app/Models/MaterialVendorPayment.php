<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialVendorPayment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function vendor(): HasOne
    {
        return $this->hasOne(Vendor::class, 'id', 'vendor_id');
    }

    public function project(): HasOne
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    public function tower(): HasOne
    {
        return $this->hasOne(ProjectTower::class, 'id', 'tower_id');
    }



    public function createdBy(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(MaterialVendorPaymentInvoice::class, 'material_vendor_payment_id', 'id');
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
        $payment = MaterialVendorPayment::with(['vendor', 'project', 'tower'])->GetRoleWiseAll();

        return DataTables::eloquent($payment)
            ->addIndexColumn()
            ->addColumn('vendor_name', function ($row) {
                return $row->vendor->name;
            })
            ->addColumn('project_name', function ($row) {
                return $row->project->project_name;
            })
            ->addColumn('tower_name', function ($row) {
                return $row->tower->name;
            })
            ->addColumn('action', function ($row) {

                $btn = '<div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';

                $btn = $btn . "<button type='button' onclick='deleteRowMaterial(" . $row->id . ")' class='dropdown-item'><i class='fa fa-trash' aria-hidden='true'></i> Delete</button>";
                // $btn = $btn . "<a href='". route('materialvendorpayment.print', $row->id) ."' class='dropdown-item'><i class='fa fa-print' aria-hidden='true'></i> Print</button>";

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
