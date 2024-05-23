<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialVendorPaymentInvoice extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'material_vendor_payment_invoices';


    public function materialLifting(): HasOne
    {
        return $this->hasOne(MaterialLifting::class, 'id', 'lifting_id');
    }
}
