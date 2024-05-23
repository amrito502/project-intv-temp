@extends('admin.mlm.dashboard.layouts.app')

@section('content')
@include('admin.mlm.dashboard.layouts.partials.error')


<form action="{{ route('business.setting') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('patch')

    <div class="tile mb-3">
        <div class="tile-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <button onclick="window.history.back()" type="button" type="button"
                            class="btn btn-info float-left">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                        </button>
                        <h3 class="text-center">Business Plan Setting</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="tile">
        <div class="tile-body">
            <div class="container">

                <div class="mb-5 py-2 bg-dark text-light">
                    <h3 class="text-center text-uppercase">General Settings</h3>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-12">

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="person_per_level">Downline Team Qty</label>
                                    <input class="form-control" name="person_per_level" id="person_per_level"
                                        type="number" value="{{ $data->businessSettings->person_per_level }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="account_price">Account Value (price)</label>
                                    <input class="form-control" name="account_price" id="account_price" type="number"
                                        value="{{ $data->businessSettings->account_price }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="hand_name">Team Identity Name</label>
                                    <input class="form-control" name="hand_name" id="hand_name" type="text"
                                        value="{{ $data->businessSettings->hand_name }}">
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="reference_bonus">Reference Bonus</label>
                                    <input class="form-control" name="reference_bonus" id="reference_bonus"
                                        type="number" value="{{ $data->businessSettings->reference_bonus }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="distribution_bonus">Team Bonus</label>
                                    <input class="form-control" name="distribution_bonus" id="distribution_bonus"
                                        type="number" value="{{ $data->businessSettings->distribution_bonus }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="distribution_bonus_after">Team Matching Customer</label>
                                    <input class="form-control" name="distribution_bonus_after"
                                        id="distribution_bonus_after" type="number"
                                        value="{{ $data->businessSettings->distribution_bonus_after }}">
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="daily_bonus">Daily Bonus</label>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <label for="is_ad_view">Is Ad View</label> &nbsp;
                                            <input name="is_ad_view" id="is_ad_view" type="checkbox"
                                                @if($data->businessSettings->is_ad_view == 1)
                                            checked
                                            @endif

                                            >
                                        </div>
                                    </div>

                                    <input class="form-control" name="daily_bonus" id="daily_bonus" type="number"
                                        value="{{ $data->businessSettings->daily_bonus }}">
                                </div>
                            </div>

                            <div class="col-md-4 on_ad_view">
                                <div class="form-group">
                                    <label for="bonus_per_ad">Bonus Per Ad</label>
                                    <input class="form-control" name="bonus_per_ad" id="bonus_per_ad" type="number"
                                        value="{{ $data->businessSettings->bonus_per_ad }}">
                                </div>
                            </div>

                            <div class="col-md-4 on_ad_view">
                                <div class="form-group">
                                    <label for="ad_per_day">Ad Per Day</label>
                                    <input class="form-control" name="ad_per_day" id="ad_per_day" type="number"
                                        value="{{ $data->businessSettings->ad_per_day }}">
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="payment_info">Payment Info</label>
                                    <textarea name="payment_info" id="payment_info" id="ckeditor"
                                        class="ckeditor form-control" rows="9">{{ $data->businessSettings->payment_info
                                        }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-4">

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="withdraw_charge">Withdraw Charge</label>
                                            <input class="form-control" name="withdraw_charge" id="withdraw_charge"
                                                type="number" value="{{ $data->businessSettings->withdraw_charge }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="withdraw_charge">Type</label>
                                            <select name="withdraw_type" class="form-control" id="withdraw_type">

                                                <option value="Percentage" @if ($data->businessSettings->withdraw_type
                                                    == "Percentage")
                                                    selected
                                                    @endif
                                                    >Percentage</option>

                                                <option value="Fixed" @if ($data->businessSettings->withdraw_type ==
                                                    "Fixed")
                                                    selected
                                                    @endif
                                                    >Fixed</option>

                                            </select>

                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="transfer_charge">Transfer Charge</label>
                                            <input class="form-control" name="transfer_charge" id="transfer_charge"
                                                type="number" value="{{ $data->businessSettings->transfer_charge }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="transfer_charge">Type</label>

                                            <select name="transfer_type" class="form-control" id="transfer_type">
                                                <option value="Percentage" @if ($data->businessSettings->transfer_type
                                                    == "Percentage")
                                                    selected
                                                    @endif
                                                    >Percentage</option>

                                                <option value="Fixed" @if ($data->businessSettings->transfer_type ==
                                                    "Fixed")
                                                    selected
                                                    @endif
                                                    >Fixed</option>


                                            </select>

                                        </div>
                                    </div>

                                </div>



                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="account_expire_after_joining">Account Duration (Days)</label>
                                            <input class="form-control" name="account_expire_after_joining"
                                                id="account_expire_after_joining" type="number"
                                                value="{{ $data->businessSettings->account_expire_after_joining }}">
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="founder_reservation">Founder Reservation (Per ID)</label>
                                            <input class="form-control" name="founder_reservation"
                                                id="founder_reservation" type="number"
                                                value="{{ $data->businessSettings->founder_reservation }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="number_of_level">Rank Level</label>
                                            <input class="form-control" name="number_of_rank_level"
                                                id="number_of_rank_level" type="number"
                                                value="{{ $data->businessSettings->number_of_rank_level }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button class="btn btn-outline-info btn-block" onclick="generateRankInputs()"
                                            style="margin-top: 29px" type="button">Generate Ranks</button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="number_of_level">Generation Level</label>
                                            <input class="form-control" name="number_of_level" id="number_of_level"
                                                type="number" value="{{ $data->businessSettings->number_of_level }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button class="btn btn-outline-info btn-block"
                                            onclick="generateGenerationInputs()" style="margin-top: 29px"
                                            type="button">Create Generation</button>
                                    </div>
                                </div>

                            </div>


                        </div>

                    </div>
                </div>


                <div class="mb-5 mt-5 py-2 bg-dark text-light">
                    <h3 class="text-center text-uppercase">Generation Settings</h3>
                </div>

                <div id="generationInputs"></div>

                <div id="preRenderedGenerationInputs">

                    @foreach ($data->generationSettings as $generationSetting)

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="level_no">Level No</label>
                                <input class="form-control" name="level_no[]"
                                    id="level_no_{{ $generationSetting->level_no }}" type="number"
                                    value="{{ $generationSetting->level_no }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="level_bonus_amount">Bonus Amount</label>
                                <input class="form-control"
                                    name="level_bonus_amount[{{ $generationSetting->level_no }}]"
                                    value="{{ $generationSetting->bonus_amount }}" id="level_bonus_amount"
                                    type="number">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bonus_type">Bonus Type</label>
                                <select name="bonus_type[{{ $generationSetting->level_no }}]" class="form-control"
                                    id="bonus_type">
                                    <option value="Individual" @if ($generationSetting->bonus_type == "Individual")
                                        selected
                                        @endif
                                        >Individual</option>
                                    <option value="Complete" @if ($generationSetting->bonus_type == "Complete")
                                        selected
                                        @endif
                                        >Complete</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    @endforeach

                </div>


                <div class="mb-5 mt-5 py-2 bg-dark text-light">
                    <h3 class="text-center text-uppercase">Rank Settings</h3>
                </div>


                <div id="rankInputs"></div>


                <div id="preRenderedRankInputs">

                    @foreach ($data->rankSettings as $rankSetting)

                    <div class="row p-3 my-5 border">

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="level_no">Sequence No</label>
                                        <input class="form-control" name="sequence_no[]"
                                            id="sequence_no_{{ $rankSetting->sequence_no }}" type="number"
                                            value="{{ $rankSetting->sequence_no }}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="rank_name">Rank Short Name</label>
                                        <input class="form-control" value="{{ $rankSetting->rank_short_name }}"
                                            name="rank_short_name[{{ $rankSetting->sequence_no }}]"
                                            id="rank_short_name_{{ $rankSetting->sequence_no }}" type="text">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="rank_name">Rank Name</label>
                                        <input class="form-control" value="{{ $rankSetting->rank_name }}"
                                            name="rank_name[{{ $rankSetting->sequence_no }}]"
                                            id="rank_name_{{ $rankSetting->sequence_no }}" type="text">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="cash_bonus">Cash Bonus</label>
                                        <input class="form-control" value="{{ $rankSetting->cash_bonus }}"
                                            name="cash_bonus[{{ $rankSetting->sequence_no }}]"
                                            id="cash_bonus_{{ $rankSetting->sequence_no }}" type="number">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="level_bonus_amount">Type</label>
                                        <select class="form-control"
                                            name="cash_bonus_type[{{ $rankSetting->sequence_no }}]"
                                            id="cash_bonus_type_{{ $rankSetting->sequence_no }}">

                                            <option value="Per Id Team" @if ($rankSetting->cash_bonus_type == 'Per Id
                                                Team')
                                                selected
                                                @endif
                                                >Per Id Team</option>
                                            <option value="Per Id Company" @if ($rankSetting->cash_bonus_type == 'Per Id
                                                Company')
                                                selected
                                                @endif
                                                >Per Id Company</option>
                                            <option value="One Time" @if ($rankSetting->cash_bonus_type == 'One Time')
                                                selected
                                                @endif
                                                >One Time</option>

                                        </select>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="monthly_bonus">Monthly Bonus</label>
                                        <input class="form-control" value="{{ $rankSetting->monthly_bonus }}"
                                            name="monthly_bonus[{{ $rankSetting->sequence_no }}]"
                                            id="monthly_bonus_{{ $rankSetting->sequence_no }}" type="number">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="bonus_duration">Duration</label>
                                        <input class="form-control"
                                            name="bonus_duration[{{ $rankSetting->sequence_no }}]"
                                            value="{{ $rankSetting->bonus_duration }}"
                                            id="bonus_duration_{{ $rankSetting->sequence_no }}" type="number">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="monthly_bonus_type">Type</label>
                                        <select class="form-control"
                                            name="monthly_bonus_type[{{ $rankSetting->sequence_no }}]"
                                            id="monthly_bonus_type_{{ $rankSetting->sequence_no }}">

                                            <option value="Daily" @if ($rankSetting->monthly_bonus_type == 'Daily')
                                                selected
                                                @endif

                                                >Daily</option>
                                            <option value="Weekly" @if ($rankSetting->monthly_bonus_type == 'Weekly')
                                                selected
                                                @endif

                                                >Weekly</option>
                                            <option value="Bi-Monthly" @if ($rankSetting->monthly_bonus_type ==
                                                'Bi-Monthly')
                                                selected
                                                @endif

                                                >Bi-Monthly</option>
                                            <option value="Monthly" @if ($rankSetting->monthly_bonus_type == 'Monthly')
                                                selected
                                                @endif

                                                >Monthly</option>

                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="Others">Others</label>
                                <textarea class="form-control" name="others[{{ $rankSetting->sequence_no }}]"
                                    id="others_{{ $rankSetting->sequence_no }}" rows="4">{{ $rankSetting->others
                                    }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="bonus_type">Achivement Policy</label>
                                <div class="row">

                                    @foreach ($rankSetting->achivement as $achivement)

                                    <div class="col-md">
                                        <input class="form-control" value="{{ $achivement->achivement }}"
                                            name="achivement_policy[{{ $rankSetting->sequence_no }}][]"
                                            id="achivement_policy_{{ $rankSetting->sequence_no }}" type="text">
                                    </div>

                                    @endforeach

                                </div>
                            </div>
                        </div>

                    </div>

                    @endforeach

                </div>


            </div>
        </div>
    </div>

    <div class="tile">
        <div class="tile-body">
            <div class="row">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>

</form>

@endsection

@section('custom-script')
<script>
    function toggleAdViewInputs(){

        let isChecked = $('#is_ad_view').is(':checked');

        if(isChecked){

            $('.on_ad_view').show();
            $('#daily_bonus').attr('readonly', true);

        }else{

            $('.on_ad_view').hide();
            $('#daily_bonus').attr('readonly', false);

        }

    }

    function generateGenerationInputs(){

        let numberOfLevel = +$('#number_of_level').val();

        $('#generationInputs').html('');
        $('#preRenderedGenerationInputs').html('');


        for (let index = 1; index < numberOfLevel+1; index++) {

            let boilerplate = `
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="level_no">Level No</label>
                                    <input class="form-control" name="level_no[]" id="level_no_${index}" type="number" value="${index}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="level_bonus_amount">Bonus Amount</label>
                                    <input class="form-control" name="level_bonus_amount[${index}]" id="level_bonus_amount" type="number">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bonus_type">Bonus Type</label>
                                    <select name="bonus_type[${index}]" class="form-control" id="bonus_type">
                                        <option value="Individual">Individual</option>
                                        <option value="Complete">Complete</option>
                                    </select>
                                </div>
                            </div>
                        </div>`;


            $('#generationInputs').append(boilerplate);

        }

    }


    function generateAchivementInput(index){


        let achivementInputs = '';

        let numberOfAchivementPolicy = +$('#person_per_level').val();


        for (let i = 0; i < numberOfAchivementPolicy; i++) {


            let oneInput = `
                <div class="col-md">
                    <input class="form-control" name="achivement_policy[${index}][]" id="achivement_policy_${index}"
                        type="text">
                </div>
            `;

            // achivementInputs += oneInput;

            achivementInputs = achivementInputs + oneInput;

        }

        let achivementBoilerplate = `
            <div class="col-md-12">
                <div class="form-group">
                    <label for="bonus_type">Achivement Policy</label>
                    <div class="row">
                        ${achivementInputs}
                    </div>
                </div>
            </div>
            `;

        return achivementBoilerplate;

    }


    function generateRankInputs(){

        let numberOfLevel = +$('#number_of_rank_level').val();

        $('#rankInputs').html('');
        $('#preRenderedRankInputs').html('');


        for (let index = 1; index < numberOfLevel+1; index++) {

            let achivementInputs =  generateAchivementInput(index);

            let boilerplate = `
                        <div class="row p-3 my-5 border">

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="level_no">Sequence No</label>
                                        <input class="form-control" name="sequence_no[]" id="sequence_no_${index}"
                                            type="number" value="${index}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="rank_name">Rank Short Name</label>
                                        <input class="form-control" value="{{ $rankSetting->rank_short_name }}"
                                            name="rank_short_name[{{ $rankSetting->sequence_no }}]" id="rank_short_name_{{ $rankSetting->sequence_no }}"
                                            type="text">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="level_bonus_amount">Rank Name</label>
                                        <input class="form-control" name="rank_name[${index}]" id="rank_name_${index}"
                                            type="text">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="cash_bonus">Cash Bonus</label>
                                        <input class="form-control" name="cash_bonus[${index}]" id="cash_bonus_${index}"
                                            type="number">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="level_bonus_amount">Type</label>
                                        <select class="form-control" name="cash_bonus_type[${index}]"
                                            id="cash_bonus_type_${index}">
                                            <option value="Per Id Team">Per Id Team</option>
                                            <option value="Per Id Company">Per Id Company</option>
                                            <option value="One Time">One Time</option>
                                        </select>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="monthly_bonus">Monthly Bonus</label>
                                        <input class="form-control" name="monthly_bonus[${index}]"
                                            id="monthly_bonus_${index}" type="number">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="bonus_duration">Duration</label>
                                        <input class="form-control" name="bonus_duration[${index}]"
                                            id="bonus_duration_${index}" type="number">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="monthly_bonus_type">Type</label>
                                        <select class="form-control" name="monthly_bonus_type[${index}]"
                                            id="monthly_bonus_type_${index}">
                                            <option value="Daily">Daily</option>
                                            <option value="Weekly">Weekly</option>
                                            <option value="Bi-Monthly">Bi-Monthly</option>
                                            <option value="Monthly">Monthly</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="Others">Others</label>
                                <textarea class="form-control" name="others[${index}]" id="others_${index}" rows="4"></textarea>
                            </div>
                        </div>

                        ${achivementInputs}

                    </div>
        `;


        $('#rankInputs').append(boilerplate);

        }

    }


    $(document).ready(function () {

        toggleAdViewInputs();

        // if ad view is checked
        $('#is_ad_view').click(function (e) {
            toggleAdViewInputs();
        });

        // on ad view input

        $('#bonus_per_ad, #ad_per_day').keyup(function (e) {

            let isChecked = $('#is_ad_view').is(':checked');

            if(isChecked){

                let bonusPerAd = +$('#bonus_per_ad').val();
                let adPerDay = +$('#ad_per_day').val();


                let total = bonusPerAd * adPerDay;

                $('#daily_bonus').val(total);
            }


        });



    });

</script>
@endsection
