{{-- pile ratio start --}}
<div class="col-md-6 form-main-div form-8">
    <div class="row">

        <div class="col-md-12">
            <div class="form-group">
                <label for="pile_length">Pile Length</label>
                <input type="number" step="any" class="form-control" name="pile_length" id="pile_length" step="any" value="{{ @$unitConfig->pile_length }}" onkeyup="UpdateUnitName()">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="dia">DIA (mm)</label>
                <input type="number" step="any" class="form-control" name="dia" id="dia" step="any" value="{{ @$unitConfig->dia }}" onkeyup="UpdateUnitName()">
            </div>
        </div>

        <div class="col-md-12">

            <div class="row">
                <div class="col-md-12">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cement_qty">Cement (Bosta)</label>
                                <input type="number" step="any" class="form-control" name="cement_qty" value="{{ @$unitConfig->cement_qty }}" id="cement_qty" step="any"
                                    readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sand_qty">Sand (CFT)</label>
                                <input type="number" step="any" class="form-control" name="sand_qty" value="{{ @$unitConfig->sand_qty }}" id="sand_qty" step="any"
                                    readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="stone_qty">Stone (CFT)</label>
                                <input type="number" step="any" class="form-control" name="stone_qty" value="{{ @$unitConfig->stone_qty }}" id="stone_qty" step="any"
                                    readonly>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<div class="col-md-6 form-main-div form-8">
    <div class="row">

        <div class="col-md-12 text-center mb-3">

            <h4 style="margin-top: 30px;height:30px" class="bg-info">Ratio
            </h4>

        </div>

        <div class="col-md-12">
            <div class="row">

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="cement">Cement</label>
                        <input type="number" step="any" class="form-control" name="cement" id="cement" step="any" value="{{ @$unitConfig->cement }}" onkeyup="UpdateUnitName()">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="sand">Sand</label>
                        <input type="number" step="any" class="form-control" name="sand" id="sand" step="any" value="{{ @$unitConfig->sand }}" onkeyup="UpdateUnitName()">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="stone">Stone</label>
                        <input type="number" step="any" class="form-control" name="stone" id="stone" step="any" value="{{ @$unitConfig->stone }}" onkeyup="UpdateUnitName()">
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary btn-block" id="calculateMaterials" onclick="calculateMaterialsOfPile()"
                        style="margin-top: 29px;">Calculate Material</button>
                </div>
            </div>
        </div>

    </div>
</div>
{{-- pile ratio end --}}


<script src="{{ asset('js/unit_estimation/pile_calculation.js') }}"></script>

