@include('admin.header')
@include('admin.sidebar')

<div class="main-panel">
  <div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="font-weight-bold text-dark">Manage Class Teachers</h4>
      <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addClassTeacherModal">
        <i class="mdi mdi-account-plus"></i> Add Class Teacher
      </button>
    </div>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
      <table id="classTeacherTable" class="table table-bordered table-striped table-sm align-middle">
        <thead class="table-primary">
          <tr>
            <th>#</th>
            <th>Class</th>
            <th>Stream</th>
            <th>Teacher</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($assignedTeachers as $teacher)
          <tr 
            data-id="{{ $teacher->id }}"
            data-class="{{ $teacher->class }}"
            data-stream="{{ $teacher->stream }}"
            data-name="{{ $teacher->name }}"
          >
            <td>{{ $loop->iteration }}</td>
            <td>{{ $teacher->class }}</td>
            <td>{{ $teacher->stream }}</td>
            <td>{{ $teacher->name }}</td>
            <td>
              <button type="button"
                      class="btn btn-primary btn-md text-white edit-btn"
                      data-bs-toggle="modal"
                      data-bs-target="#editClassTeacherModal" style="padding: 8px 16px; font-size: 1rem;">
                Edit
              </button>

              <button type="button"
                      class="btn btn-danger btn-md text-white delete-btn"
                      data-id="{{ $teacher->id }}"
                      data-bs-toggle="modal"
                      data-bs-target="#deleteClassTeacherModal" style="padding: 8px 16px; font-size: 1rem;">
                Delete
              </button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- 🔵 Add Modal -->
<div class="modal fade" id="addClassTeacherModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('admin.teacher-class.store') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Add Class Teacher</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="dice_code" value="{{ auth('admin')->user()->dice_code }}">
          <div class="mb-3">
            <label class="form-label">Class</label>
            <select class="form-select" name="class" required>
              <option value="" disabled selected>Select Class</option>
              @foreach($classes as $class)
              <option value="{{ $class->name }}">{{ $class->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Stream</label>
            <select class="form-select" name="stream" required>
              <option value="" disabled selected>Select Stream</option>
              <option>Agriculture</option>
              <option>Arts</option>
              <option>Commerce</option>
              <option>General</option>
              <option>Science</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Teacher Name</label>
            <select class="form-select" name="name" required>
              <option value="" disabled selected>Select Teacher</option>
              @foreach($teachers as $teacher)
              <option value="{{ $teacher->name }}">{{ $teacher->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Add</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- 🟡 Edit Modal -->
<div class="modal fade" id="editClassTeacherModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('admin.teacher-class.update') }}">
      @csrf
      <input type="hidden" name="id" id="edit_id">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Edit Class Teacher</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Class</label>
            <select class="form-select" name="class" id="edit_class" required>
              @foreach($classes as $class)
              <option value="{{ $class->name }}">{{ $class->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Stream</label>
            <select class="form-select" name="stream" id="edit_stream" required>
              <option>Agriculture</option>
              <option>Arts</option>
              <option>Commerce</option>
              <option>General</option>
              <option>Science</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Teacher Name</label>
            <select class="form-select" name="name" id="edit_name" required>
              @foreach($teachers as $teacher)
              <option value="{{ $teacher->name }}">{{ $teacher->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- 🟥 Confirm Delete Modal -->
<div class="modal fade" id="deleteClassTeacherModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="deleteForm" method="POST">
        @csrf
        @method('DELETE')
        <div class="modal-header">
          <h5 class="modal-title" id="confirmDeleteLabel">Confirm Deletion</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this class teacher assignment?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger text-white">Yes, Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
@include('admin.footer')

<!-- 🧠 Scripts -->
<script>
  $(function () {
    $('#classTeacherTable').DataTable({
      responsive: true,
      ordering: true,
      searching: true,
      paging: true,
      pageLength: 10,
      lengthMenu: [5, 10, 25, 50, 100],
      language: {
        search: "🔍 Search:",
        lengthMenu: "Show _MENU_ entries per page",
        zeroRecords: "No records found.",
        info: "Showing _START_ to _END_ of _TOTAL_ entries",
        infoEmpty: "No entries available",
        infoFiltered: "(filtered from _MAX_ total entries)"
      },
      initComplete: function () {
        $('.dataTables_length select').addClass('form-select form-select-sm shadow-sm mx-2');
        $('.dataTables_filter input').addClass('form-control form-control-sm shadow-sm').attr('placeholder', 'Search...');
        $('.dataTables_length label, .dataTables_filter label').addClass('d-flex align-items-center');
      }
    });

    // Prefill Edit Modal
    $('.edit-btn').on('click', function () {
      const row = $(this).closest('tr');
      $('#edit_id').val(row.data('id'));
      $('#edit_class').val(row.data('class'));
      $('#edit_stream').val(row.data('stream'));
      $('#edit_name').val(row.data('name'));
    });

    // Delete button dynamic action setup
    $('.delete-btn').on('click', function () {
      const id = $(this).data('id');
      const form = $('#deleteForm');
      form.attr('action', '/admin/class-teacher/' + id);
    });
  });
</script>
