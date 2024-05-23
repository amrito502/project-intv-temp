@php
use App\Helper\Ui\NumberToWordConverter;
$class_obj = new NumberToWordConverter();
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transportation Bill Prepare Voucher</title>
</head>

@include('dashboard.reports.partials.common_css')

<body>

    <div class="tile">
        <div class="tile-body">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12">

                        @include('dashboard.reports.partials.layout.report_heading')


                        <div class="header">
                            <h2>Transportation Bill</h2>
                        </div>

                        <div style="width: 100%;overflow:none;">
                            <div style="width:46%;float:left;">
                                <table>
                                    <tr>
                                        <td style="width:100px;">T.Bill number</td>
                                        <td style="width:10px;">:</td>
                                        <td>{{ $data->tbp->system_serial }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width:100px;">Project</td>
                                        <td style="width:10px;">:</td>
                                        <td>{{ $data->tbp->project->project_name }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div style="width:46%;float:right;">
                                <table>
                                    <tr>
                                        <td style="width:100px;">Date</td>
                                        <td style="width:10px;">:</td>
                                        <td>{{ date('d-m-Y',
                                            strtotime($data->tbp->created_at)) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width:100px;">Vendor</td>
                                        <td style="width:10px;">:</td>
                                        <td>{{ $data->tbp->vendor->name }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width:100px;">Phone</td>
                                        <td style="width:10px;">:</td>
                                        <td>{{ $data->tbp->vendor->contact_person_phone }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width:100px;">Address</td>
                                        <td style="width:10px;">:</td>
                                        <td>{{ $data->tbp->vendor->address }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>



                        <table class="table table-hover table-bordered" style="margin-top: 100px;">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Issue Number</th>
                                    <th>Tower</th>
                                    <th>Material & UOM</th>
                                    <th>Rate Per UOM</th>
                                    <th>Qty</th>
                                    <th>Charge</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                @php
                                $totalQty = 0;
                                $totalCharge = 0;
                                @endphp
                                @foreach ($data->tbp_items as $tbp_item)
                                @php
                                $totalQty += $tbp_item->material_qty;
                                $totalCharge += $tbp_item->charge();
                                @endphp
                                <tr>
                                    <td>{{ date('d-m-Y', strtotime($tbp_item->consumptionItem->consumption->date)) }}
                                    </td>
                                    <td>{{ $tbp_item->consumptionItem->consumption->system_serial }}</td>
                                    <td alight="right">{{ $tbp_item->consumptionItem?->consumption?->tower?->name }}</td>
                                    <td>{{ $tbp_item->material->name }} ({{ $tbp_item->material->materialUnit->name }})
                                    </td>
                                    <td alight="right">{{ $tbp_item->material_rate }}</td>
                                    <td alight="right">{{ $tbp_item->material_qty }}</td>
                                    <td alight="right">{{ $tbp_item->charge() }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            {{-- <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>{{ $totalQty }}</th>
                                    <th>{{ $totalCharge }}</th>
                                </tr>
                            </tfoot> --}}
                        </table>


                        <table>
                            <tr>
                                <td style="width:100px;">Total Qty</td>
                                <td style="width:10px;">:</td>
                                <td style="text-align: right;">{{ $totalQty }}</td>
                            </tr>
                            <tr>
                                <td style="width:100px;">Total Charge</td>
                                <td style="width:10px;">:</td>
                                <td style="text-align: right;">{{ $totalCharge }}</td>
                            </tr>
                        </table>


                        <h4>Charge In Words: {{ $class_obj->convert_number($totalCharge); }}</h4>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <p>Print Date: {{ date('d-m-Y h:i:s') }}</p>

</body>
</html>
