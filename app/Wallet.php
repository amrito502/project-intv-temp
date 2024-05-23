<?php

namespace App;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Wallet extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "wallets";

    protected $guarded = [];



    public function from(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'from_id');
    }

    public function to(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'to_id');
    }


    public function ApprovedBy(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'approved_by');
    }


    public static function thisMonthSoldPackages()
    {
        // get current month start date and end date using carbon
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        // get sold package count
        $packageCount = Wallet::where('remarks', 'TeamBonus')
            ->where('pp', 100)
            ->whereBetween('created_at', [$startDate->format('Y-m-d') . " 00:00:00", $endDate->format('Y-m-d') . " 00:00:00"])
            ->count();


        return $packageCount;
    }


}
