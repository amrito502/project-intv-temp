{{-- cap ratio start --}}
<div class="col-md-6 form-main-div form-9">
    <div class="row">

        <div class="col-md-12">
            <div class="row">

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="length">Length (feet)</label>
                        <input type="number" step="any" class="form-control" name="length" id="length" step="any"
                            value="{{ @$unitConfig->length }}" onkeyup="UpdateUnitName()">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="width">Width (feet)</label>
                        <select class="form-control" name="width" id="width" onchange="UpdateUnitName()">
                            <option value=".42">5" Wall</option>
                            <option value=".83">10" Wall</option>
                        </select>

                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="height">Height (feet)</label>
                        <input type="number" step="any" class="form-control" name="height" id="height" step="any"
                            value="{{ @$unitConfig->height }}" onkeyup="UpdateUnitName()">
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<div class="col-md-6 form-main-div form-9">

    <div class="row">
        <div class="col-md-12">

            <div class="row">

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="cement_qty_of_cap">Total Required Brick</label>
                        <input type="number" step="any" class="form-control" name="brick_qty" id="brick_qty" step="any" value="{{ @$unitConfig->brick_qty }}" readonly>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary btn-block" id="calculateMaterialsOfCap"
                        onclick="calcWall()" style="margin-top: 29px;">Calculate Material</button>
                </div>
            </div>

        </div>


    </div>

</div>
{{-- cap ratio end --}}

<script src="{{ asset('js/unit_estimation/wall_calculation.js') }}"></script>
