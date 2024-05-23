<?php

namespace App\Helper;

use App\Wallet;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class MyStatement
{
    protected $searchData;
    protected $previousBalance;

    public function __construct($searchData, $previousBalance)
    {
        $this->id = $searchData['member'];
        $this->searchData = $searchData;
        $this->previousBalance = $previousBalance;
        // dd($this->searchData);
    }

    public function queryResult()
    {

        $directIncomeWithExpense = Wallet::with(['to', 'from'])
            ->where('from_id', $this->id)
            ->whereIn('remarks', ['Withdraw', 'Transfer', 'ConversionToCash', 'TeamBonus', 'SalesBonus', 'RePurchaseBonus', 'Entertainment', 'RankBonus', 'LevelBonus'])
            ->whereDate('created_at', '>=', $this->searchData['start_date'])
            ->whereDate('created_at', '<=', $this->searchData['end_date'])
            ->where('status', 1)
            ->get();

        $indirectIncome = Wallet::with(['to', 'from'])
            ->where('to_id', $this->id)
            ->whereIn('remarks', ['Transfer'])
            ->whereDate('created_at', '>=', $this->searchData['start_date'])
            ->whereDate('created_at', '<=', $this->searchData['end_date'])
            ->where('status', 1)
            ->get();

        $withdraws = Wallet::with(['to', 'from'])
            ->where('from_id', $this->id)
            ->whereIn('remarks', ['Withdraw'])
            ->whereDate('created_at', '>=', $this->searchData['start_date'])
            ->whereDate('created_at', '<=', $this->searchData['end_date'])
            ->whereIn('status', [0, 1])
            ->get();

        $queryResult = [
            'directIncomeWithExpense' => $directIncomeWithExpense,
            'indirectIncome' => $indirectIncome,
            'withdraws' => $withdraws,
        ];

        return $queryResult;
    }


    public function formattedData($queryResult)
    {

        $data = [];

        $incomeRemarks = ['ConversionToCash', 'TeamBonus', 'RankBonus', 'LevelBonus', 'SalesBonus', 'RePurchaseBonus', 'Entertainment'];
        $expenseRemarks = ['Withdraw', 'Transfer'];

        $balance = $this->previousBalance;

        foreach ($queryResult['directIncomeWithExpense'] as $walletInfo) {

            $isIncome = in_array($walletInfo->remarks, $incomeRemarks);

            if ($walletInfo->remarks == 'TeamBonus') {
                if ($walletInfo->pp == 100) {
                    continue;
                }
            }

            $income = 0;
            $expense = 0;

            if ($isIncome) {
                $income = $walletInfo->amount;
                $balance += $income;
            } else {
                $expense = $walletInfo->amount;
                $balance -= $expense;
            }

            $remarks = $walletInfo->remarks;

            if (in_array($walletInfo->remarks, ["Entertainment", "SalesBonus"])) {
                $remarks = $walletInfo->remarks == "SalesBonus" ? "Sales Bonus" : $walletInfo->remarks;
                if ($walletInfo->to) {
                    $remarks = $remarks . " By " . $walletInfo->to->name . " (" . $walletInfo->to->username . ")";
                }
            }

            if (in_array($walletInfo->remarks, ["Transfer"])) {

                if (@$walletInfo->to->id != $this->id) {
                    $remarks = $remarks . " To " . $walletInfo->to->name . " (" . $walletInfo->to->username . ")";
                }
            }

            if (in_array($walletInfo->remarks, ["RankBonus"])) {
                $remarks = "Rank Bonus of " . Carbon::createFromDate($walletInfo->year, $walletInfo->month)->format('M') . " " . $walletInfo->year;
            }

            if (in_array($walletInfo->remarks, ["TeamBonus"])) {
                $remarks = "Team Bonus from " . @$walletInfo->to->name . " (" . @$walletInfo->to->username . ")";
            }


            $data[] = [
                'dateTimeStamp' => strtotime($walletInfo->created_at),
                'date' => date('d-m-Y', strtotime($walletInfo->created_at)),
                'description' => $remarks,
                'income' => number_format($income, 2, '.', ''),
                'expense' =>  number_format($expense, 2, '.', ''),
                'balance' => number_format($balance, 2, '.', ''),
            ];

            if ($walletInfo->remarks == "Transfer") {

                $expense = (float)$walletInfo->charge;
                $balance -= $expense;

                $data[] = [
                    'dateTimeStamp' => strtotime($walletInfo->created_at),
                    'date' => date('d-m-Y', strtotime($walletInfo->created_at)),
                    'description' => "Transfer Service Charge",
                    'income' => 0,
                    'expense' =>  number_format($walletInfo->charge, 2, '.', ''),
                    'balance' => number_format($balance, 2, '.', ''),
                ];
            }

            if ($walletInfo->remarks == "Withdraw") {

                $expense = (float)$walletInfo->charge;
                $balance -= $expense;

                $data[] = [
                    'dateTimeStamp' => strtotime($walletInfo->created_at),
                    'date' => date('d-m-Y', strtotime($walletInfo->created_at)),
                    'description' => "Withdraw Service Charge",
                    'income' => 0,
                    'expense' =>  number_format($walletInfo->charge, 2, '.', ''),
                    'balance' => number_format($balance, 2, '.', ''),
                ];
            }
        }

        foreach ($queryResult['indirectIncome'] as $walletInfo) {

            // dd($walletInfo);

            $isIncome = in_array($walletInfo->remarks, $expenseRemarks);

            $income = 0;
            $expense = 0;

            if ($isIncome) {
                $income = $walletInfo->amount;
                $balance += $income;
            } else {
                $expense = $walletInfo->amount;
                $balance -= $expense;
            }

            $remarks = $walletInfo->remarks;

            if (in_array($walletInfo->remarks, ["Transfer"])) {

                if (@$walletInfo->from->id != $this->id) {
                    $remarks = "Receive from " . $walletInfo->from->name . " (" . $walletInfo->from->username . ")";
                }
            }

            $data[] = [
                'dateTimeStamp' => strtotime($walletInfo->created_at),
                'date' => date('d-m-Y', strtotime($walletInfo->created_at)),
                'description' => $remarks,
                'income' => number_format($income, 2, '.', ''),
                'expense' =>  number_format($expense, 2, '.', ''),
                'balance' => number_format($balance, 2, '.', ''),
            ];
        }

        foreach ($queryResult['withdraws'] as $walletInfo) {


            $isIncome = false;

            $income = 0;
            $expense = 0;

            if ($isIncome) {
                $income = $walletInfo->amount;
                $balance += $income;
            } else {
                $expense = $walletInfo->amount;
                $balance -= $expense;
            }

            $remarks = $walletInfo->remarks;

            if($walletInfo->status == 0){
                $remarks .= " (Pending)";
            }

            $data[] = [
                'dateTimeStamp' => strtotime($walletInfo->created_at),
                'date' => date('d-m-Y', strtotime($walletInfo->created_at)),
                'description' => $remarks,
                'income' => number_format($income, 2, '.', ''),
                'expense' =>  number_format($expense, 2, '.', ''),
                'balance' => number_format($balance, 2, '.', ''),
            ];
        }

        return $data;
    }


    public function recalculateBalance($formattedData)
    {

        $data = [];

        $balance = $this->previousBalance;

        foreach ($formattedData as $ld) {

            $balance += $ld['income'];
            $balance -= $ld['expense'];

            $ld['balance'] = number_format($balance, 2, '.', '');

            $data[] = $ld;
        }

        return $data;
    }

    public function getMyStatement()
    {
        $queryResult = $this->queryResult();

        $formattedData = $this->formattedData($queryResult);

        $dateTimeStamp = array_column($formattedData, 'dateTimeStamp');

        array_multisort($dateTimeStamp, SORT_ASC, $formattedData);

        $formattedData = $this->recalculateBalance($formattedData);

        return $formattedData;
    }
}
