 {{-- cap ratio start --}}
 <div class="col-md-6 form-main-div form-9">
    <div class="row">

        <div class="col-md-12">
            <div class="row">

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="length">Length (feet)</label>
                        <input type="number" step="any" class="form-control" name="length" id="length"
                            step="any" value="{{ @$unitConfig->length }}" onkeyup="UpdateUnitName()">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="width">Width (feet)</label>
                        <input type="number" step="any" class="form-control" name="width" id="width"
                            step="any" value="{{ @$unitConfig->width }}" onkeyup="UpdateUnitName()">
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
                        <label for="brick_qty">Number Of Brick</label>
                        <input type="number" step="any" class="form-control" name="brick_qty"
                            id="brick_qty" step="any" value="{{ @$unitConfig->brick_qty }}" readonly>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary btn-block" id="calculateMaterialsOfCap" onclick="calcSolingBrick()"
                        style="margin-top: 29px;">Calculate Material</button>
                </div>
            </div>

        </div>


    </div>

</div>
{{-- cap ratio end --}}


<script src="{{ asset('js/unit_estimation/brick_soling_calculation.js') }}"></script>
