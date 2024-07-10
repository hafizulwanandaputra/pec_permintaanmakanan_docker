<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?> - Sistem Permintaan Makanan Pasien Rawat Inap RSKM PEC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="<?= base_url(); ?>assets/css/dashboard/dashboard.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets_public/css/main.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets_public/css/JawiDubai.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Color+Emoji&family=Noto+Sans+Arabic:wdth,wght@62.5..100,100..900&family=Noto+Sans+Mono:wdth,wght@62.5..100,100..900&family=Noto+Sans:ital,wdth,wght@0,62.5..100,100..900;1,62.5..100,100..900&display=swap" rel="stylesheet">
    <?php if ($agent->getPlatform() == 'Mac OS X' || $agent->getPlatform() == 'iOS' || $agent->getPlatform() == 'iPadOS') : ?>
        <link href="<?= base_url(); ?>assets_public/fonts/base-font/apple.css" rel="stylesheet">
    <?php else : ?>
        <link rel="stylesheet" href="<?= base_url(); ?>assets_public/fonts/Inter/inter.css">
        <link href="<?= base_url(); ?>assets_public/fonts/jetbrains-mono/jetbrains-mono.css" rel="stylesheet">
        <link href="<?= base_url(); ?>assets_public/fonts/base-font/non-apple.css" rel="stylesheet">
    <?php endif; ?>
    <link href="<?= base_url(); ?>assets_public/fontawesome/css/all.css" rel="stylesheet">
    <script src="<?= base_url(); ?>assets/tinymce/js/tinymce/tinymce.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <style>
        .toast-container {
            padding-top: 4rem !important;
            right: 0 !important;
        }

        .sidebar {
            top: 0;
            box-shadow: inset 0px 0 0 rgba(0, 0, 0, 0);
            border-right: 1px solid var(--bs-border-color-translucent);
        }

        .profilephotosidebar {
            background-image: url('<?= (session()->get('profilephoto') == NULL) ? base_url() . 'assets/images/profile/blank.jpg' : base_url() . 'assets/images/profile/' . session()->get('profilephoto'); ?>');
            background-color: var(--bs-gray-500);
            width: 64px;
            aspect-ratio: 1/1;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            position: relative;
            outline: 3px solid var(--bs-gray-500);
            box-shadow: 0 0 0 4px var(--bs-border-color);
        }

        div.dataTables_processing>div:last-child {
            display: none;
        }

        div.dataTables_wrapper div.dataTables_processing.card {
            position: fixed;
            margin: 0 !important;
            z-index: 999;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            background-color: rgba(var(--bs-body-bg-rgb), var(--bs-bg-opacity)) !important;
            --bs-bg-opacity: 0.6667;
            backdrop-filter: blur(20px);
            border: 1px solid var(--bs-border-color-translucent);
            box-shadow: var(--bs-box-shadow) !important;
            border-radius: var(--bs-border-radius-lg) !important;
        }

        .modal-body div.dataTables_wrapper div.dataTables_processing.card {
            background-color: rgba(var(--bs-body-bg-rgb), var(--bs-bg-opacity)) !important;
            --bs-bg-opacity: 1;
            backdrop-filter: none;
        }

        @media (prefers-reduced-transparency) {
            div.dataTables_wrapper div.dataTables_processing.card {
                --bs-bg-opacity: 1;
                backdrop-filter: none;
            }
        }

        @media (max-width: 767.98px) {
            .toast-container {
                padding-top: 6.5rem !important;
                transform: translateX(-50%) !important;
                left: 50% !important;
            }

            .sidebar {
                padding-top: 5.5rem;
                backdrop-filter: blur(20px);
                --bs-bg-opacity: 0.6667;
                border-right: 0px solid var(--bs-border-color-translucent);
            }

            @media (prefers-reduced-transparency) {
                .sidebar {
                    --bs-bg-opacity: 1;
                    backdrop-filter: none;
                }
            }
        }
    </style>
</head>

