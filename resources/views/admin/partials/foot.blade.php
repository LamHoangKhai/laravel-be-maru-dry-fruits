<!-- build:js administrator/assets/vendor/js/core.js -->
<script src="{{ asset('administrator/assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('administrator/assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('administrator/assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('administrator/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('administrator/assets/vendor/js/menu.js') }}"></script>
<script src="{{ asset('administrator/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ asset('administrator/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

{{-- Notification new order --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ asset('administrator/js/notification.js') }}"></script>

<!-- Main JS -->

<script src="{{ asset('administrator/assets/js/main.js') }}"></script>

<script src="{{ asset('administrator/plugins/sweetalert2/sweetalert2.min.js') }}"></script>


<script>
    $(document).ready(() => {
        $("#renderData").on("contextmenu", ".delete", (e) => {
            e.preventDefault();
            return;
        });
    })
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
