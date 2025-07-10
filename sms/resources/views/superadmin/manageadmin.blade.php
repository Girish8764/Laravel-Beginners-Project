@include('superadmin.header')
@include('admin.sidebar')

<div class="main-panel">
  <div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="font-weight-bold text-dark">Manage Schools</h4>
    </div>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
      <table id="adminsTable" class="table table-bordered table-striped table-sm align-middle">
        <thead class="table-primary">
          <tr>
            <th>#</th>
            <th>School Name</th>
            <th>Contact Info</th>
            <th>Dice Code</th>
            <th>Status</th>
            <th>Created</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($admins as $index => $admin)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>
              <strong>{{ $admin->school_name }}</strong><br>
              <small>{{ $admin->email }}</small>
            </td>
            <td>
              <span>Email: {{ $admin->email }}</span><br>
              <span>Mobile: {{ $admin->mobile }}</span>
            </td>
            <td>{{ $admin->dice_code }}</td>
            <td>
              @if ($admin->is_active)
                <span class="badge bg-success">Active</span>
              @else
                <span class="badge bg-secondary">Inactive</span>
              @endif
            </td>
            <td>
  {{ $admin->created_at ? $admin->created_at->format('d M Y') : 'N/A' }}
</td>

            <td>
              <button type="button" class="btn btn-info btn-sm view-admin" data-admin='@json($admin)' data-bs-toggle="modal" data-bs-target="#viewAdminModal">
                <!-- <i class="mdi mdi-eye"></i> -->
                <span class="btn-text text-white">Show Details</span>
              </button>
              <button type="button" class="btn btn-warning btn-sm edit-admin" data-admin='@json($admin)' data-bs-toggle="modal" data-bs-target="#editAdminModal">
                <!-- <i class="mdi mdi-pencil"></i> -->
                <span class="btn-text text-white">Edit</span>
              </button>
              <form action="{{ route('superadmin.admins.toggle', $admin->id) }}" method="POST" class="d-inline toggle-status-form">
  @csrf
  <button type="submit" class="btn {{ $admin->is_active ? 'btn-danger' : 'btn-success' }} btn-lg fw-bold px-4 py-2 toggle-status-btn">
    <span class="btn-text text-white">{{ $admin->is_active ? 'Deactivate' : 'Activate' }}</span>
    <span class="spinner-border spinner-border-sm text-white d-none ms-2" role="status" aria-hidden="true"></span>
  </button>
</form>

            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

      @if($admins->isEmpty())
        <div class="text-center p-4">
          <strong>No admins found.</strong>
        </div>
      @endif

    </div>
  </div>
</div>
</div>
@include('admin.footer')
<script>
  $(document).on('submit', '.toggle-status-form', function (e) {
  e.preventDefault(); // stop form

  const form = this;
  const btn = $(form).find('.toggle-status-btn');
  btn.prop('disabled', true);
  btn.find('.btn-text').text('Processing...');
  btn.find('.spinner-border').removeClass('d-none');

  setTimeout(() => form.submit(), 500); // delay real submit
});

</script>
<!-- Admin Detail Modal -->
<div class="modal fade" id="viewAdminModal" tabindex="-1" aria-labelledby="viewAdminModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">School Full Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body px-4">
        <div class="row g-3">
          <div class="col-md-4"><strong>Dice Code:</strong> <span id="view_dice_code"></span></div>
          <div class="col-md-4"><strong>Mobile:</strong> <span id="view_mobile"></span></div>
          <div class="col-md-4"><strong>Email:</strong> <span id="view_email"></span></div>
          <div class="col-md-4"><strong>PSP Code:</strong> <span id="view_psp_code"></span></div>
          <div class="col-md-4"><strong>School Code:</strong> <span id="view_school_code"></span></div>
          <div class="col-md-4"><strong>School Type:</strong> <span id="view_school_type"></span></div>
          <div class="col-md-4"><strong>Medium:</strong> <span id="view_medium"></span></div>
          <div class="col-md-4"><strong>Status:</strong> <span id="view_status"></span></div>
          <div class="col-md-4"><strong>Address:</strong> <span id="view_address"></span></div>
          <div class="col-md-4"><strong>Village:</strong> <span id="view_village"></span></div>
          <div class="col-md-4"><strong>Tehsil:</strong> <span id="view_tehsil"></span></div>
          <div class="col-md-4"><strong>District:</strong> <span id="view_district"></span></div>
          <div class="col-md-4"><strong>State:</strong> <span id="view_state"></span></div>
          <div class="col-md-4"><strong>Affiliation Year:</strong> <span id="view_aff_year"></span></div>
          <div class="col-md-4"><strong>Aff No:</strong> <span id="view_aff_no"></span></div>
          <div class="col-md-4"><strong>Password:</strong> <span id="view_pass"></span></div>
          <div class="col-md-4"><strong>Standard:</strong> <span id="view_standard"></span></div>
          <div class="col-md-4"><strong>Sec Year:</strong> <span id="view_sec_year"></span></div>
          <div class="col-md-4"><strong>Sr Sec Year:</strong> <span id="view_sr_sec_year"></span></div>
          <div class="col-md-4"><strong>Created At:</strong> <span id="view_created_at"></span></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Admin Edit Modal -->
