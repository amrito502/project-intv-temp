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
                <div class="col-md-12 text-center  mb-3">
                    <h4 style="margin-top: 30px;height:30px" class="bg-info">Ratio
                    </h4>
                </div>
            </div>

            <div class="row">

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="cement_of_cap">Cement</label>
                        <input type="number" step="any" class="form-control" name="cement" id="cement_of_cap"
                            step="any" value="{{ @$unitConfig->cement }}" onkeyup="UpdateUnitName()">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="sand_of_cap">Sand</label>
                        <input type="number" step="any" class="form-control" name="sand" id="sand_of_cap"
                            step="any" value="{{ @$unitConfig->sand }}" onkeyup="UpdateUnitName()">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="stone_of_cap">Stone</label>
                        <input type="number" step="any" class="form-control" name="stone" id="stone_of_cap"
                            step="any" value="{{ @$unitConfig->stone }}" onkeyup="UpdateUnitName()">
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="cement_qty_of_cap">Cement (Bosta)</label>
                        <input type="number" step="any" class="form-control" name="cement_qty"
                            id="cement_qty_of_cap" value="{{ @$unitConfig->cement_qty }}" step="any" readonly >
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="sand_qty_of_cap">Sand (CFT)</label>
                        <input type="number" step="any" class="form-control" name="sand_qty"
                            id="sand_qty_of_cap" value="{{ @$unitConfig->sand_qty }}" step="any" readonly >
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="stone_qty_of_cap">Stone (CFT)</label>
                        <input type="number" step="any" class="form-control" name="stone_qty"
                            id="stone_qty_of_cap" value="{{ @$unitConfig->stone_qty }}" step="any" readonly >
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary btn-block" id="calculateMaterialsOfCap" onclick="calcCap()"
                        style="margin-top: 29px;">Calculate Material</button>
                </div>
            </div>

        </div>


    </div>

</div>
{{-- cap ratio end --}}


<script src="{{ asset('js/unit_estimation/cap_calculation.js') }}"></script>
