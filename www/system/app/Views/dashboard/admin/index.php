<?= $this->extend('dashboard/templates/dashboard'); ?>
<?= $this->section('title'); ?>
<div class="d-flex justify-content-start align-items-center">
    <span class="fw-medium fs-5 flex-fill text-truncate"><?= $headertitle; ?></span>
    <div id="loadingSpinner" class="spinner-border spinner-border-sm" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
<div style="min-width: 1px; max-width: 1px;"></div>
<?= $this->endSection(); ?>
<?= $this->section('content'); ?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3">
    <div class="mb-2">
        <table id="tabel" class="table table-sm table-hover" style="width:100%; font-size: 9pt;">
            <thead>
                <tr class="align-middle">
                    <th scope="col" class="bg-body-secondary border-secondary" style="border-bottom-width: 2px;">No.</th>
                    <th scope="col" class="bg-body-secondary border-secondary text-nowrap" style="border-bottom-width: 2px;">Tindakan</th>
                    <th scope="col" class="bg-body-secondary border-secondary" style="border-bottom-width: 2px;">Nama Lengkap</th>
                    <th scope="col" class="bg-body-secondary border-secondary" style="border-bottom-width: 2px;">Nama Pengguna</th>
                    <th scope="col" class="bg-body-secondary border-secondary" style="border-bottom-width: 2px;">Jenis Pengguna</th>
                </tr>
            </thead>
            <tbody class="align-top">
            </tbody>
        </table>
    </div>
    <div class="modal modal-sheet p-4 py-md-5 fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-body rounded-4 shadow-lg transparent-blur">
                <div class="modal-body p-4 text-center">
                    <h5 class="mb-0" id="deleteMessage"></h5>
                </div>
                <div class="modal-footer flex-nowrap p-0" style="border-top: 1px solid var(--bs-border-color-translucent);">
                    <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0 border-end" style="border-right: 1px solid var(--bs-border-color-translucent)!important;" data-bs-dismiss="modal">Tidak</button>
                    <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0" id="confirmDeleteBtn">Ya</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-sheet p-4 py-md-5 fade" id="resetPasswordModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-body rounded-4 shadow-lg transparent-blur">
                <div class="modal-body p-4 text-center">
                    <h5 id="resetPasswordMessage"></h5>
                    <h6 class="mb-0" id="resetPasswordSubmessage"></h6>
                </div>
                <div class="modal-footer flex-nowrap p-0" style="border-top: 1px solid var(--bs-border-color-translucent);">
                    <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0 border-end" style="border-right: 1px solid var(--bs-border-color-translucent)!important;" data-bs-dismiss="modal">Tidak</button>
                    <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0" id="confirmResetPasswordBtn">Ya</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="userModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable rounded-3">
            <form id="userForm" enctype="multipart/form-data" class="modal-content bg-body shadow-lg transparent-blur">
                <div class="modal-header justify-content-between pt-2 pb-2" style="border-bottom: 1px solid var(--bs-border-color-translucent);">
                    <h6 class="pe-2 modal-title fs-6 text-truncate" id="userModalLabel" style="font-weight: bold;">Tambah Admin</h6>
                    <button type="button" class="btn btn-danger btn-sm bg-gradient ps-0 pe-0 pt-0 pb-0 rounded-3" data-bs-dismiss="modal" aria-label="Close"><span data-feather="x" class="mb-0" style="width: 30px; height: 30px;"></span></button>
                </div>
                <div class="modal-body py-2">
                    <input type="hidden" id="userId" name="id_user">
                    <input type="hidden" id="original_username" name="original_username">
                    <div class="form-floating mb-1 mt-1">
                        <input type="text" class="form-control" autocomplete="off" dir="auto" placeholder="fullname" id="fullname" name="fullname">
                        <label for="fullname">Nama Lengkap*</label>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-floating mb-1 mt-1">
                        <input type="text" class="form-control" autocomplete="off" dir="auto" placeholder="username" id="username" name="username">
                        <label for="username">Nama Pengguna*</label>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-floating mb-1 mt-1">
                        <select class="form-select" id="role" name="role" aria-label="role">
                            <option value="">-- Pilih Jenis Pengguna --</option>
                            <option value="Master Admin">Master Admin</option>
                            <option value="Admin">Admin</option>
                        </select>
                        <label for="role">Jenis Pengguna</label>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end pt-2 pb-2" style="border-top: 1px solid var(--bs-border-color-translucent);">
                    <button type="submit" id="submitButton" class="btn btn-primary bg-gradient rounded-3">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
