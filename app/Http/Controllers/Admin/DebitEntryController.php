<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\DebitEntry;
use App\ShowroomSetup;
use App\CoaSetup;

use Auth;
use DB;
use PDF;

class DebitEntryController extends Controller
{
    public function index(Request $request)
    {
        $title = "Debit Voucher Entry";
        $searchFormLink  = 'debitEntry.index';
        $printFormLink = "debitEntry.print";
        $print = $request->print;

        if ($print) {
            $fromDate = date('Y-m-d', strtotime($request->fromDate));
            $toDate = date('Y-m-d', strtotime($request->toDate));

            $transactionLists = DebitEntry::select('tbl_account_transactions.*', 'view_account.debitHeadname as debitHeadname', 'view_account.creditHeadName as creditHeadName')
                ->leftJoin('view_account', 'view_account.voucherNo', '=', 'tbl_account_transactions.voucher_no')
                ->orWhere(function ($query) use ($fromDate, $toDate) {
                    if (!empty($fromDate)) {
                        $query->whereBetween('tbl_account_transactions.voucher_date', array($fromDate, $toDate));
                    }
                })
                // ->where('tbl_account_transactions.showroom_id',$this->showroomId)
                ->where('tbl_account_transactions.voucher_type', 'DV')
                ->where('tbl_account_transactions.debit_amount', '0')
                ->groupBY('view_account.voucherNo')
                ->orderBY('view_account.debitHeadname', 'asc')
                ->get();
        } else {
            $transactionLists = DebitEntry::select('tbl_account_transactions.*', 'view_account.debitHeadname as debitHeadname', 'view_account.creditHeadName as creditHeadName')
                // ->where('tbl_account_transactions.showroom_id',$this->showroomId)
                ->leftJoin('view_account', 'view_account.voucherNo', '=', 'tbl_account_transactions.voucher_no')
                ->where('tbl_account_transactions.voucher_type', 'DV')
                ->where('tbl_account_transactions.debit_amount', '0')
                ->groupBY('view_account.voucherNo')
                ->orderBY('view_account.debitHeadname', 'asc')
                ->get();
            $fromDate = "";
            $toDate = "";
        }

        return view('admin.debitEntry.index')->with(compact('title', 'searchFormLink', 'printFormLink', 'print', 'fromDate', 'toDate', 'transactionLists'));
    }

    public function print(Request $request)
    {
        $title = "Print Debit Voucher Entry";
        $print = $request->print;

        if ($request->fromDate == "" && $request->toDate == "") {
            $transactionLists = DebitEntry::select('tbl_account_transactions.*', 'view_account.debitHeadname as debitHeadname', 'view_account.creditHeadName as creditHeadName')
                // ->where('tbl_account_transactions.showroom_id',$this->showroomId)
                ->leftJoin('tbl_coa', 'tbl_coa.head_code', '=', 'tbl_account_transactions.coa_head_code')
                ->leftJoin('view_account', 'view_account.voucherNo', '=', 'tbl_account_transactions.voucher_no')
                ->where('tbl_account_transactions.voucher_type', 'DV')
                ->where('tbl_account_transactions.debit_amount', '0')
                ->groupBY('view_account.voucherNo')
                ->orderBY('view_account.debitHeadname', 'asc')
                ->get();
            $fromDate = "";
            $toDate = "";
        } else {
            $fromDate = date('Y-m-d', strtotime($request->fromDate));
            $toDate = date('Y-m-d', strtotime($request->toDate));

            $transactionLists = DebitEntry::select('tbl_account_transactions.*', 'view_account.debitHeadname as debitHeadname', 'view_account.creditHeadName as creditHeadName')
                ->leftJoin('tbl_coa', 'tbl_coa.head_code', '=', 'tbl_account_transactions.coa_head_code')
                ->orWhere(function ($query) use ($fromDate, $toDate) {
                    if (!empty($fromDate)) {
                        $query->whereBetween('tbl_account_transactions.voucher_date', array($fromDate, $toDate));
                    }
                })
                // ->where('tbl_account_transactions.showroom_id',$this->showroomId)
                ->leftJoin('view_account', 'view_account.voucherNo', '=', 'tbl_account_transactions.voucher_no')
                ->where('tbl_account_transactions.voucher_type', 'DV')
                ->where('tbl_account_transactions.debit_amount', '0')
                ->groupBY('view_account.voucherNo')
                ->orderBY('view_account.debitHeadname', 'asc')
                ->get();
        }

        $pdf = PDF::loadView('admin.debitEntry.print', ['title' => $title, 'fromDate' => $fromDate, 'toDate' => $toDate, 'print' => $print, 'transactionLists' => $transactionLists], []);
        return $pdf->stream('debit_voucher_' . $fromDate . '_' . $toDate . '.pdf');
    }

