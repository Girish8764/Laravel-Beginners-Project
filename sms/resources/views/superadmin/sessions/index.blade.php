<!-- resources/views/superadmin/sessions/index.blade.php -->
@include('superadmin.header')
@include('admin.sidebar')

<div class="main-panel">
  <div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4>Manage Academic Sessions</h4>
      <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addSessionModal">Add New Session</button>
    </div>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-sm">
      <thead class="table-primary">
        <tr>
          <th>#</th>
          <th>Session Name</th>
          <th>Status</th>
          <th>Created On</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($sessions as $index => $session)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $session->name }}</td>
          <td>
           @if($session->is_active)
        <span class="badge bg-success me-2">Status: Active</span>
        <form action="{{ route('sessions.toggle', $session->id) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm text-white">Set Inactive</button>
        </form>
    @else
        <span class="badge bg-danger me-2">Status: Inactive</span>
        <form action="{{ route('sessions.toggle', $session->id) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-success btn-sm text-white">Set Active</button>
        </form>
    @endif
    <small class="text-muted ms-2">Click the button to toggle status</small>
          </td>
          <td>{{ $session->created_at->format('d M Y') }}</td>
          <td>
            <button class="btn btn-primary btn-sm edit-session-btn text-white"
              data-id="{{ $session->id }}"
              data-name="{{ $session->name }}"
              data-is_active="{{ $session->is_active ? 1 : 0 }}"
              data-bs-toggle="modal" data-bs-target="#editSessionModal">
              Edit
            </button>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addSessionModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('sessions.store') }}" class="modal-content">
      @csrf
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Add Session</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <label>Session Name</label>
        <input type="text" name="name" required class="form-control form-control-sm" placeholder="e.g. 2024-2025">
        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm">Save</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editSessionModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" id="editSessionForm" class="modal-content">
        @csrf
        @method('PUT')
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Edit Session</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <label>Session Name</label>
        <input type="text" name="name" id="edit_session_name" required class="form-control form-control-sm">
        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm">Update</button>
      </div>
    </form>
  </div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function () {
    $('.edit-session-btn').on('click', function () {
      const id = $(this).data('id');
      const name = $(this).data('name');
      const active = $(this).data('is_active');

      // Set values in modal inputs
      $('#edit_session_name').val(name);
      $('#edit_is_active').prop('checked', active == 1);

      // ✅ Set the form action dynamically with the session ID
      $('#editSessionForm').attr('action', `/superadmin/sessions/${id}`);
    });
  });
</script>



@include('admin.footer')
