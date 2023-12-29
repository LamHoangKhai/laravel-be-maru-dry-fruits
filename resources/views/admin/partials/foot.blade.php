<!-- plugin JS -->
<script src="{{  secure_asset('administrator/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{  secure_asset('administrator/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{  secure_asset('administrator/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- build:js administrator/assets/vendor/js/core.js -->
<script src="{{  secure_asset('administrator/assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{  secure_asset('administrator/assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{  secure_asset('administrator/assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{  secure_asset('administrator/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{  secure_asset('administrator/assets/vendor/js/menu.js') }}"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{  secure_asset('administrator/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>


<!-- Main JS -->
<script src="{{  secure_asset('administrator/assets/js/main.js') }}"></script>




@stack('js')

@stack('handlejs')
