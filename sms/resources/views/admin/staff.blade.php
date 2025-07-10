@include('admin.header')
@include('admin.sidebar')

<div class="main-panel">
  <div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="font-weight-bold text-dark">Manage Staff</h4>
      <div>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addStaffModal">
          <i class="mdi mdi-account-plus"></i> Add Teacher
        </button>
      </div>
    </div>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
      <table id="teachersTable" class="table table-bordered table-striped table-sm align-middle">
        <thead class="table-primary">
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Father's Name</th>
            <th>Mother's Name</th>
            <th>DOB</th>
            <th>Gender</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Joining Date</th>
            <th>Active / Inactive</th>
          </tr>
        </thead>
        <tbody>
          @foreach($teachers as $teacher)
        <tr class="teacher-row"
            data-id="{{ $teacher->id }}"
            data-name="{{ $teacher->name }}"
            data-father="{{ $teacher->f_name }}"
            data-mother="{{ $teacher->m_name }}"
            data-gender="{{ $teacher->gender }}"
            data-dob="{{ $teacher->dob }}"
            data-religion="{{ $teacher->religion }}"
            data-email="{{ $teacher->email }}"
            data-mobile="{{ $teacher->mobile }}"
            data-subject="{{ $teacher->subject }}"
            data-joining="{{ $teacher->joining }}"
            data-category="{{ $teacher->category }}"
            data-aadhar="{{ $teacher->aadhar }}"
        >
            <td>{{ $loop->iteration }}</td>
            <td>{{ $teacher->name ?? '—' }}</td>
            <td>{{ $teacher->f_name ?? '—' }}</td>
            <td>{{ $teacher->m_name ?? '—' }}</td>
            <td>{{ $teacher->dob ? \Carbon\Carbon::parse($teacher->dob)->format('d-m-Y') : '—' }}</td>
            <td>{{ $teacher->gender ?? '—' }}</td>
            <td>{{ $teacher->mobile ?? '—' }}</td>
            <td>{{ $teacher->email ?? '—' }}</td>
            <td>{{ $teacher->subject ?? '—' }}</td>
            <td>{{ $teacher->joining ? \Carbon\Carbon::parse($teacher->joining)->format('d-m-Y') : '—' }}</td>
            <td class="align-middle">
            <button type="button"
                class="btn {{ $teacher->status ? 'btn-danger' : 'btn-success' }} text-white"
                style="padding: 10px 24px; font-size: 1rem; font-weight: bold;"
                data-bs-toggle="modal"
                data-bs-target="#confirmStatusModal"
                data-id="{{ $teacher->id }}"
                data-status="{{ $teacher->status }}">
                {{ $teacher->status ? 'Inactivate' : 'Activate' }}
            </button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>

<!-- Status Confirmation Modal -->
<div class="modal fade" id="confirmStatusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" id="statusForm">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="statusModalLabel">Confirm Status Change</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p id="statusModalText">Are you sure you want to change the status?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Yes, Proceed</button>
        </div>
      </form>
    </div>
  </div>
</div>


@include('admin.modals.teacher_add')
@include('admin.modals.teacher_edit')
@include('admin.footer')

<!-- Initialize DataTables -->
<script>
  $(function () {
    $('#teachersTable').DataTable({
      responsive: true,
      ordering: true,
      searching: true,
      paging: true,
      processing: true,
      pageLength: 10,
      lengthMenu: [5, 10, 25, 50, 100],
      language: {
        processing: "<span class='text-primary fw-bold'>⏳ Processing, please wait...</span>",
        search: "🔍 Search Staff:",
        lengthMenu: "Show _MENU_ entries per page",
        zeroRecords: "No staff found.",
        info: "Showing _START_ to _END_ of _TOTAL_ staff",
        infoEmpty: "No staff available",
        infoFiltered: "(filtered from _MAX_ total staff)"
      },
      columnDefs: [
        { targets: 'no-sort', orderable: false },
      ],
      initComplete: function () {
        $('.dataTables_length select').addClass('form-select form-select-sm shadow-sm mx-2');
        $('.dataTables_filter input').addClass('form-control form-control-sm shadow-sm').attr('placeholder', 'Type to search...');
        $('.dataTables_length label, .dataTables_filter label').addClass('d-flex align-items-center');
      }
    });
  });
</script>

<script>
  $(document).on('click', '.teacher-row', function (e) {
    // Prevent opening modal if clicked on a button or inside a form
    if (
      $(e.target).is('button') || 
      $(e.target).closest('form').length > 0
    ) {
      return; // stop here
    }

    // Set values to modal input fields
    $('#edit_staff_id').val($(this).data('id'));
    $('#edit_name').val($(this).data('name'));
    $('#edit_f_name').val($(this).data('father'));
    $('#edit_m_name').val($(this).data('mother'));
    $('#edit_gender').val($(this).data('gender'));
    $('#edit_dob').val($(this).data('dob'));
    $('#edit_religion').val($(this).data('religion'));
    $('#edit_email').val($(this).data('email'));
    $('#edit_mobile').val($(this).data('mobile'));
    $('#edit_subject').val($(this).data('subject'));
    $('#edit_joining').val($(this).data('joining'));
    $('#edit_category').val($(this).data('category'));
    $('#edit_aadhar').val($(this).data('aadhar'));

    // Show modal
    $('#editStaffModal').modal('show');
  });
</script>
<script>
  const modal = document.getElementById('confirmStatusModal');
  modal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const teacherId = button.getAttribute('data-id');
    const currentStatus = button.getAttribute('data-status');

    const form = document.getElementById('statusForm');
    const modalText = document.getElementById('statusModalText');

    // Set the form action dynamically
    form.action = `/teacher/status/${teacherId}`;

    // Update modal text based on status
    if (currentStatus == 1) {
      modalText.textContent = 'Are you sure you want to inactivate this teacher?';
    } else {
      modalText.textContent = 'Are you sure you want to activate this teacher?';
    }
  });
</script>

