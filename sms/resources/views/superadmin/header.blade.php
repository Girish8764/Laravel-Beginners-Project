<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Superadmin Dashboard</title>

  <!-- CSS plugins -->
  <link rel="stylesheet" href="{{ asset('assets1/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('assets1/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets1/vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('assets1/vendors/font-awesome/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets1/vendors/mdi/css/materialdesignicons.min.css') }}">

  <!-- Datatables plugin CSS -->
  <link rel="stylesheet" href="{{ asset('assets1/vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">
  <link rel="stylesheet" href="{{ asset('assets1/vendors/css/dataTables.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets1/js/select.dataTables.min.css') }}">

  <!-- Main CSS -->
  <link rel="stylesheet" href="{{ asset('assets1/css/style.css') }}">
  <link rel="shortcut icon" href="{{ asset('assets1/images/logo-mini.png') }}" />
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
      <a class="navbar-brand brand-logo me-5" href="#"><img src="{{ asset('assets1/images/logo.png') }}" class="me-2" alt="logo" /></a>
      <a class="navbar-brand brand-logo-mini" href="#"><img src="{{ asset('assets1/images/logo-mini.png') }}" alt="logo" /></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
      <ul class="navbar-nav navbar-nav-right">
        <!-- Only Logout for Superadmin -->
        <li class="nav-item nav-profile dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
            <img src="{{ asset('assets1/images/faces/face28.jpg') }}" class="rounded-circle" width="50" height="50" alt="profile">
          </a>
          <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
            <a class="dropdown-item" href="{{ route('logout') }}">
              <i class="ti-power-off text-primary"></i> Logout
            </a>
          </div>
        </li>
      </ul>
      <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
        <span class="icon-menu"></span>
      </button>
    </div>
  </nav>
