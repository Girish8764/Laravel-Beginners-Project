
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>School DiGi</title>

  <!-- ✅ CSS plugins -->
  <link rel="stylesheet" href="{{ asset('assets1/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('assets1/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets1/vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('assets1/vendors/font-awesome/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets1/vendors/mdi/css/materialdesignicons.min.css') }}">

  <!-- ✅ Datatables plugin CSS -->
  <link rel="stylesheet" href="{{ asset('assets1/vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">

  <link rel="stylesheet" href="{{ asset('assets1/vendors/css/dataTables.bootstrap5.min.css') }}">

  <link rel="stylesheet" href="{{ asset('assets1/js/select.dataTables.min.css') }}">

  <!-- ✅ Main CSS -->
  <link rel="stylesheet" href="{{ asset('assets1/css/style.css') }}">

  <link rel="shortcut icon" href="{{asset('assets1/images/logo-mini.png')}}" />
</head>

  <body>
      <!-- partial:partials/_navbar.html -->
      <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
    <a class="navbar-brand brand-logo me-5" href="index.html"><img src="{{asset('assets1/images/logo.png')}}" class="me-2" alt="logo" /></a>
    <a class="navbar-brand brand-logo-mini" href="index.html"><img src="{{asset('assets1/images/logo-mini.png')}}" alt="logo" /></a>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="icon-menu"></span>
    </button>
    <ul class="navbar-nav mr-lg-2">
      <!-- <li class="nav-item nav-search d-none d-lg-block">
        <div class="input-group">
          <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
            <span class="input-group-text" id="search">
              <i class="icon-search"></i>
            </span>
          </div>
          <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now" aria-label="search" aria-describedby="search">
        </div>
      </li> -->
    </ul>
    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item dropdown">
        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
          <i class="icon-bell mx-0"></i>
          <span class="count"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
          <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-success">
                <i class="ti-info-alt mx-0"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject font-weight-normal">Application Error</h6>
              <p class="font-weight-light small-text mb-0 text-muted"> Just now </p>
            </div>
          </a>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-warning">
                <i class="ti-settings mx-0"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject font-weight-normal">Settings</h6>
              <p class="font-weight-light small-text mb-0 text-muted"> Private message </p>
            </div>
          </a>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-info">
                <i class="ti-user mx-0"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject font-weight-normal">New user registration</h6>
              <p class="font-weight-light small-text mb-0 text-muted"> 2 days ago </p>
            </div>
          </a>
        </div>
      </li>
      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
          <img src="{{ auth('admin')->user()->image ? asset(auth('admin')->user()->image) : asset('assets1/images/faces/face28.jpg') }}" 
          alt="profile" class="rounded-circle" width="50" height="50">
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editProfileModal">
              <i class="ti-settings text-primary"></i> My Profile </a>
            </button>
            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
              <i class="mdi mdi-lock text-primary"></i> Change Password
            </button>

          <a class="dropdown-item" href="{{ route('logout') }}">
            <i class="ti-power-off text-primary"></i> Logout
          </a>

        </div>
      </li>
      <!-- <li class="nav-item nav-settings d-none d-lg-flex">
        <a class="nav-link" href="#">
          <i class="icon-ellipsis"></i>
        </a>
      </li> -->
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="icon-menu"></span>
    </button>
  </div>
</nav>

@php
  $states = \App\Models\Location::states()->get();
