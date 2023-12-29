<meta charset="utf-8" />
<meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="description" content="" />
<title>AdminPage</title>

<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="{{ secure_asset('administrator/assets/img/favicon/favicon.ico') }}" />

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />

<!-- Icons. Uncomment required icon fonts -->
<link rel="stylesheet" href="{{ secure_asset('administrator/assets/vendor/fonts/boxicons.css') }}" />

<!-- Core CSS -->
<link rel="stylesheet" href="{{ secure_asset('administrator/assets/vendor/css/core.css') }}"
    class="template-customizer-core-css" />
<link rel="stylesheet" href="{{ secure_asset('administrator/assets/vendor/css/theme-default.css') }}"
    class="template-customizer-theme-css" />
<link rel="stylesheet" href="{{ secure_asset('administrator/assets/css/demo.css') }}" />

<!-- Vendors CSS -->
<link rel="stylesheet"
    href="{{ secure_asset('administrator/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

<link rel="stylesheet" href="{{ secure_asset('administrator/assets/vendor/libs/apex-charts/apex-charts.css') }}" />


<!-- Helpers -->
<script src="{{ secure_asset('administrator/assets/vendor/js/helpers.js') }}"></script>

<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="{{ secure_asset('administrator/assets/js/config.js') }}"></script>

<!-- plugins CSS -->
<<<<<<< HEAD <link rel="stylesheet"
    href="{{ secure_asset('administrator/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet"
        href="{{ secure_asset('administrator/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

    =======
    <link rel="stylesheet" href="{{ secure_asset('administrator/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet"
        href="{{ secure_asset('administrator/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    >>>>>>> ec4d2ffd80f0c8d9a8ad4bbc5eee735cc9c2b443
    @stack('css')



    <!--! My style -->
    <link rel="stylesheet" href="{{ secure_asset('administrator/css/index.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('administrator/css/alertsweet.css') }}">
