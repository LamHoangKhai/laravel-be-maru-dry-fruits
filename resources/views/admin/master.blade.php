<!DOCTYPE html>



<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="{{  secure_asset('administrator/assets/') }}" data-template="vertical-menu-template-free">

<head>
    @include('admin.partials.head')
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('admin.partials.sidebar')
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page ">
                <!-- Navbar -->

                @include('admin.partials.nav-bar')

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    @if (Session::has('success'))
                        @push('handlejs')
                            <script>
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top',
                                    iconColor: 'white',
                                    width: 400,
                                    customClass: {
                                        popup: 'colored-toast',
                                    },
                                    showConfirmButton: false,
                                    timer: 1500,
                                    timerProgressBar: true,
                                })
                                Toast.fire({
                                    icon: 'success',
                                    title: '{{ Session::get('success') }}',
                                })
                            </script>
                        @endpush
                    @endif

                    @if (Session::has('error'))
                        @push('handlejs')
                            <script>
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top',
                                    iconColor: 'white',
                                    width: 400,
                                    customClass: {
                                        popup: 'colored-toast',
                                    },
                                    showConfirmButton: false,
                                    timer: 1500,
                                    timerProgressBar: true,
                                })
                                Toast.fire({
                                    icon: 'error',
                                    title: '{{ Session::get('error') }}',
                                })
                            </script>
                        @endpush
                    @endif

                    @yield('content')
                    <!-- / Content -->


                    <!-- Footer -->
                    @include('admin.partials.footer')
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    @include('admin.partials.foot')
</body>

</html>
