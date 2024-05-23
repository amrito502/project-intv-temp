
<script type="text/javascript">
    $(document).ready(function () {
        $( "form[name='productType']" ).on( "submit", function( event ) {
            var data = $( this ).serialize();
            $.ajax({
                type: "POST",
                url: "{{ route('productTypes.store') }}",
                data: data,
                success: function(response) {
                    $('#productType').modal('hide');
                    swal("Good job!", "Successfully added type!", "success");
                    $("#type_id").append(new Option(response.name, response.id));
                },
                error: function(response) {
                    swal("Aww!", "Something went wrong. Try again!", "error");
                }
            });
        });


        $( "form[name='productColor']" ).on( "submit", function( event ) {
            var data = $( this ).serialize();
            $.ajax({
                type: "POST",
                url: "{{ route('productColors.store') }}",
                data: data,
                success: function(response) {
                    $('#productColor').modal('hide');
                    swal("Good job!", "Successfully added type!", "success");
                    $("#color_id").append(new Option(response.name, response.id));
                },
                error: function(response) {
                    swal("Aww!", "Something went wrong. Try again!", "error");
                }
            });
        });


        $( "form[name='productName']" ).on( "submit", function( event ) {
            var data = $( this ).serialize();
            $.ajax({
                type: "POST",
                url: "{{ route('productNames.store') }}",
                data: data,
                success: function(response) {
                    $('#productName').modal('hide');
                    swal("Good job!", "Successfully added Name!", "success");
                    $("#name_id").append(new Option(response.name, response.id));
                },
                error: function(response) {
                    swal("Aww!", "Something went wrong. Try again!", "error");
                }
            });
        });


        $( "form[name='newSupplier']" ).on( "submit", function( event ) {
            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: "{{ route('suppliers.store') }}",
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#newSupplier').modal('hide');
                    $("#supplier_id").append(new Option(response.name, response.id));
                    swal("Good job!", "Successfully added Product!", "success");
                },
                error: function(response) {
                    swal("Aww!", "Something went wrong. Try again!", "error");
                }
            });
        });


        $( "form[name='newCustomer']" ).on( "submit", function( event ) {
            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: "{{ route('customers.store') }}",
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#newCustomer').modal('hide');
                    $("#customer_id").append(new Option(response.name, response.id));
                    swal("Good job!", "Successfully added Customer!", "success");
                },
                error: function(response) {
                    swal("Aww!", "Something went wrong. Try again!", "error");
                }
            });
        });


        $( "form[name='newProduct']" ).on( "submit", function( event ) {
            var data = $( this ).serialize();
            $.ajax({
                type: "POST",
                url: "{{ route('products.store') }}",
                data: data,
                success: function(response) {
                    $('#newProduct').modal('hide');
                    $("#product_id").append('<option value="'+response.data.id+'" data-price="'+response.data.price+'" data-name="'+response.data.name.name+'" data-serial="'+response.data.serial+'" data-id="'+response.data.id+'">'+response.data.serial+'</option>');
                    swal("Good job!", "Successfully added Product!", "success");
                },
                error: function(response) {
                    swal("Aww!", "Something went wrong. Try again!", "error");
                }
            });
        });

    })
</script>