<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectWiseBudget;
use App\Models\ProjectBudgetWiseRoa;
use Illuminate\Support\Facades\Auth;

class ProjectWiseRoaBudgetController extends Controller
{

    public function index(Request $request, $projectBudgetId)
    {
        if (!Auth::user()->can('ROA')) {
            return redirect(route('home'));
        }

        $data = (object)[
            'projectWiseBudget' => ProjectWiseBudget::where('id', $projectBudgetId)->where('is_additional', 0)->with(['project'])->first(),
            'projecBudgettWiseRoa' => ProjectBudgetWiseRoa::where('projectwise_budget_id', $projectBudgetId)->get(),
        ];

        return view('dashboard.projectwise_roa_budget.projectwise_roa_budget_index', compact('data'));
    }

    public function update(Request $request, $projectBudgetId)
    {
        if (!Auth::user()->can('ROA')) {
            return redirect(route('home'));
        }

        $data = $request->all();
        unset($data['_token']);

        ProjectBudgetWiseRoa::where('projectwise_budget_id', $projectBudgetId)->delete();

        if (count($data)) {
            $i = 0;
            foreach ($data['survery_date'] as $date) {

                ProjectBudgetWiseRoa::create([
                    'projectwise_budget_id' => $projectBudgetId,
                    'survery_date' => $data['survery_date'][$i],
                    'owner_name' => $data['owner_name'][$i],
                    'access_type' => $data['access_type'][$i],
                    'phone' => $data['phone'][$i],
                    'crops' => $data['crops'][$i],
                    'area' => $data['area'][$i],
                    'per_area' => $data['per_area'][$i],
                    'rate_per_kg' => $data['rate_per_kg'][$i],
                    'total' => $data['total'][$i],
                    'payment_date' => $data['payment_date'][$i],
                    'advance_paid' => $data['advance_paid'][$i],
                    'owner_demand' => $data['owner_demand'][$i],
                    'created_by' => Auth::user()->id,
                ]);

                $i++;
            }
        }

        return redirect(route('projectwiseroa.index', $projectBudgetId));
    }
}
