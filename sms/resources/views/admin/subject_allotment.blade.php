@include('admin.header')
@include('admin.sidebar')

<div class="main-panel">
  <div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="font-weight-bold text-dark">Subject Allotment to Teacher's</h4>
    </div>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- 🔵 Subject Allotment Form -->
    <form method="POST" action="{{ route('admin.teacher-subject.store') }}">
      @csrf
      <input type="hidden" name="dice_code" value="{{ auth('admin')->user()->dice_code }}">
      <div class="card mb-4">
        <div class="card-body">
          <div class="row align-items-end">
            <div class="col-md-3">
              <label>Teacher Name</label>
              <select class="form-select" name="teacher_name" required>
                <option value="" disabled selected>Select Teacher</option>
                @foreach($teachers as $teacher)
                  <option value="{{ $teacher->name }}">{{ $teacher->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2">
              <label>Class</label>
              <select class="form-select" name="class" id="class" required>
                <option value="" disabled selected>Select Class</option>
                @foreach($classes as $class)
                  <option value="{{ $class->name }}">{{ $class->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2">
              <label>Stream</label>
              <select class="form-select" name="stream" id="stream" required>
                <option value="" disabled selected>Select Stream</option>
              </select>
            </div>
            <div class="col-md-3">
              <label>Subject</label>
              <select class="form-select" name="subject" id="subject" required>
                <option value="" disabled selected>Select Subject</option>
              </select>
            </div>
            <div class="col-md-2">
              <button type="submit" id="confirmButton" class="btn btn-primary w-100">
                <span class="spinner-border spinner-border-sm d-none me-1" id="confirmSpinner" role="status" aria-hidden="true"></span>
                <span id="confirmText">Confirm</span>
              </button>              
            </div>
          </div>
        </div>
      </div>
    </form>

    <!-- 🟡 Assigned Subjects Table -->
    <div class="card">
      <div class="card-body">
        <h4 class="card-title text-center">Subject Allotted to Teacher's</h4>
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="subjectTable">
            <thead class="table-primary">
              <tr>
                <th>#</th>
                <th>Class</th>
                <th>Stream</th>
                <th>Teacher Name</th>
                <th>Subject</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($subjects as $item)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->class }}</td>
                <td>{{ $item->stream }}</td>
                <td>{{ $item->teacher }}</td>
                <td>{{ $item->subject }}</td>
                <td>
                  <!-- Button to trigger modal -->
                  <button 
                    type="button"
                    class="btn btn-danger btn-sm text-white"
                    data-bs-toggle="modal" 
                    data-bs-target="#confirmDeleteModal"
                    data-id="{{ $item->id }}"  style="padding: 8px 16px; font-size: 1rem;">
                    Remove
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
</div>
</div>

@include('admin.footer')

<!-- 🟥 Confirm Delete Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
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
          Are you sure you want to delete this subject assignment?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger text-white">Yes, Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ✅ DataTable Init -->
<script>
  $(document).ready(function () {
    $('#subjectTable').DataTable({
      responsive: true,
      ordering: true,
      searching: true,
      paging: true,
      pageLength: 10,
      lengthMenu: [5, 10, 25, 50, 100],
      language: {
        search: "🔍 Search:",
        lengthMenu: "Show _MENU_ entries",
        zeroRecords: "No records found",
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
  });
</script>

<!-- ✅ AJAX for dynamic stream/subject loading -->
<script>
  $(document).ready(function () {
    $('select[name="class"]').on('change', function () {
      const selectedClass = $(this).val();
      $.ajax({
        url: "{{ route('admin.get.streams-subjects') }}",
        method: "POST",
        data: {
          _token: "{{ csrf_token() }}",
          class: selectedClass
        },
        success: function (response) {
          const streamSelect = $('select[name="stream"]');
          const subjectSelect = $('select[name="subject"]');

          streamSelect.empty().append('<option value="">Select Stream</option>');
          response.streams.forEach(function (stream) {
            streamSelect.append(`<option value="${stream}">${stream}</option>`);
          });

          subjectSelect.empty().append('<option value="">Select Subject</option>');
          response.subjects.forEach(function (subject) {
            subjectSelect.append(`<option value="${subject}">${subject}</option>`);
          });
        }
      });
    });

    $('select[name="stream"]').on('change', function () {
      const selectedClass = $('select[name="class"]').val();
      const selectedStream = $(this).val();

      if (!selectedClass) return;

      $.ajax({
        url: "{{ route('admin.get.streams-subjects') }}",
        method: "POST",
        data: {
          _token: "{{ csrf_token() }}",
          class: selectedClass,
          stream: selectedStream
        },
        success: function (response) {
          const subjectSelect = $('select[name="subject"]');
          subjectSelect.empty().append('<option value="">Select Subject</option>');
          response.subjects.forEach(function (subject) {
            subjectSelect.append(`<option value="${subject}">${subject}</option>`);
          });
        }
      });
    });
  });
</script>

<!-- ✅ JS to set delete form action on modal open -->
<script>
  const deleteModal = document.getElementById('confirmDeleteModal');
  deleteModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const id = button.getAttribute('data-id');
    const form = document.getElementById('deleteForm');
    form.action = `/admin/teacher-subject/${id}`;
  });
</script>
<script>
  $(document).ready(function () {
    $('form[action="{{ route('admin.teacher-subject.store') }}"]').on('submit', function () {
      const confirmButton = $('#confirmButton');
      const confirmText = $('#confirmText');
      const confirmSpinner = $('#confirmSpinner');

      // Disable button
      confirmButton.prop('disabled', true);
      
      // Show spinner and change text
      confirmSpinner.removeClass('d-none');
      confirmText.text('Please wait...');
    });
  });
</script>
