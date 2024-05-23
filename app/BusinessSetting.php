<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessSetting extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function transferChargeOf($transferAmount)
    {

        // if charge type is fixed
        if ($this->transfer_type === 'Fixed') {
            return $this->withdraw_charge;
        }

        // if charge type is percentage
        $transfer_charge = $this->transfer_charge;

        $transferChargeAmount = ($transferAmount / 100) * $transfer_charge;

        return $transferChargeAmount;

    }


    public function withdrawChargeOf($withdrawAmount)
    {

        // if charge type is fixed
        if ($this->withdraw_type === 'Fixed') {
            return $this->withdraw_charge;
        }

        // if charge type is percentage
        $withdraw_charge = $this->withdraw_charge;

        $withdrawChargeAmount = ($withdrawAmount / 100) * $withdraw_charge;

        return $withdrawChargeAmount;
    }


}
