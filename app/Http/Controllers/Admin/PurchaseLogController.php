<?php
    namespace App\Http\Controllers\Admin;

    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use App\PurchaseReturn;
    use App\CreditPurchase;
    use DB;
    use PDF;
    use MPDF;

    class PurchaseLogController extends Controller
    {
        public function index(Request $request)
        {
            $title = 'Purchase Log';
            $purchaseSearch = "";
            $supplierSearch = "";
            $purchaseLog = "";
            if($request->purchaseSearch!='' || $request->supplier !='')
            {
                $purchaseSearch = $request->purchaseSearch;
                $supplierSearch = $request->supplier;
                $purchaseLog = DB::table('purchase_log')->orWhere(function($q) use($purchaseSearch,$supplierSearch)
                {
                    if(@$purchaseSearch)
                    {
                        $q->whereIn('purchase_log.purchase_type',$purchaseSearch);
                    }

                    if(@$supplierSearch)
                    {
                        $q->whereIn('purchase_log.supplier_id',@$supplierSearch);
                    }
                })->get();

                // return view('admin.purchaseLog.index')->with(compact('purchaseLog','title','purchaseSearch','supplierSearch'));
            }
                return view('admin.purchaseLog.index')->with(compact('purchaseLog','title','purchaseSearch','supplierSearch'));
            // return view('admin.purchaseLog.index')->with(compact('title'));
        }

        public function print(Request $request)
        {
            if($request->purchaseParam!='' || $request->supplierParam !='')
            {
                if($request->purchaseParam != '')
                {
                    $purchaseSearch = explode(',', @$request->purchaseParam);
                }

                if($request->supplierParam != '')
                {
                    $supplierSearch = explode(',', @$request->supplierParam);
                }
                else
                {
                    $supplierSearch = '';
                }

                $purchaseLog = DB::table('purchase_log')->orWhere(function($q) use($purchaseSearch,$supplierSearch)
                {
                    if(@$purchaseSearch)
                    {
                        $q->whereIn('purchase_log.purchase_type',$purchaseSearch);
                    }

                    if(@$supplierSearch)
                    {
                        $q->whereIn('purchase_log.supplier_id',@$supplierSearch);
                    }
                })->get();
            }

            $title = 'Purchase Log Report';
            $pdf = PDF::loadView('admin.purchaseLog.prints',['purchaseLog'=>$purchaseLog,'title'=>$title,'purchaseSearch'=>$purchaseSearch,'supplierSearch'=>$supplierSearch]);

            return $pdf->stream('purchase_log.pdf');

            // $title = 'Purchase Log Report';
            // $data = ['purchaseLog'=>$purchaseLog,'title'=>$title,'purchaseSearch'=>$purchaseSearch,'supplierSearch'=>$supplierSearch];
            // $pdf = PDF::loadView('admin.purchaseLog.prints',['purchaseLog'=>$purchaseLog,'title'=>$title,'purchaseSearch'=>$purchaseSearch,'supplierSearch'=>$supplierSearch]);
            // $pdf = mb_convert_encoding(\View::make('admin/purchaseLog/prints', $data), 'HTML-ENTITIES', 'UTF-8');
            // return PDF::loadHtml($pdf)->stream();
            // return PDF::loadHtml($pdf)->download('invoice.pdf');
        }
    }