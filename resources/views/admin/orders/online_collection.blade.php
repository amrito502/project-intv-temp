@extends('admin.layouts.master')

@section('custom-css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection


@section('content')

<style>
  th {
    background: #00c292;
    font-weight: bold !important;
    padding: 5px !important;
    font-size: 11px;
  }
</style>

<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6">
            <h4 class="card-title">{{ $title }}</h4>
          </div>
          <div class="col-md-6" style="text-align: right">

            <a href="#" style="font-size: 16px;" class="btn btn-outline-info btn-lg"
              onclick="window.history.go(-1); return false;">
              <i class="fa fa-arrow-circle-left"></i> Go Back
            </a>

          </div>
        </div>
      </div>
      <div class="card-body">
        @php
        $message = Session::get('msg');
        if (isset($message)) {
        echo"<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>" .$message."</strong>
        </div>";
        }

        Session::forget('msg')
        @endphp
        <?php
                  
          ?>
        <div class="table-responsive">
          <form action="{{ route('online.collection.save') }}" method="POST">
            {{ csrf_field() }}



            <div class="row">
              
              <div class="col-md-4">

                <div class="text-left" style="width:200px">
                  <select id="courier" class="form-control">
                    <option value="">Select An Option</option>
                    @foreach ($couriers as $courier)
                    <option value="{{ $courier->id }}">{{ $courier->name }}</option>
                    @endforeach
                  </select>
                </div>

              </div>

              <div class="col-md-4 offset-md-4">

                <div class="text-right">
                  <button type="submit" class="btn btn-outline-info btn-lg">
                    <i class="fa fa-save"></i> Save
                  </button>
                </div>

              </div>
            </div>





            <table id="ordersTable" class="table table-bordered table-striped dataTable no-footer"
              style="margin-top:20px" name="ordersTable">
              <thead>
                <tr>
                  <th>S/L</th>
                  <th>Invoice No</th>
                  <th>Invoice Date</th>
                  <th>Customer Name</th>
                  <th>Customer Phone</th>
                  <th>Bill Amount</th>
                  <th>Receive Amount</th>
                  <th>
                    <input type="checkbox" id="selectAll">
                  </th>
                </tr>
              </thead>
              <tbody id="tbody">
                @php
                $i=1;
                @endphp
                @foreach ($completedOrders as $completedOrder)
                <tr>
                  <td>{{ $i++ }}</td>
                  <td>
                    {{ "RUON-" . $completedOrder->checkout->created_at->format('yd') ."-". $completedOrder->checkout->id }}
                  </td>
                  <td>{{ $completedOrder->checkout->created_at->format('d-m-Y') }}</td>
                  <td>{{ $completedOrder->checkout->shipping->name }}</td>
                  <td>{{ $completedOrder->checkout->shipping->mobile }}</td>
                  <td>{{ $completedOrder->checkout->transaction->total }}</td>
                  <td>
                    <input type="text" class="form-control" value="{{ $completedOrder->checkout->transaction->total }}"
                      name="checkout_receive[{{ $completedOrder->checkout->id }}]">
                  </td>
                  <td>
                    <input type="checkbox" name="checkout_id[]" value="{{ $completedOrder->checkout->id }}">
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>

            <div class="text-right mt-5">
              <button type="submit" class="btn btn-outline-info btn-lg">
                <i class="fa fa-save"></i> Save
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- ============================================================== -->
<!-- End PAge Content -->
<!-- ============================================================== -->


@section('custom-js')

{{-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> --}}
{{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> --}}

<script src="https://cdn.jsdelivr.net/npm/dateformat@3.0.3/lib/dateformat.js"></script>

<script>
  $("#selectAll").click(function(){
  $('input:checkbox').not(this).prop('checked', this.checked);
  });

  let tbody = $('tbody');

  $('#courier').change(function (e) { 
    e.preventDefault();
    tbody.html('');

      $.ajaxSetup({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
          
      $.ajax({
        type: "POST",
        url: "{{ route('courierwise.checkout') }}",
        data: {
        courier_id:$('#courier').val()
      },
      
      success: function(response) {
          let i = 1;

          for (const checkout in response) {
            let tr = `<tr>`;
            let td = ``;
            if (Object.hasOwnProperty.call(response, checkout)) {
              const element = response[checkout];

              let date = new Date(element.checkout.created_at).toISOString();
              date = dateFormat(date, "yydd");

              let invoice = "RUON-" + date +"-"+ element.checkout.id;

              td += `
                <td>${i}</td>
                <td>${invoice}</td>
                <td>${dateFormat(element.checkout.created_at, "dd-mm-yyyy")}</td>
                <td>${element.checkout.shipping.name}</td>
                <td>${element.checkout.shipping.mobile}</td>
                <td>${element.checkout.transaction.total}</td>
                <td>
                  <input type="text" class="form-control" value="${element.checkout.transaction.total}"
                    name="checkout_receive[${element.checkout.id}]">
                </td>
                <td>
                  <input type="checkbox" name="checkout_id[]" value="${element.checkout.id}">
                </td>
              `;

              i++;
              tr += td;
            }
            tr += `</tr>`;

            tbody.append(tr);
            // console.log(tr);
          }

        }
      });

  });
</script>

@endsection
@endsection