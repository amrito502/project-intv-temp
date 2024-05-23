<?php

namespace App\Http\Controllers;

use App\Helper\Ui\FlashMessageGenerator;
use App\Models\Project;
use App\Models\BudgetHead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetHeadController extends Controller
{

    public function index(Request $request)
    {

        if (!Auth::user()->can('Cost Head')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {
            return BudgetHead::datatable();
        }

        return view('dashboard.budgethead.budgethead_index');
    }

    public function create()
    {

        if (!Auth::user()->can('create budgethead')) {
            return redirect(route('home'));
        }

        $data = (object)[
            'title' => 'Create Budget Head',
        ];

        return view('dashboard.budgethead.create_budgethead', compact('data'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('create budgethead')) {
            return redirect(route('home'));
        }

        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        // check if budgethead already exists
        $budgethead = BudgetHead::where('name', $validatedData['name'])->first();

        if ($budgethead) {
            FlashMessageGenerator::generate('danger', 'Budget Head already exists');
            return back();
        }

        $validatedData['type'] = 'Cash';
        $validatedData['company_id'] = $request->company ? $request->company : Auth::user()->company_id;

        $budgethead = BudgetHead::create($validatedData);

        if ($request->ajax()) {
            return [
                'budgetHead' => $budgethead,
            ];
        }

        return redirect(route('budgethead.index'));
    }

    public function show(BudgetHead $budgethead)
    {
        //
    }

    public function edit(BudgetHead $budgethead)
    {
        if (!Auth::user()->can('edit budgethead')) {
            return redirect(route('home'));
        }

        $data = (object) [
            'title' => 'Edit Budget Head',
            'budgethead' => $budgethead,
        ];

        return view('dashboard.budgethead.edit_budgethead', compact('data'));
    }

    public function update(Request $request, BudgetHead $budgethead)
    {
        if (!Auth::user()->can('edit budgethead')) {
            return redirect(route('home'));
        }

        $validatedData = $request->validate([
            // 'type' => 'required',
            'name' => 'required',
        ]);

        $validatedData['company_id'] = $request->company ? $request->company : Auth::user()->company_id;

        $budgethead->update($validatedData);

        return redirect(route('budgethead.index'));
    }

    public function destroy(BudgetHead $budgethead)
    {
        $budgethead->delete();
        return true;
    }
}
