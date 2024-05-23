<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material Transfer Voucher</title>
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
                            <p style="text-align: center;">Date: {{ date('d-m-Y', strtotime($data->materialIssue->issue_date)) }}, Project: {{ $data->materialIssue->project->project_name }}</p>
                        </div>

                        <table class="table table-hover table-bordered" style="margin-top: 29px;">
                            <thead>
                                <tr>
                                    <th width="40%">Material Name & UOM</th>
                                    <th width="16%">Quantity</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                @php
                                $totalQty = 0;
                                @endphp
                                @foreach ($data->materialIssue->issuedMaterials as $item)
                                @php
                                $totalQty += $item->material_qty;
                                @endphp
                                <tr>
                                    <td>{{ $item->material->name }} ({{ $item->material->materialUnit->name }})</td>
                                    <td align="right">{{ $item->material_qty }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th style="text-align: right">{{ $totalQty }}</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <p>Print Date: {{ date('d-m-Y h:i:s') }}</p>

</body>
</html>
