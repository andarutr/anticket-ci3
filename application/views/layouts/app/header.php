<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/img/apple-icon.png'); ?>">
  <link rel="icon" type="image/png" href="<?= base_url('assets/img/logo.png'); ?>">
  <title><?= $title ? $title : '' ?></title>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link id="pagestyle" href="<?= base_url('assets/css/argon-dashboard.css?v=2.1.0'); ?>" rel="stylesheet" />
  <script src="<?= base_url('assets/js/jquery.min.js'); ?>"></script>
  <script src="<?= base_url('assets/js/swal2.min.js'); ?>"></script>
  <link rel="stylesheet" href="<?= base_url('assets/css/select2.min.css'); ?>">
  <script src="<?= base_url('assets/js/select2.min.js'); ?>"></script>
  <link rel="stylesheet" href="<?= base_url('assets/css/quill.min.css'); ?>">
  <script src="<?= base_url('assets/js/quill.min.js'); ?>"></script>
  <link rel="stylesheet" href="<?= base_url('assets/css/datatable.min.css'); ?>">
  <script src="<?= base_url('assets/js/datatable.min.js'); ?>"></script>
  <style>
    .select2-container {
      height: calc(1.5em + 0.75rem + 2px); /* Standar Bootstrap .form-control height */
    }

    .select2-container .select2-selection--single {
      height: 100%;
      display: flex;
      align-items: center;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
      line-height: 1.5; /* agar teks rata tengah vertikal */
      padding-left: 0.75rem;
      padding-right: 0.75rem;
    }

    .select2-container .select2-selection--single .select2-selection__arrow {
      height: 100%;
      position: absolute;
      top: 0;
      right: 0;
      width: 34px;
      border-left: 1px solid #ced4da;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .select2-container .select2-selection--multiple {
      min-height: calc(1.5em + 0.75rem + 2px);
    }

    .select2-container .select2-selection--multiple .select2-selection__rendered {
      padding: 0.375rem 0.75rem;
      line-height: 1.5;
    }

    .ql-editor {
      min-height: 200px;
      max-height: 400px; 
      overflow-y: auto;
  }

  /* Wajib agar sidebar tidak terpotong */
  .sidenav {
    height: 100vh !important;
    overflow-y: auto;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
  }

  /* Wajib agar sidebar tidak terpotong */
  .sidenav .navbar-collapse {
    height: calc(100vh - 80px) !important;
    overflow-y: auto;
  }
  </style>
</head>

<body class="g-sidenav-show bg-gray-100">
    <div class="min-height-300 bg-dark position-absolute w-100"></div>