<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Budget Status</title>
</head>

<style>
    .vertical-center-text {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .table td,
    .table th {
        border-top: 1px solid #dee2e6;
        padding: .3rem;
        vertical-align: top;
    }

    .table-bordered,
    .table-bordered td,
    .table-bordered th {
        border: 1px solid #dee2e6;
    }

    .table {
        color: #212529;
        margin-bottom: 1rem;
        width: 100%;
    }

    table {
        border-collapse: collapse;
    }

    .table tfoot th,
    .table thead th {
        background-color: #009688;
    }

    .table-bordered thead td,
    .table-bordered thead th {
        border-bottom-width: 2px;
    }

    .table thead th {
        border-bottom: 2px solid #dee2e6;
        vertical-align: bottom;
    }

    .table-bordered,
    .table-bordered td,
    .table-bordered th {
        border: 1px solid #dee2e6;
    }

    th {
        text-align: inherit;
    }

    .heading-color-two th,
    .heading-color-three td {
        background-color: #9ad5c5 !important;
    }

    .heading-color-four th,
    .heading-color-four td {
        background-color: #5ec7e7 !important;
    }

    .footer-heading th {
        background-color: #000 !important;
        color: #fff;
    }

    .text-right {
        text-align: right;
    }

    .heading {
        text-align: center;
        padding-bottom: 0 !important;
        margin-bottom: 0 !important;
    }

    .heading_data {
        text-align: center;
    }

    .heading_data p {
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
    }
</style>

<body>

    <div class="tile">
        <div class="tile-body">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        @include('dashboard.reports.partials.layout.report_heading')

                        <div style="padding:15px 0"></div>

                        @include('dashboard.reports.partials.report_details.issue_material_table')

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
