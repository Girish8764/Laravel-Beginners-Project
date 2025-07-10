@include('superadmin.header')
@include('admin.sidebar')

<div class="main-panel">
  <div class="content-wrapper">
    <div class="mb-4 d-flex justify-content-between align-items-center">
      <h3 class="font-weight-bold">Manage All Subjects</h3>
    </div>

    <!-- Add Subject Form -->
    <div class="card mb-4">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Add New Subject</h5>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ url('superadmin/subjects') }}">
          @csrf
          <div class="row g-3">
            <div class="col-md-4">
              <label>Class</label>
              <select name="class" class="form-control form-control-sm" required>
                <option value="" disabled>Select Class</option>
                @foreach($classes as $class)
                  <option value="{{ $class->name }}">{{ $class->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label>Stream</label>
              <select name="stream" class="form-control form-control-sm" required>
                <option value="" disabled>Select Stream</option>
                <option value="General">General</option>
                <option value="Science">Science</option>
                <option value="Arts">Arts</option>
                <option value="Commerce">Commerce</option>
              </select>
            </div>
            <div class="col-md-4">
              <label>Subject Name</label>
              <input type="text" name="name" placeholder="e.g. Physics" required class="form-control form-control-sm" />
            </div>
            <div class="col-md-4">
              <label>Is Third Language?</label>
              <select name="is_third_language" class="form-control form-control-sm">
                <option value="0" selected>No</option>
                <option value="1">Yes</option>
              </select>
            </div>
          </div>
          <div class="mt-3">
            <button class="btn btn-primary btn-sm">Add Subject</button>
          </div>
        </form>

      </div>
    </div>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Subjects List -->
    <div class="card">
      <div class="card-header bg-info text-white">
        <h5 class="mb-0">All Subjects</h5>
      </div>
      <div class="card-body">
        <table id="globalSubjectsTable" class="table table-bordered table-striped table-sm align-middle">
  <thead class="table-primary">
    <tr>
      <th>#</th>
      <th>Class</th>
      <th>Stream</th>
      <th>Name</th>
      <th>Is Third Language</th>
      <th class="no-sort">Action</th>
    </tr>
  </thead>
  <tbody>
    @forelse($subjects as $s)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $s->class }}</td>
        <td>{{ $s->stream }}</td>
        <td>{{ $s->name }}</td>
        <td>{{ $s->is_third_language ? 'Yes' : 'No' }}</td>
        <td>
          <form method="POST" action="{{ url('superadmin/subjects/'.$s->id) }}" onsubmit="return confirm('Are you sure to Delete this Subject?');">
            @csrf @method('DELETE')
            <button class="btn btn-danger px-4 py-2 fw-bold text-white" style="font-size: 1rem;">Remove Subject</button>

          </form>
        </td>
      </tr>
    @empty
      <tr><td colspan="5" class="text-center text-muted">No subjects added yet.</td></tr>
    @endforelse
  </tbody>
</table>

      </div>
    </div>
  </div>
</div>
</div>
@include('admin.footer')
<script>
  $(document).ready(function () {
    $('#globalSubjectsTable').DataTable({
      responsive: true,
      ordering: true,
      searching: true,
      paging: true,
      pageLength: 10,
      lengthMenu: [5, 10, 25, 50],
      language: {
        search: "🔍 Search Subjects:",
        lengthMenu: "Show _MENU_ entries per page",
        zeroRecords: "No matching subjects found.",
        info: "Showing _START_ to _END_ of _TOTAL_ subjects",
        infoEmpty: "No subjects available",
        infoFiltered: "(filtered from _MAX_ total subjects)"
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
