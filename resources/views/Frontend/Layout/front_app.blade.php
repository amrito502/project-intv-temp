<!DOCTYPE html>
<html>

<head>


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Twitter meta-->
    <meta property="author" content="Rifat Hossain">
    <meta property="developer" content="Rifat Hossain">
    <title>{{ session('ss')->website_name }}</title>


    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css"
        href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    {{-- <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> --}}

    <link rel="stylesheet" type="text/css" href="{{ asset('css/front_app.css') }}">
    @yield('custom-css')
</head>

<body>


    <div id="app">

        @yield('content')
        
    </div>

    @routes
    <script src="{{ asset('js/front_app.js') }}"></script>
    <script src="{{ asset('js/plugins/pace.min.js') }}"></script>
    {{-- <script src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/plugins/dataTables.bootstrap.min.js') }}"></script> --}}
    <script src="{{ asset('js/script.js') }}"></script>

    {{-- jquery ui --}}
    {{-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            
            // $('#dtb').DataTable();
            // $('.dtb').DataTable();
            $('.select2').select2();

            // $( ".datepicker" ).datepicker({
            //     changeMonth: true,
            //     changeYear: true,
            //     dateFormat: 'dd-mm-yy',
            // });


        });
    </script>
    @yield('custom-script')
</body>

</html>