<body>
    <!-- HEADER -->
    <header class="navbar sticky-top flex-md-nowrap p-0 rounded-bottom-3 shadow-sm text-white" style="border-bottom: 1px solid var(--bs-border-color-translucent); background-color: #5eba00;" data-bs-theme="dark">
        <span class="navbar-brand col-md-3 col-lg-2 me-0 px-3 py-md-1 text-start text-md-center lh-1" style="font-size: 10pt;">
            <span class="h-100" style="font-weight: bold;">PADANG EYE CENTER</span>
        </span>
        <button class="navbar-toggler position-absolute text-white d-md-none bg-gradient rounded-3 border-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="d-flex flex-nowrap w-100 align-items-center">
            <div class="w-100 px-3 text-truncate">
                <?= $this->renderSection('title'); ?>
            </div>
            <div class="navbar-nav">
                <div class="nav-item text-nowrap">
                    <button type="button" class="btn btn-light btn-sm mx-3 my-2 rounded-3 bg-gradient d-inline-block" data-bs-toggle="modal" data-bs-target="#logoff1">
                        <i class="fa-solid fa-right-from-bracket"></i> Keluar
                    </button>
                </div>
            </div>
        </div>
    </header>

    <div class="modal modal-sheet p-4 py-md-5 fade" id="logoff1" tabindex="-1" aria-labelledby="logoff1" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-body rounded-4 shadow-lg transparent-blur">
                <div class="modal-body p-4 text-center">
                    <h5 class="mb-0">Apakah Anda ingin keluar?</h5>
                </div>
                <div class="modal-footer flex-nowrap p-0" style="border-top: 1px solid var(--bs-border-color-translucent);">
                    <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0" data-bs-dismiss="modal" style="border-right: 1px solid var(--bs-border-color-translucent);">Tidak</button>
                    <a class=" btn btn-lg btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0" href="<?= base_url('/logout'); ?>">Ya</a>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENTS -->
    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar shadow-sm collapse" style="background-color: #5eba00;" data-bs-theme="dark">
                <div class="position-sticky pt-3 sidebar-sticky">
                    <div class="mx-2">
                        <div class="d-flex justify-content-center mb-2">
                            <div class="rounded-pill profilephotosidebar"></div>
                        </div>
                        <div class="text-center lh-1 text-body-emphasis">
                            <span><?= session()->get('fullname'); ?></small><br><span class="fw-medium" style="font-size: 8pt;">@<?= session()->get('username'); ?></span><br><span class="fw-medium" style="font-size: 8pt;"><?= session()->get('role'); ?></span></span>
                        </div>
                    </div>
                    <hr class="my-1 mt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link p-2" href="<?= base_url('/home'); ?>">
                                <div class="d-flex align-items-start link-body-emphasis">
                                    <div style="min-width: 24px; max-width: 24px; text-align: center;">
                                        <i class="fa-solid fa-house"></i>
                                    </div>
                                    <div class="flex-fill ms-2">
                                        Beranda
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link p-2" href="<?= base_url('/menu'); ?>">
                                <div class="d-flex align-items-start link-body-emphasis">
                                    <div style="min-width: 24px; max-width: 24px; text-align: center;">
                                        <i class="fa-solid fa-utensils"></i>
                                    </div>
                                    <div class="flex-fill ms-2">
                                        Menu Makanan
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link p-2" href="<?= base_url('/permintaan'); ?>">
                                <div class="d-flex align-items-start link-body-emphasis">
                                    <div style="min-width: 24px; max-width: 24px; text-align: center;">
                                        <i class="fa-solid fa-truck-medical"></i>
                                    </div>
                                    <div class="flex-fill ms-2">
                                        Permintaan
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link p-2" href="<?= base_url('/petugas'); ?>">
                                <div class="d-flex align-items-start link-body-emphasis">
                                    <div style="min-width: 24px; max-width: 24px; text-align: center;">
                                        <i class="fa-solid fa-user-nurse"></i>
                                    </div>
                                    <div class="flex-fill ms-2">
                                        Petugas Gizi
                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php if (session()->get('role') == "Master Admin") : ?>
                            <li class="nav-item">
                                <a class="nav-link p-2" href="<?= base_url('/admin'); ?>">
                                    <div class="d-flex align-items-start link-body-emphasis">
                                        <div style="min-width: 24px; max-width: 24px; text-align: center;">
                                            <i class="fa-solid fa-users"></i>
                                        </div>
                                        <div class="flex-fill ms-2">
                                            Admin
                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link p-2" href="<?= base_url('/settings'); ?>">
                                <div class="d-flex align-items-start link-body-emphasis">
                                    <div style="min-width: 24px; max-width: 24px; text-align: center;">
                                        <i class="fa-solid fa-gear"></i>
                                    </div>
                                    <div class="flex-fill ms-2">
                                        Pengaturan
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <hr class="my-1 mb-2">
                    <!-- FOOTER -->
                    <div class="mx-2 text-body-emphasis" style="font-size: 9pt;">
                        <p class="text-center"><strong>Sistem Informasi Permintaan Makanan Pasien Rawat Inap</strong><br>&copy; 2024 <?= (date('Y') !== "2024") ? "- " . date('Y') : ''; ?> Rumah Sakit Khusus Mata Padang Eye Center<br><a class="text-body-emphasis" href="https://padangeyecenter.com/" target="_blank">padangeyecenter.com</a></p>
                    </div>
                </div>
            </nav>

            <?= $this->renderSection('content'); ?>
            <div class="toast-container position-fixed top-0 p-3">
                <?php if (session()->getFlashdata('info')) : ?>
                    <div class="toast fade show align-items-center text-bg-info border border-info rounded-3 transparent-blur" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-body d-flex align-items-start">
                            <div style="width: 24px; text-align: center;">
                                <i class="fa-solid fa-circle-info"></i>
                            </div>
                            <div class="w-100 mx-2 text-start">
                                <?= session()->getFlashdata('info'); ?>
                            </div>
                            <button type="button" class="btn-close btn-close-black" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                <?php endif; ?>
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
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
            <script src="<?= base_url(); ?>assets_public/fontawesome/js/all.js"></script>
            <script src="<?= base_url(); ?>assets/js/dashboard/dashboard.js"></script>
            <?= $this->renderSection('javascript'); ?>
            <?= $this->renderSection('datatable'); ?>
            <?= $this->renderSection('tinymce'); ?>
            <?= $this->renderSection('chartjs'); ?>
            <?= $this->renderSection('imgupload'); ?>
            <script>
                /*!
                 * Color mode toggler for Bootstrap's docs (https://getbootstrap.com/)
                 * Copyright 2011-2023 The Bootstrap Authors
                 * Licensed under the Creative Commons Attribution 3.0 Unported License.
                 */

                (() => {
                    'use strict'

                    const getStoredTheme = () => localStorage.getItem('theme')
                    const setStoredTheme = theme => localStorage.setItem('theme', theme)

                    const getPreferredTheme = () => {
                        const storedTheme = getStoredTheme()
                        if (storedTheme) {
                            return storedTheme
                        }

                        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
                    }

                    const setTheme = theme => {
                        if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                            document.documentElement.setAttribute('data-bs-theme', 'dark')
                        } else {
                            document.documentElement.setAttribute('data-bs-theme', theme)
                        }
                    }

                    setTheme(getPreferredTheme())

                    const showActiveTheme = (theme, focus = false) => {
                        const themeSwitcher = document.querySelector('#bd-theme')

                        if (!themeSwitcher) {
                            return
                        }

                        const themeSwitcherText = document.querySelector('#bd-theme-text')
                        const activeThemeIcon = document.querySelector('.theme-icon-active use')
                        const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`)
                        const svgOfActiveBtn = btnToActive.querySelector('svg use').getAttribute('href')

                        document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
                            element.classList.remove('active')
                            element.setAttribute('aria-pressed', 'false')
                        })

                        btnToActive.classList.add('active')
                        btnToActive.setAttribute('aria-pressed', 'true')
                        activeThemeIcon.setAttribute('href', svgOfActiveBtn)
                        const themeSwitcherLabel = `${themeSwitcherText.textContent} (${btnToActive.dataset.bsThemeValue})`
                        themeSwitcher.setAttribute('aria-label', themeSwitcherLabel)

                        if (focus) {
                            themeSwitcher.focus()
                        }
                    }

                    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                        const storedTheme = getStoredTheme()
                        if (storedTheme !== 'light' && storedTheme !== 'dark') {
                            setTheme(getPreferredTheme())
                        }
                    })

                    window.addEventListener('DOMContentLoaded', () => {
                        showActiveTheme(getPreferredTheme())

                        document.querySelectorAll('[data-bs-theme-value]')
                            .forEach(toggle => {
                                toggle.addEventListener('click', () => {
                                    const theme = toggle.getAttribute('data-bs-theme-value')
                                    setStoredTheme(theme)
                                    setTheme(theme)
                                    showActiveTheme(theme, true)
                                })
                            })
                    })
                })()
            </script>
            <script>
                feather.replace({
                    'aria-hidden': 'true'
                });
            </script>
</body>

</html>