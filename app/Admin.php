<?php

namespace App;

use App\User;
use DateTime;
use App\Wallet;
use App\BusinessSetting;
use App\Models\MemberSale;
use App\Models\MemberSaleItem;
use Illuminate\Support\Carbon;
use App\Helper\Flatten\Flatten;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that should be say the guard name.
     *
     * @var array
     */
    protected $guard = 'admin';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function user_role(): HasOne
    {
        return $this->hasOne(UserRoles::class, 'id', 'role');
    }


    // user profile Image
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

        $user = Auth::user();

        $total = 0;
        $memberSales = MemberSale::where('store_id', $user->id)->get();

        foreach ($memberSales as $memberSale) {
            $total += $memberSale->invoiceTotalItemQty();
        }
        return $total;
    }


    // total MemberSale itemwise Sum
    public function totalMemberSaleItemWiseQty()
    {
        $user = Auth::user();

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
    public function totalMemberSaleTopCustomers()
    {
        $user = Auth::user();

        $memberSale = MemberSale::where('store_id', $user->id)->get();

        $memberSale = $memberSale->groupBy('customer_id');


        $data = [];

        foreach ($memberSale as $ms) {

            $customer = Customer::find($ms->first()->customer_id);

            $data[] = [
                'customer' => $customer,
                'qty' => $ms->count(),
            ];
        }

        // sort by qty
        $data = collect($data)->sortByDesc('qty')->take(20)->toArray();

        return $data;
    }

    // total MemberSale item Amount
    public function totalMemberSaleItemAmount()
    {
        $user = Auth::user();

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

        $user = Auth::user();

        $total = 0;
        $memberSales = MemberSale::where('customer_id', $user->id)->get();

        foreach ($memberSales as $memberSale) {
            $total += $memberSale->invoiceTotalPP();
        }
        return $total;
    }



    // total MemberSale purchase point By User
    public function totalMemberSalePurchasePointByUser()
    {

        $user = $this;

        $total = 0;
        $memberSales = MemberSale::where('customer_id', $user->id)->get();

        foreach ($memberSales as $memberSale) {
            $total += $memberSale->invoiceTotalPP();
        }
        return $total;
    }

    // total CashSale item qty
    public function totalCashSaleItemQty()
    {

        $user = Auth::user();

        $total = 0;
        $cashSales = CashSale::where('customer_id', $user->id)->get();

        foreach ($cashSales as $cashSale) {
            $total += $cashSale->totalQuantity();
        }
        return $total;
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


    public static function userDatatable()
    {

        $users = User::Role(['System Admin', 'Software Admin'])->orderBy('id', 'desc');

        if (!Auth::user()->hasRole(['Software Admin'])) {
            $users = $users->where('id', '!=', 1);
        }

        return DataTables::eloquent($users)
            ->addIndexColumn()
            ->addColumn('roles', function ($row) {
                $roles = User::findOrFail($row->id)->roles()->get()->pluck(['name'])->toArray();
                $roles_string = implode(",", $roles);
                return $roles_string;
            })
            ->addColumn('status_ui', function ($row) {
                $status = $row->status;
                $checked = "";

                if ($status) {
                    $checked = "checked";
                }


                $slide_button = '<div class="toggle">
                  <label>
                    <input onclick="toggleStatus(' . $row->id . ')" type="checkbox" ' . $checked . '><span class="button-indecator"></span>
                  </label>
                </div>';

                if (Auth::user()->can('status user')) {
                    return $slide_button;
                }
                return "";
            })

            ->addColumn('action', function ($row) {

                $btn = "";

                if (Auth::user()->can('view user')) {
                    $btn = $btn . '<a href="' . route('user.show', $row->id) . '" class="edit btn btn-info btn-sm m-1"><i class="fa fa-eye" aria-hidden="true"></i>
                                View</a> &nbsp;';
                }

                if (Auth::user()->can('edit user')) {
                    $btn = $btn . '<a href="' . route('user.edit', $row->id) . '" class="edit btn btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i>
                            Edit</a> &nbsp;';
                }

                if (Auth::user()->can('change_password user')) {
                    $btn = $btn . '<a href="' . route('changepassword.view', $row->id) . '" class="edit btn btn-warning btn-sm"><i class="fa fa-lock" aria-hidden="true"></i>
                                Change Password</a> &nbsp;';
                }

                if (Auth::user()->can('delete user')) {
                    $btn = $btn . "<button type='button' onclick='deleteRow(" . $row->id . ")' class='edit btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i>Delete</button>";
                }


                return $btn;
            })
            ->rawColumns(['status_ui', 'action'])
            ->toJson();
    }

    public static function userWithFundBalance()
    {
        $ids = [];

        $users = User::where('status', 1)->get();

        foreach ($users as $user) {
            $balance = $user->FundWallet();

            if ($balance > 0) {
                array_push($ids, $user->id);
            }
        }

        return $ids;
    }

    private static function referral($userIds)
    {
        $users = User::whereIn('referrence', $userIds)->get()->pluck('id')->toArray();
        $childs = User::whereIn('referral', $userIds)->get()->pluck('id')->toArray();
        $userIds = array_merge($users, $childs);
        if ($userIds) {
            $userIds = array_unique($userIds);
        }
        return $userIds;
    }

    private static function reference($id)
    {
        $users = User::where('referrence', $id)->get()->pluck('id')->toArray();
        $childs = User::where('referral', $id)->get()->pluck('id')->toArray();

        $child = self::referral($users);

        $userIds = array_merge($users, $childs, $child);
        if ($userIds) {
            $userIds = array_unique($userIds);
        }

        return $userIds;
    }

    public static function memberDatatable($id)
    {


        if ($id == 1) {
            $users = User::where('role', 3)->with('refMember');
        } else {
            $userIds = self::reference($id);
            $users = User::where('role', 3)
                ->whereIn('id', $userIds)
                ->with('refMember');
        }

        return DataTables::eloquent($users)
            ->addIndexColumn()
            ->addColumn('roles', function ($row) {
                $roles = User::findOrFail($row->id)->get()->pluck(['name'])->toArray();
                $roles_string = implode(",", $roles);
                return $roles_string;
            })
            ->addColumn('status_ui', function ($row) {
                return \App\Link::status($row->id, $row->status);
            })
            ->addColumn('ref_member', function ($row) {
                $ref_member = @$row->refMember->username;
                return $ref_member;
            })
            ->addColumn('fund_balance', function ($row) {
                $fundBalance = $row->FundWallet();
                return $fundBalance;
            })
            ->addColumn('success_balance', function ($row) {
                $successBalance = $row->SuccessWallet();
                return $successBalance;
            })
            ->addColumn('total_withdraw', function ($row) {
                $withdraw = $row->withdrawWallet();
                return $withdraw;
            })
            ->addColumn('action', function ($row) {
                return \App\Link::action($row->id);
            })
            ->rawColumns(['status_ui', 'action'])
            ->toJson();
    }

    public function hands()
    {

        $handUsers = User::where('referral', $this->id)->get();

        return $handUsers;
    }

    public function totalIncome()
    {

        $totalIncome = Wallet::where('from_id', $this->id)->whereIn('remarks', ['Daily', 'Reference', 'Generation', 'RankBonus', 'ADV BONUS'])->where('status', 1)->sum('amount');

        $transfferedIncome = Wallet::where('to_id', $this->id)->whereIn('remarks', ['Transfer', 'Withdraw'])->where('status', 1)->sum('amount');

        $addedFund = Wallet::where('from_id', $this->id)->whereIn('remarks', ['Added Fund'])->where('status', 1)->sum('amount');

        $totalIncome = $transfferedIncome + $totalIncome + $addedFund;

        return $totalIncome;
    }

    public function totalExpense()
    {

        $Expense = Wallet::where('from_id', $this->id)->whereIn('remarks', ['Recharge', 'Withdraw', 'Transfer'])->where('status', 1)->sum('amount');

        $ExpenseCharge = Wallet::where('from_id', $this->id)->whereIn('remarks', ['Withdraw', 'Transfer'])->where('status', 1)->sum('charge');

        $accountPurchaseExpense = Wallet::where('from_id', $this->id)->where('remarks', 'Account Purchase')->where('payment_gateway', 'Account Wallet')->where('status', 1)->sum('amount');

        $totalExpense = $Expense + $ExpenseCharge + $accountPurchaseExpense;

        return $totalExpense;
    }

    public function InWallet()
    {

        $totalIncome = $this->totalIncome();

        $totalExpense = $this->totalExpense();

        $InWallet = $totalIncome - $totalExpense;

        return $InWallet;
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

        // dd($invoiceAmount, $netAmount, $withDrawCommission, $investorBonus);

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


    public function SuccessWallet()
    {

        // income
        $totalIncome = Wallet::where('from_id', $this->id)->whereIn('remarks', ['Reference', 'Generation'])->where('status', 1)->sum('amount');

        // expenses
        $Expense = Wallet::where('from_id', $this->id)->whereIn('remarks', ['Withdraw'])->where('status', 1)->sum('amount');
        $Charge = Wallet::where('from_id', $this->id)->whereIn('remarks', ['Withdraw'])->where('status', 1)->sum('charge');
        $transferMinus = Wallet::where('from_id', $this->id)->whereIn('remarks', ['Transfer'])->where('transfer_from', 'success_wallet')->where('status', 1)->sum('amount');

        $totalExpense = $Expense + $Charge + $transferMinus;

        $SuccessWallet = $totalIncome - $totalExpense;

        return $SuccessWallet;
    }

    public function SuccessWalletWithDateRange($start_date, $end_date)
    {

        // income
        $totalIncome = Wallet::whereDate('created_at', '>', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->where('from_id', $this->id)
            ->whereIn('remarks', ['Reference', 'Generation'])
            ->where('status', 1)
            ->sum('amount');

        // expenses
        $Expense = Wallet::whereDate('created_at', '>', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->where('from_id', $this->id)
            ->whereIn('remarks', ['Withdraw'])
            ->where('status', 1)
            ->sum('amount');

        $Charge = Wallet::whereDate('created_at', '>', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->where('from_id', $this->id)
            ->whereIn('remarks', ['Withdraw'])
            ->where('status', 1)
            ->sum('charge');

        $transferMinus = Wallet::whereDate('created_at', '>', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->where('from_id', $this->id)
            ->whereIn('remarks', ['Transfer'])
            ->where('transfer_from', 'success_wallet')
            ->where('status', 1)
            ->sum('amount');

        $totalExpense = $Expense + $Charge + $transferMinus;

        $SuccessWallet = $totalIncome - $totalExpense;

        return $SuccessWallet;
    }

    public function withdrawWallet()
    {
        $withdrawAmountSum = Wallet::where('from_id', $this->id)->whereIn('remarks', ['Withdraw'])->where('status', 1)->sum('amount');
        $withdrawChargeSum = Wallet::where('from_id', $this->id)->whereIn('remarks', ['Withdraw'])->where('status', 1)->sum('charge');

        $totalAmount = $withdrawAmountSum + $withdrawChargeSum;

        return $totalAmount;
    }


    public function FounderWallet()
    {

        // income
        $founderWallet = Wallet::where('from_id', $this->id)->whereIn('remarks', ['FounderBonus'])->where('status', 1)->sum('amount');

        return $founderWallet;
    }

    public function SuccessWalletDetails()
    {

        // income
        $totalIncome = Wallet::where('from_id', $this->id)->whereIn('remarks', ['Reference', 'Generation'])->where('status', 1)->sum('amount');

        // expenses
        $Expense = Wallet::where('from_id', $this->id)->whereIn('remarks', ['Withdraw'])->where('status', 1)->sum('amount');
        $Charge = Wallet::where('from_id', $this->id)->whereIn('remarks', ['Withdraw'])->where('status', 1)->sum('charge');
        $transferMinus = Wallet::where('from_id', $this->id)->whereIn('remarks', ['Transfer'])->where('transfer_from', 'success_wallet')->where('status', 1)->sum('amount');

        $totalExpense = $Expense + $Charge + $transferMinus;

        $SuccessWallet = $totalIncome - $totalExpense;

        return [
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'SuccessWallet' => $SuccessWallet,
        ];
    }

    public function FundWallet()
    {

        // incomes
        $transferedAmount = Wallet::where('to_id', $this->id)->whereIn('remarks', ['Transfer'])->where('status', 1)->sum('amount');
        $withdrawIncome = Wallet::where('to_id', $this->id)->whereIn('remarks', ['Withdraw'])->where('status', 1)->sum('charge');
        $addedFund = Wallet::where('from_id', $this->id)->whereIn('remarks', ['Added Fund'])->where('status', 1)->sum('amount');

        $totalIncomes = $transferedAmount + $addedFund + $withdrawIncome;

        // expenses
        $expense = Wallet::where('from_id', $this->id)->whereIn('remarks', ['Account Purchase'])->where('payment_gateway', 'Account Wallet')->where('status', 1)->sum('amount');
        $transferMinus = Wallet::where('from_id', $this->id)->whereIn('remarks', ['Transfer'])->where('transfer_from', 'fund_wallet')->where('status', 1)->sum('amount');
        $charges = Wallet::where('from_id', $this->id)->whereIn('remarks', ['Transfer'])->where('transfer_from', 'fund_wallet')->where('status', 1)->sum('charge');

        $totalExpense = $expense + $transferMinus + $charges;


        // final wallet Amount
        $receiveAmount = $totalIncomes - $totalExpense;

        return $receiveAmount;
    }

    public function FundWalletWithDateRange($start_date, $end_date)
    {

        // incomes
        $transferedAmount = Wallet::whereDate('created_at', '>', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->where('to_id', $this->id)
            ->whereIn('remarks', ['Transfer'])
            ->where('status', 1)
            ->sum('amount');

        $withdrawIncome = Wallet::whereDate('created_at', '>', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->where('to_id', $this->id)
            ->whereIn('remarks', ['Withdraw'])
            ->where('status', 1)
            ->sum('charge');

        $addedFund = Wallet::whereDate('created_at', '>', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->where('from_id', $this->id)
            ->whereIn('remarks', ['Added Fund'])
            ->where('status', 1)
            ->sum('amount');

        $totalIncomes = $transferedAmount + $addedFund + $withdrawIncome;


        // expenses
        $expense = Wallet::whereDate('created_at', '>', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->where('from_id', $this->id)
            ->whereIn('remarks', ['Account Purchase'])
            ->where('payment_gateway', 'Account Wallet')
            ->where('status', 1)
            ->sum('amount');

        $transferMinus = Wallet::whereDate('created_at', '>', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->where('from_id', $this->id)
            ->whereIn('remarks', ['Transfer'])
            ->where('transfer_from', 'fund_wallet')
            ->where('status', 1)
            ->sum('amount');

        $charges = Wallet::whereDate('created_at', '>', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->where('from_id', $this->id)
            ->whereIn('remarks', ['Transfer'])
            ->where('transfer_from', 'fund_wallet')
            ->where('status', 1)
            ->sum('charge');

        $totalExpense = $expense + $transferMinus + $charges;


        // final wallet Amount
        $receiveAmount = $totalIncomes - $totalExpense;

        return $receiveAmount;
    }

    public function FundWalletDetails()
    {

        // incomes
        $transferedAmount = Wallet::where('to_id', $this->id)->whereIn('remarks', ['Transfer'])->where('status', 1)->sum('amount');
        $withdrawIncome = Wallet::where('to_id', $this->id)->whereIn('remarks', ['Withdraw'])->where('status', 1)->sum('charge');
        $addedFund = Wallet::where('from_id', $this->id)->whereIn('remarks', ['Added Fund'])->where('status', 1)->sum('amount');

        $totalIncomes = $transferedAmount + $addedFund + $withdrawIncome;

        // expenses
        $expense = Wallet::where('from_id', $this->id)->whereIn('remarks', ['Account Purchase'])->where('payment_gateway', 'Account Wallet')->where('status', 1)->sum('amount');
        $transferMinus = Wallet::where('from_id', $this->id)->whereIn('remarks', ['Transfer'])->where('transfer_from', 'fund_wallet')->where('status', 1)->sum('amount');
        $charges = Wallet::where('from_id', $this->id)->whereIn('remarks', ['Transfer'])->where('transfer_from', 'fund_wallet')->where('status', 1)->sum('charge');

        $totalExpense = $expense + $transferMinus + $charges;

        // final wallet Amount
        $receiveAmount = $totalIncomes - $totalExpense;

        return [
            'totalIncome' => $totalIncomes,
            'totalExpense' => $totalExpense,
            'SuccessWallet' => $receiveAmount,
        ];
    }

    public function earningIncome()
    {

        $earningIncome = Wallet::where('from_id', $this->id)->whereIn('remarks', ['Daily'])->where('status', 0)->sum('amount');

        $totalIncome = $earningIncome;

        return $totalIncome;
    }


    public function haveTodaysDailyBonus()
    {

        $bonus = Wallet::where('from_id', $this->id)->whereDate('created_at', Carbon::today())->get();

        $bool = $bonus->count() == 0 ? false : true;

        return $bool;
    }




    public function DaysSinceJoined()
    {

        $join_date = new DateTime($this->created_at->format('Y-m-d'));
        $todayDate = new DateTime(date('Y-m-d', strtotime(now())));

        $interval = $join_date->diff($todayDate);
        $intervalDays = $interval->format('%a');

        return $intervalDays;
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

    public function DownLevelMemberIds()
    {

        $businessSettings = BusinessSetting::where('id', 1)->select(['number_of_level'])->first();

        $ids = [];

        $ReferenceId = $this->id;

        $level1Ids = User::where('referral', $ReferenceId)->where('status', 1)->select(['id'])->get()->pluck('id')->toArray();

        array_push($ids, $level1Ids);

        $lastLevelIds = $level1Ids;

        for ($i = 1; $i < 999999 + 1; $i++) {

            $levelIds = User::whereIn('referral', $lastLevelIds)->where('status', 1)->select(['id'])->get()->pluck('id')->toArray();

            if ($levelIds == null) {
                break;
            }

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

    public function user_rank(): HasOne
    {
        return $this->hasOne(RankSetting::class, 'id', 'rank');
    }

    public function PackageActivationCount()
    {
        return Wallet::where('from_id', $this->id)->where('remarks', 'Cash')->count();
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

        $users = User::whereIn('id', $downLevelMemberIds)->get();

        foreach ($users as $user) {

            // if ($user->member_rank_date) {

            $totalPP = Wallet::where('from_id', $user->id)
                ->where('remarks', 'Purchase Point')
                ->whereDate('created_at', '>=', date('Y-m-d', strtotime($this->member_rank_date)))
                ->sum('pp');

            $total += $totalPP;

            // }

        }

        return $total;
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

    public function urank()
    {
        $rank = '';

        if ($this->role == 3) {
            if ($this->rank == 'Customer' || $this->rank == 'Founder') {
                $rank = $this->rank;
            } else {
                $rank = $this->user_rank->rank_name;
            }
        }

        return $rank;
    }

    public function pp()
    {
        $purchasepoint = Wallet::where('from_id', $this->id)->whereIn('remarks', ['Purchase Point'])->where('status', 1)->sum('pp');

        return $purchasepoint;
    }

    public function DownLevelMembers()
    {
        $ids = $this->DownLevelMemberIds();

        $members = User::whereIn('id', $ids)->get();

        return $members;
    }

    public function district(): HasOne
    {
        return $this->hasOne(District::class, 'id', 'district_id');
    }

    public function thana(): HasOne
    {
        return $this->hasOne(Thana::class, 'id', 'thana_id');
    }

    public function totalPointIncome()
    {
        $totalIncome = Wallet::where('from_id', $this->id)->whereIn('remarks', ['Purchase Point'])->where('status', 1)->sum('pp');

        $totalIncome = $totalIncome;

        return $totalIncome;
    }

    public function totalPointExpense()
    {
        $Expense = Wallet::where('from_id', $this->id)->whereIn('remarks', ['ConversionToCash'])->where('status', 1)->sum('pp');

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
}
