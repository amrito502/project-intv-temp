<form action="{{ route('home.theme.OneBanner') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}

    <div class="red-border pt-4">

        <div class="row">
            <div class="col-md-10">
                <h1 class="text-center border-bottom">Inner Advertisement</h1>

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
                    <input type="checkbox" class="form-check-input ml-1" name="one_banner[show]"
                        @if($data->one_banner->show == true)
                    checked
                    @endif
                    >
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Image:</p>
                </div>
                <div class="col-md-9">
                    <input type="file" class="form-control" name="one_banner[image_one]"
                        @if(isset($data->one_banner->image_one))
                    value="{{ $data->one_banner->image_one }}"
                    @endif
                    >

                    @if(isset($data->one_banner->image_one))
                    <div class="w-25 mt-2">
                        <img src="{{ asset($data->one_banner->image_one) }}" class="img-fluid">
                    </div>
                    @endif
                </div>
            </div>

            {{-- <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Banner Redirect Category:</p>
                </div>
                <div class="col-md-9">
                    <select name="one_banner[image_one_redirect_category]" class="chosen-select">
                        @foreach ($data->categories as $category)
                        <option value="{{ $category->id }}" @if ($category->id ==
                            $data->one_banner->image_one_redirect_category)
                            selected
                            @endif

                            >{{ $category->categoryName }}</option>
                        @endforeach
                    </select>
                </div>
            </div> --}}

        </div>

        <div class="row mb-4">
            <div class="col-md-10">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>

    </div>

</form>