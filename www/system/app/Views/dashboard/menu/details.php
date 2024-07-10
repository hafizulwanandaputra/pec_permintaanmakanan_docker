<?= $this->extend('dashboard/templates/dashboard'); ?>
<?= $this->section('title'); ?>
<div class="d-flex justify-content-start align-items-center">
    <a class="fs-5 me-3 link-body-emphasis" href="<?= base_url('/menu'); ?>"><i class="fa-solid fa-arrow-left"></i></a>
    <span class="fw-medium fs-5 flex-fill text-truncate"><?= $title; ?></span>
</div>
<div style="min-width: 1px; max-width: 1px;"></div>
<?= $this->endSection(); ?>
<?= $this->section('content'); ?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3">
    <fieldset class="border rounded-3 px-2 py-0 mb-3">
        <legend class="float-none w-auto mb-0 px-1 fs-6 fw-bold">Informasi Menu</legend>
        <div style="font-size: 9pt;">
            <div class="mb-2 row">
                <div class="col-lg-3 fw-medium">Tanggal</div>
                <div class="col-lg">
                    <div class="date"><?= $menu['tanggal']; ?></div>
                </div>
            </div>
            <div class="mb-2 row">
                <div class="col-lg-3 fw-medium">Nama Menu</div>
                <div class="col-lg">
                    <div>
                        <div class="mb-1 date fw-bold"><?= $menu['nama_menu']; ?></div>
                        <div class="mb-1 row">
                            <div class="col-5 fw-medium">Protein Hewani</div>
                            <div class="col">
                                <div><?= $menu['protein_hewani']; ?></div>
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <div class="col-5 fw-medium">Protein Nabati</div>
                            <div class="col">
                                <div><?= $menu['protein_nabati']; ?></div>
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <div class="col-5 fw-medium">Sayur</div>
                            <div class="col">
                                <div><?= $menu['sayur']; ?></div>
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <div class="col-5 fw-medium">Buah</div>
                            <div class="col">
                                <div><?= $menu['buah']; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-2 row">
                <div class="col-lg-3 fw-medium">Jadwal Makan</div>
                <div class="col-lg">
                    <div class="date"><?= $menu['jadwal_makan']; ?></div>
                </div>
            </div>
            <div class="mb-2 row">
                <div class="col-lg-3 fw-medium">Petugas Gizi</div>
                <div class="col-lg">
                    <div class="date"><?= $petugas['nama_petugas']; ?></div>
                </div>
            </div>
        </div>
    </fieldset>
    <hr>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
        <a class="btn btn-secondary rounded-3 bg-gradient" href="<?= base_url('/menu/edit/' . $menu['id_menu']); ?>" role="button"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
        <button class="btn btn-danger rounded-3 bg-gradient" type="button" data-bs-toggle="modal" data-bs-target="#modal-delete"><i class="fa-solid fa-trash"></i> Hapus</button>
    </div>
    <div class="modal modal-sheet p-4 py-md-5 fade" id="modal-delete" tabindex="-1" aria-labelledby="modal-delete" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-body rounded-4 shadow-lg transparent-blur">
                <div class="modal-body p-4 text-center">
                    <h5>Hapus menu "<?= $menu['nama_menu'] ?>"?</h5>
                    <h6 class="mb-0">Mengapus menu juga akan menghapus permintaan yang menggunakan menu ini</h6>
                </div>
                <form class="modal-footer flex-nowrap p-0" style="border-top: 1px solid var(--bs-border-color-translucent);" id="delete" action="<?= base_url('/menu/delete/' . $menu['id_menu']); ?>" method="post">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0 border-end" style="border-right: 1px solid var(--bs-border-color-translucent)!important;" data-bs-dismiss="modal">Tidak</button>
                    <button class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0">Ya</button>
                </form>
            </div>
        </div>
    </div>
    <hr>
    <fieldset class="border rounded-3 px-2 py-0 mb-3">
        <legend class="float-none w-auto mb-0 px-1 fs-6 fw-bold">Permintaan</legend>
        <div class="mb-1">
            <table id="tabel" class="table table-sm table-hover" style="width:100%; font-size: 9pt;">
                <thead>
                    <tr class="align-middle">
                        <th scope="col" class="bg-body-secondary border-secondary" style="border-bottom-width: 2px;">No</th>
                        <th scope="col" class="bg-body-secondary border-secondary text-nowrap" style="border-bottom-width: 2px;">Tindakan</th>
                        <th scope="col" class="bg-body-secondary border-secondary" style="border-bottom-width: 2px;">Nama Pasien</th>
                        <th scope="col" class="bg-body-secondary border-secondary" style="border-bottom-width: 2px;">Tanggal Lahir</th>
                        <th scope="col" class="bg-body-secondary border-secondary" style="border-bottom-width: 2px;">Jenis Kelamin</th>
                        <th scope="col" class="bg-body-secondary border-secondary" style="border-bottom-width: 2px;">Kamar</th>
                        <th scope="col" class="bg-body-secondary border-secondary" style="border-bottom-width: 2px;">Jenis Tindakan</th>
                        <th scope="col" class="bg-body-secondary border-secondary" style="border-bottom-width: 2px;">Diet</th>
                        <th scope="col" class="bg-body-secondary border-secondary" style="border-bottom-width: 2px;">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="align-top">
                </tbody>
            </table>
        </div>
    </fieldset>