@endphp

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Edit Profile</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">

          <!-- Section: Personal Details -->
          <h5 class="mb-3 text-primary">Personal Details</h5>
          <hr class="mb-3">
          <div class="row">
            <div class="col-md-4 mb-3">
              <label>Dice Code</label>
              <input type="text" class="form-control" value="{{ auth('admin')->user()->dice_code }}" readonly>
            </div>
            <div class="col-md-4 mb-3">
              <label>Email</label>
              <input type="email" class="form-control" value="{{ auth('admin')->user()->email }}" readonly>
            </div>
            <div class="col-md-4 mb-3">
              <label>Mobile</label>
              <input type="text" class="form-control" value="{{ auth('admin')->user()->mobile }}" readonly>
            </div>
            <div class="col-md-4 mb-3">
              <label>School Name</label>
              <input type="text" name="school_name" class="form-control" value="{{ auth('admin')->user()->school_name }}">
            </div>
            <div class="col-md-4 mb-3">
              <label>School Code</label>
              <input type="text" name="Sch_code" class="form-control" value="{{ auth('admin')->user()->Sch_code }}">
            </div>
            <div class="col-md-4 mb-3">
              <label>PSP Code</label>
              <input type="text" name="Psp_code" class="form-control" value="{{ auth('admin')->user()->Psp_code }}">
            </div>
            <div class="col-md-4 mb-3">
              <label>Phone</label>
              <input type="text" name="phone" class="form-control" value="{{ auth('admin')->user()->phone }}">
            </div>
            <div class="col-md-4 mb-3">
              <label>Medium</label>
              <select name="medium" class="form-select">
                <option value="English" {{ auth('admin')->user()->medium == 'English' ? 'selected' : '' }}>English</option>
                <option value="Hindi" {{ auth('admin')->user()->medium == 'Hindi' ? 'selected' : '' }}>Hindi</option>
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label>School Type</label>
              <input type="text" name="School_type" class="form-control" value="{{ auth('admin')->user()->School_type }}">
            </div>
            <div class="col-md-4 mb-3">
              <label>Affiliation No</label>
              <input type="text" name="Aff_no" class="form-control" value="{{ auth('admin')->user()->Aff_no }}">
            </div>
            <div class="col-md-4 mb-3">
              <label>Affiliation Year</label>
              <input type="text" name="Aff_year" class="form-control" value="{{ auth('admin')->user()->Aff_year }}">
            </div>
            <div class="col-md-4 mb-3">
              <label>Standard</label>
              <input type="text" name="standrad" class="form-control" value="{{ auth('admin')->user()->standrad }}">
            </div>
            <div class="col-md-4 mb-3">
              <label>Sec Year</label>
              <input type="text" name="sec_year" class="form-control" value="{{ auth('admin')->user()->sec_year }}">
            </div>
            <div class="col-md-4 mb-3">
              <label>Sr. Sec Year</label>
              <input type="text" name="sr_sec_year" class="form-control" value="{{ auth('admin')->user()->sr_sec_year }}">
            </div>
          </div>

          <!-- Section: Location & Logo -->
          <h5 class="mb-3 text-primary mt-4">Location & Logo</h5>
          <hr class="mb-3">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="stateDropdown">State</label>
              <select id="stateDropdown" name="state_id" class="form-select">
                <option value="">Select State</option>
                @foreach($states as $state)
                  <option value="{{ $state->id }}" {{ auth('admin')->user()->state == $state->name ? 'selected' : '' }}>
                    {{ $state->name }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label for="districtDropdown">District</label>
              <select id="districtDropdown" name="district" class="form-select">
                @if(auth('admin')->user()->district)
                  <option selected>{{ auth('admin')->user()->district }}</option>
                @else
                  <option value="">Select District</option>
                @endif
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label>Address</label>
              <input type="text" name="address" class="form-control" value="{{ auth('admin')->user()->address }}">
            </div>
            <div class="col-md-4 mb-3">
              <label>Tehsil</label>
              <input type="text" name="tehsil" class="form-control" value="{{ auth('admin')->user()->tehsil }}">
            </div>
            <div class="col-md-4 mb-3">
              <label>Village</label>
              <input type="text" name="village" class="form-control" value="{{ auth('admin')->user()->village }}">
            </div>
            <div class="col-md-4 mb-3">
              <label>Logo</label>
              <input type="file" name="image" class="form-control">
              @if(auth('admin')->user()->image)
                <img src="{{ asset(auth('admin')->user()->image) }}" class="mt-2 rounded" width="120" height="120" style="border: 2px solid #ffc107;">
              @endif
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update Profile</button>
        </div>
      </div>
    </form>
  </div>
</div>

</div>

<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('admin.change.password') }}">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Current Password</label>
            <input type="password" name="current_password" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Confirm New Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Update Password</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  document.getElementById('stateDropdown').addEventListener('change', function () {
    let stateId = this.value;
    let districtDropdown = document.getElementById('districtDropdown');

    districtDropdown.innerHTML = '<option>Loading...</option>';

    fetch(`{{ route('admin.get.districts') }}?state_id=${stateId}`)
      .then(response => response.json())
      .then(data => {
        districtDropdown.innerHTML = '<option value="">Select District</option>';
        for (const [id, name] of Object.entries(data)) {
          districtDropdown.innerHTML += `<option value="${name}">${name}</option>`;
        }
      });
  });
</script>
