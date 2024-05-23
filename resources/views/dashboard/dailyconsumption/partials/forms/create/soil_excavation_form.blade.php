<div class="col-md-12 form-main-div form-8">
    <div class="row">

        <div class="col-md-4">
            <div class="form-group">
                <label for="completed_length">Completed Length (mm)</label>
                <input type="number" step="any" class="form-control" name="completed_length" id="completed_length" step="any" readonly>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="length">Length (mm)</label>
                <input type="number" step="any" class="form-control" name="length" id="length" step="any">
            </div>
        </div>

        <div class="col-md-4">
            <button type="button" class="btn btn-primary btn-block" id="calculateMaterials" onclick="getNewLengthMaterials()"
                style="margin-top: 29px;">Calculate</button>
        </div>

    </div>
</div>
