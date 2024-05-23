<form action="{{ route('home.theme.ThreeCategory') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}

    <div class="red-border pt-4">

        <div class="row">
            <div class="col-md-10">
                <h1 class="text-center border-bottom">6 Category</h1>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>

        <div class="container-fluid mt-4">

            {{-- <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Show:</p>
                </div>
                <div class="col-md-9">
                    <input type="checkbox" class="form-check-input ml-1" name="three_category[show]"
                        @if($data->three_category->show == true)
                    checked
                    @endif
                    >
                </div>
            </div> --}}

            {{-- <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Banner Image:</p>
                </div>
                <div class="col-md-9">
                    <input type="file" class="form-control" placeholder="Banner Image"
                        name="three_category[banner_image]" @if(isset($data->three_category->banner_image))
                    value="{{ $data->three_category->banner_image }}"
                    @endif
                    >
                    @if(isset($data->three_category->banner_image))
                    <div class="w-25 mt-2">
                        <img src="{{ asset($data->three_category->banner_image) }}" class="img-fluid">
                    </div>
                    @endif
                </div>
            </div> --}}

            {{-- <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Banner Image Text:</p>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" placeholder="Banner Image Text"
                        name="three_category[banner_image_text]" value="{{ $data->three_category->banner_image_text }}">
                </div>
            </div> --}}

            {{-- <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Section Header Text:</p>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" placeholder="Section Header text"
                        name="three_category[section_header_text]"
                        value="{{ $data->three_category->section_header_text }}">
                </div>
            </div> --}}

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Category One:</p>
                </div>
                <div class="col-md-9">
                    <select name="three_category[category_one]" class="chosen-select">
                        @foreach ($data->categories as $category)
                        <option value="{{ $category->id }}" @if ($category->id == $data->three_category->category_one)
                            selected
                            @endif
                            >{{ $category->categoryName }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Category Two:</p>
                </div>
                <div class="col-md-9">
                    <select name="three_category[category_two]" class="chosen-select">
                        <@foreach ($data->categories as $category)
                            <option value="{{ $category->id }}" @if ($category->id ==
                                $data->three_category->category_two)
                                selected
                                @endif
                                >{{ $category->categoryName }}</option>
                            @endforeach
                    </select>
                </div>
            </div>


            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Category Three:</p>
                </div>
                <div class="col-md-9">
                    <select name="three_category[category_three]" class="chosen-select">
                        @foreach ($data->categories as $category)
                        <option value="{{ $category->id }}" @if ($category->id == $data->three_category->category_three)
                            selected
                            @endif
                            >{{ $category->categoryName }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Category Four:</p>
                </div>
                <div class="col-md-9">
                    <select name="three_category[category_four]" class="chosen-select">
                        @foreach ($data->categories as $category)
                        <option value="{{ $category->id }}" @if ($category->id == $data->three_category->category_four)
                            selected
                            @endif
                            >{{ $category->categoryName }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Category Five:</p>
                </div>
                <div class="col-md-9">
                    <select name="three_category[category_five]" class="chosen-select">
                        @foreach ($data->categories as $category)
                        <option value="{{ $category->id }}" @if ($category->id == $data->three_category->category_five)
                            selected
                            @endif
                            >{{ $category->categoryName }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Category Six:</p>
                </div>
                <div class="col-md-9">
                    <select name="three_category[banner_redirect_category]" class="chosen-select">
                        @foreach ($data->categories as $category)
                        <option value="{{ $category->id }}" @if ($category->id ==
                            $data->three_category->banner_redirect_category)
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