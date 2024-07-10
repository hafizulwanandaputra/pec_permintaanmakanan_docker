<?= $this->extend('dashboard/templates/dashboard'); ?>
<?= $this->section('title'); ?>
<div class="d-flex justify-content-start align-items-center">
    <a class="fs-5 me-3 link-body-emphasis" href="<?= base_url('/admin'); ?>"><i class="fa-solid fa-arrow-left"></i></a>
    <span class="fw-medium fs-5 flex-fill text-truncate"><?= $title; ?></span>
</div>
<div style="min-width: 1px; max-width: 1px;"></div>
<?= $this->endSection(); ?>
<?= $this->section('content'); ?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3">
    <?= form_open_multipart('/admin/create'); ?>
    <?= csrf_field(); ?>
    <fieldset class="border rounded-3 px-2 py-0 mb-3">
        <legend class="float-none w-auto mb-0 px-1 fs-6 fw-bold">Informasi Pengguna</legend>
        <div class="form-floating mb-2">
            <input type="text" class="form-control rounded-3 <?= (validation_show_error('fullname')) ? 'is-invalid' : ''; ?>" id="fullname" name="fullname" value="<?= old('fullname'); ?>" autocomplete="off" dir="auto" placeholder="fullname">
            <label for="fullname">Nama Lengkap*</label>
            <div class="invalid-feedback">
                <?= validation_show_error('fullname'); ?>
            </div>
        </div>
        <div class="form-floating mb-2">
            <input type="text" class="form-control rounded-3 <?= (validation_show_error('username')) ? 'is-invalid' : ''; ?>" id="username" name="username" value="<?= old('username'); ?>" autocomplete="off" dir="auto" placeholder="username">
            <label for="username">Nama Pengguna*</label>
            <div class="invalid-feedback">
                <?= validation_show_error('username'); ?>
            </div>
        </div>
        <div class="form-floating mb-2">
            <select class="form-select rounded-3 <?= (validation_show_error('role')) ? 'is-invalid' : ''; ?>" id="role" name="role" aria-label="role">
                <option value="" <?= (old('role')) ? '' : 'selected'; ?>>-- Pilih Jenis Pengguna --</option>
                <option value="Master Admin" <?= (old('role')) ? 'selected' : ''; ?>>Master Admin</option>
                <option value="Admin" <?= (old('role')) ? 'selected' : ''; ?>>Admin</option>
            </select>
            <label for="role">Jenis Pengguna*</label>
            <div class="invalid-feedback">
                <?= validation_show_error('role'); ?>
            </div>
        </div>
        </legend>
    </fieldset>
    <hr>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
        <button class="btn btn-primary rounded-3 bg-gradient" type="submit" id="submit"><i class="fa-solid fa-plus"></i> Tambah</button>
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