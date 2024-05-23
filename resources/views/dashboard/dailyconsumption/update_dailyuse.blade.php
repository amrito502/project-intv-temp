@extends('dashboard.layouts.app')

@section('content')

<form method="POST" action="{{ route('DailyUsesUpdate', $data->dailyConsumption->id) }}">
    @csrf

    <div class="tile">
        <div class="tile-body">
            <div class="">
                <div class="row">
                    <div class="col-md-12">
                        <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                        </button>
                        <h3 class="text-center mt-5 mb-0 d-md-none d-block">Edit Daily Consumption</h3>
                        <h3 class="text-center d-md-block d-none text-uppercase">Edit Daily Consumption</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tile">
        <div class="tile-body">
            <div class="">

                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="project">Project</label>
                            <input type="text" class="form-control" name="project"
                                value="{{ $data->dailyConsumption->project->project_name }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="unit">Unit</label>
                            <input type="text" class="form-control" name="unit"
                                value="{{ $data->dailyConsumption->unit->name }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tower">Tower</label>
                            <select class="select2" name="tower[]" id="tower" disabled>
                                @foreach ($data->projectTowers as $projectTower)
                                <option value="{{ $projectTower->id }}" @if ($projectTower->id ==
                                    $data->dailyConsumption->tower_id)
                                    selected
                                    @endif
                                    >{{ $projectTower->name }}</option>
                                @endforeach
                            </select>
                            {{-- <input type="text" class="form-control" name="tower"
                                value="{{ $data->dailyConsumption?->tower?->name }}" readonly> --}}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" name="date" class="form-control"
                                value="{{ $data->dailyConsumption->date }}" disabled>
                        </div>
                    </div>

                </div>

                @include('dashboard.dailyconsumption.table.daily_use_table', ['dailyconsumptionItems' =>
                $data->dailyconsumptionItems, 'budgetHeads' => $data->budgetHeads ])

            </div>
        </div>
    </div>


    <div class="tile">
        <div class="tile-body">
            <div class="row">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-success mt-2 float-right">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>

</form>



<div id="itemList" style="display:none">
    <div class="input select">
        {!! $data->budgetHeadSelect !!}
    </div>
</div>

<div id="unitList" style="display:none">
    <div class="input select">
        <select>
            <option value=" ">Select UOM</option>
            <?php
                foreach ($data->units as $unit)
                {
            ?>
            <option value="{{$unit->id}}">{{$unit->name}}</option>
            <?php
                }
            ?>
        </select>
    </div>
</div>


@endsection

@section('custom-script')


{{-- projectwise unit start --}}
{{-- <script>
    function getProjectWiseUnit() {
        const projectId = +$('#project').val();
        const projectType = $('#project option:selected').attr('ptype');

        if(projectId == ''){
            $('#unit_ids').html('');
            return false;
        }

        axios.get(route('project.units', projectId))
        .then(function (response) {

            const data = response.data.project_units;

            let options = '<option>Select Unit</option>';

            data.forEach(el => {

                let option = `<option value="${el.unit.id}" >${el.unit.name}</option>`;

                options += option;

            });


            $('#unit_ids').html(options);

        })
        .catch(function (error) {
        })


        // fetch project towers
        if(projectType == 'tower'){

            axios.get(route('projectwise.tower', projectId))
            .then(function (response) {

                const data = response.data.project_towers;

                let options = '<option value="">Select Tower</option>';

                data.forEach(el => {

                    let option = `<option value="${el.id}" >${el.name}</option>`;

                    options += option;

                });


                $('#tower').html(options);

            })
            .catch(function (error) {
            })

        }

    }


    function getProjectAndUnitWiseBudgetHeads() {
        const projectId = +$('#project').val();
        const unitIds = $('#unit_ids').val();

        if(projectId == ''){
            $('#unit_ids').html('');
            return false;
        }

        if(unitIds == []){
            return false;
        }

        console.log(projectId, unitIds);


        axios.get(route('projectUnitToBudgetHead', [projectId, unitIds]))
        .then(function (response) {

            const data = response.data;

            $('.budgethead-table-here').html(data);

        })
        .catch(function (error) {
        })

    }


    $(document).ready(function () {

        $('#project').change(function (e) {
            e.preventDefault();

            getProjectWiseUnit();

        });


        $('#unit_ids').change(function (e) {
            e.preventDefault();

            getProjectAndUnitWiseBudgetHeads();

        });

    });
</script> --}}
{{-- projectwise unit end --}}


