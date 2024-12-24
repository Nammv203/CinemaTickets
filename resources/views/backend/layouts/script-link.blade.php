<!-- Vendor js -->
<script src="{{ asset('assets-backend/js/vendor.min.js') }}"></script>

<!-- Code Highlight js -->
<script src="{{ asset('assets-backend/vendor/highlightjs/highlight.pack.min.js') }}"></script>
<script src="{{ asset('assets-backend/vendor/clipboard/clipboard.min.js') }}"></script>
<script src="{{ asset('assets-backend/js/hyper-syntax.js') }}"></script>

<!-- Datatable js -->
<script src="{{ asset('assets-backend/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets-backend/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets-backend/vendor/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets-backend/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}">
</script>
<script src="{{ asset('assets-backend/vendor/jquery-datatables-checkboxes/js/dataTables.checkboxes.min.js') }}"></script>
<script src="{{ asset('assets-backend/vendor/datatables.net-fixedcolumns-bs5/js/fixedColumns.bootstrap5.min.js') }}">
</script>
<script src="{{ asset('assets-backend/vendor/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
<script src="{{ asset('assets-backend/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets-backend/vendor/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets-backend/vendor/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets-backend/vendor/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('assets-backend/vendor/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets-backend/vendor/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
<script src="{{ asset('assets-backend/vendor/datatables.net-select/js/dataTables.select.min.js') }}"></script>

<!-- Product Demo App js -->
<script src="{{ asset('assets-backend/js/pages/demo.products.js') }}"></script>
<script src="{{ asset('assets-backend/js/pages/demo.datatable-init.js') }}"></script>

<!-- App js -->
<script src="{{ asset('assets-backend/js/app.min.js') }}"></script>

<!-- Toastr -->
<script src="{{ asset('assets-backend/js/libraries/toastr.js') }}"></script>

<!--  Select2 Js -->
<script src="{{asset('assets-backend')}}/js/select2.min.js"></script>

<!-- Daterangepicker js -->
<script src="{{asset('assets-backend')}}/vendor/daterangepicker/moment.min.js"></script>
<script src="{{asset('assets-backend')}}/vendor/daterangepicker/daterangepicker.js"></script>

{{-- copy from ui-modals.html --}}
<script>
    const exampleModal = document.getElementById('exampleModal')
    exampleModal.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget
        // Extract info from data-bs-* attributes
        const recipient = button.getAttribute('data-bs-whatever')
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        const modalTitle = exampleModal.querySelector('.modal-title')
        const modalBodyInput = exampleModal.querySelector('.modal-body input')

        modalTitle.textContent = `New message to ${recipient}`
        modalBodyInput.value = recipient
    })
</script>
