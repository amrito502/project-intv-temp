<?php

namespace App\Helper\Reports;

use App\Models\Material;
use Carbon\CarbonPeriod;
use App\Models\DailyUses;
use App\Models\MaterialIssue;
use App\Models\MaterialLifting;
use App\Models\DailyConsumption;
use App\Helper\Project\StockHelper;
use Illuminate\Support\Facades\Auth;
use App\Helper\Project\BasicMaterialStock;

class MaterialStatementReport
{

    public $project_id;
    public $material_id;
    public $budgetHead;
    public $start_date;
    public $end_date;

    public function __construct($filters)
    {

        $this->project_id = $filters['project'];
        $this->material_id = $filters['material'];
        $this->start_date = $filters['start_date'];
        $this->end_date = $filters['end_date'];

        $this->budgetHead = Material::find($this->material_id)->budgetheadInfo();

    }

    public function queryData()
    {

        $materialId = $this->material_id;

        $liftings = MaterialLifting::with(['liftingMaterials'])
            ->where('company_id', Auth::user()->company_id)
            ->whereHas('liftingMaterials', function ($q) use ($materialId) {
                if ($materialId) {
                    $q->where('material_id', $materialId);
                }
            })
            ->whereDate('vouchar_date', '>=', $this->start_date)
            ->whereDate('vouchar_date', '<=', $this->end_date);

        if ($this->project_id) {
            $liftings = $liftings->where('project_id', $this->project_id);
        }

        $liftings = $liftings->get();


        $localIssues = DailyConsumption::with(['items'])
            ->where('company_id', Auth::user()->company_id)
            ->whereHas('items', function ($q) use ($materialId) {
                if ($materialId) {
                    $q->where('budget_head_id', $this->budgetHead->id);
                }
            })
            ->whereDate('date', '>=', $this->start_date)
            ->whereDate('date', '<=', $this->end_date);

        if ($this->project_id) {
            $localIssues = $localIssues->where('project_id', $this->project_id);
        }

        $localIssues = $localIssues->get();

        $localUses = DailyUses::with(['items'])
            ->where('company_id', Auth::user()->company_id)
            ->whereHas('items', function ($q) use ($materialId) {
                if ($materialId) {
                    $q->where('budget_head_id', $this->budgetHead->id);
                }
            })
            ->whereDate('date', '>=', $this->start_date)
            ->whereDate('date', '<=', $this->end_date);

        if ($this->project_id) {
            $localUses = $localUses->where('project_id', $this->project_id);
        }

        $localUses = $localUses->get();


        $receives = MaterialIssue::with(['issuedMaterials'])
            ->whereHas('issuedMaterials', function ($q) use ($materialId) {
                if ($materialId) {
                    $q->where('material_id', $materialId);
                }
            });

        if ($this->project_id) {
            $receives = $receives->where('project_id', $this->project_id);
        }

        $receives->where('company_id', Auth::user()->company_id)
            ->get();


        $returns = MaterialIssue::with(['issuedMaterials'])
            ->whereHas('issuedMaterials', function ($q) use ($materialId) {
                if ($materialId) {
                    $q->where('material_id', $materialId);
                }
            });

        if ($this->project_id) {
            $returns = $returns->where('source_project_id', $this->project_id);
        }

        $returns->where('company_id', Auth::user()->company_id)
            ->get();


        return [
            'liftings' => $liftings,
            'localIssues' => $localIssues,
            'localUses' => $localUses,
            'receives' => $receives,
            'returns' => $returns,
        ];
    }

    public function generate($opening = 0)
    {

        $report = [];

        $queryData = $this->queryData();

        $dateRange = CarbonPeriod::between($this->start_date, $this->end_date)->toArray();

        foreach ($dateRange as $date) {

            $timestamp = $date->timestamp;
            $queryDate = $date->format('Y-m-d');
            $frontDate = $date->format('d-m-Y');

            $lifting = 0;
            $localissue = 0;
            $receive = 0;
            $uses = 0;
            $return = 0;

            if ($queryData['liftings']->where('vouchar_date', $queryDate)->count()) {
                foreach ($queryData['liftings']->where('vouchar_date', $queryDate) as $liftingVoucher) {
                    $lifting += $liftingVoucher->totalAmount();
                }
            }

            if ($queryData['localIssues']->where('date', $queryDate)->count()) {
                foreach ($queryData['localIssues']->where('date', $queryDate) as $localIssueVoucher) {
                    $localissue += $localIssueVoucher->grandTotalIssueAmount();
                }
            }

            if ($queryData['receives']->where('issue_date', $queryDate)->count()) {
                foreach ($queryData['receives']->where('issue_date', $queryDate) as $receiveVoucher) {
                    $receive += $receiveVoucher->totalAmount();
                }
            }

            if ($queryData['returns']->where('issue_date', $queryDate)->count()) {
                foreach ($queryData['receives']->where('issue_date', $queryDate) as $returnVoucher) {
                    $return += $returnVoucher->totalAmount();
                }
            }

            if ($queryData['localUses']->where('date', $queryDate)->count()) {
                foreach ($queryData['localUses']->where('date', $queryDate) as $localUsesVoucher) {
                    $uses += $localUsesVoucher->grandTotalUseAmount();
                }
            }

            if($lifting == 0 && $localissue == 0 && $receive == 0 && $uses == 0 && $return == 0){
                continue;
            }

            $balance = ($opening + $lifting + $localissue + $receive) - ($uses + $return);

            $opening = round($balance, 2);

            $report[] = [
                'timestamp' => $timestamp,
                'date' => $frontDate,
                'lifting' => round($lifting, 2),
                'localissue' => round($localissue, 2),
                'receive' => round($receive, 2),
                'uses' => round($uses, 2),
                'return' => round($return, 2),
                'balance' => round($balance, 2),
            ];

        }

        return [
            'report_table' => $report,
        ];
    }
}
