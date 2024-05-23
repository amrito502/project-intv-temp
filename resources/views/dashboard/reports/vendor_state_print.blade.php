<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Title Here</title>
</head>

@include('dashboard.reports.partials.common_css')

<body>

    <div class="tile">
        <div class="tile-body">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12">

                        @include('dashboard.reports.partials.layout.report_heading')

                        <div style="padding:15px 0"></div>

                        @include('dashboard.reports.partials.vendor_statement.vendor_statement_table')

                    </div>
                </div>
            </div>
        </div>
    </div>

    <p>Print Date: {{ date('d-m-Y h:i:s') }}</p>

</body>

</html>
