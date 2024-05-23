 {{-- cap ratio start --}}
 <div class="col-md-6 form-main-div form-9">
    <div class="row">

        <div class="col-md-12">
            <div class="row">

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="length">Length (mm)</label>
                        <input type="number" step="any" class="form-control" name="length" id="length"
                            step="any" value="{{ @$unitConfig->length }}" onkeyup="UpdateUnitName()">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="width">Width (mm)</label>
                        <input type="number" step="any" class="form-control" name="width" id="width"
                            step="any" value="{{ @$unitConfig->width }}" onkeyup="UpdateUnitName()">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="height">Height (mm)</label>
                        <input type="number" step="any" class="form-control" name="height" id="height"
                            step="any" value="{{ @$unitConfig->height }}" onkeyup="UpdateUnitName()">
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
                        <label for="soil_qty">Total Soil Volume (CFT)</label>
                        <input type="number" step="any" class="form-control" name="soil_qty"
                            id="soil_qty" value="{{ @$unitConfig->soil_qty }}" step="any" readonly>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary btn-block" id="calculateMaterialsOfCap" onclick="calcSoilFillingVolume()"
                        style="margin-top: 29px;">Calculate Material</button>
                </div>
            </div>

        </div>


    </div>

</div>
{{-- cap ratio end --}}


<script src="{{ asset('js/unit_estimation/soil_filling_calculation.js') }}"></script>
