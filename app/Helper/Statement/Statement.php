<?php


namespace App\Helper\Statement;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Collection;


class Statement
{

    public static function formatDataFund($collection, $parentData)
    {

        $data = [];
        
        $balance = User::find($parentData['user_id'])->FundWalletWithDateRange('0000-00-00', $parentData['start_date']);

        $data[] = [
            'previous_balance' => $balance,
        ];

        foreach ($collection as $one) {

            $income = 0;
            $expense = 0;

            if ($one->remarks == 'Transfer') {

                if ($parentData['user_id'] == $one->to_id) {

                    $income = $one->amount;
                } else {

                    if ($one->transfer_from == 'fund_wallet') {
                        $expense = $one->amount + $one->charge;
                    }
                }
            }

            if (in_array($one->remarks, ['Withdraw', 'Added Fund'])) {
                $income = $one->amount;
            }

            if ($one->remarks == 'Account Purchase') {

                if ($one->payment_gateway == 'Account Wallet') {
                    $expense = $one->amount;
                }
            }

            $balance += $income - $expense;


            $data[] = [
                'date' => $one->created_at->format('d-m-Y'),
                'remarks' => $one->remarks,
                'income' => $income,
                'expense' => $expense,
                'balance' => $balance,
            ];
        }

        // dd($data);

        return $data;
    }

    public static function fundStatement($data)
    {

        // incomes
        $transferedAmount = Wallet::whereDate('created_at', '>=', $data['start_date'])
            ->whereDate('created_at', '<=', $data['end_date'])
            ->where('to_id', $data['user_id'])
            ->whereIn('remarks', ['Transfer'])
            ->where('status', 1)
            ->get();

        $withdrawIncome = Wallet::whereDate('created_at', '>=', $data['start_date'])
            ->whereDate('created_at', '<=', $data['end_date'])
            ->where('to_id', $data['user_id'])
            ->whereIn('remarks', ['Withdraw'])
            ->where('status', 1)
            ->get();

        $addedFund = Wallet::whereDate('created_at', '>=', $data['start_date'])
            ->whereDate('created_at', '<=', $data['end_date'])
            ->where('from_id', $data['user_id'])
            ->whereIn('remarks', ['Added Fund'])
            ->where('status', 1)
            ->get();


        // expenses
        $expense = Wallet::whereDate('created_at', '>=', $data['start_date'])
            ->whereDate('created_at', '<=', $data['end_date'])
            ->where('from_id', $data['user_id'])
            ->whereIn('remarks', ['Account Purchase'])
            ->where('payment_gateway', 'Account Wallet')
            ->where('status', 1)
            ->get();

        $transferMinus = Wallet::whereDate('created_at', '>=', $data['start_date'])
            ->whereDate('created_at', '<=', $data['end_date'])
            ->where('from_id', $data['user_id'])
            ->whereIn('remarks', ['Transfer'])
            ->where('transfer_from', 'fund_wallet')
            ->where('status', 1)
            ->get();

        $charges = Wallet::whereDate('created_at', '>=', $data['start_date'])
            ->whereDate('created_at', '<=', $data['end_date'])
            ->where('from_id', $data['user_id'])
            ->whereIn('remarks', ['Transfer'])
            ->where('transfer_from', 'fund_wallet')
            ->where('status', 1)
            ->get();


        $statements = new Collection();

        $statements = $statements->merge($transferedAmount);
        $statements = $statements->merge($withdrawIncome);
        $statements = $statements->merge($addedFund);

        $statements = $statements->merge($expense);
        $statements = $statements->merge($transferMinus);
        $statements = $statements->merge($charges);

        $statements = $statements->sortBy('created_at');
        $statements = $statements->unique();

        $formatted = self::formatDataFund($statements, $data);

        return $formatted;
    }

    public static function formatDataSuccess($collection, $parentData)
    {

        $data = [];

        $balance = User::find($parentData['user_id'])->FundWalletWithDateRange('0000-00-00', $parentData['start_date']);

        $data[] = [
            'previous_balance' => $balance,
        ];


        foreach ($collection as $one) {

            $income = 0;
            $expense = 0;


            if (in_array($one->remarks, ['Reference', 'Generation'])) {
                $income = $one->amount;
            }

            if ($one->remarks == 'Withdraw') {

                if ($parentData['user_id'] == $one->to_id) {

                    $income = $one->charge;
                } else {

                    $expense = $one->amount + $one->charge;
                }
            }



            if ($one->remarks == 'Transfer') {

                if ($one->transfer_from == 'success_wallet') {
                    $expense = $one->amount;
                }
            }

            $balance += $income - $expense;


            $data[] = [
                'date' => $one->created_at->format('d-m-Y'),
                'remarks' => $one->remarks,
                'income' => $income,
                'expense' => $expense,
                'balance' => $balance,
            ];
        }

        return $data;
    }

    public static function SuccessStatement($data)
    {

        // incomes
        $transferedAmount = Wallet::whereDate('created_at', '>=', $data['start_date'])
            ->whereDate('created_at', '<=', $data['end_date'])
            ->where('from_id', $data['user_id'])
            ->whereIn('remarks',  ['Reference', 'Generation'])
            ->where('status', 1)
            ->get();


        // expenses
        $expense = Wallet::whereDate('created_at', '>=', $data['start_date'])
            ->whereDate('created_at', '<=', $data['end_date'])
            ->where('from_id', $data['user_id'])
            ->whereIn('remarks',  ['Withdraw'])
            ->where('status', 1)
            ->get();

        $transferMinus = Wallet::whereDate('created_at', '>=', $data['start_date'])
            ->whereDate('created_at', '<=', $data['end_date'])
            ->where('from_id', $data['user_id'])
            ->whereIn('remarks', ['Transfer'])
            ->where('transfer_from', 'success_wallet')
            ->where('status', 1)
            ->get();


        $statements = new Collection();

        $statements = $statements->merge($transferedAmount);

        $statements = $statements->merge($expense);
        $statements = $statements->merge($transferMinus);

        $statements = $statements->sortBy('created_at');

        $formatted = self::formatDataSuccess($statements, $data);

        return $formatted;
    }


}
