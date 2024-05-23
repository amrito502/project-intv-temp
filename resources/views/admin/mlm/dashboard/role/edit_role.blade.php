@extends('admin.mlm.dashboard.layouts.app')

@section('custom-css')
<style>
    ul {
        list-style: none;
    }
</style>
@endsection

@section('content')
@include('admin.mlm.dashboard.layouts.partials.error')

<form action="{{ route('role.update', $data->role) }}" method="POST">
    @csrf
    @method('patch')

    <div class="tile">
        <div class="tile-body">
            <div class="container mb-3">
                <div class="row">
                    <div class="col-md-12">
                        <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                        </button>
                        <h3 class="text-center">Edit Role</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="tile">
        <div class="tile-body">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Role Name</label>
                                    <input class="form-control" name="name" id="name" type="text"
                                        placeholder="Enter name" value="{{ $data->role->name }}">
                                </div>
                            </div>
                        </div>


                        <div class="row mt-5">
                            @foreach ($data->permissions->where('parent_id', 0)->sortBy('order_serial') as $parentMenu)
                            <div class="col-md-12">
                                <ul>
                                    <li class="bg-dark text-light py-2 pl-2">
                                        <input type="checkbox" name="permissions[]"
                                            class="parent parent_{{ $parentMenu->id }}" parent="{{ $parentMenu->id }}"
                                            value="{{ $parentMenu->name }}" onclick="togglePermissions(event)"
                                            @if(in_array($parentMenu->id, $data->role_permissions))
                                        checked
                                        @endif

                                        >
                                        {{ $parentMenu->name }}
                                    </li>

                                    <li class="mt-2">
                                        <ul>
                                            <div class="row">
                                                @foreach ($data->permissions->where('parent_id',
                                                $parentMenu->id)->sortBy('order_serial') as $childMenu)
                                                <div class="col-md-6 mt-2">
                                                    <li class="font-weight-bold">
                                                        <input type="checkbox" name="permissions[]"
                                                            class="child child_{{ $parentMenu->id }}"
                                                            value="{{ $childMenu->name }}"
                                                            parent="{{ $parentMenu->id }}" child="{{ $childMenu->id }}"
                                                            onclick="togglePermissions(event)"
                                                            @if(in_array($childMenu->id, $data->role_permissions))
                                                        checked
                                                        @endif

                                                        >
                                                        {{ $childMenu->name }}
                                                    </li>

                                                    <li>
                                                        <ul>
                                                            @foreach ($data->permissions->where('parent_id',
                                                            $childMenu->id)->sortBy('order_serial') as $actionMenu)
                                                            <li>
                                                                <input type="checkbox" name="permissions[]"
                                                                    class="action action_{{ $parentMenu->id }}"
                                                                    parent="{{ $parentMenu->id }}"
                                                                    child="{{ $childMenu->id }}"
                                                                    value="{{ $actionMenu->name }}"
                                                                    onclick="togglePermissions(event)"
                                                                    @if(in_array($actionMenu->id, $data->role_permissions))
                                                                checked
                                                                @endif
                                                                >
                                                                {{ $actionMenu->name }}
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </li>

                                                </div>

                                                @endforeach
                                            </div>

                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            @endforeach
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tile">
        <div class="tile-body">
            <div class="row">
                <div class="col-md-2 offset-md-10">
                    <button class="btn btn-success float-right">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>

</form>

@endsection

@section('custom-script')
<script>
    function togglePermissions(e) {
                let thisEl = $(e.target);
                let isThisElChecked = thisEl.is(':checked');

                let isParent = $(thisEl).hasClass('parent');
                let isChild = $(thisEl).hasClass('child');

                let selectedInputs = '';


                if(isParent){
                    let thisElId = thisEl.attr('parent');
                    selectedInputs = $( "input[parent='"+thisElId+"']");
                }

                if(isChild){
                    let thisElId = thisEl.attr('child');
                    selectedInputs = $( "input[child='"+thisElId+"']");
                }

                if(typeof selectedInputs == 'object'){
                    selectedInputs.each(function(){
                        this.checked = isThisElChecked;
                    });
                }

            }
</script>
@endsection
