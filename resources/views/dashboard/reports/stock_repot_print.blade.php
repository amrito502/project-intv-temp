@php
use App\Models\Project;
$project = Project::find(request()->project);
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material Statement</title>
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
                            <p style="text-align: center;">Stock Report. From {{ date('d-m-Y', strtotime(request()->start_date)) }} to {{ date('d-m-Y', strtotime(request()->end_date)) }}. Project: {{ $project->project_name }}</p>
                        </div>

                        @include('dashboard.reports.partials.stock_report.stock_report_table')

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
