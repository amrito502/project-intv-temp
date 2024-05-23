<?php

namespace App\Helper\Reports;

use App\Models\MaterialIssue;
use Illuminate\Support\Facades\Auth;


class IssueLogReport
{

    public $start_date;
    public $end_date;
    public $source_project;
    public $source_tower;
    public $destination_project;
    public $destination_tower;
    public $material_ids;

    public function __construct($filters)
    {

        $this->start_date = $filters['start_date'];
        $this->end_date = $filters['end_date'];
        $this->source_project = $filters['source_project'];
        $this->source_tower = $filters['source_tower'];
        $this->destination_project = $filters['destination_project'];
        $this->destination_tower = $filters['destination_tower'];
        $this->material_ids = $filters['materials'];
    }

    public function query()
    {

        $materialIds = $this->material_ids;

        $materialIssue = MaterialIssue::where('issue_date', '>=', $this->start_date)
            ->where('issue_date', '<=', $this->end_date)
            ->where('source_project_id', $this->source_project)
            ->where('project_id', $this->destination_project)
            ->where('company_id', Auth::user()->company_id);

        if ($this->source_tower) {
            $materialIssue = $materialIssue->where('source_tower_id', $this->source_tower);
        }

        if ($this->destination_tower) {
            $materialIssue = $materialIssue->where('tower_id', $this->destination_tower);
        }

        $materialIssue = $materialIssue->with('issuedMaterials.material.materialUnit', 'SourceProject', 'project')
            ->whereHas('issuedMaterials', function ($q) use ($materialIds) {
                if ($materialIds) {
                    $q->whereIn('material_id', $materialIds);
                }
            })
            ->get();


        return $materialIssue;
    }

    public function generate()
    {

        $queryData = $this->query();

        $data = [];

        foreach ($queryData as $MaterialIssue) {


            foreach ($MaterialIssue->issuedMaterials as $issuedMaterial) {

                $ld = [
                    'date' => date('d-m-Y', strtotime($MaterialIssue->issue_date)),
                    'material' => $issuedMaterial->material->name . ' (' . $issuedMaterial->material->materialUnit->name . ')',
                    'issued_qty' => $issuedMaterial->material_qty,
                    'receive_qty' => $issuedMaterial->receive_qty == 0 ? '-' : $issuedMaterial->receive_qty,
                    'source_project' => $MaterialIssue->SourceProject->project_name,
                    'issue_project' => $MaterialIssue->project->project_name,
                ];

                array_push($data, $ld);
            }
        }

        return [
            'report_table' => $data,
        ];
    }
}
