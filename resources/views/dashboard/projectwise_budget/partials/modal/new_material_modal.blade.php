<div class="modal fade" id="newMaterialModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Budgethead</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="code">Material Code</label>
                            <input class="form-control" name="code" id="code" type="text"
                                placeholder="Enter Material Code">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Material Name</label>
                            <input class="form-control" name="name" id="name" type="text"
                                placeholder="Enter Material Name">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price">Material Unit</label>
                            <select name="unit" id="unitId" class="select2" required>
                                <option value="">Select Unit</option>
                                @foreach ($data->units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-check" style="margin-top: 29px;">
                            <input type="checkbox" class="form-check-input" name="budgetHead" id="budgetHead">
                            <label class="form-check-label" for="budgetHead">In BudgetHead</label>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" id="create_new_material_submit_btn" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>


