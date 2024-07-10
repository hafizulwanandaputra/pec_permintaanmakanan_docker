<?= $this->extend('auth/templates/login'); ?>
<?= $this->section('content'); ?>
<main class="form-signin w-100 m-auto">
    <div class="modal d-block" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-body rounded-4 shadow-lg transparent-blur">
                <div class="modal-body">
                    <?= form_open('check-login'); ?>
                    <img class="rounded-pill mb-2" src="<?= base_url('/assets/images/logo_pec.png'); ?>" width="96px" style="border: var(--bs-modal-border-width) solid var(--bs-modal-border-color);">
                    <h1 class="h3 mb-2 fw-normal">
                        Sistem Informasi Permintaan Makanan Pasien Rawat Inap
                    </h1>
                    <h6>Rumah Sakit Khusus Mata Padang Eye Center</h6>
                    <div class="form-floating">
                        <input type="text" class="form-control username rounded-top-3 <?= (validation_show_error('username')) ? 'is-invalid' : ''; ?>" id="floatingInput" name="username" placeholder="Username" value="" autocomplete="off" list="username">
                        <datalist id="username">
                            <?php foreach ($users as $user) : ?>
                                <option value="<?= $user['username'] ?>">
                                <?php endforeach; ?>
                        </datalist>
                        <label for="floatingInput">
                            <div class="d-flex align-items-start">
                                <div style="width: 12px; text-align: center;">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <div class="w-100 ms-3">
                                    Nama Pengguna
                                </div>
                            </div>
                        </label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control rounded-bottom-3 <?= (validation_show_error('password')) ? 'is-invalid' : ''; ?>" id="floatingPassword" name="password" placeholder="Password" autocomplete="off">
                        <label for="floatingPassword">
                            <div class="d-flex align-items-start">
                                <div style="width: 12px; text-align: center;">
                                    <i class="fa-solid fa-key"></i>
                                </div>
                                <div class="w-100 ms-3">
                                    Kata Sandi
                                </div>
                            </div>
                        </label>
                        <div class="invalid-feedback mb-2">
                            <?= validation_show_error('username'); ?><br><?= validation_show_error('password'); ?>
                        </div>
                    </div>
                    <input type="hidden" name="url" value="<?= (isset($_GET['redirect'])) ? base_url('/' . urldecode($_GET['redirect'])) : base_url('/home'); ?>">
                    <button class="w-100 btn btn-lg btn-primary rounded-3 bg-gradient" type="submit">
                        <i class="fa-solid fa-right-to-bracket"></i> MASUK
                    </button>
                    <?= form_close(); ?>
                </div>
                <!-- FOOTER -->
                <div class="modal-footer d-block" style="font-size: 9pt; border-top: 1px solid var(--bs-border-color-translucent);">
                    <span class="text-center">&copy; 2024 <?= (date('Y') !== "2024") ? "- " . date('Y') : ''; ?> Rumah Sakit Khusus Mata Padang Eye Center<br><a class="text-decoration-none" href="https://padangeyecenter.com/" target="_blank">padangeyecenter.com</a></span>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3">
    <?php if (session()->getFlashdata('msg')) : ?>
        <div class="toast fade show align-items-center text-bg-success border border-success rounded-3 transparent-blur" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body d-flex align-items-start">
                <div style="width: 24px; text-align: center;">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="w-100 mx-2 text-start">
                    <?= session()->getFlashdata('msg'); ?>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>
    <?php if (isset($_GET['redirect'])) : ?>
        <div class="toast fade show align-items-center text-bg-danger border border-danger rounded-3 transparent-blur" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body d-flex align-items-start">
                <div style="width: 24px; text-align: center;">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
                <div class="w-100 mx-2 text-start">
                    Please login first before accessing "<?= urldecode($_GET['redirect']); ?>"
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="toast fade show align-items-center text-bg-danger border border-danger rounded-3 transparent-blur" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body d-flex align-items-start">
                <div style="width: 24px; text-align: center;">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
                <div class="w-100 mx-2 text-start">
                    <?= session()->getFlashdata('error'); ?>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection(); ?>