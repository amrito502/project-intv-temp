<div class="col-lg-4 col-md-6 col-sm-6 addressParent" id="addressParent" targetVal="{{ $address->id }}">
    <article id="address" class="address" data-id-address="70">
        <div class="address-body">
            <h4>My Address {{ $sl }}</h4>
            <address>
               {{ $address->address }}
            </address>
        </div>

        <div class="address-footer">
            <a href="#" data-toggle="modal" data-target="#editAddressModal-{{ $address->id }}">
                <i class="fa fa-pencil" aria-hidden="true"></i>
                <span>Update</span>
            </a>
            <a href="{{ route('customer.address.delete', [$address->id]) }}" data-link-action="delete-address">
                <i class="fa fa-trash" aria-hidden="true"></i>
                <span>Delete</span>
            </a>
        </div>
    </article>
</div>

    <!-- Address update Modal -->
    <div class="modal fade" id="editAddressModal-{{ $address->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('customer.address.update', [$address->id]) }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Address {{ $sl }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control address_value" name="address" placeholder="Address" 
                                cols="30">{{ $address->address }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>