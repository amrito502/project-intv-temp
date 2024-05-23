<div>
    @include('dashboard.layouts.partials.error')
    <form wire:submit.prevent='save'>
        @csrf
        <div class="row">
            <div class="col-md-10">
                <div class="form-group">
                    <label for="name">Module Name</label>
                    <input class="form-control" wire:model='module.name' name="name" id="name" type="text"
                        placeholder="Enter name">
                </div>
            </div>

            <div class="col-md-2 mt-4">
                <button type="submit" class="btn btn-success mt-2 float-right">
                    <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                </button>
            </div>
        </div>
    </form>
</div>