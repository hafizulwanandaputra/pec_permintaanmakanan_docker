<?= $this->extend('dashboard/templates/dashboard'); ?>
<?= $this->section('title'); ?>
<div class="d-flex justify-content-start align-items-center">
    <a class="fs-5 me-3 link-body-emphasis" href="<?= base_url('/petugas'); ?>"><i class="fa-solid fa-arrow-left"></i></a>
    <span class="fw-medium fs-5 flex-fill text-truncate"><?= $title; ?></span>
</div>
<div style="min-width: 1px; max-width: 1px;"></div>
<?= $this->endSection(); ?>
<?= $this->section('content'); ?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3">
    <?= form_open_multipart('/petugas/update/' . $petugas['id_petugas']); ?>
    <?= csrf_field(); ?>
    <fieldset class="border rounded-3 px-2 py-0 mb-3">
        <legend class="float-none w-auto mb-0 px-1 fs-6 fw-bold">Petugas Gizi (wajib diisi)</legend>
        <div class="form-floating mb-2">
            <input type="text" class="form-control rounded-3 <?= (validation_show_error('nama_petugas')) ? 'is-invalid' : ''; ?>" id="nama_petugas" name="nama_petugas" value="<?= (old('nama_petugas')) ? old('nama_petugas') : $petugas['nama_petugas']; ?>" autocomplete="off" dir="auto" placeholder="nama_petugas">
            <label for="nama_petugas">Nama Petugas Gizi (dilarang sama dengan menu lain)</label>
            <div class="invalid-feedback">
                <?= validation_show_error('nama_petugas'); ?>
            </div>
        </div>
        </legend>
    </fieldset>
    <hr>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
        <button class="btn btn-primary rounded-3 bg-gradient" type="submit" id="submit"><i class="fa-solid fa-pen-to-square"></i> Ganti Nama</button>
    </div>
    <?= form_close(); ?>
</main>
</div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('javascript'); ?>
<script>
    var warnMessage = "Save your unsaved changes before leaving this page!";
    $("input").change(function() {
        window.onbeforeunload = function() {
            return 'You have unsaved changes on this page!';
        }
    });
    $("select").change(function() {
        window.onbeforeunload = function() {
            return 'You have unsaved changes on this page!';
        }
    });
    $("textarea").change(function() {
        window.onbeforeunload = function() {
            return 'You have unsaved changes on this page!';
        }
    });
    $(function() {
        $('button[type=submit]').click(function(e) {
            window.onbeforeunload = null;
        });
    });
</script>
<?= $this->endSection(); ?>