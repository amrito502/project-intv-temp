<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js"
    integrity="sha512-u9akINsQsAkG9xjc1cnGF4zw5TFDwkxuc9vUp5dltDWYCSmyd0meygbvgXrlc/z7/o4a19Fb5V0OUE58J7dcyw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="{{ asset('admin-elite/assets/node_modules/jquery/jquery-3.2.1.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!-- Jquery for multi select or choose -->
<script src="{{ asset('admin-elite/dist/js/chosen.jquery.js') }}"></script>

<!-- Bootstrap popper Core JavaScript -->
<script src="{{ asset('admin-elite/assets/node_modules/popper/popper.min.js') }}"></script>
<script src="{{ asset('admin-elite/assets/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="{{ asset('admin-elite/dist/js/perfect-scrollbar.jquery.min.js') }}"></script>
<!--Wave Effects -->
<script src="{{ asset('admin-elite/dist/js/waves.js') }}"></script>
<!--Menu sidebar -->
<script src="{{ asset('admin-elite/dist/js/sidebarmenu.js') }}"></script>
<!--Custom JavaScript -->
{{-- <script src="{{ asset('admin-elite/dist/js/custom.min.js') }}"></script> --}}
<script src="{{ asset('admin-elite/dist/js/custom.js') }}"></script>

<!--stickey kit -->
<script src="{{ asset('admin-elite/assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
<script src="{{ asset('admin-elite/assets/node_modules/sparkline/jquery.sparkline.min.js') }}"></script>

<!-- Sweet-Alert  -->
<script src="{{ asset('admin-elite/assets/node_modules/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('admin-elite/assets/node_modules/sweetalert/jquery.sweet-alert.custom.js') }}"></script>

<!-- switchery  -->
<script src="{{ asset('admin-elite/assets/node_modules/switchery/dist/switchery.min.js') }}"></script>

<!-- Morris graph chart -->
<script src="{{ asset('admin-elite/assets/node_modules/morrisjs/morris.min.js') }}"></script>

<script src="{{ asset('admin-elite/assets/node_modules/morrisjs/morris.js') }}"></script>
<script src="{{ asset('admin-elite/assets/node_modules/morrisjs/raphael.min.js') }}"></script>

<!-- summernote  -->
<script src="{{ asset('admin-elite/assets/node_modules/summernote/dist/summernote.min.js') }}"></script>
<!-- tagsinput  -->
<script src="{{ asset('admin-elite/assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}">
</script>

<!-- This is data table -->
{{-- <script src="{{ asset('admin-elite/assets/node_modules/datatables/jquery.dataTables.min.js') }}"></script> --}}

<script type="text/javascript" src="{{ asset('admin-elite/dist/js/jquery.fancybox.min.js') }}"></script>


<!-- This is Tree Menu JS  -->
<script src="{{ asset('tree-menu/TreeMenu.js') }}"></script>

<!-- <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
 <script>
    $(document).ready(function () {
        setTimeout(function () { //$(".message").hide('blind', {}, 500));
            $(".message").slideUp(1000).hide(1000);
        }, 5000);
        tinymce.init({
            selector: '.tinymce',
            forced_root_block: ''
        });
    });
</script> -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script type="text/javascript">
    $(document).ready(function () {

        $('.select2').select2({ width: '100%' });

        $(".chosen-select").chosen();

        $(".chosen-select-6").chosen({
            max_selected_options: 6
        , });

        $(".chosen-select-5").chosen({
            max_selected_options: 5
        , });

        $(".chosen-select-10").chosen({
            max_selected_options: 10
        , });
    });

</script>

{{-- script for success messege hide --}}
<script>
    $(document).ready(function() {
        $('.alert-success').fadeIn().delay(7000).fadeOut();
    });

</script>

<script>
    $(function() {
        $(".add_datepicker").datepicker({
            changeMonth: true
            , changeYear: true
            , dateFormat: 'dd-mm-yy'
        , }).datepicker('setDate', 'today');

        $(".add_birth_datepicker").datepicker({
            changeMonth: true
            , changeYear: true
            , dateFormat: 'dd-mm-yy'
            , yearRange: '1970:' + (new Date).getFullYear()
        , }).datepicker('setDate', 'today');

        $("edit_birth_datepicker").datepicker({
            changeMonth: true
            , changeYear: true
            , dateFormat: 'dd-mm-yy'
            , yearRange: '1970:' + (new Date).getFullYear()
        , });

        $(".add_birth_datepicker").datepicker({
            changeMonth: true
            , changeYear: true
            , dateFormat: 'dd-mm-yy'
            , yearRange: '1970:' + (new Date).getFullYear()
        , }).datepicker('setDate', 'today');

        var date = new Date();
        var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        // var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);

        $("#from_date").datepicker({
            changeMonth: true
            , changeYear: true
            , dateFormat: 'dd-mm-yy'
        , });
        $("#from_date").datepicker("setDate", firstDay);

        $("#to_date").datepicker({
            changeMonth: true
            , changeYear: true
            , dateFormat: 'dd-mm-yy'
        , });
        $("#to_date").datepicker("setDate", 'today');

        $(".datepicker").datepicker({
            changeMonth: true
            , changeYear: true
            , dateFormat: 'dd-mm-yy'
        , });
    });

</script>

<script type="text/javascript">
    $('[data-fancybox="gallery"]').fancybox({
        buttons: [
            'download'
            , 'zoom'
            , 'slideShow'
            , 'thumbs'
            , 'close'
        ]
    });

</script>
<script src="{{ asset('admin-elite/assets/node_modules/datatables/jquery.dataTables.min.js') }}"></script>
<script>
    function removeColumnData(tableName, columnName, index) {

        axios.post("{{ route('remove.column') }}", {
                tableName: tableName
                , columnName: columnName
                , index: index
            , })
            .then(function(response) {
                location.reload();
            })
            .catch(function(error) {})

    }


</script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


{{-- <script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/plugins/pace.min.js') }}"></script>
<script src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('js/script.js') }}"></script> --}}

{{-- <script src="https://cdn.ckeditor.com/4.16.2/full-all/ckeditor.js"></script> --}}

{{-- jquery ui --}}
{{-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}



{{-- <script type="text/javascript">
    $(document).ready(function() {

        $('#dataTable').DataTable();
        $('.dtb').DataTable();
        $('.select2').select2();

        $(".datepicker").datepicker({
            changeMonth: true
            , changeYear: true
            , dateFormat: 'dd-mm-yy'
        , });

        CKEDITOR.replace('.ckeditor');
        CKEDITOR.config.height = 245;

    });

</script> --}}


<script>
    $(document).ready(function () {

        $('#dataTable').DataTable({
            "lengthMenu": [[25, 50, 100, 200], [25, 50, 100, 200]],
            "pageLength": 25
        });

        $('#dtb').DataTable({
            "lengthMenu": [[25, 50, 100, 200], [25, 50, 100, 200]],
            "pageLength": 25
        });

        $('.dtb').DataTable({
            "lengthMenu": [[25, 50, 100, 200], [25, 50, 100, 200]],
            "pageLength": 25
        });

    });
</script>
