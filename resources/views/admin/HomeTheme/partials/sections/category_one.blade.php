<form action="{{ route('home.theme.CategoryOne') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}

    <div class="red-border pt-4">

        <div class="row">
            <div class="col-md-10">
                <h1 class="text-center border-bottom">Footer Categories</h1>
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
                    <input type="checkbox" class="form-check-input ml-1" name="category_one[show]"
                        @if($data->category_one->show == true)
                    checked
                    @endif
                    >
                </div>
            </div>


            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Header Text:</p>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" placeholder="Header Text Here"
                        name="category_one[header_text]" value="{{ $data->category_one->header_text }}">
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Banner Redirect Category:</p>
                </div>
                <div class="col-md-9">
                    <select name="category_one[banner_redirect_category][]" class="chosen-select-6" id="categories-5"
                        multiple>
                        @foreach ($data->categories->where('parent', null) as $category)
                        <option value="{{ $category->id }}" @foreach ($data->category_one->banner_redirect_category as
                            $cid)
                            @if ($category->id == $cid)
                            selected
                            @endif
                            @endforeach

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