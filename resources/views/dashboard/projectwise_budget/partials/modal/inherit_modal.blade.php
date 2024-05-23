
<div class="modal fade" id="inheritModal" tabindex="-1" role="dialog" aria-labelledby="inheritModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="inheritModalLabel">Inherit</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="tower">Tower</label>
                            <select class="select2" name="tower_inherit" id="tower_inherit" required>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="unit_config_id_inherit">Unit Config</label>
                            <select class="select2" name="unit_config_id_inherit" id="unit_config_id_inherit"
                                required>
                                <option value="">Select Unit First</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="inheritBtn">Inherit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>
