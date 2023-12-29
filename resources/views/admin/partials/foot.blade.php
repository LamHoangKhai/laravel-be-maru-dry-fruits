<<<<<<< HEAD
<!-- plugin JS -->
<script src="{{  secure_ secure_asset('administrator/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{  secure_ secure_asset('administrator/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{  secure_ secure_asset('administrator/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

=======
>>>>>>> ec4d2ffd80f0c8d9a8ad4bbc5eee735cc9c2b443
<!-- build:js administrator/assets/vendor/js/core.js -->
<script src="{{  secure_ secure_asset('administrator/assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{  secure_ secure_asset('administrator/assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{  secure_ secure_asset('administrator/assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{  secure_ secure_asset('administrator/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{  secure_ secure_asset('administrator/assets/vendor/js/menu.js') }}"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{  secure_ secure_asset('administrator/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

{{-- Notification new order --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{  secure_asset('administrator/js/notification.js') }}"></script>

<!-- Main JS -->
<<<<<<< HEAD
<script src="{{  secure_ secure_asset('administrator/assets/js/main.js') }}"></script>
=======
<script src="{{  secure_asset('administrator/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

<script src="{{  secure_asset('administrator/assets/js/main.js') }}"></script>
>>>>>>> ec4d2ffd80f0c8d9a8ad4bbc5eee735cc9c2b443

<script>
    const loading = () => {
        const loadingEl = $("#loading");

        // Show page loading

        // Hide after 3 seconds
        setTimeout(function() {
            loadingEl.remove();
        }, 1000);
    };
    loading();

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
</script>



@stack('js')

@stack('handlejs')
