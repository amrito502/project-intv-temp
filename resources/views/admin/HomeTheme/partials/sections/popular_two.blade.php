<form action="{{ route('home.theme.popularTwo') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}


    <div class="red-border pt-4">

        <div class="row">
            <div class="col-md-10">
                <h1 class="text-center border-bottom">Popular 2</h1>

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
                    <input type="checkbox" class="form-check-input ml-1" name="popular_two[show]"
                        @if($data->popular_two->show == true)
                    checked
                    @endif>
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Header Text:</p>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" placeholder="Header Text Here"
                        name="popular_two[header_text]" value="{{ $data->popular_two->header_text }}">
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Banner Image:</p>
                </div>
                <div class="col-md-9">
                    <input type="file" class="form-control" placeholder="Banner Image" name="popular_two[banner_image]"
                        @if(isset($data->popular_two->banner_image))
                    value="{{ $data->popular_two->banner_image }}"
                    @endif
                    >

                    @if(isset($data->popular_two->banner_image))
                    <div class="w-25 mt-2">
                        <img src="{{ asset($data->popular_two->banner_image) }}" class="img-fluid">
                    </div>
                    @endif

                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Banner Image Text:</p>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" placeholder="Banner Image Text"
                        name="popular_two[banner_image_text]" value="{{ $data->popular_two->banner_image_text }}">
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Banner Redirect Category:</p>
                </div>
                <div class="col-md-9">
                    <select name="popular_two[banner_redirect_category]" class="chosen-select">
                        @foreach ($data->categories as $category)
                        <option value="{{ $category->id }}" @if ($category->id ==
                            $data->popular_two->banner_redirect_category)
                            selected
                            @endif
                            >{{ $category->categoryName }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Products:</p>
                </div>
                <div class="col-md-9">
                    <select name="popular_two[products][]" class="chosen-select-10" multiple>
                        @foreach ($data->products as $product)
                        <option value="{{ $product->id }}" 
                            @foreach ($data->popular_two->products as $p)
                            @if ($product->id == $p)
                            selected
                            @endif
                            @endforeach
                            >{{ $product->name }}</option>
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