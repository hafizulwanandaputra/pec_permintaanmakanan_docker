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
    <?= form_open_multipart('/menu/create'); ?>
    <?= csrf_field(); ?>
    <fieldset class="border rounded-3 px-2 py-0 mb-3">
        <legend class="float-none w-auto mb-0 px-1 fs-6 fw-bold">Menu Makanan (wajib diisi)</legend>
        <div class="form-floating mb-2">
            <input type="date" class="form-control rounded-3 <?= (validation_show_error('tanggal')) ? 'is-invalid' : ''; ?>" id="tanggal" name="tanggal" value="<?= old('tanggal'); ?>" autocomplete="off" dir="auto" placeholder="tanggal">
            <label for="tanggal">Tanggal</label>
            <div class="invalid-feedback">
                <?= validation_show_error('tanggal'); ?>
            </div>
        </div>
        <div class="form-floating mb-2">
            <input type="text" class="form-control rounded-3 <?= (validation_show_error('nama_menu')) ? 'is-invalid' : ''; ?>" id="nama_menu" name="nama_menu" value="<?= old('nama_menu'); ?>" autocomplete="off" dir="auto" placeholder="nama_menu">
            <label for="nama_menu">Nama Menu</label>
            <div class="invalid-feedback">
                <?= validation_show_error('nama_menu'); ?>
            </div>
        </div>
        <div class="form-floating mb-2">
            <select class="form-select rounded-3 <?= (validation_show_error('jadwal_makan')) ? 'is-invalid' : ''; ?>" id="jadwal_makan" name="jadwal_makan" aria-label="jadwal_makan">
                <option value="">-- Pilih Jadwal Makan --</option>
                <option value="Pagi" <?= (old('jadwal_makan') == "Pagi") ? 'selected' : ''; ?>>Pagi</option>
                <option value="Siang" <?= (old('jadwal_makan') == "Siang") ? 'selected' : ''; ?>>Siang</option>
                <option value="Sore" <?= (old('jadwal_makan') == "Sore") ? 'selected' : ''; ?>>Sore</option>
                <option value="Malam" <?= (old('jadwal_makan') == "Malam") ? 'selected' : ''; ?>>Malam</option>
            </select>
            <label for="jadwal_makan">Jadwal Makan</label>
            <div class="invalid-feedback">
                <?= validation_show_error('jadwal_makan'); ?>
            </div>
        </div>
        <div class="form-floating mb-2">
            <select class="form-select rounded-3 <?= (validation_show_error('petugas')) ? 'is-invalid' : ''; ?>" id="petugas" name="petugas" aria-label="petugas">
                <option value="">-- Pilih Petugas --</option>
                <?php foreach ($petugas as $selectpetugas) : ?>
                    <option value="<?= $selectpetugas['id_petugas']; ?>" <?= (old('petugas') == $selectpetugas['id_petugas']) ? 'selected' : ''; ?>><?= $selectpetugas['nama_petugas']; ?></option>
                <?php endforeach; ?>
            </select>
            <label for="petugas">Petugas Gizi*</label>
            <div class="invalid-feedback">
                <?= validation_show_error('petugas'); ?>
            </div>
        </div>
        </legend>
    </fieldset>
    <fieldset class="border rounded-3 px-2 py-0 mb-3">
        <legend class="float-none w-auto mb-0 px-1 fs-6 fw-bold">Gizi (opsional)</legend>
        <div class="form-floating mb-2">
            <input type="text" class="form-control rounded-3 <?= (validation_show_error('protein_hewani')) ? 'is-invalid' : ''; ?>" id="protein_hewani" name="protein_hewani" value="<?= old('protein_hewani'); ?>" autocomplete="off" dir="auto" placeholder="protein_hewani">
            <label for="protein_hewani">Protein Hewani</label>
            <div class="invalid-feedback">
                <?= validation_show_error('protein_hewani'); ?>
            </div>
        </div>
        <div class="form-floating mb-2">
            <input type="text" class="form-control rounded-3 <?= (validation_show_error('protein_nabati')) ? 'is-invalid' : ''; ?>" id="protein_nabati" name="protein_nabati" value="<?= old('protein_nabati'); ?>" autocomplete="off" dir="auto" placeholder="protein_nabati">
            <label for="protein_nabati">Protein Nabati</label>
            <div class="invalid-feedback">
                <?= validation_show_error('protein_nabati'); ?>
            </div>
        </div>
        <div class="form-floating mb-2">
            <input type="text" class="form-control rounded-3 <?= (validation_show_error('sayur')) ? 'is-invalid' : ''; ?>" id="sayur" name="sayur" value="<?= old('sayur'); ?>" autocomplete="off" dir="auto" placeholder="sayur">
            <label for="sayur">Sayur</label>
            <div class="invalid-feedback">
                <?= validation_show_error('sayur'); ?>
            </div>
        </div>
        <div class="form-floating mb-2">
            <input type="text" class="form-control rounded-3 <?= (validation_show_error('buah')) ? 'is-invalid' : ''; ?>" id="buah" name="buah" value="<?= old('buah'); ?>" autocomplete="off" dir="auto" placeholder="buah">
            <label for="buah">Buah</label>
            <div class="invalid-feedback">
                <?= validation_show_error('buah'); ?>
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