<form action="{{ route('home.theme.TwoBanner') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}

    <div class="red-border pt-4">

        <div class="row">
            <div class="col-md-10">
                <h1 class="text-center border-bottom">2 Banner</h1>
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
                    <input type="checkbox" class="form-check-input ml-1" name="two_banner[show]"
                    @if($data->two_banner->show == true)
                    checked
                    @endif
                    >
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Image one:</p>
                </div>
                <div class="col-md-9">
                    <input type="file" class="form-control" name="two_banner[image_one]"
                    @if(isset($data->two_banner->image_one))
                    value="{{ $data->two_banner->image_one }}"
                    @endif
                    >

                    @if(isset($data->two_banner->image_one))
                    <div class="w-25 mt-2">
                        <img src="{{ asset($data->two_banner->image_one) }}" class="img-fluid">
                    </div>
                    @endif
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Image one text:</p>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="two_banner[image_one_text]" value="{{ $data->two_banner->image_one_text }}">
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Image one Redirect:</p>
                </div>
                <div class="col-md-9">
                    <select name="two_banner[image_one_redirect_category]" class="chosen-select">
                        @foreach ($data->categories as $category)
                        <option value="{{ $category->id }}"
                            @if ($category->id == $data->two_banner->image_one_redirect_category)
                            selected
                            @endif
                            >{{ $category->categoryName }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Image two:</p>
                </div>
                <div class="col-md-9">
                    <input type="file" class="form-control" name="two_banner[image_two]"
                    @if(isset($data->two_banner->image_two))
                    value="{{ $data->two_banner->image_two }}"
                    @endif
                    >

                    @if(isset($data->two_banner->image_two))
                    <div class="w-25 mt-2">
                        <img src="{{ asset($data->two_banner->image_two) }}" class="img-fluid">
                    </div>
                    @endif

                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Image two text:</p>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="two_banner[image_two_text]"  value="{{ $data->two_banner->image_two_text }}">
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Image two Redirect:</p>
                </div>
                <div class="col-md-9">
                    <select name="two_banner[image_two_redirect_category]" class="chosen-select">
                        @foreach ($data->categories as $category)
                        <option value="{{ $category->id }}"
                            @if ($category->id == $data->two_banner->image_two_redirect_category)
                            selected
                            @endif
                            >{{ $category->categoryName }}</option>
                        @endforeach
                    </select>
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


</form>