<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Budget Status</title>

    <style>
        td {
            font-size: 11px;
        }
    </style>
</head>

@include('dashboard.reports.partials.common_css')

<body>

    @include('dashboard.reports.partials.layout.report_heading')

    <div style="padding:15px 0"></div>

    {{-- @include('dashboard.reports.partials.lifting_log.lifting_log_table') --}}
    @include('dashboard.reports.partials.project_budget_status.with_unit')

    <p>Print Date: {{ date('d-m-Y h:i:s') }}</p>

</body>
</html>
