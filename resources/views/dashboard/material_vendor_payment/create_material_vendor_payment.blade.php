@extends('dashboard.layouts.app')

@section('content')

<form method="POST" action="{{ route('materialvendorpayment.store') }}">
    @csrf

    <div class="tile">
        <div class="tile-body">
            <div class="">
                <div class="row">
                    <div class="col-md-12">
                        <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                        </button>
                        <h3 class="text-center mt-5 mb-0 d-md-none d-block">Material Payment</h3>
                        <h3 class="text-center d-md-block d-none text-uppercase">Material Payment</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tile">
        <div class="tile-body">
            <div class="">

                <div class="row">
                    <div class="col-md-12 text-right mb-2">
                        <button class="btn btn-primary" type="button" onclick="getLiftingInvoiceAndShow()">Get Invoices</button>
                    </div>
                </div>

                <div class="row">

                    @include('dashboard.layouts.partials.company_dropdown', [
                    'columnClass'=> 'col-md-12',
                    'company_id' => 0,
                    ])

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="payment_no">Payment No.</label>
                            <input class="form-control" name="payment_no" id="payment_no" type="text"
                                value="{{ $data->serial_no }}" disabled>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="vendor">Vendor</label>
                            <select name="vendor" class="select2" id="vendor" required>
                                <option value="">Select</option>
                                @foreach ($data->vendors as $vendor)
                                <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="project">Project</label>
                            <select name="project" id="project" class="select2">
                                <option value="">Select Project</option>
                                @foreach ($data->projects as $project)
                                <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tower">Tower</label>
                            <select class="select2" name="tower" id="tower">
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="current_due">Current Due</label>
                            <input class="form-control" name="current_due" id="current_due" type="text" value="0" disabled>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="payment_now">Payment Now</label>
                            <input class="form-control" name="payment_now" id="payment_now" type="number" required readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="balance">Balance</label>
                            <input class="form-control" name="balance" id="balance" type="number" disabled>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="payment_date">Payment Date</label>
                            <input class="form-control datepicker" name="payment_date" id="payment_date" type="text" autocomplete="off"
                                required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="payment_type">Payment Type</label>
                            <select name="payment_type" class="select2" id="payment_type" required>
                                <option value="">Select</option>
                                <option value="Cash">Cash</option>
                                <option value="Cheque">Cheque</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="money_receipt">Money Receipt</label>
                            <input class="form-control" name="money_receipt" id="money_receipt" type="text" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <input class="form-control" name="remarks" id="remarks" type="text">
                        </div>
                    </div>

                </div>

                <div class="row mt-3">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>System Serial</th>
                                <th>Voucher No</th>
                                <th>Materials</th>
                                <th>Total Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="invoice-list"></tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>


    <div class="tile">
        <div class="tile-body">
            <div class="row">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-success mt-2 float-right">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>

</form>
@endsection

@section('custom-script')
<script>

    function calculateDueAmount(){
        let currentDue = +$('#current_due').val();
        let paymentNow = +$('#payment_now').val();

        let balance = currentDue - paymentNow;

        $('#balance').val(balance);
    }

    function CalculateTotalAmount() {

        let TotalAmount = 0;

        $('.invoiceCheckBox').each(function (index, element) {
            let thisEl = $(element);

            if(thisEl.is(':checked')){

                let checkboxId = thisEl.attr('iter');

                let invoiceAmount = $('.totalAmount-'+checkboxId).val();

                TotalAmount += parseFloat(invoiceAmount);

            }
        });

        $('#payment_now').val(TotalAmount);

        calculateDueAmount();
    }

    function getProjectTower(projectId){

        // fetch tower start
        axios.get(route('projectwise.tower', projectId))
            .then(function (response) {

            const data = response.data.project_towers;

            let options = `<option value="">Select An Option</option>`;

            data.forEach(el => {

                let option = `<option value="${el.id}">${el.name}</option>`;

                options += option;

            });


            $('#tower').html(options);

        })
        .catch(function (error) {
        })
        // fetch tower end

    }


    function getLiftingInvoiceAndShow() {

        let vendorId = $('#vendor').val();
        let projectId = $('#project').val();
        let towerId = $('#tower').val();

        if (vendorId == '' || projectId == '') {
            return false;
        }

        $('#invoice-list').html('');

        // fetch lifting invoice start
        axios.get(route('unpaid.lifting.invoice', {
            vendor_id: vendorId,
            project_id: projectId,
            tower_id: towerId
        }))
            .then(function (response) {

            const data = response.data;

            let tbody = "";

            let i = 1;
            data.forEach(el => {

                let tr = `<tr>
                            <td>${i++}</td>
                            <td>${el.date}</td>
                            <td>${el.serial_no}</td>
                            <td>${el.voucher_no}</td>
                            <td>${el.materials}</td>
                            <td>
                                ${el.total_amount}
                                <input type="hidden" class="totalAmount-${el.id}" value="${el.total_amount}">
                            </td>
                            <td>
                                <input onclick="CalculateTotalAmount()" class="invoiceCheckBox" iter="${el.id}" type="checkbox" name="lifting_invoice_ids[]" value="${el.id}">
                            </td>
                        </tr>`;

                tbody += tr;

            });

            $('#invoice-list').html(tbody);

        })
    }


    $(document).ready(function () {

        $('#vendor').change(function (e) {
            e.preventDefault();

            let vendorId = $(this).val();

            axios.get(route('getVendorDue'), {
            params: {
                vendorId:vendorId
            }
            })
            .then(function (response) {
                let dueAmount = response.data;
                $('#current_due').val(dueAmount);
            })
            .catch(function (error) {
            })


        });

        $('#project').change(function (e) {
            e.preventDefault();

            const projectId = +$(this).val();

            getProjectTower(projectId);

        });

    });
</script>
@endsection
