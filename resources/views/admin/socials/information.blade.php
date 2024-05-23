@extends('admin.layouts.master')

@section('custom-css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <?php
                    $message = Session::get('msg');
                      if (isset($message)) {
                        echo"<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>" .$message."</strong></div>";
                      }

                      Session::forget('msg')
                  
                ?>
                <h4 class="card-title">Update Social Information</h4>

                  <div id="editsocials" class="">
    <div class="">        
        <div class="">
            
            <form class="form-horizontal" action="{{route('socials.update')}}" method="POST" enctype="multipart/form-data" name="editsocials">
            {{ csrf_field() }}

                <input type="hidden" name="socialId" value="{{@$socials->id}}">

                 <div class="form-group row {{ $errors->has('facebook') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Facebook</label>
                    <div class="col-sm-9"> 
                        <input type="text" class="form-control form-control-danger" placeholder="write your facebook url" name="facebook" value="{{ @$socials->facebook }}">
                        @if ($errors->has('facebook'))
                        @foreach($errors->get('facebook') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>

                 <div class="form-group row {{ $errors->has('twitter') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Twitter</label>
                    <div class="col-sm-9"> 
                        <input type="text" class="form-control form-control-danger" placeholder="write your twitter url" name="twitter" value="{{ @$socials->twitter }}">
                        @if ($errors->has('twitter'))
                        @foreach($errors->get('twitter') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>

                 <div class="form-group row {{ $errors->has('google') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Google Plus</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-danger" placeholder="write your google url" name="google" value="{{ @$socials->google }}">
                        @if ($errors->has('google'))
                        @foreach($errors->get('google') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('linkdin') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Linkedin</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-danger" placeholder="write your linkedin url" name="linkdin" value="{{ @$socials->linkdin }}">
                        @if ($errors->has('linkdin'))
                        @foreach($errors->get('linkdin') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('youtube') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Youtube</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-danger" placeholder="write your youtube channel link" name="youtube" value="{{ @$socials->youtube }}">
                        @if ($errors->has('youtube'))
                        @foreach($errors->get('youtube') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('metaTitle') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Meta Title</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-danger" placeholder="Meta Title" name="metaTitle" value="{{ @$socials->metaTitle }}">
                        @if ($errors->has('metaTitle'))
                        @foreach($errors->get('metaTitle') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('metaKeyword') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Meta keyword</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-danger" placeholder="Meta Keyword" name="metaKeyword" value="{{ @$socials->metaKeyword }}">
                        @if ($errors->has('metaKeyword'))
                        @foreach($errors->get('metaKeyword') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('description') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Meta description</label>
                    <div class="col-sm-9">
                        <textarea style="min-height: 100px;" class="form-control" name="metaDescription">{{ @$socials->metaDescription }}</textarea>
                        @if ($errors->has('metaDescription'))
                        @foreach($errors->get('metaDescription') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>

                 <div class="form-group row {{ $errors->has('orderBy') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Order By</label>
                    <div class="col-sm-9">
                        <input type="text"   name="orderBy" value="{{ @$socials->orderBy }}">
                        @if ($errors->has('orderBy'))
                        @foreach($errors->get('orderBy') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('sitestatus') ? ' has-danger' : '' }}">
                    <label class="col-sm-3 col-form-label">Publication Status</label>
                    <div class="col-sm-9 row">
                        <div class="form-control">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="published" name="status" class="custom-control-input" value="1">
                                <label class="custom-control-label" for="published">Published</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="unpublished" name="status" class="custom-control-input" checked="" value="0">
                                <label class="custom-control-label" for="unpublished">Unpublished</label>
                            </div>
                        </div>                            
                    </div>
                </div>

                <div class="col-md-12 m-b-20 text-right">    
                    <button type="submit" class="btn btn-info waves-effect">Update Information</button> 
                </div>
            </div>                
            </form>
        </div>
    </div>
    <!-- /.modal-dialog -->
</div>
                
            </div>
        </div>
    </div>
</div>



    <script type="text/javascript">

        document.forms['editsocials'].elements['status'].value = "{{@$socials->status}}";

    </script>

@endsection