    public function add()
    {
        $title = "Add Debit Voucher Entry";
        $formLink = "debitEntry.save";
        $buttonName = "Save";

        $voucherNo = $this->getVoucharNo();

        // $showrooms = ShowroomSetup::where('status','1')->get();
        $creditCoas = CoaSetup::where(function ($q) {

            $q->where('head_code', 'LIKE', '10101%')
                ->orWhere('head_code', 'LIKE', '10102%');
        })
            ->where('transaction', '1')
            ->orderBy('head_name', 'asc')
            ->get();


        $coas = CoaSetup::where(function ($q) {
            $q->where('head_code', 'LIKE', '10%')
                ->orWhere('head_code', 'LIKE', '40%');
        })
            ->where(function ($q) {
                $q->where('head_code', 'not like', '10101%')
                    ->where('head_code', 'not like', '10102%');
            })
            ->where('transaction', '1')
            ->orderBy('head_name', 'asc')
            ->get();

        return view('admin.debitEntry.add')->with(compact('title', 'formLink', 'buttonName', 'coas', 'creditCoas', 'voucherNo'));
    }

    public function save(Request $request)
    {
        // dd($request->all());
        $date = date('Y-m-d', strtotime($request->transactionDate));

        DebitEntry::create([
            'voucher_no' => $request->voucharNo,
            'voucher_type' => "DV",
            'voucher_date' => $date,
            'coa_head_code' => $request->creditAccountHead,
            // 'showroom_id' => $request->showroom,
            'narration' => $request->remarks,
            'debit_amount' => "0",
            'credit_amount' => $request->totalDebit,
            'posted' => "I",
            // 'created_by' => $this->userId
        ]);

        $countDebit = count($request->debit);
        if ($request->debit) {
            $postData = [];
            for ($i = 0; $i < $countDebit; $i++) {
                $postData[] = [
                    'voucher_no' => $request->voucharNo,
                    'voucher_type' => "DV",
                    'voucher_date' => $date,
                    'coa_head_code' => $request->coa[$i],
                    // 'showroom_id' => $request->showroom,
                    'narration' => $request->remarks,
                    'debit_amount' => $request->debit[$i],
                    'credit_amount' => "0",
                    'posted' => "I",
                    // 'created_by' => $this->userId
                ];
            }
            DebitEntry::insert($postData);
        }

        return redirect(route('debitEntry.index'))->with('msg', 'Debit Voucher Added Successfully');
    }

