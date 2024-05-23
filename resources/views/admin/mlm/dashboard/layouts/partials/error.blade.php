@foreach ($errors->all() as $error)

 {{-- <div class="bs-component">
    <div class="alert alert-dismissible alert-danger">
        <button class="close" type="button" data-dismiss="alert">×</button>
        {{ $error }}
    </div>
</div> --}}

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    swal("{{ $error }}", {
        button: "OK",
        timer: 5000,
        icon: 'error',
      });

</script>

@endforeach

@if( Session('message'))

 {{-- <div class="alert alert-{{Session('class_name')}} alert-dismissible fade show" role="alert">
    <strong>{{ Session('message') }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div> --}}


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>

    let type = '{{Session('class_name')}}';

    let is_danger = type == 'danger' ? 'error' : 'success'

    swal("{{ Session('message') }}", {
        button: "OK",
        timer: 5000,
        icon: is_danger,
      });

</script>


@endif
