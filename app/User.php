<?php

namespace App;

use App\CreditSale;
use App\Helper\Ranks;
use App\Models\Customer;
use App\Models\MemberSale;
use App\Models\MemberSaleItem;
use Illuminate\Support\Carbon;
use App\Helper\Flatten\Flatten;
use App\Models\DealerPurchaseReturn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\DealerPurchaseReturnItem;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    protected $table = 'admins';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function profile_image()
    {
        if ($this->profile_img) {
            return asset($this->profile_img);
        } else {
            return asset('admin-elite/assets/images/users/1.jpg');
        }
    }

    public function toggleStatus()
    {
        if ($this->status) {
            $this->status = False;
        } else {
            $this->status = True;
            $this->created_at = date('Y-m-d h:i:s', strtotime(now()));
        }

        $this->save();
    }

    // current Rank Name

    public function currentRank()
    {
        $rank = $this->rank != "Customer" ? $this->rank : $this->member_type;

        return $rank;
    }

    public static function AllCustomer()
    {

        $filteredUser = [];

        $users = Self::all();

        foreach ($users as $user) {
            if ($user->currentRank() == "Customer") {
                $filteredUser[] = $user;
            }
        }

        return $filteredUser;
    }

    public static function AllCustomerCount()
    {

        $i = 0;
        $users = Self::all();

        foreach ($users as $user) {
            if ($user->currentRank() == "Customer") {
                $i++;
            }
        }

        return $i;
    }

    public static function AllStarter()
    {

        $filteredUser = [];
        $users = Self::all();

        foreach ($users as $user) {
            if ($user->currentRank() == "Starter") {
                $filteredUser[] = $user;
            }
        }

        return $filteredUser;
    }

    public static function AllStarterCount()
    {

        $i = 0;
        $users = Self::all();

        foreach ($users as $user) {
            if ($user->currentRank() == "Starter") {
                $i++;
            }
        }

        return $i;
    }

    // total MemberSale item qty
    public function totalMemberSaleItemQty()
    {

        $user = $this;

        $total = 0;
        $memberSales = MemberSale::where('store_id', $user->id)->get();

        foreach ($memberSales as $memberSale) {
            $total += $memberSale->invoiceTotalItemQty();
        }
        return $total;
    }


    // total MemberSale itemwise Sum
    public static function totalMemberSaleItemWiseQty($userId)
    {
        $user = self::find($userId);

        $products = Product::all();

        $memberSaleIds = MemberSale::where('store_id', $user->id)->select('id')->pluck('id')->toArray();

        $memberSaleItems = MemberSaleItem::whereIn('member_sale_id', $memberSaleIds)->get();

        $data = [];

        foreach ($products as $product) {

            $data[] = [
                'product' => $product,
                'qty' => $memberSaleItems->where('item_id', $product->id)->sum('item_quantity'),
            ];
        }

        // sort by qty
        $data = collect($data)->sortByDesc('qty')->take(10)->toArray();

        return $data;
    }


    // total MemberSale top customer
    public static function totalMemberSaleTopCustomers()
    {
        $user = $this;

        $memberSale = MemberSale::where('store_id', $user->id)->get();

        $memberSale = $memberSale->groupBy('customer_id');


        $data = [];

        foreach ($memberSale as $ms) {

            $customer = Customer::with(['UserAccount'])->where('id', $ms->first()->customer_id)->first();

            $data[] = [
                'customer' => $customer,
                'point' => $customer->UserAccount->totalPointIncome(),
            ];
        }

        // sort by qty
        $data = collect($data)->sortByDesc('point')->take(20)->toArray();

        return $data;
    }

    // total MemberSale item Amount
    public function totalMemberSaleItemAmount()
    {
        $user = $this;

        $total = 0;
        $memberSales = MemberSale::where('store_id', $user->id)->get();

        foreach ($memberSales as $memberSale) {
            $total += $memberSale->invoiceTotalItemQty();
        }
        return $total;
    }

    // total MemberSale purchase point
    public function totalMemberSalePurchasePoint()
    {

        $user = $this;

        $total = 0;
        $memberSales = MemberSale::where('store_id', $user->id)->get();

        foreach ($memberSales as $memberSale) {
            $total += $memberSale->invoiceTotalPP();
        }
        return $total;
    }


    // total CashSale item qty
    public function totalCashSaleItemQty()
    {

        $user = $this;

        $total = 0;
        $cashSales = CashSale::where('customer_id', $user->id)->get();

        foreach ($cashSales as $cashSale) {
            $total += $cashSale->totalQuantity();
        }
        return $total;
    }

    // total return item qty
    public function totalReturnItemQty()
    {

        $user = $this;

        $total = 0;
        $returns = DealerPurchaseReturn::where('dealer_id', $user->id)->get();

        foreach ($returns as $return) {
            $total += $return->totalQuantity();
        }
        return $total;
    }


    // total cashsale purchase point
    public function totalCashSalePurchasePoint()
    {

        $user = $this;

        $total = 0;
        $cashSales = CashSale::where('customer_id', $user->id)->get();

        foreach ($cashSales as $cashSale) {
            $total += $cashSale->invoiceTotalPP();
        }
        return $total;
    }



    // dealer total Member Pay Amount
    public function totalMemberPay()
    {

        $total = Wallet::with(['from'])
            ->where('remarks', 'Withdraw')
            ->where('to_id', $this->id)
            ->where('status', 1)
            ->sum('amount');

        return $total;
    }

    // dealer total credit Sale Amount
    public function totalCreditSaleAmount()
    {
        $total = CashSale::where('customer_id', $this->id)->where('payment_type', 'Credit')->sum('invoice_amount');
        return $total;
    }


    // total credit collection amount
    public function totalCreditCollectionAmount()
    {
        $total = CreditCollection::where('client_id', $this->id)->sum('payment_amount');
        return $total;
    }


    public function currentRankMemberCount()
    {
        $count = User::where('rank', $this->rank)->count();
        return $count;
    }

    public function nextRankMemberCount()
    {
        $count = User::where('rank', $this->nextRank())->count();
        return $count;
    }

    public function nextRank()
    {

        $userRank = $this->rank;

        $ranks = Ranks::all();

        $currentRank = $ranks->where('name', $userRank)->first();

        if (!$currentRank) {
            return "";
        }

        $nextRankSL = $ranks->where('name', $userRank)->first()['sl'] + 1;

        $nextRank = $ranks->where('sl', $nextRankSL)->first();

        if (!$nextRank) {
            return "";
        }

        return $nextRank['name'];
    }


    public function currentRankReserve()
    {

        // get user Current Rank
        $userRank = $this->rank;

        // get current Rank achivement
        $ranks = Ranks::all();
        $currentRank = $ranks->where('name', $userRank)->first();

        if (!$currentRank) {
            return "";
        }

        $currentRankAchivement = $currentRank['achivement'];

        // get current month package sold
        $packageSold = Wallet::thisMonthSoldPackages();

        return $currentRankAchivement * $packageSold;
    }

    public function nextRankReserve()
    {

        // get user Current Rank
        $userRank = $this->nextRank();

        // get current Rank achivement
        $ranks = Ranks::all();

        $currentRank = $ranks->where('name', $userRank)->first();

        if (!$currentRank) {
            return "";
        }

        $currentRankAchivement = $currentRank['achivement'];


        // get current month package sold
        $packageSold = Wallet::thisMonthSoldPackages();

        return $currentRankAchivement * $packageSold;
    }


    public function refMember(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'referrence');
    }

    public function placeMember(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'referral');
    }

    public function CustomerAccount(): HasOne
    {
        return $this->hasOne(Customer::class, 'user_id', 'id');
    }


    public function DownLevelMemberIds()
    {

        $ids = [];

        $ReferenceId = $this->id;

        $level1Ids = User::where('referral', $ReferenceId)->where('status', 1)->select(['id'])->get()->pluck('id')->toArray();

        array_push($ids, $level1Ids);

        $lastLevelIds = $level1Ids;


        for ($i = 1; $i < 150; $i++) {

            $levelIds = User::whereIn('referral', $lastLevelIds)->where('status', 1)->select(['id'])->get()->pluck('id')->toArray();

            $lastLevelIds = $levelIds;

            array_push($ids, $levelIds);
        }

        $ids = Flatten::ArrayFlatten($ids);

        return $ids;
    }


    public function DownLevelMemberCount()
    {

        $ids = $this->DownLevelMemberIds();

        $memberCount = User::whereIn('id', $ids)->count();

        return $memberCount;
    }

    public function hands()
    {

        $handUsers = User::where('referral', $this->id)->get();

        return $handUsers;
    }

    public function DownLevelMemberAllIdsWithHand($handId)
    {

        $totalUserCount = User::count();

        $ids = [];

        $ReferenceId = $this->id;

        $level1Id = User::where('referral', $ReferenceId)->where('hand_id', $handId)->select(['id', 'hand_id'])->first();

        if (!$level1Id) {
            return $ids;
        }

        array_push($ids, $level1Id->id);

        $lastLevelId = $level1Id->id;

        for ($i = 1; $i < $totalUserCount + 1; $i++) {

            if (gettype($lastLevelId) == 'array') {

                $levelId = User::whereIn('referral', $lastLevelId)->select(['id'])->get()->pluck(['id'])->toArray();
            } else {

                $levelId = User::where('referral', $lastLevelId)->select(['id'])->get()->pluck(['id'])->toArray();
            }

            if (!count($levelId)) {
                continue;
            }

            array_push($ids, $levelId);

            $lastLevelId = $levelId;
        }

        $ids = Flatten::ArrayFlatten($ids);

        return $ids;
    }


    public function DownLevelMemberAllIdsWithHandCount($handId)
    {

        $ids = $this->DownLevelMemberAllIdsWithHand($handId);

        return count($ids);
    }

    public function DownLevelMemberAllIdsWithHandCountCached($handId)
    {

        $ids = Cache::remember($this->id . '_ids', 18000, function () use ($handId) {
            return $this->DownLevelMemberAllIdsWithHand($handId);
        });

        return count($ids);
    }


    public function DownLevelMembers()
    {
        $ids = $this->DownLevelMemberIds();

        $members = User::whereIn('id', $ids)->get();

        return $members;
    }


    public function isActive()
    {
        return Wallet::where('from_id', $this->id)->where('remarks', 'Cash')->count() > 0 ? true : false;
    }

    public function PackageActivationCount()
    {
        // return Wallet::where('from_id', $this->id)->where('remarks', 'Cash')->count();

        return Wallet::where('from_id', $this->id)
            ->where('remarks', 'TeamBonus')
            ->where('pp', 100)
            ->count();
    }


    public function referMemberActivePackage($handId)
    {
        $members = User::where('referral', $this->id)->where('hand_id', $handId)->get();

        $packageCount  = 0;

        foreach ($members as $member) {
            $packageCount += $member->PackageActivationCount();
        }

        return $packageCount;
    }

    public function referActiveMemberCount($handId)
    {
        $members = User::where('referral', $this->id)->where('hand_id', $handId)->get();

        $memberCount  = 0;

        foreach ($members as $member) {
            if ($member->isActive()) {
                $memberCount++;
            }
        }

        return $memberCount;
    }

    public function referMemberPoint($handId)
    {
        $members = User::where('referral', $this->id)->where('hand_id', $handId)->select(['id'])->pluck('id')->toArray();
        $totalPP = Wallet::whereIn('from_id', $members)
            ->where('remarks', 'Purchase Point')
            ->sum('pp');
        return $totalPP;
    }


    public function downLevelAllReferMemberPoint($handId)
    {
        $downLevelMemberIds = $this->DownLevelMemberAllIdsWithHand($handId);
        $totalPP = Wallet::whereIn('from_id', $downLevelMemberIds)
            ->where('remarks', 'Purchase Point')
            ->sum('pp');
        return $totalPP;
    }

    public function downLevelAllReferWhereRankIsMemberPoint($handId)
    {
        $total = 0;

        if (!$this->member_rank_date) {
            return 0;
        }

        $downLevelMemberIds = $this->DownLevelMemberAllIdsWithHand($handId);

        // $users = User::whereIn('id', $downLevelMemberIds)->get();

        foreach ($downLevelMemberIds as $downLevelMemberId) {

            $totalPP = Wallet::where('from_id', $downLevelMemberId)
                ->where('remarks', 'Purchase Point')
                ->whereDate('created_at', '>=', date('Y-m-d', strtotime($this->member_rank_date)))
                ->sum('pp');

            $total += $totalPP;
        }

        return $total;
    }

    public function ActiveMember()
    {
        return User::where('referrence', $this->id)->where('rank', 'Customer')->where('status', 1)->count();
    }

    public function InActiveMember()
    {
        return User::where('referrence', $this->id)->where('rank', 'Customer')->where('status', 0)->count();
    }

    public function ExecutiveMember()
    {
        return User::where('referrence', $this->id)->where('rank', 'Executive')->count();
    }

    public function SrExecutiveMember()
    {
        return User::where('referrence', $this->id)->where('rank', 'SrExecutive')->count();
    }

    public function AsmMember()
    {
        return User::where('referrence', $this->id)->where('rank', 'ASM')->count();
    }


    public function ManagerMember()
    {
        return User::where('referrence', $this->id)->where('rank', 'Manager')->count();
    }

    public function SrManagerMember()
    {
        return User::where('referrence', $this->id)->where('rank', 'SrManager')->count();
    }

    public function AGMMember()
    {
        return User::where('referrence', $this->id)->where('rank', 'AGM')->count();
    }

    public function DGMMember()
    {
        return User::where('referrence', $this->id)->where('rank', 'DGM')->count();
    }

    public function GMMember()
    {
        return User::where('referrence', $this->id)->where('rank', 'GM')->count();
    }

    public function EDMember()
    {
        return User::where('referrence', $this->id)->where('rank', 'ED')->count();
    }

    public function totalCreditPurchase()
    {
        $totalCreditPurchase = CreditSale::where('customer_id', $this->id)->sum('invoice_amount');
        return $totalCreditPurchase;
    }

    public function totalCreditCollection()
    {
        $totalCreditPurchase = CreditCollection::where('client_id', $this->id)->sum('payment_amount');
        return $totalCreditPurchase;
    }

    public function totalCashPurchase()
    {
        $totalCashPurchase = CashSale::where('customer_id', $this->id)->sum('invoice_amount');
        return $totalCashPurchase;
    }

    public function totalOnlinePurchase()
    {

        $checkOutIds = Checkout::where('customer_id', $this->id)->select('id')->get()->pluck('id')->toArray();

        if (!$checkOutIds) {
            return 0;
        }

        $totalOrdersAmount = Order::whereIn('checkout_id', $checkOutIds)->sum('price');

        return $totalOrdersAmount;
    }

    public function totalPurchaseAmount()
    {
        return $this->totalCreditPurchase() + $this->totalCashPurchase();
    }

    public function dealerCommissionIncome()
    {
        $invoiceAmount = (double)CashSale::where('customer_id', $this->id)->sum('invoice_amount');
        $netAmount = (double)CashSale::where('customer_id', $this->id)->sum('net_amount');

        $withDrawCommission = (double)Wallet::where('from_id', $this->id)
            ->where('remarks', 'DealerCommission')
            ->where('status', 1)
            ->sum('amount');

        $investorBonus = (double)Wallet::where('from_id', $this->id)
            ->where('remarks', 'InvestorProfit')
            ->where('status', 1)
            ->sum('amount');

        // $operationalBonus = Wallet::where('from_id', $this->id)
        //     ->where('remarks', 'OperationalBonus')
        //     ->where('status', 1)
        //     ->sum('amount');


        // dd($this->id, $invoiceAmount, $netAmount);

        $totalCommission = ($withDrawCommission + $investorBonus) + ($invoiceAmount - $netAmount);

        return $totalCommission;
    }

    public function dealerCommissionWallet()
    {
        $totalIncome = $this->dealerCommissionIncome();

        $totalExpense = $this->totalCashExpense();

        $InWallet = $totalIncome - $totalExpense;

        return $InWallet;
    }

    public function totalCashIncome()
    {

        $directIncome = Wallet::where('from_id', $this->id)
            ->whereIn('remarks', ['ConversionToCash', 'TeamBonus', 'SalesBonus', 'RePurchaseBonus', 'Entertainment', 'RankBonus', 'LevelBonus', 'DealerCommission', 'InvestorProfit', "OperationalBonus"])
            ->where('status', 1)
            ->sum('amount');

        $indirectIncome = Wallet::where('to_id', $this->id)
            ->whereIn('remarks', ['Withdraw', 'Transfer'])
            ->where('status', 1)
            ->sum('amount');

        $totalIncome = $directIncome + $indirectIncome;

        return $totalIncome;
    }

    public function totalCashExpense()
    {

        $expense = Wallet::where('from_id', $this->id)->whereIn('remarks', ['Withdraw', 'Transfer'])->whereIn('status', [1, 0])->sum('amount');
        $charge = Wallet::where('from_id', $this->id)->whereIn('remarks', ['Withdraw', 'Transfer'])->whereIn('status', [1, 0])->sum('charge');

        $totalExpense = $expense + $charge;

        return $totalExpense;
    }

    public function CashWallet()
    {

        $totalIncome = $this->totalCashIncome();

        $totalExpense = $this->totalCashExpense();

        $InWallet = $totalIncome - $totalExpense;

        return round($InWallet, 2);
    }

    public function totalPointIncome()
    {
        $totalIncome = Wallet::where('from_id', $this->id)->whereIn('remarks', ['Purchase Point'])->where('status', 1)->sum('pp');

        $totalIncome = $totalIncome;

        return $totalIncome;
    }

    public function totalPointExpense()
    {
        $Expense = Wallet::where('from_id', $this->id)->whereIn('remarks', ['ConversionToCash', 'TeamBonus'])->where('status', 1)->sum('pp');

        $totalExpense = $Expense;

        return $totalExpense;
    }

    public function PointWallet()
    {
        $totalIncome = $this->totalPointIncome();

        $totalExpense = $this->totalPointExpense();

        $InWallet = $totalIncome - $totalExpense;

        return $InWallet;
    }

    public function ReferenceCount()
    {
        return User::where('referrence', $this->id)->count();
    }


    public function district(): HasOne
    {
        return $this->hasOne(District::class, 'id', 'district_id');
    }

    public function thana(): HasOne
    {
        return $this->hasOne(Thana::class, 'id', 'thana_id');
    }
}
