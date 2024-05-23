@extends('admin.mlm.dashboard.layouts.app')

@section('content')
@include('admin.mlm.dashboard.layouts.partials.error')

<div class="tile mb-3">
    <div class="tile-body">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                    </button>
                </div>
                <div class="col-md-8">
                    <h2 class="h2 text-center">Notices</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="tile">
    <div class="tile-body" style="overflow-y: auto">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <table class="table table-striped table-hover table-bordered">
                        {{-- <thead>
                            <tr>
                                <th>Notice</th>
                            </tr>
                        </thead> --}}
                        <tbody>
                            @foreach ($data->notices as $notice)
                            <tr>
                                <td>
                                    <a href="{{ route('notice.show', $notice->id) }}" class="text-dark">{{ $notice->description }}</a>
                                    <br>
                                    <span class="float-right mt-2">Date: {{ $notice->created_at->format('d-m-Y') }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>



@endsection

@section('custom-script')
<script>
    function toggleStatus(id){
        axios.get(route('notice.toggle.status', id))
        .then(function (response) {
        })
        .catch(function (error) {
        })
    }

    function deleteRow(id) {
            let trEl = document.getElementById(id);

            let c = confirm("Are You Sure ?");

            if(c){
                axios.delete(route('notice.destroy', id))
                .then(function (response) {
                    window.location.reload(true);
                })
                .catch(function (error) {
                })

                trEl.remove();
            }
        }
</script>
@endsection