</main>
</div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('datatable'); ?>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
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
        $('#tabel').DataTable({
            "oLanguage": {
                "sDecimal": ",",
                "sEmptyTable": 'Tidak ada permintaan pasien. Klik "Tambah Permintaan" untuk menambahkan permintaan.',
                "sInfo": "Menampilkan _START_ hingga _END_ dari _TOTAL_ permintaan",
                "sInfoEmpty": "Menampilkan 0 hingga 0 dari 0 permintaan",
                "sInfoFiltered": "(di-filter dari _MAX_ permintaan)",
                "sInfoPostFix": "",
                "sThousands": ".",
                "sLengthMenu": "Tampilkan _MENU_ permintaan",
                "sLoadingRecords": "Memuat...",
                "sProcessing": "",
                "sSearch": "Cari:",
                "sZeroRecords": "Permintaan pasien yang Anda cari tidak ditemukan",
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
                $(".pagination").wrap("<div class='overflow-auto'></div>");
                $(".pagination").addClass("pagination-sm");
                $('.pagination-sm').css({
                    '--bs-pagination-border-radius': 'var(--bs-border-radius-lg)'
                });
                $(".page-item .page-link").addClass("bg-gradient");
                $(".form-control").addClass("rounded-3");
                $(".form-select").addClass("rounded-3");
                feather.replace({
                    'aria-hidden': 'true'
                });
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
                action: function(e, dt, node, config) {
                    window.location.href = '<?= base_url('menu/addpermintaan/' . $menu['id_menu']); ?>';
                },
                text: '<i class="fa-solid fa-plus"></i> Tambah Permintaan',
                className: 'btn-primary btn-sm bg-gradient',
                init: function(api, node, config) {
                    $(node).removeClass('btn-secondary')
                },
            }, {
                action: function(e, dt, node, config) {
                    window.location.href = '<?= base_url('permintaan/exportexcel?keyword=' . $menu['id_menu']); ?>';
                },
                text: '<i class="fa-solid fa-file-excel"></i> Ekspor Excel',
                className: 'btn-success btn-sm bg-gradient rounded-end-3',
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
            "processing": true,
            "language": {
                "processing": '<div class="m-4"><div class="spinner-border mt-1" style="width: 5rem; height: 5rem;" role="status"><span class="visually-hidden">Loading...</span></div></div>',
            },
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url('/menu/listpermintaanmenu/' . $menu['id_menu']) ?>",
                "type": "POST"
            },
            "columnDefs": [{
                "target": [0, 1],
                "orderable": false
            }, {
                "target": [0, 1, 3, 4, 5],
                "width": "0%"
            }, {
                "target": [3, 6, 7, 8],
                "width": "12.5%"
            }]
        });
    });
</script>
<?= $this->endSection(); ?>