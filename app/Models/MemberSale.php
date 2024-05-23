<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberSale extends Model
{

    use HasFactory;

    protected $table = 'member_sales';
    protected $guarded = [];


    public function items()
    {
        return $this->hasMany(MemberSaleItem::class, 'member_sale_id', 'id');
    }

    public function dealer()
    {
        return $this->hasOne(User::class, 'id', 'store_id');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }


    public function invoiceTotalAmount()
    {
        $total = $this->items->sum('item_price');

        return $total;
    }


    public function invoiceTotalPP()
    {
        $total = $this->items->sum('pp');

        return $total;
    }


    public function invoiceTotalItemQty()
    {
        $total = $this->items->sum('item_quantity');

        return $total;
    }

    public static function totalInvoiceTotalPP()
    {
        $totalMemberSalePP = 0;

        $memberSales = self::where('status', 1)->get();

        foreach ($memberSales as $memberSale) {
            $totalMemberSalePP += $memberSale->invoiceTotalPP();
        }

        return $totalMemberSalePP;
    }

    public static function totalInvoiceTotalPPByDate($startDate, $endDate)
    {
        $totalMemberSalePP = 0;

        $memberSales = self::where('status', 1)
            ->whereBetween('invoice_date', [$startDate->format('Y-m-d') . " 00:00:00", $endDate->format('Y-m-d') . " 00:00:00"])
            ->get();

        foreach ($memberSales as $memberSale) {
            $totalMemberSalePP += $memberSale->invoiceTotalPP();
        }

        return $totalMemberSalePP;
    }

}
