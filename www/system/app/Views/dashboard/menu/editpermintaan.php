<?= $this->extend('dashboard/templates/dashboard'); ?>
<?= $this->section('title'); ?>
<div class="d-flex justify-content-start align-items-center">
    <a class="fs-5 me-3 link-body-emphasis" href="<?= base_url('/menu/details/' . $permintaan['id_menu']); ?>"><i class="fa-solid fa-arrow-left"></i></a>
    <div>
        <div class="fw-medium fs-6 flex-fill text-truncate"><?= $title; ?></div>
        <div style="font-size: 8pt;">Menu: <?= $permintaan['nama_menu'] ?></div>
    </div>
</div>
<div style="min-width: 1px; max-width: 1px;"></div>
<?= $this->endSection(); ?>
<?= $this->section('content'); ?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3">
    <?= form_open_multipart('/menu/updatepermintaan/' . $permintaan['id']); ?>
    <?= csrf_field(); ?>
    <fieldset class="border rounded-3 px-2 py-0 mb-3">
        <legend class="float-none w-auto mb-0 px-1 fs-6 fw-bold">Menu dan Petugas</legend>
        <div class="form-floating mb-2">
            <select class="form-select rounded-3" id="menu" name="menu" aria-label="menu" disabled>
                <option value="<?= $permintaan['id_menu']; ?>" selected><?= $permintaan['tanggal'] . ' - ' . $permintaan['nama_menu'] . ' - ' . $permintaan['nama_petugas']; ?></option>
            </select>
            <label for="menu">Menu*</label>
        </div>
    </fieldset>
    <fieldset class="border rounded-3 px-2 py-0 mb-3">
        <legend class="float-none w-auto mb-0 px-1 fs-6 fw-bold">Identitas Pasien</legend>
        <div class="form-floating mb-2">
            <input type="text" class="form-control rounded-3 <?= (validation_show_error('nama_pasien')) ? 'is-invalid' : ''; ?>" id="nama_pasien" name="nama_pasien" value="<?= (old('nama_pasien')) ? old('nama_pasien') : $permintaan['nama_pasien']; ?>" autocomplete="off" dir="auto" placeholder="nama_pasien">
            <label for="nama_pasien">Nama Pasien*</label>
            <div class="invalid-feedback">
                <?= validation_show_error('nama_pasien'); ?>
            </div>
        </div>
        <div class="form-floating mb-2">
            <input type="date" class="form-control rounded-3 <?= (validation_show_error('tanggal_lahir')) ? 'is-invalid' : ''; ?>" id="tanggal_lahir" name="tanggal_lahir" value="<?= (old('tanggal_lahir')) ? old('tanggal_lahir') : $permintaan['tanggal_lahir']; ?>" autocomplete="off" dir="auto" placeholder="tanggal_lahir">
            <label for="tanggal_lahir">Tanggal Lahir*</label>
            <div class="invalid-feedback">
                <?= validation_show_error('tanggal_lahir'); ?>
            </div>
        </div>
        <div class="mb-2 row">
            <label for="jenis_kelamin" class="col-xl-3 col-form-label">Jenis Kelamin*</label>
            <div class="col-lg col-form-label">
                <div class="d-flex align-items-center justify-content-evenly justify-content-xl-start">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input <?= (validation_show_error('jenis_kelamin')) ? 'is-invalid' : ''; ?>" type="radio" name="jenis_kelamin" id="jenis_kelamin1" value="Laki-Laki" <?= (old('jenis_kelamin')) ? ((old('jenis_kelamin') == 'Laki-Laki') ? 'checked' : '') : (($permintaan['jenis_kelamin'] == 'Laki-Laki') ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="jenis_kelamin1">
                            Laki-Laki
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input <?= (validation_show_error('jenis_kelamin')) ? 'is-invalid' : ''; ?>" type="radio" name="jenis_kelamin" id="jenis_kelamin2" value="Perempuan" <?= (old('jenis_kelamin')) ? ((old('jenis_kelamin') == 'Perempuan') ? 'checked' : '') : (($permintaan['jenis_kelamin'] == 'Perempuan') ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="jenis_kelamin2">
                            Perempuan
                        </label>
                    </div>
                </div>
                <?php if (validation_show_error('jenis_kelamin')) : ?>
                    <div class="invalid-feedback d-block">
                        <?= validation_show_error('jenis_kelamin'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="form-floating mb-2">
            <input type="text" class="form-control rounded-3 <?= (validation_show_error('kamar')) ? 'is-invalid' : ''; ?>" id="kamar" name="kamar" value="<?= (old('kamar')) ? old('kamar') : $permintaan['kamar']; ?>" autocomplete="off" dir="auto" placeholder="kamar">
            <label for="kamar">Kamar*</label>
            <div class="invalid-feedback">
                <?= validation_show_error('kamar'); ?>
            </div>
        </div>
        <div class="form-floating mb-2">
            <textarea style="resize: none; height: 96px; white-space: pre-wrap;" class="form-control rounded-3 <?= (validation_show_error('jenis_tindakan')) ? 'is-invalid' : ''; ?>" id="jenis_tindakan" name="jenis_tindakan" dir="auto" placeholder="jenis_tindakan"><?= (old('jenis_tindakan')) ? old('jenis_tindakan') : $permintaan['jenis_tindakan']; ?></textarea>
            <label for="jenis_tindakan">Jenis Tindakan*</label>
            <div class="invalid-feedback">
                <?= validation_show_error('jenis_tindakan'); ?>
            </div>
        </div>
        <div class="form-floating mb-2">
            <textarea style="resize: none; height: 96px; white-space: pre-wrap;" class="form-control rounded-3 <?= (validation_show_error('diet')) ? 'is-invalid' : ''; ?>" id="diet" name="diet" dir="auto" placeholder="diet"><?= (old('diet')) ? old('diet') : $permintaan['diet']; ?></textarea>
            <label for="diet">Diet*</label>
            <div class="invalid-feedback">
                <?= validation_show_error('diet'); ?>
            </div>
        </div>
        <div class="form-floating mb-2">
            <textarea style="resize: none; height: 96px; white-space: pre-wrap;" class="form-control rounded-3 <?= (validation_show_error('keterangan')) ? 'is-invalid' : ''; ?>" id="keterangan" name="keterangan" dir="auto" placeholder="keterangan"><?= (old('keterangan')) ? old('keterangan') : $permintaan['keterangan']; ?></textarea>
            <label for="keterangan">Keterangan (Alergi/Pantangan Makanan)</label>
            <div class="invalid-feedback">
                <?= validation_show_error('keterangan'); ?>
            </div>
        </div>
        </legend>
    </fieldset>
    <hr>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
        <button class="btn btn-primary rounded-3 bg-gradient" type="submit" id="submit"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
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