<form action="{{ route('home.theme.Services') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}

    <div class="red-border pt-4">

        <div class="row">
            <div class="col-md-10">
                <h1 class="text-center border-bottom">Services</h1>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>

        <div class="container-fluid mt-4">

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Show:</p>
                </div>
                <div class="col-md-9">
                    <input type="checkbox" class="form-check-input ml-1" name="promotional[show]"
                        @if($data->promotional->show == true)
                    checked
                    @endif
                    >
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Icon one:</p>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="promotional[icon_one]"
                        value="{{ $data->promotional->icon_one }}" placeholder="fa fa-paper-plane-o">
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Header one:</p>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="promotional[header_one]"
                        value="{{ $data->promotional->header_one }}">

                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Description one:</p>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="promotional[description_one]"
                        value="{{ $data->promotional->description_one }}">
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Icon two:</p>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="promotional[icon_two]"
                        value="{{ $data->promotional->icon_two }}" placeholder="fa fa-paper-plane-o">
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Header two:</p>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="promotional[header_two]"
                        value="{{ $data->promotional->header_two }}">
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Description two:</p>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="promotional[description_two]"
                        value="{{ $data->promotional->description_two }}">
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Icon three:</p>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="promotional[icon_three]"
                        value="{{ $data->promotional->icon_three }}" placeholder="fa fa-paper-plane-o">
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Header three:</p>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="promotional[header_three]"
                        value="{{ $data->promotional->header_three }}">
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Description three:</p>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="promotional[description_three]"
                        value="{{ $data->promotional->description_three }}">
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Icon four:</p>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="promotional[icon_four]"
                        value="{{ $data->promotional->icon_four }}" placeholder="fa fa-paper-plane-o">
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Header four:</p>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="promotional[header_four]"
                        value="{{ $data->promotional->header_four }}">
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Description four:</p>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="promotional[description_four]"
                        value="{{ $data->promotional->description_four }}">
                </div>
            </div>


            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Icon five:</p>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="promotional[icon_five]"
                        value="{{ $data->promotional->icon_five }}" placeholder="fa fa-paper-plane-o">
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Header five:</p>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="promotional[header_five]"
                        value="{{ $data->promotional->header_five }}">
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Description five:</p>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="promotional[description_five]"
                        value="{{ $data->promotional->description_five }}">
                </div>
            </div>


        </div>

        <div class="row mb-4">
            <div class="col-md-10">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>

    </div>