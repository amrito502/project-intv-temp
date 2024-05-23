@extends('dashboard.layouts.app')

@section('content')
@include('dashboard.layouts.partials.error')

<form action="{{ route('cashrequisition.payment.update', $data->cashPayment->id ) }}" method="POST">
    @csrf


    <div class="tile mb-3">
        <div class="tile-body">
            <div class="">
                <div class="row">
                    <div class="col-md-12">
                        <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                        </button>
                        <h3 class="text-center mt-5 mb-0 d-md-none d-block">Cash Requisition Payment</h3>
                        <h3 class="text-center d-md-block d-none text-uppercase">Cash Requisition Payment</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tile">
        <div class="tile-body">
            <div class="">

                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="project_id">Project</label>
                            <select class="select2" id="project_id" required>
                                <option value="">Select Project</option>
                                @foreach ($data->projects as $project)
                                <option value="{{ $project->id }}" pt="{{ $project->project_type }}">{{
                                    $project->project_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="unit_id">Unit</label>
                            <select class="select2" id="unit_id" required>
                                <option value="">Select Project First</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tower">Tower</label>
                            <select class="select2" id="tower_id" required>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="text" class="form-control datepicker" id="date" name="date"
                                value="{{ $data->cashPayment->date }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="serial">Payment Serial</label>
                            <input type="text" class="form-control" id="serial" value="{{ $data->cashPayment->serial }}"
                                name="serial" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="budgethead">Budget Head</label>
                            <select class="select2" id="budgethead" required>
                                <option value="">Select Budget Head</option>
                                @foreach ($data->budgetHeads as $budgetHead)
                                <option value="{{ $budgetHead->id }}">{{ $budgetHead->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="estimated_amount">Estimated Amount</label>
                            <input type="text" class="form-control" id="estimated_amount" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="approved_amount">Approved Amount</label>
                            <input type="text" class="form-control" id="approved_amount" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="payment_amount">Payment Amount</label>
                            <input type="text" class="form-control" id="payment_amount" name="payment_amount">
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-success" id="addPaymentBtn">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="tile">
        <div class="tile-body">
            <div class="row">
                <div class="col-md-12" style="overflow-y: auto">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Project</th>
                                <th>Unit</th>
                                <th>Tower</th>
                                <th>Budget Head</th>
                                <th>Payment Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="payment-table">
                            @foreach ($data->cashPayment->items as $item)
                            <tr>
                                <td>
                                    <input type="hidden" name="projectId[]" value="{{ $item->project->id }}">
                                    {{ $item->project->project_name }}
                                </td>
                                <td>
                                    {{ $item->unit->name }}
                                    <input type="hidden" name="unitId[]" value="{{ $item->unit->id }}">
                                </td>
                                <td>
                                    <input type="hidden" name="towerId[]" value="{{ $item->tower->id }}">
                                    {{ $item->tower->name }}
                                </td>
                                <td>
                                    {{ $item->budgethead->name }}
                                    <input type="hidden" name="budgetheadId[]" value="{{ $item->budgethead->id }}">
                                </td>
                                <td>
                                    {{ $item->paymentAmount }}
                                    <input type="hidden" name="paymentAmount[]" value="{{ $item->paymentAmount }}">
                                </td>
                                <td>
                                    <span role="button" class="text-center text-danger"
                                        onclick="removeRow(event)">X</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <div class="tile">
        <div class="tile-body">
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-success float-right">
                        <i class="fa fa-check-circle" aria-hidden="true"></i> Pay
                    </button>
                </div>
            </div>
        </div>
    </div>


</form>
@endsection

@section('custom-script')

{{-- projectwise unit start --}}

<script>
    $(document).ready(function () {

        $('#project_id').change(function (e) {
            e.preventDefault();

            const projectId = +$(this).val();

            // projectwise unit start
            axios.get(route('project.units', projectId))
            .then(function (response) {

                const data = response.data.project_units;

                let options = `<option value="">Select An Option</option>`;

                data.forEach(el => {

                    let option = `<option value="${el.unit.id}">${el.unit.name}</option>`;

                    options += option;

                });

                $('#unit_id').html(options);

            })
            .catch(function (error) {
            })
            // projectwise unit end



            // projectwise tower start
            axios.get(route('projectwise.tower', projectId))
            .then(function (response) {

                const data = response.data.project_towers;

                let options = `<option value="">Select An Option</option>`;

                data.forEach(el => {

                    let option = `<option value="${el.id}">${el.name}</option>`;

                    options += option;

                });

                $('#tower_id').html(options);

            })
            .catch(function (error) {
            })
            // projectwise tower end


        });

        $('#unit_id').change(function (e) {
            e.preventDefault();

            const unitId = +$(this).val();

            if(unitId == ''){
                $('#unit_id').html('');
                return false;
            }

            let projectId = $('#project_id').val();


            axios.get(route('projectUnitWiseBudgetHeadCashOnly', [projectId, unitId]))
            .then(function (response) {


                const items = response.data;


                let options = `<option value="">Select An Option</option>`;


                items.forEach(item => {

                    let option = `<option value="${item.id}">${item.name}</option>`;

                    options += option;

                });

                $('#unitList .input select').html('');
                $('#unitList .input select').html(options);

            })
            .catch(function (error) {
            })

        });

        $('#budgethead').change(function (e) {
            e.preventDefault();

            budgetHeadWiseTotalEstimated();

            alreadyIssuedAmount();

        });

    });

    function budgetHeadWiseTotalEstimated(id){
        const projectId = +$('#project_id option:selected').val();
        const unitId = +$('#unit_id option:selected').val();
        const towerId = +$('#tower_id option:selected').val();
        const budgetHeadId = $('#budgethead option:selected').val();

        // get estimated amount start
            axios.get(route('budgetHeadWiseTotalEstimated', [projectId, unitId, budgetHeadId, towerId]))
            .then(function (response) {

                let data = response.data;

                $('#estimated_amount').val(data);

            })
            .catch(function (error) {
            })
        // get estimated amount end


    }

    function alreadyIssuedAmount(){

        const projectId = +$('#project_id option:selected').val();
        const unitId = +$('#unit_id option:selected').val();
        const towerId = +$('#tower_id option:selected').val();
        const budgetHeadId = $('#budgethead option:selected').val();

        // get issued amount start
        axios.get(route('budgetHeadWiseTotalApproved', {
            projectId, unitId, budgetHeadId, towerId
        }))
        .then(function (response) {

            let data = response.data;

            $('#approved_amount').val(data);

        })
        .catch(function (error) {
        })
        // get issued amount end

    }

</script>

{{-- projectwise unit end --}}


{{-- add data to table start --}}

<script>
    $(function () {

        $('#addPaymentBtn').click(function (e) {
            e.preventDefault();

            let projectEl = $('#project_id option:selected');
            let unitEl = $('#unit_id option:selected');
            let towerEl = $('#tower_id option:selected');
            let budgetheadEl = $('#budgethead option:selected');
            let paymentAmountEl = $('#payment_amount');

            let data = {
                project : {
                    'id': projectEl.val(),
                    'text': projectEl.text(),
                },
                unit : {
                    'id': unitEl.val(),
                    'text': unitEl.text(),
                },
                tower : {
                    'id': towerEl.val(),
                    'text': towerEl.text(),
                },
                budgetHead : {
                    'id': budgetheadEl.val(),
                    'text': budgetheadEl.text(),
                },
                paymentAmount : paymentAmountEl.val(),
            };


            let isValid = validateFormData(data);

            if(!isValid){
                return false;
            }

            addDataToTable(data);


        });

    });

    function addDataToTable(data){

        let tr = `
            <tr>
                <td>
                    ${data.project.text}
                    <input type="hidden" name="projectId[]" value="${data.project.id}">
                </td>
                <td>
                    ${data.unit.text}
                    <input type="hidden" name="unitId[]" value="${data.unit.id}">
                </td>
                <td>
                    ${data.tower.text}
                    <input type="hidden" name="towerId[]" value="${data.tower.id}">
                </td>
                <td>
                    ${data.budgetHead.text}
                    <input type="hidden" name="budgetheadId[]" value="${data.budgetHead.id}">
                </td>
                <td>
                    ${data.paymentAmount}
                    <input type="hidden" name="paymentAmount[]" value="${data.paymentAmount}">
                </td>
                <td>
                    <span role="button" class="text-center text-danger" onclick="removeRow(event)">X</span>
                </td>
            </tr>
        `;

        $('#payment-table').append(tr);

    }

    function removeRow(e){
        e.preventDefault();
        let row = $(e.target).parent().parent();

        row.remove()
    }

    function validateFormData(data){

        if(data.project.id == ''){
            alert('Please select a project');
            return false;
        }

        if(data.unit.id == ''){
            alert('Please select a unit');
            return false;
        }

        if(data.tower.id == ''){
            alert('Please select a tower');
            return false;
        }

        if(data.budgetHead.id == ''){
            alert('Please select a budgetHead');
            return false;
        }


        return true;

    }

</script>

{{-- add data to table end --}}

@endsection
