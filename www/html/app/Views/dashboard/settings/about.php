<?php
$platform = $agent->getPlatform();
$iconClass = '';
$browser = $agent->getBrowser();
$browserIcon = '';

if (stripos($platform, 'Windows') !== false) {
    $iconClass = '<i class="fa-brands fa-windows"></i>';
} elseif (stripos($platform, 'Mac') !== false) {
    $iconClass = '<i class="fa-brands fa-apple"></i>';
} elseif (stripos($platform, 'Linux') !== false) {
    $iconClass = '<i class="fa-brands fa-linux"></i>';
} elseif (stripos($platform, 'Android') !== false) {
    $iconClass = '<i class="fa-brands fa-android"></i>';
} elseif (stripos($platform, 'iOS') !== false || stripos($platform, 'iPhone') !== false || stripos($platform, 'iPad') !== false) {
    $iconClass = '<i class="fa-brands fa-apple"></i>';
} else {
    $iconClass = '<i class="fa-solid fa-computer"></i>';
}

if (stripos($browser, 'Chrome') !== false) {
    $browserIcon = '<i class="fa-brands fa-chrome"></i>';
} elseif (stripos($browser, 'Firefox') !== false) {
    $browserIcon = '<i class="fa-brands fa-firefox-browser"></i>';
} elseif (stripos($browser, 'Safari') !== false) {
    $browserIcon = '<i class="fa-brands fa-safari"></i>';
} elseif (stripos($browser, 'Edge') !== false) {
    $browserIcon = '<i class="fa-brands fa-edge"></i>';
} elseif (stripos($browser, 'Opera') !== false || stripos($browser, 'OPR') !== false) {
    $browserIcon = '<i class="fa-brands fa-opera"></i>';
} elseif (stripos($browser, 'Internet Explorer') !== false || stripos($browser, 'IE') !== false) {
    $browserIcon = '<i class="fa-brands fa-internet-explorer"></i>';
} else {
    $browserIcon = '<i class="fa-solid fa-globe"></i>';
}
?>
<?= $this->extend('dashboard/templates/dashboard'); ?>
<?= $this->section('title'); ?>
<div class="d-flex justify-content-start align-items-center">
    <a class="fs-5 me-3 link-body-emphasis" href="<?= base_url('/settings'); ?>"><i class="fa-solid fa-arrow-left"></i></a>
    <span class="fw-medium fs-5 flex-fill text-truncate"><?= $headertitle; ?></span>
    <div id="loadingSpinner" class="spinner-border spinner-border-sm" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
<div style="min-width: 1px; max-width: 1px;"></div>
<?= $this->endSection(); ?>
<?= $this->section('content'); ?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-3 px-md-4 pt-3">
    <h5>Informasi Klien</h5>
    <ul class="list-group shadow-sm rounded-3 mb-3">
        <li class="list-group-item p-1 list-group-item-action disabled" aria-disabled="true">
            <div class="d-flex align-items-start">
                <a href="#" class="stretched-link" style="min-width: 48px; max-width: 48px; text-align: center;">
                    <p class="mb-0" style="font-size: 1.75rem!important;"><?= $iconClass; ?></p>
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
                    <p class="mb-0" style="font-size: 1.75rem!important;"><?= $browserIcon; ?></p>
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
    <h5>Informasi Backend</h5>
    <ul class="list-group shadow-sm rounded-3 mb-3">
        <li class="list-group-item p-1 list-group-item-action disabled" aria-disabled="true">
            <div class="d-flex align-items-start">
                <a href="#" class="stretched-link" style="min-width: 48px; max-width: 48px; text-align: center;">
                    <p class="mb-0" style="font-size: 1.75rem!important;"><i class="fa-solid fa-server"></i></p>
                </a>
                <div class="align-self-center flex-fill ps-1 text-wrap overflow-hidden" style="text-overflow: ellipsis;">
                    <h5 class="card-title">Peladen Web</h5>
                    <span><?= $_SERVER['SERVER_SOFTWARE']; ?></span>
                </div>
            </div>
        </li>
        <li class="list-group-item p-1 list-group-item-action disabled" aria-disabled="true">
            <div class="d-flex align-items-start">
                <a href="#" class="stretched-link" style="min-width: 48px; max-width: 48px; text-align: center;">
                    <p class="mb-0" style="font-size: 1.75rem!important;"><i class="fa-brands fa-php"></i></p>
                </a>
                <div class="align-self-center flex-fill ps-1 text-wrap overflow-hidden" style="text-overflow: ellipsis;">
                    <h5 class="card-title">Versi PHP dan CodeIgniter</h5>
                    <span><?= phpversion(); ?> • <?= CodeIgniter\CodeIgniter::CI_VERSION ?></span>
                </div>
            </div>
        </li>
    </ul>
    <h5>Informasi Frontend</h5>
    <ul class="list-group shadow-sm rounded-3 mb-3">
        <li class="list-group-item p-1 list-group-item-action disabled" aria-disabled="true">
            <div class="d-flex align-items-start">
                <a href="#" class="stretched-link" style="min-width: 48px; max-width: 48px; text-align: center;">
                    <p class="mb-0" style="font-size: 1.75rem!important;"><i class="fa-brands fa-bootstrap"></i></p>
                </a>
                <div class="align-self-center flex-fill ps-1 text-wrap overflow-hidden" style="text-overflow: ellipsis;">
                    <h5 class="card-title">Versi Bootstrap</h5>
                    <span>5.3.3</span>
                </div>
            </div>
        </li>
        <li class="list-group-item p-1 list-group-item-action disabled" aria-disabled="true">
            <div class="d-flex align-items-start">
                <a href="#" class="stretched-link" style="min-width: 48px; max-width: 48px; text-align: center;">
                    <p class="mb-0" style="font-size: 1.75rem!important;"><i class="fa-brands fa-js"></i></p>
                </a>
                <div class="align-self-center flex-fill ps-1 text-wrap overflow-hidden" style="text-overflow: ellipsis;">
                    <h5 class="card-title">Versi jQuery</h5>
                    <span>3.7.1</span>
                </div>
            </div>
        </li>
    </ul>
    <hr>
    <div>
        <p><strong>Sistem Informasi Permintaan Makanan Pasien Rawat Inap</strong><br>&copy; 2024 <?= (date('Y') !== "2024") ? "- " . date('Y') : ''; ?> Rumah Sakit Khusus Mata Padang Eye Center<br><a class="text-decoration-none" href="https://padangeyecenter.com/" target="_blank">padangeyecenter.com</a></p>
        <p>Template aplikasi ini didasarkan pada <a class="text-decoration-none" href="https://github.com/hafizulwanandaputra/hwpweb-admin-template" target="_blank">Repositori GitHub</a> ini.</p>
    </div>
</main>
<?= $this->endSection(); ?>
<?= $this->section('javascript'); ?>
<script>
    $(document).ready(function() {
        $('#loadingSpinner').hide();
    });
</script>
<?= $this->endSection(); ?>