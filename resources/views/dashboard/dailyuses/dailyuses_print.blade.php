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

                        <div class="text-center" style="border-bottom:1px solid black;">
                            <p class="font-weight-bold">Daily Consumption</p>
                        </div>

                        <div style="margin-top: 25px;">

                            <table style="width:100%">
                                <tr>
                                    <td>Serial</td>
                                    <td>:</td>
                                    <td>{{ $data->dailyuse->system_serial }}</td>
                                    <td>Project</td>
                                    <td>:</td>
                                    <td>{{ $data->dailyuse->project->project_name }}</td>
                                </tr>
                                <tr>
                                    <td>Date</td>
                                    <td>:</td>
                                    <td>{{ date('d-m-Y', strtotime($data->dailyuse->date)) }}</td>
                                    <td>Address</td>
                                    <td>:</td>
                                    <td>{{ $data->dailyuse->project->address }}</td>
                                </tr>
                                <tr>
                                    <td>Use By</td>
                                    <td>:</td>
                                    <td>{{ $data->dailyuse->createdBy->name }}</td>
                                    <td>Contact</td>
                                    <td>:</td>
                                    <td>{{ $data->dailyuse->project->contact_person_phone }}</td>
                                </tr>

                                <tr>
                                    <td>Pile No</td>
                                    <td>:</td>
                                    <td>{{ $data->dailyuse->pile_no }}</td>
                                    <td>Site Engineer</td>
                                    <td>:</td>
                                    <td>{{ $data->dailyuse->site_engineer }}</td>
                                </tr>

                                <tr>
                                    <td>Epc Engineer</td>
                                    <td>:</td>
                                    <td>{{ $data->dailyuse->epc_engineer }}</td>
                                    <td>Department Engineer</td>
                                    <td>:</td>
                                    <td>{{ $data->dailyuse->department_engineer }}</td>
                                </tr>

                                <tr>
                                    <td>Tower Type</td>
                                    <td>:</td>
                                    <td>{{ $data->tower->type }}</td>
                                    <td>Soil Category</td>
                                    <td>:</td>
                                    <td>{{ $data->tower->soil_category }}</td>
                                </tr>

                            </table>

                        </div>

                        <table class="table table-hover table-bordered" style="margin-top: 20px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Material Name & UOM</th>
                                    <th class="text-right">Design</th>
                                    <th class="text-right">Consumption</th>
                                    <th class="text-right">Difference</th>
                                    <th class="text-right">Remarks</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                @php
                                $totalQty = 0;
                                $totalAmount = 0;
                                @endphp
                                @foreach ($data->dailyuse->items as $item)
                                @php
                                $totalQty += $item->use_qty;
                                $totalAmount += $item->use_qty * $item->budgetHead->materialInfo()->price();
                                $designQty = $data->projectWiseBudget->items()->where('budget_head', $item->budget_head_id)->sum('qty') / $data->pileNo;
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->budgetHead->name }} ({{
                                        $item->budgetHead->materialInfo()->materialUnit->name }})</td>
                                    <td align="right">{{ $designQty }}</td>
                                    <td align="right">{{ $item->use_qty }}</td>
                                    <td align="right">{{ $designQty - $item->use_qty }}</td>
                                    <td align="right">{{ $item->remarks }}</td>
                                </tr>
                                @endforeach
                            </tbody>

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