<div class="modal fade" id="editAdminModal" tabindex="-1" aria-labelledby="editAdminModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <form id="editAdminForm" method="POST" action="" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-header bg-primary text-dark">
          <h5 class="modal-title text-white">Edit Admin Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body row g-3 px-4 py-2">
          <input type="hidden" name="admin_id" id="edit_admin_id">
          <div class="col-md-6">
            <label>School Name</label>
            <input type="text" name="school_name" id="edit_school_name" class="form-control form-control-sm" required>
          </div>
          <div class="col-md-6">
            <label>Dice Code</label>
            <input type="text" name="dice_code" id="edit_dice_code" class="form-control form-control-sm" readonly>
          </div>
          <div class="col-md-6">
            <label>Email</label>
            <input type="email" name="email" id="edit_email" class="form-control form-control-sm" required>
          </div>
          <div class="col-md-6">
            <label>Mobile</label>
            <input type="text" name="mobile" id="edit_mobile" class="form-control form-control-sm" required>
          </div>
          <div class="col-md-6">
            <label>School Type</label>
            <input type="text" name="School_type" id="edit_school_type" class="form-control form-control-sm">
          </div>
          <div class="col-md-6">
            <label>Affiliation Year</label>
            <input type="text" name="Aff_year" id="edit_aff_year" class="form-control form-control-sm">
          </div>
          <div class="col-md-6">
            <label>Password</label>
            <input type="text" name="pass" id="edit_pass" class="form-control form-control-sm">
          </div>
          <div class="col-md-6">
            <label>Standard</label>
            <input type="text" name="standrad" id="edit_standard" class="form-control form-control-sm">
          </div>
          <div class="col-md-6">
            <label>Sec Year</label>
            <input type="text" name="sec_year" id="edit_sec_year" class="form-control form-control-sm">
          </div>
          <div class="col-md-6">
            <label>Sr Sec Year</label>
            <input type="text" name="sr_sec_year" id="edit_sr_sec_year" class="form-control form-control-sm">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary btn-sm">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  $(document).on('click', '.view-admin', function () {
    const admin = $(this).data('admin');
    $('#view_dice_code').text(admin.dice_code || '—');
    $('#view_mobile').text(admin.mobile || '—');
    $('#view_email').text(admin.email || '—');
    $('#view_psp_code').text(admin.Psp_code || '—');
    $('#view_school_code').text(admin.Sch_code || '—');
    $('#view_school_type').text(admin.School_type || '—');
    $('#view_medium').text(admin.medium || '—');
    $('#view_status').text(admin.is_active ? 'Active' : 'Inactive');
    $('#view_address').text(admin.address || '—');
    $('#view_village').text(admin.village || '—');
    $('#view_tehsil').text(admin.tehsil || '—');
    $('#view_district').text(admin.district || '—');
    $('#view_state').text(admin.state || '—');
    $('#view_aff_year').text(admin.Aff_year || '—');
    $('#view_aff_no').text(admin.Aff_no || '—');
    $('#view_pass').text(admin.pass || '—');
    $('#view_standard').text(admin.standrad || '—');
    $('#view_sec_year').text(admin.sec_year || '—');
    $('#view_sr_sec_year').text(admin.sr_sec_year || '—');
    $('#view_created_at').text(admin.created_at || '—');
  });

  $(document).on('click', '.edit-admin', function () {
    const data = $(this).data('admin');
    $('#edit_admin_id').val(data.id);
    $('#edit_school_name').val(data.school_name);
    $('#edit_dice_code').val(data.dice_code);
    $('#edit_email').val(data.email);
    $('#edit_mobile').val(data.mobile);
    $('#edit_school_type').val(data.School_type);
    $('#edit_aff_year').val(data.Aff_year);
    $('#edit_pass').val(data.pass);
    $('#edit_standard').val(data.standrad);
    $('#edit_sec_year').val(data.sec_year);
    $('#edit_sr_sec_year').val(data.sr_sec_year);
    $('#editAdminForm').attr('action', `/superadmin/admins/${data.id}`);
  });
</script>
