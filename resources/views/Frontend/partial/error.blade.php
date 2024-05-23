@if (count($errors->all()) > 0)
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endif

@foreach ($errors->all() as $error)

    {{--  <div class="bs-component">
        <div class="alert alert-dismissible alert-danger">
            <button class="close" type="button" data-dismiss="alert">×</button>
            {{ $error }}
        </div>
    </div>  --}}


    <script>
        swal("{{ $error }}", {
            button: "OK",
            timer: 5000,
            icon: 'error',
            ButtonColor: "#DD6B55",
        });
    </script>

@endforeach

@if( Session('msg'))

    {{--  <div class="alert alert-{{Session('class_name')}} alert-dismissible fade show" role="alert">
        <strong>{{ Session('message') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>  --}}


    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>

        let type = '{{Session('class_name')}}';

        let is_danger = type == 'danger' ? 'error' : 'success'

        swal("{{ Session('msg') }}", {
            button: "OK",
            timer: 5000,
            icon: is_danger,
            ButtonColor: "#DD6B55",
        });

    </script>


@endif
