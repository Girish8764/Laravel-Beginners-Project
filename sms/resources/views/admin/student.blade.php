@include('admin.header')
@include('admin.sidebar')

<div class="main-panel">
  <div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="font-weight-bold text-dark">Manage Students</h4>
      <div>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#studentAdmissionModal">
          <i class="mdi mdi-account-plus"></i> Admission
        </button>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#studentUploadModal">
          <i class="mdi mdi-upload"></i> Upload Students
        </button>
        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#generateRollNoModal">
          <i class="mdi mdi-format-list-numbered"></i> Generate Roll Number
        </button>
      </div>
    </div>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
      <table id="studentsTable" class="table table-bordered table-striped table-sm align-middle">
        <thead class="table-primary">
  <tr>
    <th>#</th>
    <th>SR No</th>
    <th>Name</th>
    <th>Father's Name</th>
    <th>DOB</th>
    <th>Gender</th>
    <th>Mobile</th>
    <th>Class</th>
    <th>Stream</th>
    <th>Admission Date</th>
    <th>Roll No</th>
  </tr>
</thead>
<tbody>
  @foreach($students as $student)
<tr class="student-row"
    data-id="{{ $student->id }}"
    data-name="{{ $student->student_name }}"
    data-father="{{ $student->father_name }}"
    data-mother="{{ $student->mother_name }}"
    data-sr_no="{{ $student->sr_no }}"
    data-admission_date="{{ $student->admission_date }}"
    data-dob="{{ $student->dob }}"
    data-gender="{{ $student->gender }}"
    data-mobile="{{ $student->mobile }}"
    data-caste="{{ $student->caste }}"
    data-category="{{ $student->category }}"
    data-stream="{{ $student->stream }}"
    data-class="{{ $student->admission_class }}" {{-- ✅ This line is KEY --}}
    data-bs-toggle="modal"
    data-bs-target="#studentEditModal"
>

  <td>{{ $loop->iteration }}</td>
  <td>{{ $student->sr_no ?? '—' }}</td>
  <td>{{ $student->student_name ?? '—' }}</td>
  <td>{{ $student->father_name ?? '—' }}</td>
  <td>{{ $student->dob ? \Carbon\Carbon::parse($student->dob)->format('d-m-Y') : '—' }}</td>
  <td>{{ $student->gender ?? '—' }}</td>
  <td>{{ $student->mobile ?? '—' }}</td>
  <td>{{ $student->admission_class ?? '—' }}</td>
  <td>{{ $student->stream ?? '—' }}</td>
  <td>{{ $student->admission_date ? \Carbon\Carbon::parse($student->admission_date)->format('d-m-Y') : '—' }}</td>
  <td>{{ $student->rollno ?? '—' }}</td>
</tr>

  @endforeach
</tbody>
      </table>
    </div>

  </div>
</div>
</div>
<style>
  th.no-sort::after {
    display: none !important;
  }
</style>

@include('admin.modals.student_admission')
@include('admin.modals.upload_students')
@include('admin.modals.edit_student')
@include('admin.modals.generate_rollno')
@include('admin.footer')


<!-- Initialize DataTables -->
<script>
  $(function () {
    $('#studentsTable').DataTable({
      responsive: true,
      ordering: true,
      searching: true,
      paging: true,
      processing: true,
      pageLength: 10,
      lengthMenu: [5, 10, 25, 50, 100],
      language: {
        processing: "<span class='text-primary fw-bold'>⏳ Processing, please wait...</span>",
        search: "🔍 Search Students:",
        lengthMenu: "Show _MENU_ entries per page",
        zeroRecords: "No students found.",
        info: "Showing _START_ to _END_ of _TOTAL_ students",
        infoEmpty: "No students available",
        infoFiltered: "(filtered from _MAX_ total students)"
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
  $(document).on('click', '.student-row', function () {
    const classCode = $(this).data('class-code'); // ✅ Correct way to get data-class-code
    console.log("Class Code:", classCode);        // Confirm output is like "10"

    $('#edit_id').val($(this).data('id'));
    $('#edit_sr_no').val($(this).data('sr_no'));
    $('#edit_name').val($(this).data('name'));
    $('#edit_father').val($(this).data('father'));
    $('#edit_mother').val($(this).data('mother'));
    $('#edit_dob').val($(this).data('dob'));
    $('#edit_gender').val($(this).data('gender'));
    $('#edit_mobile').val($(this).data('mobile'));

    $('#edit_class').val($(this).data('class')).change(); // ← use admission_class field

    $('#edit_admission_date').val($(this).data('admission_date'));
    $('#edit_caste').val($(this).data('caste'));
    $('#edit_category').val($(this).data('category'));
    $('#edit_stream').val($(this).data('stream'));
  });
</script>


