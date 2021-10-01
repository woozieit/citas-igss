
<!-- Javascripts -->
<script src="{{ asset('assets/plugins/jquery/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/popper.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
{{-- <script src="{{ asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('assets/plugins/apexcharts/dist/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/plugins/blockui/jquery.blockUI.js') }}"></script>
<script src="{{ asset('assets/plugins/flot/jquery.flot.min.js') }}"></script>
<script src="{{ asset('assets/plugins/flot/jquery.flot.time.min.js') }}"></script>
<script src="{{ asset('assets/plugins/flot/jquery.flot.symbol.min.js') }}"></script>
<script src="{{ asset('assets/plugins/flot/jquery.flot.resize.min.js') }}"></script>
<script src="{{ asset('assets/plugins/flot/jquery.flot.tooltip.min.js') }}"></script> --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="{{ asset('assets/js/connect.min.js') }}"></script>
{{-- <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script> --}}


<script>
    'use strict';

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $("meta[name=csrf-token]").attr("content")
        }
    })

    function sweetalert2( table, url, type = 0 ) {
        Swal.fire({
            width: "25rem",
            title: "¿Estás seguro?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "¡Sí, bórralo!",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    method: "DELETE",
                    success: function( response ) {
                        if ( response.success ) {

                            Swal.fire({
                                width: "22rem",
                                title: "¡Eliminado!",
                                text: response.success,
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1500
                            });

                            if ( type == 0 ) {
                                $("#" + table).DataTable().ajax.reload();
                            } else {
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1500);
                            }

                        } else if (response.info) {
                            toastr.info(response.info);
                        } else {
                            toastr.error(response.authorize);
                        }

                    }
                });
            }
        })
    }

    @if(session('success'))
        notify('success', "{{ session('success') }}")
    @endif

    @if(session('info'))
        notify("info", "{{ session('info') }}")
    @endif

    @if(session('error'))
        notify("error", "{{ session('error') }}")
    @endif

    // success, error, info
    function notify(sign, message) {
        const sessionId = "{{ uniqid() }}";

        if (sessionStorage) {

            if ( !sessionStorage.getItem('shown-' + sessionId) ) {
                if (sign ===  "success") {
                    success(message)
                }
                if (sign === "error") {
                    error(message)
                }
                if (sign === "info") {
                    info(message)
                }
            }

            sessionStorage.setItem('shown-' + sessionId, '1');
        }
    }

    toastr.options.closeButton = true;

    function success(message) {
        toastr.success(message);
    }

    function error(message) {
        toastr.error(message);
    }

    function info(message) {
        toastr.info(message);
    }

    // Toast
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    function alert_sweet_success(message) {
        Toast.fire({
            icon: 'success',
            type: 'success',
            title: message
        });
    }

    function alert_sweet_error(message) {
        Toast.fire({
            icon: 'error',
            type: 'error',
            title: message
        });
    }


</script>

@yield('js')
