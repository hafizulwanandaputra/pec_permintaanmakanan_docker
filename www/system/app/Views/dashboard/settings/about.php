<?= $this->extend('dashboard/templates/dashboard'); ?>
<?= $this->section('title'); ?>
<div class="d-flex justify-content-start align-items-center">
    <a class="fs-5 me-3 link-body-emphasis" href="<?= base_url('/settings'); ?>"><i class="fa-solid fa-arrow-left"></i></a>
    <span class="fw-medium fs-5 flex-fill text-truncate">Tentang Sistem</span>
</div>
<div style="min-width: 1px; max-width: 1px;"></div>
<?= $this->endSection(); ?>
<?= $this->section('content'); ?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3">
    <h5>Informasi Klien</h5>
    <ul class="list-group shadow-sm rounded-3 mb-3">
        <li class="list-group-item p-1 list-group-item-action disabled" aria-disabled="true">
            <div class="d-flex align-items-start">
                <a href="#" class="stretched-link" style="min-width: 48px; max-width: 48px; text-align: center;">
                    <p class="mb-0" style="font-size: 1.75rem!important;"><i class="fa-solid fa-computer"></i></p>
                </a>
                <div class="align-self-center flex-fill ps-1 text-wrap overflow-hidden" style="text-overflow: ellipsis;">
                    <h5 class="card-title">Sistem Operasi</h5>
                    <span><?= $agent->getPlatform(); ?></span>
                </div>
            </div>
        </li>
        <li class="list-group-item p-1 list-group-item-action disabled" aria-disabled="true">
            <div class="d-flex align-items-start">
                <a href="#" class="stretched-link" style="min-width: 48px; max-width: 48px; text-align: center;">
                    <p class="mb-0" style="font-size: 1.75rem!important;"><i class="fa-solid fa-globe"></i></p>
                </a>
                <div class="align-self-center flex-fill ps-1 text-wrap overflow-hidden" style="text-overflow: ellipsis;">
                    <h5 class="card-title">Web Browser</h5>
                    <span><?= $agent->getBrowser() . ' ' . $agent->getVersion(); ?></span>
                </div>
            </div>
        </li>
        <?php if ($agent->isMobile()) : ?>
            <li class="list-group-item p-1 list-group-item-action disabled" aria-disabled="true">
                <div class="d-flex align-items-start">
                    <a href="#" class="stretched-link" style="min-width: 48px; max-width: 48px; text-align: center;">
                        <p class="mb-0" style="font-size: 1.75rem!important;"><i class="fa-solid fa-mobile-screen"></i></p>
                    </a>
                    <div class="align-self-center flex-fill ps-1 text-wrap overflow-hidden" style="text-overflow: ellipsis;">
                        <h5 class="card-title">Telepon Seluler</h5>
                        <span><?= $agent->getMobile(); ?></span>
                    </div>
                </div>
            </li>
        <?php endif; ?>
        <li class="list-group-item p-1 list-group-item-action disabled" aria-disabled="true">
            <div class="d-flex align-items-start">
                <a href="#" class="stretched-link" style="min-width: 48px; max-width: 48px; text-align: center;">
                    <p class="mb-0" style="font-size: 1.75rem!important;"><i class="fa-solid fa-user-large"></i></p>
                </a>
                <div class="align-self-center flex-fill ps-1 text-wrap overflow-hidden" style="text-overflow: ellipsis;">
                    <h5 class="card-title">User Agent</h5>
                    <span><?= $agent->getAgentString(); ?></span>
                </div>
            </div>
        </li>
    </ul>
    <h5>Informasi Sistem</h5>
    <ul class="list-group shadow-sm rounded-3 mb-3">
        <li class="list-group-item p-1 list-group-item-action disabled" aria-disabled="true">
            <div class="d-flex align-items-start">
                <a href="#" class="stretched-link" style="min-width: 48px; max-width: 48px; text-align: center;">
                    <p class="mb-0" style="font-size: 1.75rem!important;"><i class="fa-brands fa-bootstrap"></i></p>
                </a>
                <div class="align-self-center flex-fill ps-1 text-wrap overflow-hidden" style="text-overflow: ellipsis;">
                    <h5 class="card-title">Versi Bootstrap</h5>
                    <span>5.3.2</span>
                </div>
            </div>
        </li>
        <li class="list-group-item p-1 list-group-item-action disabled" aria-disabled="true">
            <div class="d-flex align-items-start">
                <a href="#" class="stretched-link" style="min-width: 48px; max-width: 48px; text-align: center;">
                    <p class="mb-0" style="font-size: 1.75rem!important;"><i class="fa-brands fa-php"></i></p>
                </a>
                <div class="align-self-center flex-fill ps-1 text-wrap overflow-hidden" style="text-overflow: ellipsis;">
                    <h5 class="card-title">Versi PHP</h5>
                    <span><?= phpversion(); ?></span>
                </div>
            </div>
        </li>
    </ul>
</main>
</div>
</div>
<?= $this->endSection(); ?>