    public function edit($debitEntryId)
    {
        $title = "Edit Debit Voucher Entry";
        $formLink = "debitEntry.update";
        $buttonName = "Update";

        $info = $this->findDebitInfo($debitEntryId);
        $debitEntry = $info[0];
        $debitEntries = $info[1];

        $creditCoas = CoaSetup::where(function ($q) {

            $q->where('head_code', 'LIKE', '10101%')
                ->orWhere('head_code', 'LIKE', '10102%');
        })
            ->where('transaction', '1')
            ->orderBy('head_name', 'asc')
            ->get();


        $coas = CoaSetup::where(function ($q) {
            $q->where('head_code', 'LIKE', '10%')
                ->orWhere('head_code', 'LIKE', '40%');
        })
            ->where(function ($q) {
                $q->where('head_code', 'not like', '10101%')
                    ->where('head_code', 'not like', '10102%');
            })
            ->where('transaction', '1')
            ->orderBy('head_name', 'asc')
            ->get();

        return view('admin.debitEntry.edit')->with(compact('title', 'formLink', 'buttonName', 'debitEntry', 'debitEntries', 'coas', 'creditCoas'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $date = date('Y-m-d', strtotime($request->transactionDate));

        DebitEntry::where('voucher_no', $request->voucharNo)->delete();

        DebitEntry::create([
            'voucher_no' => $request->voucharNo,
            'voucher_type' => "DV",
            'voucher_date' => $date,
            'coa_head_code' => $request->creditAccountHead,
            // 'showroom_id' => $request->showroom,
            'narration' => $request->remarks,
            'debit_amount' => "0",
            'credit_amount' => $request->totalDebit,
            'posted' => "I",
            'created_by' => $request->createdBy,
            // 'updated_by' => $this->userId
        ]);

        $countDebit = count($request->debit);
        if ($request->debit) {
            $postData = [];
            for ($i = 0; $i < $countDebit; $i++) {
                $postData[] = [
                    'voucher_no' => $request->voucharNo,
                    'voucher_type' => "DV",
                    'voucher_date' => $date,
                    'coa_head_code' => $request->coa[$i],
                    // 'showroom_id' => $request->showroom,
                    'narration' => $request->remarks,
                    'debit_amount' => $request->debit[$i],
                    'credit_amount' => "0",
                    'posted' => "I",
                    'created_by' => $request->createdBy,
                    // 'updated_by' => $this->userId
                ];
            }
            DebitEntry::insert($postData);
        }

        return redirect(route('debitEntry.index'))->with('msg', 'Debit Voucher Updated Successfully');
    }

    public function view($debitEntryId)
    {
        $title = "View Debit Voucher Entry";

        $info = $this->findDebitInfo($debitEntryId);
        $debitEntry = $info[0];
        $debitEntries = $info[1];

        return view('admin.debitEntry.view')->with(compact('title', 'debitEntry', 'debitEntries'));
    }

    public function printDebitVoucher($debitEntryId)
    {
        $title = "Print Debit Voucher";

        $info = $this->findDebitInfo($debitEntryId);
        $debitEntry = $info[0];
        $debitEntries = $info[1];

        // return view('admin.debitEntry.printDebitVoucher')->with(compact('title', 'debitEntry', 'debitEntries'));

        $pdf = PDF::loadView('admin.debitEntry.printDebitVoucher', ['title' => $title, 'debitEntry' => $debitEntry, 'debitEntries' => $debitEntries], []);
        return $pdf->stream('debit_voucher_' . $debitEntry->voucher_no . '.pdf');
    }

    public function findDebitInfo($debitEntryId)
    {
        $debitEntry = DebitEntry::select('tbl_account_transactions.*', 'tbl_coa.head_name as creditHeadName')
            // ->leftJoin('tbl_showroom', 'tbl_showroom.id', '=', 'tbl_account_transactions.showroom_id')
            ->leftJoin('tbl_coa', 'tbl_coa.head_code', '=', 'tbl_account_transactions.coa_head_code')
            // ->where('tbl_account_transactions.showroom_id',$this->showroomId)
            ->where('tbl_account_transactions.id', $debitEntryId)
            ->first();

        $debitEntries = DebitEntry::select('tbl_account_transactions.*', 'tbl_coa.head_name as debitHeadName')
            ->leftJoin('tbl_coa', 'tbl_coa.head_code', '=', 'tbl_account_transactions.coa_head_code')
            // ->where('tbl_account_transactions.showroom_id',$this->showroomId)
            ->where('voucher_no', $debitEntry->voucher_no)
            ->where('credit_amount', '0')
            ->get();

        return array($debitEntry, $debitEntries);
    }

    public function changePublish(Request $request)
    {
        $debitEntryId = $request->debitEntryId;

        $debitEntry = DebitEntry::find($debitEntryId);

        if ($debitEntry->active == 0) {
            DebitEntry::where('voucher_no', $debitEntry->voucher_no)->update(['active' => 1]);
        } else {
            DebitEntry::where('voucher_no', $debitEntry->voucher_no)->update(['active' => 0]);
        }
    }

    public function delete(Request $request)
    {
        $debitEntry = DebitEntry::find($request->debitEntryId);

        DebitEntry::where('voucher_no', $debitEntry->voucher_no)->delete();
    }

    public function getVoucharNo()
    {

        $str = "DV-";

        $serialNo = DebitEntry::where('voucher_type', 'DV')->where('voucher_no', 'LIKE', '%' . $str . '%')->max('voucher_no');

        if ($serialNo) {
            $serialNo = substr($serialNo, strlen($str));
            $voucherNo = $str . ($serialNo + 1);
        } else {
            $voucherNo = $str . "1000000001";
        }

        return $voucherNo;
    }

    public function getCoa(Request $request)
    {
        $output = '';
        $total = $request->total;

        $coas = CoaSetup::where(function ($q) {
            $q->where('head_code', 'LIKE', '10%')
                ->orWhere('head_code', 'LIKE', '40%');
        })
            ->where(function ($q) {
                $q->where('head_code', 'not like', '10101%')
                    ->where('head_code', 'not like', '10102%');
            })
            ->where('transaction', '1')
            ->orderBy('head_name', 'asc')
            ->get();

        if ($coas) {
            $output .= '<select class="chosen-select coa coa_' . $total . '" id="coa" name="coa[]">';
            $output .= '<option value="">Select Account Name</option>';
            foreach ($coas as $coas) {
                $output .= '<option value="' . $coas->head_code . '">' . $coas->head_name . '</option>';
            }
            $output .= '</select>';
        } else {
            $output .= '<select class="chosen-select coa coa_' . $total . '" id="coa" name="coa[]">';
            $output .= '<option value="">Select Account Name</option>';
            $output .= '</select>';
        }

        echo $output;
    }
}