<script type="text/javascript">
    function addItem() {
        var row_count = $('.row_count').val();
        var total = parseInt(row_count) + 1;

        let rate_attr = '';
        let liftingType = $('#lifting_type').val();

        if(['Project wise Company Provide', 'Central Company Provide'].includes(liftingType)){
            rate_attr = 'readonly'
        }

        $(".gridTable tbody").append('<tr id="itemRow_' + total + '">' +
            '<td>'+
            '<select name="budgetHeadIds[]" onchange="updateItemRow(event, ' + total + ')" class="form-control chosen-select itemList itemList_'+total+'">'+
            '</select>'+
            '</td>'+
            '<td>'+
            '<select name="unit_id[]" class="form-control chosen-select unitList_'+total+'" required readonly>'+
            '</select>'+
            '</td>'+
            '<td><input style="text-align: right;" class="form-control qty qty_'+total+'" type="number" step="any" name="consumption_qty[]" value="1" required oninput="totalAmount('+total+')"></td>'+
            '<td align="center"><span class="btn btn-success" onclick="addItem()"> <i class="fa fa-plus" aria-hidden="true" style="font-size: 20px"></i> </span> <span class="btn btn-danger item_remove" onclick="itemRemove(' + total + ')"><i class="fa fa-trash" style="font-size: 20px"></i> </span></td>'+
            '</tr>');
        $('.row_count').val(total);

        var itemList = $("#itemList div select").html();
        $('.itemList_'+total).html(itemList);
        $('.chosen-select').chosen();
        $('.chosen-select').trigger("chosen:updated");

        var unitList = $("#unitList div select").html();
        $('.unitList_'+total).html(unitList);
        $('.chosen-select').chosen();
        $('.chosen-select').trigger("chosen:updated");

        row_sum();
    }

    $(".add_item").click(function () {
        addItem();
    });

    function itemRemove(i) {
        var total_qty = $('.total_qty').val();
        var total_amount = $('.total_amount').val();

        var quantity = $('.qty_'+i).val();
        var amount = $('.amount_'+i).val();

        total_qty = total_qty - quantity;
        total_amount = total_amount - amount;

        $('.total_qty').val(total_qty.toFixed(2));
        $('.total_amount').val(total_amount.toFixed(2));

        $("#itemRow_" + i).remove();
    }

    function totalAmount(i){
        var qty = $(".qty_" + i).val();
        var rate = $(".rate_" + i).val();
        var sum_total = parseFloat(qty) *parseFloat(rate);
        $(".amount_" + i).val(sum_total.toFixed(2));
        row_sum();
    }

    function row_sum(){
        var total_qty = 0;
        var total_amount = 0;
        $(".qty").each(function () {
            var stvalTotal = parseFloat($(this).val());
            // console.log(stval);
            total_qty += isNaN(stvalTotal) ? 0 : stvalTotal;
        });

        $(".amount").each(function () {
            var stvalAmount = parseFloat($(this).val());
            // console.log(stval);
            total_amount += isNaN(stvalAmount) ? 0 : stvalAmount;
        });

        $('.total_qty').val(total_qty.toFixed(2));
        $('.total_amount').val(total_amount.toFixed(2));
    }
</script>

<script>
    function updateItemRow(e, rowId) {

        let changeInputVal = +$(e.target).val();
        let changeInputText = $(e.target).find("option:selected").text();

        axios.get(route('budgetHeadToMaterialByName', changeInputText))
        .then(function (response) {
            let data = response.data;

            $('.unitList_' + rowId).val(data.unit);
            $('.unitList_' + rowId).trigger("chosen:updated");

            // $('.cement_uom').chosen().chosenReadonly();

            $('.unitList_' + rowId).chosen().chosenReadonly();

        })
        .catch(function (error) {
        })

        // console.log(changeInputVal, rowId);
    }
</script>

<script>
    $(function () {
        row_sum();
    });
</script>

@endsection
