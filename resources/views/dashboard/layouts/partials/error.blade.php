@if ($errors->any())
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endif

@foreach ($errors->all() as $error)
    <script>
        swal("{{ $error }}", {
            button: "OK",
            timer: 5000,
            icon: 'error',
            ButtonColor: "#DD6B55",
        });
    </script>
@endforeach

@if (Session('message'))
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        let type = '{{ Session('class_name') }}';

        let is_danger = type == 'danger' ? 'error' : 'success'

        swal("{!! Session('message') !!}", {
            button: "OK",
            timer: 5000,
            icon: is_danger,
            ButtonColor: "#DD6B55",
        });
    </script>
@endif
