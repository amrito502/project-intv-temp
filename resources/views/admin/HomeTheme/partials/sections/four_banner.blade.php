<form action="{{ route('home.theme.FourBanner') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}

    <div class="red-border pt-4">

        <div class="row">
            <div class="col-md-10">
                <h1 class="text-center border-bottom">6 Banner</h1>

            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>

        <div class="container-fluid mt-4">

            <div class="row my-3  d-none">
                <div class="col-md-3">
                    <p class="mt-2">Show:</p>
                </div>
                <div class="col-md-9">
                    <input type="checkbox" class="form-check-input ml-1" name="four_banner[show]"
                        @if($data->four_banner->show == true)
                    checked
                    @endif
                    >
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Image one: (555x146)</p>
                </div>
                <div class="col-md-9">
                    <input type="file" class="form-control" name="four_banner[image_one]"
                        @if(isset($data->four_banner->image_one))
                    value="{{ $data->four_banner->image_one }}"
                    @endif >

                    @if(isset($data->four_banner->image_one))
                    <div class="w-25 mt-2">
                        <img src="{{ asset($data->four_banner->image_one) }}" class="img-fluid">
                    </div>
                    @endif

                </div>
            </div>
            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Image one category</p>
                </div>
                <div class="col-md-9">
                    <select class="form-control chosen-select" name="four_banner[category_one]">
                        <option value=""></option>
                        @foreach($data->categories as $category)
                            <option value="{{ $category->id }}" @if(!empty($data->four_banner->category_one) && $category->id == $data->four_banner->category_one) selected @endif>{{ $category->categoryName }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Image one text:</p>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="four_banner[image_one_text]"
                        value="{{ $data->four_banner->image_one_text }}">
                </div>
            </div> --}}

            {{-- <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Image one Redirect Category:</p>
                </div>
                <div class="col-md-9">
                    <select name="four_banner[image_one_text_redirect_category]" class="chosen-select">
                        @foreach ($data->categories as $category)
                        <option value="{{ $category->id }}" @if ($category->id ==
                            $data->four_banner->image_one_text_redirect_category)
                            selected
                            @endif
                            >{{ $category->categoryName }}</option>
                        @endforeach
                    </select>
                </div>
            </div> --}}

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Image two: (555x146)</p>
                </div>
                <div class="col-md-9">
                    <input type="file" class="form-control" name="four_banner[image_two]"
                        @if(isset($data->four_banner->image_two))
                    value="{{ $data->four_banner->image_two }}"
                    @endif
                    >

                    @if(isset($data->four_banner->image_two))
                    <div class="w-25 mt-2">
                        <img src="{{ asset($data->four_banner->image_two) }}" class="img-fluid">
                    </div>
                    @endif

                </div>
            </div>
            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Image two category</p>
                </div>
                
                <div class="col-md-9">
                    <select class="form-control chosen-select" name="four_banner[category_two]">
                        <option value=""></option>
                        @foreach($data->categories as $category)
                            <option value="{{ $category->id }}" @if(!empty($data->four_banner->category_two) && $category->id == $data->four_banner->category_two) selected @endif>{{ $category->categoryName }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Image two text:</p>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="four_banner[image_two_text]"
                        value="{{ $data->four_banner->image_two_text }}">
                </div>
            </div> --}}

            {{-- <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Image two Redirect Category:</p>
                </div>
                <div class="col-md-9">
                    <select name="four_banner[image_two_text_redirect_category]" class="chosen-select">
                        @foreach ($data->categories as $category)
                        <option value="{{ $category->id }}" @if ($category->id ==
                            $data->four_banner->image_two_text_redirect_category)
                            selected
                            @endif
                            >{{ $category->categoryName }}</option>
                        @endforeach
                    </select>
                </div>
            </div> --}}

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Image three: (555x146)</p>
                </div>
                <div class="col-md-9">
                    <input type="file" class="form-control" name="four_banner[image_three]"
                        @if(isset($data->four_banner->image_three))
                    value="{{ $data->four_banner->image_three }}"
                    @endif
                    >

                    @if(isset($data->four_banner->image_three))
                    <div class="w-25 mt-2">
                        <img src="{{ asset($data->four_banner->image_three) }}" class="img-fluid"
                        @if(isset($data->four_banner->image_three))
                        value="{{ $data->four_banner->image_three }}"
                        @endif
                        >
                    </div>
                    @endif
                </div>
            </div>
            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Image three category</p>
                </div>
                
                <div class="col-md-9">
                    <select class="form-control chosen-select" name="four_banner[category_three]">
                        <option value=""></option>
                        @foreach($data->categories as $category)
                            <option value="{{ $category->id }}" @if(!empty($data->four_banner->category_three) && $category->id == $data->four_banner->category_three) selected @endif>{{ $category->categoryName }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Image three text:</p>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="four_banner[image_three_text]"
                        value="{{ $data->four_banner->image_three_text }}">


                </div>
            </div> --}}

            {{-- <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Image three Redirect Category:</p>
                </div>
                <div class="col-md-9">
                    <select name="four_banner[image_three_text_redirect_category]" class="chosen-select">
                        @foreach ($data->categories as $category)
                        <option value="{{ $category->id }}" @if ($category->id ==
                            $data->four_banner->image_three_text_redirect_category)
                            selected
                            @endif
                            >{{ $category->categoryName }}</option>
                        @endforeach
                    </select>
                </div>
            </div> --}}

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Image four: (555x146)</p>
                </div>
                <div class="col-md-9">
                    <input type="file" class="form-control" name="four_banner[image_four]"
                        @if(isset($data->four_banner->image_four))
                    value="{{ $data->four_banner->image_four }}"
                    @endif
                    >

                    @if(isset($data->four_banner->image_four))
                    <div class="w-25 mt-2">
                        <img src="{{ asset($data->four_banner->image_four) }}" class="img-fluid">
                    </div>
                    @endif
                </div>
            </div>
            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Image four category</p>
                </div>
                
                <div class="col-md-9">
                    <select class="form-control chosen-select" name="four_banner[category_four]">
                        <option value=""></option>
                        @foreach($data->categories as $category)
                            <option value="{{ $category->id }}" @if(!empty($data->four_banner->category_four) && $category->id == $data->four_banner->category_four) selected @endif>{{ $category->categoryName }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Image five: (555x146)</p>
                </div>
                <div class="col-md-9">
                    <input type="file" class="form-control" name="four_banner[image_five]"
                        @if(isset($data->four_banner->image_five))
                    value="{{ $data->four_banner->image_five }}"
                    @endif
                    >

                    @if(isset($data->four_banner->image_five))
                    <div class="w-25 mt-2">
                        <img src="{{ asset($data->four_banner->image_five) }}" class="img-fluid">
                    </div>
                    @endif
                </div>
            </div>
            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Image five category</p>
                </div>
                
                <div class="col-md-9">
                    <select class="form-control chosen-select" name="four_banner[category_five]">
                        <option value=""></option>
                        @foreach($data->categories as $category)
                            <option value="{{ $category->id }}" @if(!empty($data->four_banner->category_five) && $category->id == $data->four_banner->category_five) selected @endif>{{ $category->categoryName }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Image six: (555x146)</p>
                </div>
                <div class="col-md-9">
                    <input type="file" class="form-control" name="four_banner[image_six]"
                        @if(isset($data->four_banner->image_six))
                    value="{{ $data->four_banner->image_six }}"
                    @endif
                    >

                    @if(isset($data->four_banner->image_six))
                    <div class="w-25 mt-2">
                        <img src="{{ asset($data->four_banner->image_six) }}" class="img-fluid">
                    </div>
                    @endif
                </div>
            </div>
            <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Image six category</p>
                </div>
                <div class="col-md-9">
                    <select class="form-control chosen-select" name="four_banner[category_six]">
                        <option value=""></option>
                        @foreach($data->categories as $category)
                            <option value="{{ $category->id }}" @if(!empty($data->four_banner->category_six) && $category->id == $data->four_banner->category_six) selected @endif>{{ $category->categoryName }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Image four text:</p>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="four_banner[image_four_text]"
                        value="{{ $data->four_banner->image_four_text }}">
                </div>
            </div> --}}

            {{-- <div class="row my-3">
                <div class="col-md-3">
                    <p class="mt-2">Image four Redirect Category:</p>
                </div>
                <div class="col-md-9">
                    <select name="four_banner[image_four_text_redirect_category]" class="chosen-select">
                        @foreach ($data->categories as $category)
                        <option value="{{ $category->id }}" @if ($category->id ==
                            $data->four_banner->image_four_text_redirect_category)
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