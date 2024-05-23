<?php

namespace App\Helper;

use App\User;
use App\Wallet;

class TeamPaymentStatus
{

    protected $params;
    protected $reportData;

    public function __construct($params)
    {
        $this->params = $params;

        if (!$this->params["members"]) {
            $this->params["members"] = User::pluck('id')->toArray();
        }

        $this->getData();
    }

    public function getWalletInfo($user, $startDate, $endDate)
    {
        $achieve = Wallet::where('from_id', $user->id)
            ->whereIn('remarks', ['TeamBonus', 'SalesBonus', 'RePurchaseBonus', 'Entertainment', 'RankBonus', 'LevelBonus'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 1)
            ->sum('amount');

        $receive = Wallet::where('to_id', $user->id)
            ->whereIn('remarks', ['Withdraw', 'Transfer'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 1)
            ->sum('amount');

        $transfer = Wallet::where('from_id', $user->id)
            ->whereIn('remarks', ['Transfer'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 1)
            ->sum('amount');

        $transfer_charge = Wallet::where('from_id', $user->id)
            ->whereIn('remarks', ['Transfer'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 1)
            ->sum('charge');

        $withdraw = Wallet::where('from_id', $user->id)
            ->whereIn('remarks', ['Withdraw'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 1)
            ->sum('amount');

        $withdraw_charge = Wallet::where('from_id', $user->id)
            ->whereIn('remarks', ['Withdraw'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 1)
            ->sum('charge');

        $charge = $transfer_charge + $withdraw_charge;

        $balance = ($achieve + $receive) - ( $transfer + $withdraw + $charge);

        return [
            'achieve' => $achieve,
            'receive' => $receive,
            'transfer' => $transfer,
            'withdraw' => $withdraw,
            'charge' => $charge,
            'balance' => $balance,
        ];
    }

    public function getData()
    {


        $reportData = [];

        $users = User::whereIn('id', $this->params["members"])->get();

        foreach ($users as $user) {

            // current wallet
            $walletInfo = $this->getWalletInfo($user, $this->params["dateRange"]["start_date"], $this->params["dateRange"]["end_date"]);
            $achieve = $walletInfo['achieve'];
            $receive = $walletInfo['receive'];
            $transfer = $walletInfo['transfer'];
            $withdraw = $walletInfo['withdraw'];
            $charge = $walletInfo['charge'];

            // previous Wallet
            $oneDayBeforeStartDate = date('Y-m-d', strtotime( $this->params["dateRange"]["start_date"] . " -1 days"));
            $previousWalletInfo = $this->getWalletInfo($user, "0000-00-00", $oneDayBeforeStartDate);
            $previousBalance = $previousWalletInfo['balance'];

            $balance = $walletInfo['balance'] + $previousBalance;

            if ($balance < 1) {
                continue;
            }

            $reportData[] = [
                'user' => $user,
                'achieve' => number_format($achieve, 2, ".", ""),
                'receive' => number_format($receive, 2, ".", ""),
                'transfer' => number_format($transfer, 2, ".", ""),
                'payment' => number_format($withdraw, 2, ".", ""),
                'charge' => number_format($charge, 2, ".", ""),
                'balance' => number_format($balance, 2, ".", ""),
                'previousBalance' => number_format($previousBalance, 2, ".", ""),
            ];
        }

        // sort array by balance
        usort($reportData, function ($a, $b) {
            return $b['balance'] - $a['balance'];
        });

        $this->reportData = $reportData;
    }

    public function getReport()
    {
        return $this->reportData;
    }
}
