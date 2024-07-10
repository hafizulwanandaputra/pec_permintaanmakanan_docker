<?= $this->extend('dashboard/templates/dashboard'); ?>
<?= $this->section('title'); ?>
<div class="d-flex justify-content-start align-items-center">
    <span class="fw-medium fs-5 flex-fill text-truncate"><?= $title; ?></span>
</div>
<div style="min-width: 1px; max-width: 1px;"></div>
<?= $this->endSection(); ?>
<?= $this->section('content'); ?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3">
    <div class="alert alert-danger bg-gradient" role="alert">
        <div class="d-flex align-items-start">
            <div style="width: 12px; text-align: center;">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
            <div class="w-100 ms-3">
                Halaman ini hanya bisa diakses oleh master admin!
            </div>
        </div>
    </div>
</main>
</div>
</div>
<?= $this->endSection(); ?>