</div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('toast'); ?>

<?= $this->endSection(); ?>
<?= $this->section('datatable'); ?>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
<script>
    /* For Export Buttons available inside jquery-datatable "server side processing" - Start
- due to "server side processing" jquery datatble doesn't support all data to be exported
- below function makes the datatable to export all records when "server side processing" is on */

    function newexportaction(e, dt, button, config) {
        var self = this;
        var oldStart = dt.settings()[0]._iDisplayStart;
        dt.one('preXhr', function(e, s, data) {
            // Just this once, load all data from the server...
            data.start = 0;
            data.length = 2147483647;
            dt.one('preDraw', function(e, settings) {
                // Call the original action function
                if (button[0].className.indexOf('buttons-copy') >= 0) {
                    $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
                } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                    $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                        $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                        $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                    $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                        $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                        $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
                } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                    $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                        $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                        $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                } else if (button[0].className.indexOf('buttons-print') >= 0) {
                    $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                }
                dt.one('preXhr', function(e, s, data) {
                    // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                    // Set the property to what it was before exporting.
                    settings._iDisplayStart = oldStart;
                    data.start = oldStart;
                });
                // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                setTimeout(dt.ajax.reload, 0);
                // Prevent rendering of the full data to the DOM
                return false;
            });
        });
        // Requery the server with the new one-time export settings
        dt.ajax.reload();
    };
    //For Export Buttons available inside jquery-datatable "server side processing" - End
    // Inisialisasi Datatables
    $(document).ready(function() {
        var table = $('#tabel').DataTable({
            "oLanguage": {
                "sDecimal": ",",
                "sEmptyTable": 'Tidak ada admin. Klik "Tambah Admin" untuk menambahkan admin.',
                "sInfo": "Menampilkan _START_ hingga _END_ dari _TOTAL_ admin",
                "sInfoEmpty": "Menampilkan 0 hingga 0 dari 0 admin",
                "sInfoFiltered": "(di-filter dari _MAX_ admin)",
                "sInfoPostFix": "",
                "sThousands": ".",
                "sLengthMenu": "Tampilkan _MENU_ admin",
                "sLoadingRecords": "Memuat...",
                "sProcessing": "",
                "sSearch": "Cari:",
                "sZeroRecords": "Admin yang Anda cari tidak ditemukan",
                "oAria": {
                    "sOrderable": "Urutkan menurut kolom ini",
                    "sOrderableReverse": "Urutkan terbalik kolom ini"
                },
                "oPaginate": {
                    "sFirst": '<i class="fa-solid fa-angles-left"></i>',
                    "sLast": '<i class="fa-solid fa-angles-right"></i>',
                    "sPrevious": '<i class="fa-solid fa-angle-left"></i>',
                    "sNext": '<i class="fa-solid fa-angle-right"></i>'
                }
            },
            'dom': "<'d-lg-flex justify-content-lg-between align-items-lg-center mb-0'<'text-md-center text-lg-start'i><'d-md-flex justify-content-md-center d-lg-block'f>>" +
                "<'d-lg-flex justify-content-lg-between align-items-lg-center'<'text-md-center text-lg-start mt-2'l><'mt-2 mb-2 mb-lg-0'B>>" +
                "<'row'<'col-md-12'tr>>" +
                "<'d-lg-flex justify-content-lg-between align-items-lg-center'<'text-md-center text-lg-start'><'d-md-flex justify-content-md-center d-lg-block'p>>",
            'initComplete': function(settings, json) {
                $("#tabel").wrap("<div class='overflow-auto position-relative'></div>");
                $('.dataTables_filter input[type="search"]').css({
                    'width': '220px'
                });
                $('.dataTables_info').css({
                    'padding-top': '0',
                    'font-variant-numeric': 'tabular-nums'
                });
            },
            "drawCallback": function() {
                var api = this.api();
                api.column(0, {
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                    $(cell).css({
                        'font-variant-numeric': 'tabular-nums'
                    });
                });
                $(".pagination").wrap("<div class='overflow-auto'></div>");
                $(".pagination").addClass("pagination-sm");
                $('.pagination-sm').css({
                    '--bs-pagination-border-radius': 'var(--bs-border-radius-lg)'
                });
                $(".page-item .page-link").addClass("bg-gradient");
                $(".form-control").addClass("rounded-3");
                $(".form-select").addClass("rounded-3");
            },
            'buttons': [{
                action: function(e, dt, node, config) {
                    dt.ajax.reload(null, false);
                },
                text: '<i class="fa-solid fa-arrows-rotate"></i> Refresh',
                className: 'btn-primary btn-sm bg-gradient rounded-start-3',
                init: function(api, node, config) {
                    $(node).removeClass('btn-secondary')
                },
            }, {
                text: '<i class="fa-solid fa-plus"></i> Tambah Admin',
                className: 'btn-primary btn-sm bg-gradient rounded-end-3',
                attr: {
                    id: 'addUserBtn'
                },
                init: function(api, node, config) {
                    $(node).removeClass('btn-secondary')
                },
            }],
            "search": {
                "caseInsensitive": true
            },
            'pageLength': 25,
            'lengthMenu': [
                [25, 50, 100, 250, 500],
                [25, 50, 100, 250, 500]
            ],
            "autoWidth": true,
            "processing": false,
            "serverSide": true,
            "ajax": {
                "url": "<?= base_url('/admin/adminlist') ?>",
                "type": "POST",
                "data": function(d) {
                    // Additional parameters
                    d.search = {
                        "value": $('.dataTables_filter input[type="search"]').val()
                    };
                },
                beforeSend: function() {
                    // Show the custom processing spinner
                    $('#loadingSpinner').show();
                },
                complete: function() {
                    // Hide the custom processing spinner after the request is complete
                    $('#loadingSpinner').hide();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Hide the custom processing spinner on error
                    $('#loadingSpinner').hide();
                    // Show the Bootstrap error toast when the AJAX request fails
                    showFailedToast('Gagal memuat data. Silakan coba lagi.');
                }
            },
            columns: [{
                    data: null
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<div class="btn-group" role="group">
                                    <button class="btn btn-warning text-nowrap bg-gradient rounded-start-3 resetpwd-btn" style="--bs-btn-padding-y: 0.15rem; --bs-btn-padding-x: 0.5rem; --bs-btn-font-size: 9pt;" data-id="${row.id_user}" data-username="${row.username}"data-bs-toggle="tooltip" data-bs-title="Atur ulang kata sandi"><i class="fa-solid fa-key"></i></button>
                                    <button class="btn btn-secondary text-nowrap bg-gradient edit-btn" style="--bs-btn-padding-y: 0.15rem; --bs-btn-padding-x: 0.5rem; --bs-btn-font-size: 9pt;" data-id="${row.id_user}" data-bs-toggle="tooltip" data-bs-title="Edit"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <button class="btn btn-danger text-nowrap bg-gradient rounded-end-3 delete-btn" style="--bs-btn-padding-y: 0.15rem; --bs-btn-padding-x: 0.5rem; --bs-btn-font-size: 9pt;" data-id="${row.id_user}" data-username="${row.username}" data-bs-toggle="tooltip" data-bs-title="Hapus"><i class="fa-solid fa-trash"></i></button>
                                </div>`;
                    }
                },
                {
                    data: 'fullname'
                },
                {
                    data: 'username'
                },
                {
                    data: 'role'
                },
            ],
            "order": [
                [2, 'asc']
            ],
            "columnDefs": [{
                "target": [0, 1],
                "orderable": false
            }, {
                "target": [0, 1],
                "width": "0%"
            }, {
                "target": [2, 3],
                "width": "50%"
            }],
        });
        // Initialize Bootstrap tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();
        // Re-initialize tooltips on table redraw (server-side events like pagination, etc.)
        table.on('draw', function() {
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
        // Show add user modal
        $('#addUserBtn').click(function() {
            $('#userModalLabel').text('Tambah Admin');
            $('#userForm')[0].reset();
            $('#userId').val('');
            $('#original_username').val('');
            $('#userModal').modal('show');
        });
        // Show edit user modal
        $(document).on('click', '.edit-btn', function() {
            var $this = $(this);
            var id = $(this).data('id');
            $this.prop('disabled', true).html(`<span class="spinner-border" style="width: 11px; height: 11px;" aria-hidden="true"></span>`);
            $.ajax({
                url: '<?= base_url('/admin/admin') ?>/' + id,
                success: function(response) {
                    $('#userModalLabel').text('Edit Admin');
                    $('#userId').val(response.id_user);
                    $('#fullname').val(response.fullname);
                    $('#username').val(response.username);
                    $('#role').val(response.role);
                    // Set the original_username hidden field
                    $('#original_username').val(response.username);
                    $('#userModal').modal('show');
                },
                error: function(xhr, status, error) {
                    showToast('Terjadi kesalahan. Silakan coba lagi.');
                },
                complete: function() {
                    $this.prop('disabled', false).html(`<i class="fa-solid fa-pen-to-square"></i>`);
                }
            });
        });
        // Store the ID of the user to be deleted
        var userId;
        var userName;

        // Show delete confirmation modal
        $(document).on('click', '.delete-btn', function() {
            userId = $(this).data('id');
            userName = $(this).data('username');
            $('#deleteMessage').html(`Hapus @` + userName + `?`);
            $('#deleteModal').modal('show');
        });

        $(document).on('click', '.resetpwd-btn', function() {
            userId = $(this).data('id');
            userName = $(this).data('username');
            $('#resetPasswordMessage').html(`Atur ulang kata sandi @` + userName + `?`);
            $('#resetPasswordSubmessage').html(`Kata sandi pengguna ini akan diatur sama dengan nama pengguna`);
            $('#resetPasswordModal').modal('show');
        });

        // Confirm deletion
        $('#confirmDeleteBtn').click(function() {
            $('#deleteModal button').prop('disabled', true);
            $('#deleteMessage').html(`Mengapus, silakan tunggu...`);
            $.ajax({
                url: '<?= base_url('/admin/delete') ?>/' + userId,
                type: 'DELETE',
                success: function(response) {
                    showSuccessToast(response.message);
                    table.ajax.reload();
                },
                error: function(xhr, status, error) {
                    showFailedToast('Terjadi kesalahan. Silakan coba lagi.');
                },
                complete: function() {
                    $('#deleteModal').modal('hide');
                    $('#deleteModal button').prop('disabled', false);
                }
            });
        });
        // Confirm reset password
        $('#confirmResetPasswordBtn').click(function() {
            $('#resetPasswordModal button').prop('disabled', true);
            $('#resetPasswordMessage').addClass('mb-0').html(`Mengatur ulang kata sandi, silakan tunggu...`);
            $('#resetPasswordSubmessage').hide();
            $.ajax({
                url: '<?= base_url('/admin/resetpassword') ?>/' + userId,
                type: 'POST',
                success: function(response) {
                    showSuccessToast(response.message);
                    table.ajax.reload();
                },
                error: function(xhr, status, error) {
                    showFailedToast('Terjadi kesalahan. Silakan coba lagi.');
                },
                complete: function() {
                    $('#resetPasswordModal').modal('hide');
                    $('#resetPasswordMessage').removeClass('mb-0');
                    $('#resetPasswordSubmessage').show();
                    $('#resetPasswordModal button').prop('disabled', false);
                }
            });
        });
        // Submit user form (Add/Edit)
        $('#userForm').submit(function(e) {
            e.preventDefault();
            var url = $('#userId').val() ? '<?= base_url('/admin/update') ?>' : '<?= base_url('/admin/create') ?>';
            var formData = new FormData(this);
            console.log("Form URL:", url);
            console.log("Form Data:", $(this).serialize());
            // Clear previous validation states
            $('#userForm .is-invalid').removeClass('is-invalid');
            $('#userForm .invalid-feedback').text('').hide();
            $('#submitButton').prop('disabled', true).html(`
                <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                <span role="status">Memproses, silakan tunggu...</span>
            `);
            // Disable form inputs
            $('#userForm input, #userForm select, #closeBtn').prop('disabled', true);
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                contentType: false, // Required for FormData
                processData: false, // Required for FormData
                success: function(response) {
                    if (response.success) {
                        showSuccessToast(response.message, 'success');
                        $('#userModal').modal('hide');
                        table.ajax.reload();
                    } else {
                        console.log("Validation Errors:", response.errors);

                        // Clear previous validation states
                        $('#userForm .is-invalid').removeClass('is-invalid');
                        $('#userForm .invalid-feedback').text('').hide();

                        // Display new validation errors
                        for (var field in response.errors) {
                            if (response.errors.hasOwnProperty(field)) {
                                var fieldElement = $('#' + field);
                                var feedbackElement = fieldElement.siblings('.invalid-feedback'); // Adjust this if necessary

                                console.log("Target Field:", fieldElement);
                                console.log("Target Feedback:", feedbackElement);

                                if (fieldElement.length > 0 && feedbackElement.length > 0) {
                                    fieldElement.addClass('is-invalid');
                                    feedbackElement.text(response.errors[field]).show();

                                    // Remove error message when the user corrects the input
                                    fieldElement.on('input change', function() {
                                        $(this).removeClass('is-invalid');
                                        $(this).siblings('.invalid-feedback').text('').hide();
                                    });
                                } else {
                                    console.warn("Elemen tidak ditemukan pada field:", field);
                                }
                            }
                        }
                        showFailedToast('Perbaiki kesalahan pada formulir.');
                    }
                },
                error: function(xhr, status, error) {
                    showFailedToast('Terjadi kesalahan. Silakan coba lagi.');
                },
                complete: function() {
                    $('#submitButton').prop('disabled', false).html(`
                        <i class="fa-solid fa-floppy-disk"></i> Simpan
                    `);
                    $('#userForm input, #userForm select, #closeBtn').prop('disabled', false)
                }
            });
        });
        $('#userModal').on('hidden.bs.modal', function() {
            $('#userForm')[0].reset();
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').text('').hide();
        });
        // Show toast notification
        function showSuccessToast(message) {
            var toastHTML = `<div id="toast" class="toast fade show align-items-center text-bg-success border border-success rounded-3 transparent-blur" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body d-flex align-items-start">
                    <div style="width: 24px; text-align: center;">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div class="w-100 mx-2 text-start" id="toast-message">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>`;
            var toastElement = $(toastHTML);
            $('#toastContainer').append(toastElement); // Make sure there's a container with id `toastContainer`
            var toast = new bootstrap.Toast(toastElement);
            toast.show();
        }

        function showFailedToast(message) {
            var toastHTML = `<div id="toast" class="toast fade show align-items-center text-bg-danger border border-danger rounded-3 transparent-blur" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body d-flex align-items-start">
                    <div style="width: 24px; text-align: center;">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </div>
                    <div class="w-100 mx-2 text-start" id="toast-message">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>`;
            var toastElement = $(toastHTML);
            $('#toastContainer').append(toastElement); // Make sure there's a container with id `toastContainer`
            var toast = new bootstrap.Toast(toastElement);
            toast.show();
        }
    });
</script>
<?= $this->endSection(); ?>