<meta charset="utf-8" />
<title>Cinema</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
<meta content="Coderthemes" name="author" />
<meta name="csrf-token" content="{{ csrf_token() }}" />


{{-- link icon
    https://iconscout.com/
--}}
<!-- App favicon -->
<link rel="shortcut icon" href="{{ asset('assets-backend/images/peony-logo.jpg') }}">

<!-- Datatable css -->
<link href="{{ asset('assets-backend/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
    type="text/css" />
<link href="{{ asset('assets-backend/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}"
    rel="stylesheet" type="text/css" />
<link href="{{ asset('assets-backend/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css') }}"
    rel="stylesheet" type="text/css" />
<link href="{{ asset('assets-backend/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css') }}"
    rel="stylesheet" type="text/css" />
<link href="{{ asset('assets-backend/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}"
    rel="stylesheet" type="text/css" />
<link href="{{ asset('assets-backend/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css') }}"
    rel="stylesheet" type="text/css" />

<!-- Theme Config Js -->
<script src="{{ asset('assets-backend/js/hyper-config.js') }}"></script>

<!-- App css -->
<link href="{{ asset('assets-backend/css/app-saas.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

<!-- Icons css -->
<link href="{{ asset('assets-backend/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Toastr CSS -->
<link rel="stylesheet" href="{{ asset('assets-backend/css/libraries/toastr.css') }}">

{{-- font awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

{{-- css custom --}}
<link rel="stylesheet" href="{{ asset('assets/css/backend.css') }}">

<link href="{{asset('assets-backend')}}/css/select2.min.css" rel="stylesheet" type="text/css" />

<!-- Daterangepicker css -->
<link rel="stylesheet" href="{{asset('assets-backend')}}/vendor/daterangepicker/daterangepicker.css" type="text/css" />

