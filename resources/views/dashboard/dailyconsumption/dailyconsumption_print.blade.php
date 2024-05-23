<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Consumption</title>
</head>

@include('dashboard.reports.partials.common_css')

<body>

    <div class="tile">
        <div class="tile-body">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12">

                        @include('dashboard.reports.partials.layout.report_heading')

                        <div class="text-center">
                            <p class="font-weight-bold">Local Issue</p>
                        </div>

                        <div style="margin-top: 29px;border-top:1px solid black;border-bottom:1px solid black;">

                            <table style="width:100%">
                                <tr>
                                    <td>Serial</td>
                                    <td>:</td>
                                    <td>{{ $data->dailyConsumption->system_serial }}</td>
                                    <td>Project</td>
                                    <td>:</td>
                                    <td>{{ $data->dailyConsumption->project->project_name }}</td>
                                </tr>
                                <tr>
                                    <td>Date</td>
                                    <td>:</td>
                                    <td>{{ date('d-m-Y', strtotime($data->dailyConsumption->date)) }}</td>
                                    <td>Address</td>
                                    <td>:</td>
                                    <td>{{ $data->dailyConsumption->project->address }}</td>
                                </tr>
                                <tr>
                                    <td>Issue By</td>
                                    <td>:</td>
                                    <td>{{ $data->dailyConsumption->issue_by->name }}</td>
                                    <td>Contact</td>
                                    <td>:</td>
                                    <td>{{ $data->dailyConsumption->project->contact_person_phone }}</td>
                                </tr>
                            </table>

                        </div>

                        <table class="table table-hover table-bordered" style="margin-top: 29px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Material Name & UOM</th>
                                    <th>Quantity</th>
                                    <th>Rate</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                @php
                                $totalQty = 0;
                                $totalAmount = 0;
                                @endphp
                                @foreach ($data->dailyConsumption->items as $item)
                                @php
                                $totalQty += $item->consumption_qty;
                                $totalAmount += $item->consumption_qty * $item->budgetHead->materialInfo()->price();
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->budgetHead->name }} ({{
                                        $item->budgetHead->materialInfo()->materialUnit->name }})</td>
                                    <td align="right">{{ $item->consumption_qty }}</td>
                                    <td>{{ round($item->budgetHead->materialInfo()->price(), 2) }}</td>
                                    <td>{{ round($item->consumption_qty * $item->budgetHead->materialInfo()->price(), 2)
                                        }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2">Total</th>
                                    <th style="text-align: right">{{ $totalQty }}</th>
                                    <th></th>
                                    <th>{{ round($totalAmount, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>


                        <table style="width:100%;margin-top: 60px;">
                            {{-- <tr>
                                <td>________________</td>
                                <td>________________</td>
                                <td style="text-align:center">________________</td>
                                <td style="text-align:right">________________</td>
                            </tr> --}}
                            <tr>
                                <td style="text-align:left">
                                    <span>________________</span>
                                    <p>Received by</p>
                                </td>
                                <td style="text-align:center">
                                    <span>________________</span>
                                    <p>Check by</p>
                                </td>
                                <td style="text-align:center">
                                    <span>________________</span>
                                    <p>Store Manage</p>
                                </td>
                                <td style="text-align:right">
                                    <span>________________</span>
                                    <p>Authorized by</p>
                                </td>
                            </tr>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <p>Print Date: {{ date('d-m-Y h:i:s') }}</p>

</body>
</html>
