<!-- This page CSS -->
<!-- chartist CSS -->
<link href="{{ asset('admin-elite/assets/node_modules/morrisjs/morris.css') }}" rel="stylesheet">
<link href="{{ asset('admin-elite/assets/node_modules/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
{{--
<link href="{{ asset('admin-elite/assets/node_modules/bootstrap/dist/css/bootstrap-theme.min.css') }}" rel="stylesheet">
--}}

<link href="{{ asset('admin-elite/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')  }}" rel="stylesheet">

<link href="{{ asset('admin-elite/dist/css/chosen.css') }}" rel="stylesheet">
<!--Toaster Popup message CSS -->
<link href="{{ asset('admin-elite/assets/node_modules/toast-master/css/jquery.toast.css') }}" rel="stylesheet">

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<!--alerts CSS -->
<link href="{{ asset('admin-elite/assets/node_modules/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">

<!--switchery switch CSS -->
<link href="{{ asset('admin-elite/assets/node_modules/switchery/dist/switchery.min.css') }}" rel="stylesheet" />


<!-- summernotes CSS -->
<link href="{{ asset('admin-elite/assets/node_modules/summernote/dist/summernote.css') }}" rel="stylesheet" />

<!-- tagsinput CSS -->
<link href="{{ asset('admin-elite/assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}"
    rel="stylesheet">

<!-- Tree Menu CSS -->
<link href="{{ asset('tree-menu/TreeMenu.css') }}" rel="stylesheet">
<link href="{{ asset('admin-elite/dist/css/jquery.fancybox.min.css') }}" rel="stylesheet">


<!-- Custom CSS -->
<link href="{{ asset('admin-elite/dist/css/style.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin-elite/dist/css/style.css') }}" rel="stylesheet">

{{-- select 2 --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


<style type="text/css">
    .modal {
        position: absolute;
        top: 10px;
        right: 100px;
        bottom: 0;
        left: 0;
        z-index: 10040;
        overflow: auto;
        overflow-y: auto;
    }

    .car-pad {
        padding-bottom: 20px;
    }

    table thead th,
    table tfoot th {
        background: #00c292;
        font-weight: 700 !important;
        padding: 5px;
        font-size: 12px;
    }

    /* chosen select error start */
    select:invalid {
        height: 0px !important;
        opacity: 0 !important;
        position: absolute !important;
        display: flex !important;
    }

    select:invalid[multiple] {
        margin-top: 15px !important;
    }

    /* chosen select error end */

    /* navbar media query */
    @media (max-width: 425px) {
        .topbar .top-navbar .navbar-header {
            width: 98px;
        }
    }
</style>
