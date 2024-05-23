<?php

namespace App\Helper\Reports;

use App\Models\MaterialLifting;
use Illuminate\Support\Facades\Auth;

class LiftingReport
{

    public $start_date;
    public $end_date;
    public $project_id;
    public $unit_id;
    public $tower_id;
    public $vendor_ids;
    public $logistics_associate_ids;
    public $lifting_type;
    public $material_ids;

    public function __construct($filters)
    {

        $this->start_date = $filters['start_date'];
        $this->end_date = $filters['end_date'];
        $this->project_id = $filters['project'];
        $this->unit_id = $filters['unit'];
        $this->tower_id = $filters['tower'];
        $this->vendor_ids = $filters['vendors'];
        $this->logistics_associate_ids = $filters['logistics_associates'];
        $this->lifting_type = $filters['lifting_type'];
        $this->material_ids = $filters['materials'];
    }

    public function query()
    {

        $materialIds = $this->material_ids;

        $materialLifting = MaterialLifting::where('company_id', Auth::user()->company_id);

        if ($this->project_id) {
            $materialLifting->where('project_id', $this->project_id);
        }

        if ($this->lifting_type) {
            $materialLifting->where('lifting_type', $this->lifting_type);
        }

        if ($this->vendor_ids) {
            $materialLifting->whereIn('vendor_id', $this->vendor_ids);
        }

        if ($this->logistics_associate_ids) {
            $materialLifting->whereIn('logistics_vendor', $this->logistics_associate_ids);
        }

        if ($this->unit_id) {
            $materialLifting->where('unit_id', $this->unit_id);
        }

        if ($this->tower_id) {
            $materialLifting->where('tower_id', $this->tower_id);
        }

        $materialLifting = $materialLifting->where('vouchar_date', '>=', $this->start_date)
            ->where('vouchar_date', '<=', $this->end_date)
            ->with(['project', 'vendor', 'liftingMaterials.material'])
            ->whereHas('liftingMaterials', function ($q) use ($materialIds) {
                if ($materialIds) {
                    $q->whereIn('material_id', $materialIds);
                }
            })
            ->get();


        return $materialLifting;
    }

    public function generate()
    {

        $queryData = $this->query();

        $data = [];

        foreach ($queryData as $materialLifting) {


            foreach ($materialLifting->liftingMaterials as $liftingMaterial) {

                $ld = [
                    'date' => date('d-m-Y', strtotime($materialLifting->vouchar_date)),
                    'vendor' => $materialLifting?->vendor?->name,
                    'project' => $materialLifting?->project?->project_name,
                    'material' => $liftingMaterial->material?->name,
                    'qty' => $liftingMaterial->material_qty,
                    'amount' => $liftingMaterial->material_qty * $liftingMaterial->material_rate,
                ];

                if($ld['vendor'] == ""){
                    $ld['vendor'] = $materialLifting->lifting_type;
                }

                if($ld['project'] == ""){
                    $ld['project'] = "Central Store";
                }

                array_push($data, $ld);
            }
        }

        return [
            'report_table' => $data,
        ];
    }
}
