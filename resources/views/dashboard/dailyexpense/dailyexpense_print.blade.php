<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Expense Print</title>
</head>

@include('dashboard.reports.partials.common_css')

<body>

    <div class="tile">
        <div class="tile-body">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        @include('dashboard.reports.partials.layout.report_heading')

                        <div style="margin-top: 29px;border-top:1px solid black;border-bottom:1px solid black;">


                            <table>
                                <tr>
                                    <td style="width: 450px;">Serial: {{ $data->dailyexpense->thisSerial() }}</td>
                                    <td style="width: 150px;">Cash Requisition</td>
                                    <td style="width: 430px;text-align: right;">Date: {{ date('d-m-Y',
                                        strtotime($data->dailyexpense->date)) }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 450px;">Project: {{ $data->dailyexpense->project->project_name
                                        }}</td>
                                    <td style="width: 150px;"></td>
                                    <td style="width: 430px;text-align: right;">Tower: {{
                                        $data->dailyexpense->tower->name }}</td>
                                </tr>
                            </table>

                        </div>

                        <table class="table table-hover table-bordered" style="margin-top: 10px;">
                            <thead>
                                <tr>
                                    <th>Vendor</th>
                                    <th>Budget Head</th>
                                    <th class="text-right">Budget Amount</th>
                                    <th class="text-right">Approved Amount</th>
                                    <th class="text-right">Issued Amount</th>
                                    <th class="text-right">Approved Due</th>
                                    <th class="text-right">Amount</th>
                                    <th class="text-center">Remarks</th>
                                </tr>
                            </thead>

                            <tbody id="tbody">
                                @php
                                $requisitionTotal = 0;
                                $approvedTotal = 0;
                                @endphp
                                @foreach ($data->dailyexpense->items as $item)
                                @php
                                $requisitionTotal += $item->requisition_amount;
                                $approvedTotal += $item->approved_amount;
                                @endphp
                                <tr id="itemRow_{{ $item->id + 999 }}">
                                    <td class="text-center">
                                        {{ $item->vendor->name }}
                                    </td>
                                    <td class="text-center">
                                        {{ $item->budgethead->name }}
                                    </td>
                                    <td class="text-center">
                                        {{ $item->approved_amount_log }}
                                    </td>
                                    <td class="text-center">
                                        {{ $item->approved_due_log }}
                                    </td>
                                    <td class="text-center">
                                        {{ $item->requisition_amount }}
                                    </td>
                                    <td align="center">
                                        {{ $item->approved_amount }}
                                    </td>
                                    <td class="text-center">
                                        {{ $item->remarks }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-right">Total</td>
                                    <td class="text-center">{{ $requisitionTotal }}</td>
                                    <td class="text-center">{{ $approvedTotal }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
