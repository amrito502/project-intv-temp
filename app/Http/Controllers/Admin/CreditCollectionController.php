<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Customer;

use App\CreditSale;
use App\ClientEntry;
use App\CreditCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CreditCollectionController extends Controller
{
    public function index()
    {
        $title = $this->title;
        $creditCollections = CreditCollection::with(['dealer'])->get();
        return view('admin.creditCollection.index')->with(compact('title', 'creditCollections'));
    }

    public function add()
    {
        $title = "Credit Collection";
        $customers = User::where('role', 4)->get();
        return view('admin.creditCollection.add')->with(compact('title', 'customers'));
    }

    public function getClientInfo(Request $request)
    {
        $clientInfo = ClientEntry::where('id', $request->clientId)->first();
        $creditSalesInfo = CreditSale::where('customer_id', $request->clientId)->get();
        $creditCollectionsInfo = CreditCollection::where('client_id', $request->clientId)->get();

        $credit_collection_id = CreditCollection::whereRaw('id = (select max(`id`) from credit_collections)')->first();

        if (!$credit_collection_id) {
            $random_no = 1;
        } else {
            $random_no = $credit_collection_id->id + 1;
        }

        $payment_no = vsprintf("%04d-%04d-%04d", str_split(sprintf("%012d", $random_no), 4));

        $data = [
            'clientInfo' => $clientInfo,
            'creditSalesInfo' => $creditSalesInfo,
            'payment_no' => $payment_no,
            'creditCollectionsInfo' => $creditCollectionsInfo
        ];

        return $data;
    }

    public function getDealerInfo(Request $request)
    {
        $clientInfo = User::findOrFail($request->clientId);

        $creditSaleTotal = $clientInfo->totalCreditSaleAmount();

        $creditCollectionTotal = $clientInfo->totalCreditCollectionAmount();

        $creditDueTotal = $creditSaleTotal - $creditCollectionTotal;

        $credit_collection_id = CreditCollection::whereRaw('id = (select max(`id`) from credit_collections)')->first();

        if (!$credit_collection_id) {
            $random_no = 1;
        } else {
            $random_no = $credit_collection_id->id + 1;
        }

        $payment_no = vsprintf("%04d-%04d-%04d", str_split(sprintf("%012d", $random_no), 4));

        $data = [
            'clientInfo' => $clientInfo,
            'payment_no' => $payment_no,
            'creditDueTotal' => $creditDueTotal,
            // 'creditCollectionsInfo' => $creditCollectionsInfo
        ];

        return $data;
    }

    public function save(Request $request)
    {
        $paymentDate = date('Y-m-d', strtotime($request->payment_date));

        $this->validate(request(), [
            'client' => 'required',
            'payment_no' => 'required',
            'payment_date' => 'required',
            'money_receipt_no' => 'required',
            'money_receipt_type' => 'required',
            'new_paid' => 'required',
        ]);

        // $data = $request->all();
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit();

        $clientEntry = CreditCollection::create([
            'client_id' => $request->client,
            'payment_no' => $request->payment_no,
            'payment_date' => $paymentDate,
            'money_receipt_no' => $request->money_receipt_no,
            'money_receipt_type' => $request->money_receipt_type,
            'payment_amount' => $request->new_paid,
            'remarks' => $request->remarks,
        ]);

        return redirect(route('creditCollection.index'))->with('msg', 'Credit Collected Successfully');
    }

    public function edit($id)
    {
        $title = "Credit Collection";
        $creditCollection = CreditCollection::where('id', $id)->first();

        $clientId = $creditCollection->client_id;

        $clientEntry = ClientEntry::where('id', $clientId)->first();
        $creditSales = CreditSale::where('customer_id', $clientId)->get();
        $creditCollections = CreditCollection::where('client_id', $clientId)->get();

        $payment_amounts = 0;
        $net_amounts = 0;
        $due_amount = 0;

        foreach ($creditCollections as $collection) {
            if ($collection->id != $id) {
                $payment_amounts = $payment_amounts + $collection->payment_amount;
            }
        }

        foreach ($creditSales as $creditSale) {
            $net_amounts = $net_amounts + $creditSale->net_amount;
        }

        $due_amount = $net_amounts - $payment_amounts;

        return view('admin.creditCollection.edit')->with(compact('title', 'creditCollection', 'clientEntry', 'due_amount'));;
    }

    public function update(Request $request)
    {
        $paymentDate = date('Y-m-d', strtotime($request->payment_date));
        $creditCollectionId = $request->credit_collection_id;

        $this->validate(request(), [
            'client' => 'required',
            'payment_no' => 'required',
            'payment_date' => 'required',
            'money_receipt_no' => 'required',
            'money_receipt_type' => 'required',
            'new_paid' => 'required',
        ]);

        // $data = $request->all();
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit();

        $creditCollection = CreditCollection::find($creditCollectionId);

        $creditCollection->update([
            'client_id' => $request->client,
            'payment_no' => $request->payment_no,
            'payment_date' => $paymentDate,
            'money_receipt_no' => $request->money_receipt_no,
            'money_receipt_type' => $request->money_receipt_type,
            'payment_amount' => $request->new_paid,
            'remarks' => $request->remarks,
        ]);

        return redirect(route('creditCollection.index'))->with('msg', 'Collected Credit Updated Successfully');
    }

    public function destroy(Request $request)
    {
        CreditCollection::where('id', $request->creditCollectionId)->delete();
    }
}
