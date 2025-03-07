<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title; ?></title>
  <link rel="manifest" href="<?= base_url(); ?>/manifest.json">
  <meta name="theme-color" content="#5eba00">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <!-- Favicons -->
  <link href="https://padangeyecenter.com/assets/logo/logo_pec.png" rel="icon" />
  <link href="https://padangeyecenter.com/assets/img/apple-touch-icon.png" rel="apple-touch-icon" />
  <link href="https://getbootstrap.com/docs/5.3/examples/sign-in/sign-in.css" rel="stylesheet">
  <link href="<?= base_url(); ?>assets_public/fontawesome/css/all.css" rel="stylesheet">
  <link href="<?= base_url(); ?>assets_public/css/main.css" rel="stylesheet">
  <link href="<?= base_url(); ?>assets_public/css/JawiDubai.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Color+Emoji&family=Noto+Sans+Arabic:wdth,wght@62.5..100,100..900&family=Noto+Sans+Mono:wdth,wght@62.5..100,100..900&family=Noto+Sans:ital,wdth,wght@0,62.5..100,100..900;1,62.5..100,100..900&display=swap" rel="stylesheet">
  <link href="<?= base_url(); ?>assets_public/fonts/Geist-1.3.0/font-face.css" rel="stylesheet">
  <link href="<?= base_url(); ?>assets_public/fonts/GeistMono-1.3.0/font-face.css" rel="stylesheet">
  <link href="<?= base_url(); ?>assets_public/fonts/base-font/geist.css" rel="stylesheet">
  <style>
    .form-signin .username {
      margin-bottom: -1px;
      border-bottom-right-radius: 0;
      border-bottom-left-radius: 0;
    }

    body {
      background: linear-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 0)), url('<?= base_url('/assets/images/pec.jpg'); ?>');
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      position: relative;
    }

    @media (prefers-color-scheme: dark) {
      body {
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('<?= base_url('/assets/images/pec.jpg'); ?>');
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        position: relative;
      }
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script>
    if ('serviceWorker' in navigator) {
      window.addEventListener('load', () => {
        navigator.serviceWorker.register('<?= base_url(); ?>/service-worker.js')
          .then((registration) => {
            console.log('Service Worker registered with scope:', registration.scope);
          })
          .catch((error) => {
            console.error('Service Worker registration failed:', error);
          });
      });
    }
  </script>
</head>

<body class="d-flex align-items-center py-4 text-center" id="background" style="background-color: #5eba00;">

  <?= $this->renderSection('content'); ?>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="<?= base_url(); ?>assets_public/fontawesome/js/all.js"></script>
  <script>
    $(document).ready(function() {
      $('input.form-control').on('input', function() {
        // Remove the is-invalid class for the current input field
        $(this).removeClass('is-invalid');
        // Hide the invalid-feedback message for the current input field
        $(this).siblings('.invalid-feedback').hide();
      });
      $(document).on('click', '#loginBtn', function(e) {
        e.preventDefault();
        $('#loginForm').submit();
        $('input').prop('disabled', true).removeClass('is-invalid');
        $('#loginBtn').prop('disabled', true).html(`
          <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
          <span role="status">SILAKAN TUNGGU...</span>
        `);
      });
    });
  </script>
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
</body>

</html>