@extends('admin.mlm.dashboard.layouts.app')

@section('content')
@include('admin.mlm.dashboard.layouts.partials.error')

<form action="{{ route('member.update', $data->member->id) }}" method="POST" enctype="multipart/form-data">
    @csrf


    <div class="tile mb-3">
        <div class="tile-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                        </button>
                        <h3 class="text-center">Profile Edit</h3>
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

                            <div class="col-md-4">
                                <div class="form-group">
                                    <img src="{{ $data->member->profile_image() }}" style="width:210px;height:210px;"
                                        class="mb-3 mt-3 img-fluid" alt="">
                                </div>
                            </div>

                            <div class="col-md-8">

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="username">UserName</label> <span class="text-danger">*</span>
                                            <input class="form-control" name="username" id="username" type="text"
                                                placeholder="Username" autocomplete="off"
                                                value="{{ $data->member->username }}" required>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Joining Duration</label>
                                            <input class="form-control" type="text"
                                                value="{{  $data->member->DaysSinceJoined() }}" autocomplete="off"
                                                disabled>
                                        </div>
                                    </div>

                                </div>


                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Full Name</label>
                                            <input class="form-control" name="name" id="name" type="text"
                                                placeholder="Enter name" value="{{  $data->member->name }}"
                                                autocomplete="off">
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rank">Rank</label>
                                            <input type="text" class="form-control" name="rank"
                                                value="{{  $data->member->urank() }}" autocomplete="off" disabled>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mobile">Mobile</label>
                                            <input type="text" class="form-control" name="mobile"
                                                value="{{  $data->member->mobile }}" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="joining_date">Joining Date</label>
                                            <input type="text" class="form-control" name="rank"
                                                value="{{ date('d-m-Y', strtotime( $data->member->created_at)) }}"
                                                autocomplete="off" disabled>
                                        </div>
                                    </div>



                                </div>


                                <div class="row">

                                    @if ( Auth::user()->hasRole(['System Admin', 'Software Admin']))

                                    <div class="col-md-6 mt-5">

                                        <div class="d-flex">
                                            <div class="form-group mr-5">
                                                <input type="checkbox" name="is_founder" @if ( $data->member->is_founder
                                                == 1)
                                                checked
                                                @endif> &nbsp;
                                                <label for="mobile">Is Founder</label>
                                            </div>


                                            <div class="form-group">
                                                <input type="checkbox" name="is_agent" id="is_agent" @if (
                                                    $data->member->is_agent == 1)
                                                checked
                                                @endif> &nbsp;
                                                <label for="mobile">Is Agent</label>
                                            </div>
                                        </div>

                                    </div>

                                    @endif

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="joining_date">Team Customer</label>
                                            <input type="text" class="form-control" name="rank"
                                                value="{{  $data->member->DownLevelMemberCount() }}" autocomplete="off"
                                                disabled>
                                        </div>
                                    </div>
                                </div>

                                @if ( Auth::user()->hasRole(['System Admin', 'Software Admin']))
                                <div class="row">

                                    <div class="col-md-6 agent_inputs">
                                        <div class="form-group">
                                            <label for="district">District</label>
                                            <select class="form-control select2" name="district" id="district">
                                                <option value="">Select An District</option>
                                                @foreach ($data->districts as $district)
                                                <option value="{{ $district->id }}" @if ($district->id ==
                                                    $data->member->district_id)
                                                    selected
                                                    @endif
                                                    >{{ $district->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 agent_inputs">
                                        <div class="form-group">
                                            <label for="thana">Thana</label>
                                            <select class="form-control select2" name="thana" id="thana">
                                                <option value="">Select District First</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                @endif

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="hidden" name="old_image" value="{{ $data->member->profile_img }}">
                                    <label for="profile_img">Profile Image</label>
                                    <input class="form-control" style="width:210px;" name="profile_img" id="profile_img"
                                        type="file" autocomplete="off">
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tile">
        <div class="tile-body">
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-success float-right">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>

</form>

@csrf
@endsection

@section('custom-script')
<script>
    $(document).ready(function () {

// fetch district wise thana
$('#district').change(function (e) {
e.preventDefault();

let districtId = $(this).val();

axios.get(route('getDistrictWiseThanas'), {
params: {
districtId:districtId
}
})
.then(function (response) {

$('#thana').html('');

let districts = response.data;

districts.forEach(el => {

let option = `<option value="${el.id}">${el.name}</option>`;

$('#thana').append(option);

});

})
.catch(function (error) {
console.log(error);
});

});


// $('.agent_inputs').hide();

function toggleAreaInputs(){
    let is_agent = $('#is_agent').is(':checked');

    if(is_agent){
    $('.agent_inputs').show();

    }else{
    $('.agent_inputs').hide();
    }
}

toggleAreaInputs();

$('#is_agent').click(toggleAreaInputs);



        });
</script>
@endsection
