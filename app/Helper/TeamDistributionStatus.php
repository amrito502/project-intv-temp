<?php

namespace App\Helper;

use App\User;
use App\Wallet;

class TeamDistributionStatus
{

    protected $params;
    protected $queryData;
    protected $report;

    public function __construct($params)
    {
        $this->params = $params;

        if (!$this->params["members"]) {
            $this->params["members"] = User::pluck('id')->toArray();
        }
    }


    public function getReport()
    {

        $reportData = [];

        $users = User::whereIn('id', $this->params["members"])->get();

        foreach ($users as $user) {


            $salesBonus = Wallet::where('from_id', $user->id)
                ->where('created_at', '>=', $this->params["dateRange"]["start_date"])
                ->where('created_at', '<=', $this->params["dateRange"]["end_date"])
                ->whereIn('remarks', ['SalesBonus'])
                ->where('status', 1)
                ->sum('amount');

            $teamBonus = Wallet::where('from_id', $user->id)
                ->where('created_at', '>=', $this->params["dateRange"]["start_date"])
                ->where('created_at', '<=', $this->params["dateRange"]["end_date"])
                ->whereIn('remarks', ['TeamBonus'])
                ->where('status', 1)
                ->sum('amount');

            $rePurchaseBonus = Wallet::where('from_id', $user->id)
                ->where('created_at', '>=', $this->params["dateRange"]["start_date"])
                ->where('created_at', '<=', $this->params["dateRange"]["end_date"])
                ->whereIn('remarks', ['RePurchaseBonus'])
                ->where('status', 1)
                ->sum('amount');

            $rankBonus = Wallet::where('from_id', $user->id)
                ->where('created_at', '>=', $this->params["dateRange"]["start_date"])
                ->where('created_at', '<=', $this->params["dateRange"]["end_date"])
                ->whereIn('remarks', ['RankBonus'])
                ->where('status', 1)
                ->sum('amount');

            if ($salesBonus == 0 && $teamBonus == 0 && $rePurchaseBonus == 0 && $rankBonus == 0) {
                continue;
            }


            if ($this->params['type']) {

                if (in_array('TeamBonus', $this->params['type']) && $teamBonus == 0) {
                    continue;
                }

                if (in_array('SalesBonus', $this->params['type']) && $salesBonus == 0) {
                    continue;
                }

                if (in_array('RePurchaseBonus', $this->params['type']) && $rePurchaseBonus == 0) {
                    continue;
                }

                if (in_array('RankBonus', $this->params['type']) && $rankBonus == 0) {
                    continue;
                }
            }

            $reportData[] = [
                'user' => $user,
                'sales_bonus' => $salesBonus,
                'team_bonus' => $teamBonus,
                'repurchase_bonus' => $rePurchaseBonus,
                'rank_bonus' => $rankBonus,
                'total' => $salesBonus + $teamBonus + $rePurchaseBonus + $rankBonus,
            ];
        }


        return $reportData;
    }
}
