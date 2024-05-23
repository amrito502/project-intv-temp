<?php
namespace App\Helper\Project;

use App\Models\Material;

class MaterialHelper {

    public static function materialIdToBudgetHeadId(array $materialIds)
    {
      	$materials = Material::whereIn('id', $materialIds)->get();

      	$budgetHeadsIds= [];

      	foreach($materials as $material){

            $budgetHead = $material->budgetheadInfo();

            if(!$budgetHead){
                continue;
            }

         	$budgetHeadId = $material->budgetheadInfo()->id;

          	array_push($budgetHeadsIds, $budgetHeadId);
        }

      	return $budgetHeadsIds;
    }

}
