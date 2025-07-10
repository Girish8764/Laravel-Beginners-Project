@include('admin.header')
@include('admin.sidebar')

<div class="main-panel">
  <div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="font-weight-bold text-dark">Exam Datesheet Management</h4>
      <div>
        <button class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#bulkExamModal">
          <i class="mdi mdi-table-plus"></i> Create Datesheet
        </button>
        <button class="btn btn-info btn-sm me-2" data-bs-toggle="modal" data-bs-target="#bulkEditModal">
          <i class="mdi mdi-pencil"></i> Edit Datesheet
        </button>
        <!-- <button class="btn btn-primary btn-sm" id="printDatesheet">
          <i class="mdi mdi-printer"></i> Print Datesheet
        </button> -->
      </div>
    </div>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Filter Controls -->
    <div class="card mb-4">
      <div class="card-body">
        <div class="row">
          <div class="col-md-3">
            <label class="form-label">Filter by Class</label>
            <select id="filterClass" class="form-select">
              <option value="">All Classes</option>
              @foreach($classes as $class)
                <option value="{{ $class->name }}">{{ $class->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">Filter by Stream</label>
            <select id="filterStream" class="form-select">
              <option value="">All Streams</option>
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">Filter by Exam Type</label>
            <select id="filterExamType" class="form-select">
              <option value="">All Exam Types</option>
              @foreach($examTypes as $type)
                <option value="{{ $type }}">{{ $type }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">View Mode</label>
            <select id="viewMode" class="form-select">
              <option value="table">Table View</option>
              <option value="class">Class-wise View</option>
              <option value="date">Date-wise View</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- Table View -->
    <div id="tableView" class="view-container">
      <div class="card">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0"><i class="mdi mdi-table"></i> All Exam Schedules</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="examTable" class="table table-bordered table-striped table-sm align-middle">
              <thead class="table-primary">
                <tr>
                  <th>#</th>
                  <th>Class</th>
                  <th>Stream</th>
                  <th>Subject</th>
                  <th>Exam Type</th>
                  <th>Date</th>
                  <th>Shift</th>
                  <th>Time</th>
                  <th class="no-sort">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($timetables as $exam)
                <tr data-class="{{ $exam->class }}" data-stream="{{ $exam->stream }}" data-exam-type="{{ $exam->exam_type }}">
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $exam->class }}</td>
                  <td>{{ $exam->stream ?? '—' }}</td>
                  <td>{{ $exam->subject }}</td>
                  <td><span class="badge bg-info">{{ $exam->exam_type }}</span></td>
                  <td>{{ \Carbon\Carbon::parse($exam->exam_date)->format('d-m-Y') }}</td>
                  <td>
                    <span class="badge {{ $exam->shift == 'Morning' ? 'bg-warning' : 'bg-secondary' }}">
                      {{ $exam->shift }}
                    </span>
                  </td>
                  <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $exam->start_time)->format('h:i A') }} to {{ \Carbon\Carbon::createFromFormat('H:i:s', $exam->end_time)->format('h:i A') }}</td>
                  <td>
                      <!-- <button type="button"
                              class="btn btn-warning btn-sm editExamBtn"
                              data-id="{{ $exam->id }}"
                              data-class="{{ $exam->class }}"
                              data-stream="{{ $exam->stream }}"
                              data-subject="{{ $exam->subject }}"
                              data-exam_type="{{ $exam->exam_type }}"
                              data-exam_date="{{ $exam->exam_date }}"
                              data-shift="{{ $exam->shift }}"
                              data-start_time="{{ $exam->start_time }}"
                              data-end_time="{{ $exam->end_time }}"
                              data-bs-toggle="modal"
                              data-bs-target="#editExamModal">
                          <i class="mdi mdi-pencil"></i>
                      </button> -->
                      <form action="{{ url('exam-timetable/delete/'.$exam->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this exam schedule?')">
                          @csrf
                          @method('DELETE')
                          <!-- Delete Button -->
<button type="button" 
        class="btn btn-danger btn-lg text-white px-4 py-2 fw-bold" 
        data-bs-toggle="modal" 
        data-bs-target="#deleteExamModal" 
        data-id="{{ $exam->id }}">
    Delete
</button>
           </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteExamModal" tabindex="-1" aria-labelledby="deleteExamModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="deleteExamForm" method="POST">
        @csrf
        @method('DELETE')
        <div class="modal-header">
          <h5 class="modal-title" id="deleteExamModalLabel">Confirm Delete</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this exam schedule?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger text-white">Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  const deleteExamModal = document.getElementById('deleteExamModal');
  deleteExamModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const examId = button.getAttribute('data-id');
    const form = document.getElementById('deleteExamForm');
    form.action = `/exam-timetable/delete/${examId}`;
  });
</script>


    <!-- Class-wise View -->
    <div id="classView" class="view-container" style="display: none;">
      <div id="classViewContent">
        <!-- Content will be dynamically loaded -->
      </div>
    </div>

    <!-- Date-wise View -->
    <div id="dateView" class="view-container" style="display: none;">
      <div id="dateViewContent">
        <!-- Content will be dynamically loaded -->
      </div>
    </div>

    <!-- Add Single Exam Modal -->
    <div class="modal fade" id="addExamModal" tabindex="-1">
      <div class="modal-dialog">
        <form action="{{ route('exam.timetable.store') }}" method="POST" class="modal-content">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title">Add Exam Schedule</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-2">
              <label>Class</label>
              <select class="form-control" name="class" id="classSelect" required>
                <option value="">Select</option>
                @foreach($classes as $c)
                <option value="{{ $c->name }}">{{ $c->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="mb-2">
              <label>Stream</label>
              <select class="form-control" name="stream" id="streamSelect"></select>
            </div>

            <div class="mb-2">
              <label>Subject</label>
              <select class="form-control" name="subject" id="subjectSelect" required></select>
            </div>

            <div class="mb-2">
              <label>Exam Type</label>
              <select name="exam_type" class="form-control" required>
                @foreach($examTypes as $type)
                <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
              </select>
            </div>

            <div class="mb-2">
              <label>Date</label>
              <input type="date" name="exam_date" class="form-control" required>
            </div>

            <div class="mb-2">
              <label>Shift</label>
              <select name="shift" class="form-select form-select-sm" required>
                <option value="Morning">Morning</option>
                <option value="Evening">Evening</option>
              </select>
            </div>

            <div class="mb-2">
              <label>Start Time</label>
              <input type="time" name="start_time" class="form-control" required>
            </div>

            <div class="mb-2">
              <label>End Time</label>
              <input type="time" name="end_time" class="form-control" required>
            </div>
          </div>

          <div class="modal-footer">
            <button class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Edit Single Exam Modal -->
    <div class="modal fade" id="editExamModal" tabindex="-1">
      <div class="modal-dialog">
        <form method="POST" id="editExamForm" class="modal-content">
          @csrf
          @method('PUT')
          <div class="modal-header">
            <h5 class="modal-title">Edit Exam Schedule</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="exam_id" id="edit_exam_id">

            <div class="mb-2">
              <label>Class</label>
              <input type="text" name="class" id="edit_class" class="form-control" readonly>
            </div>

            <div class="mb-2">
              <label>Stream</label>
              <input type="text" name="stream" id="edit_stream" class="form-control" readonly>
            </div>

            <div class="mb-2">
              <label>Subject</label>
              <input type="text" name="subject" id="edit_subject" class="form-control" readonly>
            </div>

            <div class="mb-2">
              <label>Exam Type</label>
              <select name="exam_type" id="edit_exam_type" class="form-control" required>
                @foreach($examTypes as $type)
                  <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
              </select>
            </div>

            <div class="mb-2">
              <label>Date</label>
              <input type="date" name="exam_date" id="edit_exam_date" class="form-control" required>
            </div>

            <div class="mb-2">
              <label>Shift</label>
              <select name="shift" id="edit_shift" class="form-control" required>
                <option value="Morning">Morning</option>
                <option value="Evening">Evening</option>
              </select>
            </div>

            <div class="mb-2">
              <label>Start Time</label>
              <input type="time" name="start_time" id="edit_start_time" class="form-control" required>
            </div>

            <div class="mb-2">
              <label>End Time</label>
              <input type="time" name="end_time" id="edit_end_time" class="form-control" required>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary">Update</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Bulk Create Datesheet Modal -->
    <div class="modal fade" id="bulkExamModal" tabindex="-1">
      <div class="modal-dialog modal-xl">
        <form id="bulkExamForm" action="{{ route('exam.timetable.bulkStore') }}" method="POST">
          @csrf
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Create Datesheet for Class</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
              <div class="row mb-3">
                <div class="col-md-4">
                  <label>Class</label>
                  <select name="class" id="bulkClass" class="form-control" required>
                    <option value="">Select Class</option>
                    @foreach($classes as $class)
                      <option value="{{ $class->name }}">{{ $class->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-4">
                  <label>Stream</label>
                  <select name="stream" id="bulkStream" class="form-control" required></select>
                </div>
                <div class="col-md-4">
                  <label>Exam Type</label>
                  <select name="exam_type" id="bulkExamType" class="form-control" required>
                    <option value="">Select Exam Type</option>
                    @foreach($examTypes as $type)
                      <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div id="subjectsContainer" style="display:none;">
                <div class="alert alert-info">
                  <strong>Note:</strong> The exam type selected above will be applied to all subjects in this datesheet.
                </div>
                <table class="table table-bordered table-sm">
                  <thead class="table-light">
                    <tr>
                      <th>Subject</th>
                      <th>Date</th>
                      <th>Shift</th>
                      <th>Start Time</th>
                      <th>End Time</th>
                    </tr>
                  </thead>
                  <tbody id="subjectsTableBody"></tbody>
                </table>
              </div>
            </div>

            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Save Datesheet</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Bulk Edit Datesheet Modal -->
    <div class="modal fade" id="bulkEditModal" tabindex="-1">
      <div class="modal-dialog modal-xl">
        <form id="bulkEditForm" action="{{ route('exam.timetable.bulkUpdate') }}" method="POST">
          @csrf
          @method('PUT')
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Datesheet for Class</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
              <div class="row mb-3">
                <div class="col-md-4">
                  <label>Class</label>
                  <select name="class" id="editBulkClass" class="form-control" required>
                    <option value="">Select Class</option>
                    @foreach($classes as $class)
                      <option value="{{ $class->name }}">{{ $class->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-4">
                  <label>Stream</label>
                  <select name="stream" id="editBulkStream" class="form-control" required></select>
                </div>
                <div class="col-md-4">
                  <label>Exam Type</label>
                  <select name="exam_type" id="editBulkExamType" class="form-control" required>
                    <option value="">Select Exam Type</option>
                    @foreach($examTypes as $type)
                      <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div id="editSubjectsContainer" style="display:none;">
                <div class="alert alert-warning">
                  <strong>Note:</strong> This will update all existing exam entries for the selected class, stream, and exam type.
                </div>
                <table class="table table-bordered table-sm">
                  <thead class="table-light">
                    <tr>
                      <th>Subject</th>
                      <th>Date</th>
                      <th>Shift</th>
                      <th>Start Time</th>
                      <th>End Time</th>
                    </tr>
                  </thead>
                  <tbody id="editSubjectsTableBody"></tbody>
                </table>
              </div>
            </div>

            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Update Datesheet</button>
            </div>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>
</div>
@include('admin.footer')

<script>
$(document).ready(function() {
  // Initialize DataTable
  let examTable = $('#examTable').DataTable({
    responsive: true,
    ordering: true,
    searching: true,
    paging: true,
    processing: true,
    pageLength: 10,
    lengthMenu: [5, 10, 25, 50, 100],
    order: [[5, 'asc'], [6, 'asc']], // Sort by date then shift
    language: {
      processing: "<span class='text-primary fw-bold'>⏳ Processing...</span>",
      search: "🔍 Search:",
      lengthMenu: "Show _MENU_ entries",
      zeroRecords: "No records found.",
      info: "Showing _START_ to _END_ of _TOTAL_",
      infoEmpty: "No data available",
      infoFiltered: "(filtered from _MAX_ total records)"
    },
    columnDefs: [
      { targets: 'no-sort', orderable: false }
    ],
    initComplete: function () {
      $('.dataTables_length select').addClass('form-select form-select-sm shadow-sm mx-2');
      $('.dataTables_filter input').addClass('form-control form-control-sm shadow-sm').attr('placeholder', 'Search exams...');
      $('.dataTables_length label, .dataTables_filter label').addClass('d-flex align-items-center');
    }
  });

  // View Mode Toggle
  $('#viewMode').change(function() {
    const mode = $(this).val();
    $('.view-container').hide();
    
    switch(mode) {
      case 'table':
        $('#tableView').show();
        break;
      case 'class':
        $('#classView').show();
        loadClassWiseView();
        break;
      case 'date':
        $('#dateView').show();
        loadDateWiseView();
        break;
    }
  });

  // Filter functionality
  $('#filterClass, #filterStream, #filterExamType').change(function() {
    applyFilters();
    
    // Update view if not in table mode
    const viewMode = $('#viewMode').val();
    if (viewMode === 'class') {
      loadClassWiseView();
    } else if (viewMode === 'date') {
      loadDateWiseView();
    }
  });

  // Filter class change - update stream dropdown
  $('#filterClass').change(function() {
    const classVal = $(this).val();
    $('#filterStream').empty().append('<option value="">All Streams</option>');
    
    if (classVal) {
      $.post('/exam-timetable/get-streams', {
        _token: '{{ csrf_token() }}',
        class: classVal
      }, function(data) {
        data.forEach(stream => {
          $('#filterStream').append(`<option value="${stream}">${stream}</option>`);
        });
      });
    }
  });

  function applyFilters() {
    const classFilter = $('#filterClass').val();
    const streamFilter = $('#filterStream').val();
    const examTypeFilter = $('#filterExamType').val();
    
    examTable.rows().every(function() {
      const row = this.node();
      const rowClass = $(row).data('class');
      const rowStream = $(row).data('stream');
      const rowExamType = $(row).data('exam-type');
      
      let show = true;
      
      if (classFilter && rowClass !== classFilter) show = false;
      if (streamFilter && rowStream !== streamFilter) show = false;
      if (examTypeFilter && rowExamType !== examTypeFilter) show = false;
      
      if (show) {
        $(row).show();
      } else {
        $(row).hide();
      }
    });
    
    examTable.draw();
  }

  function loadClassWiseView() {
    const classFilter = $('#filterClass').val();
    const streamFilter = $('#filterStream').val();
    const examTypeFilter = $('#filterExamType').val();
    
    $.post('/exam-timetable/get-class-wise-view', {
      _token: '{{ csrf_token() }}',
      class: classFilter,
      stream: streamFilter,
      exam_type: examTypeFilter
    }, function(data) {
      let html = '';
      
      Object.keys(data).forEach(className => {
        Object.keys(data[className]).forEach(streamName => {
          Object.keys(data[className][streamName]).forEach(examType => {
            const exams = data[className][streamName][examType];
            
            html += `
              <div class="card mb-4">
                <div class="card-header bg-gradient-primary text-white">
                  <h5 class="mb-0">
                    <i class="mdi mdi-school"></i> ${className}
                    ${streamName !== 'null' ? ` - ${streamName}` : ''}
                    <span class="badge bg-light text-dark ms-2">${examType}</span>
                  </h5>
                </div>
                <div class="card-body">
                  <div class="row">
            `;
            
            // Group by date and shift
            const groupedByDate = {};
            exams.forEach(exam => {
              const date = exam.exam_date;
              if (!groupedByDate[date]) {
                groupedByDate[date] = { Morning: [], Evening: [] };
              }
              groupedByDate[date][exam.shift].push(exam);
            });
            
            Object.keys(groupedByDate).sort().forEach(date => {
              const formattedDate = new Date(date).toLocaleDateString('en-GB');
              
              html += `
                <div class="col-md-6 mb-3">
                  <div class="border rounded p-3 h-100">
                    <h6 class="text-primary mb-3">
                      <i class="mdi mdi-calendar"></i> ${formattedDate}
                    </h6>
              `;
              
              ['Morning', 'Evening'].forEach(shift => {
                if (groupedByDate[date][shift].length > 0) {
                  html += `
                    <div class="mb-2">
                      <span class="badge ${shift === 'Morning' ? 'bg-warning' : 'bg-secondary'} mb-2">
                        ${shift} Shift
                      </span>
                      <ul class="list-unstyled ms-3">
                  `;
                  
                  groupedByDate[date][shift].forEach(exam => {
                    const startTime = new Date('1970-01-01T' + exam.start_time).toLocaleTimeString('en-US', {
                      hour: 'numeric', minute: '2-digit', hour12: true
                    });
                    const endTime = new Date('1970-01-01T' + exam.end_time).toLocaleTimeString('en-US', {
                      hour: 'numeric', minute: '2-digit', hour12: true
                    });
                    
                    html += `
                      <li class="mb-1">
                        <strong>${exam.subject}</strong><br>
                        <small class="text-muted">${startTime} - ${endTime}</small>
                      </li>
                    `;
                  });
                  
                  html += `
                      </ul>
                    </div>
                  `;
                }
              });
              
              html += `
                  </div>
                </div>
              `;
            });
            
            html += `
                  </div>
                </div>
              </div>
            `;
          });
        });
      });
      
      $('#classViewContent').html(html || '<div class="alert alert-info">No exam schedules found for the selected criteria.</div>');
    });
  }

  function loadDateWiseView() {
    const classFilter = $('#filterClass').val();
    const streamFilter = $('#filterStream').val();
    const examTypeFilter = $('#filterExamType').val();
    
    $.post('/exam-timetable/get-date-wise-view', {
      _token: '{{ csrf_token() }}',
      class: classFilter,
      stream: streamFilter,
      exam_type: examTypeFilter
    }, function(data) {
      let html = '';
      
      Object.keys(data).sort().forEach(date => {
        const formattedDate = new Date(date).toLocaleDateString('en-GB', {
          weekday: 'long',
          year: 'numeric',
          month: 'long',
          day: 'numeric'
        });
        
        html += `
          <div class="card mb-4">
            <div class="card-header bg-gradient-info text-white">
              <h5 class="mb-0">
                <i class="mdi mdi-calendar-today"></i> ${formattedDate}
              </h5>
            </div>
            <div class="card-body">
              <div class="row">
        `;
        
        ['Morning', 'Evening'].forEach(shift => {
          if (data[date][shift] && data[date][shift].length > 0) {
            html += `
              <div class="col-md-6">
                <div class="border rounded p-3 mb-3">
                  <h6 class="mb-3">
                    <span class="badge ${shift === 'Morning' ? 'bg-warning' : 'bg-secondary'}">
                      ${shift} Shift
                    </span>
                  </h6>
                  <div class="table-responsive">
                    <table class="table table-sm">
                      <thead>
                        <tr>
                          <th>Class</th>
                          <th>Subject</th>
                          <th>Time</th>
                        </tr>
                      </thead>
                      <tbody>
            `;
            
            data[date][shift].forEach(exam => {
              const startTime = new Date('1970-01-01T' + exam.start_time).toLocaleTimeString('en-US', {
                hour: 'numeric', minute: '2-digit', hour12: true
              });
              const endTime = new Date('1970-01-01T' + exam.end_time).toLocaleTimeString('en-US', {
                hour: 'numeric', minute: '2-digit', hour12: true
              });
              
              html += `
                <tr>
                  <td>
                    <strong>${exam.class}</strong>
                    ${exam.stream ? `<br><small class="text-muted">${exam.stream}</small>` : ''}
                  </td>
                  <td>${exam.subject}</td>
                  <td><small>${startTime} - ${endTime}</small></td>
                </tr>
              `;
            });
            
            html += `
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            `;
          }
        });
        
        html += `
              </div>
            </div>
          </div>
        `;
      });
      
      $('#dateViewContent').html(html || '<div class="alert alert-info">No exam schedules found for the selected criteria.</div>');
    });
  }

  // Print functionality
$('#printDatesheet').click(function () {
  const viewMode = $('#viewMode').val();
  let printContent = '';

  // Extract selected filters for title (optional)
  const selectedClass = $('#filterClass').val() || 'All Classes';
  const selectedStream = $('#filterStream').val() || 'All Streams';

  // Datesheet table content
  if (viewMode === 'class') {
    printContent = $('#classViewContent').html();
  } else if (viewMode === 'date') {
    printContent = $('#dateViewContent').html();
  } else {
    // Standard table view
    printContent += `
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Class</th>
            <th>Stream</th>
            <th>Subject</th>
            <th>Exam Type</th>
            <th>Date</th>
            <th>Shift</th>
            <th>Time</th>
          </tr>
        </thead>
        <tbody>
    `;

    $('#examTable tbody tr:visible').each(function () {
      const cells = $(this).find('td');
      printContent += '<tr>';
      for (let i = 1; i < cells.length - 1; i++) {
        printContent += '<td>' + $(cells[i]).text().trim() + '</td>';
      }
      printContent += '</tr>';
    });

    printContent += '</tbody></table>';
  }

  // Open new window and inject layout
  const printWindow = window.open('', '_blank');
  printWindow.document.write(`
    <html>
      <head>
        <title>Exam Datesheet</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
          body {
            font-family: 'Segoe UI', sans-serif;
            font-size: 13px;
            margin: 40px;
            color: #000;
          }
          .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
          }
          .header h3, .header p {
            margin: 0;
            line-height: 1.4;
          }
          .datesheet-title {
            text-align: center;
            margin-top: 10px;
            margin-bottom: 10px;
            font-weight: bold;
            font-size: 16px;
            text-decoration: underline;
          }
          table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
          }
          th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
          }
          th {
            background-color: #f0f0f0;
          }
          .footer {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            font-size: 13px;
          }
          .footer div {
            width: 45%;
            text-align: center;
          }
          @media print {
            .no-print { display: none; }
            body {
              -webkit-print-color-adjust: exact !important;
              print-color-adjust: exact !important;
            }
          }
        </style>
      </head>
      <body>
        <div class="header">
          <img src="https://via.placeholder.com/80x80" style="float:left;margin-right:10px;" />
          <h3>Tejas Public School</h3>
          <p>Ward No. 12, Basant Colony, India</p>
          <p>Email: school@example.com | Phone: 0123-456789</p>
        </div>

        <div class="datesheet-title">Exam Datesheet (${selectedClass} - ${selectedStream})</div>

        ${printContent}

        <div class="footer">
          <div>
            <br><br>
            _______________________<br>
            Exam Incharge
          </div>
          <div>
            <br><br>
            _______________________<br>
            Principal
          </div>
        </div>
      </body>
    </html>
  `);
  printWindow.document.close();
  printWindow.focus();
  printWindow.print();
});

});

// JS for dependent dropdowns
$('#classSelect').change(function () {
  var classVal = $(this).val();
  $('#streamSelect').empty();
  $('#subjectSelect').empty();
  if (classVal !== '') {
    $.post('/exam-timetable/get-streams', {
      _token: '{{ csrf_token() }}',
      class: classVal
    }, function (data) {
      $('#streamSelect').append('<option value="">Select</option>');
      data.forEach(stream => {
        $('#streamSelect').append(`<option value="${stream}">${stream}</option>`);
      });
    });
  }
});

$('#streamSelect').change(function () {
  var classVal = $('#classSelect').val();
  var streamVal = $(this).val();
  $('#subjectSelect').empty();
  if (classVal && streamVal) {
    $.post('/exam-timetable/get-subjects', {
      _token: '{{ csrf_token() }}',
      class: classVal,
      stream: streamVal
    }, function (data) {
      data.forEach(subject => {
        $('#subjectSelect').append(`<option value="${subject}">${subject}</option>`);
      });
    });
  }
});

// Edit Single Exam Script
$(document).on('click', '.editExamBtn', function () {
  let id = $(this).data('id');
  let className = $(this).data('class');
  let stream = $(this).data('stream');
  let subject = $(this).data('subject');
  let examType = $(this).data('exam_type');
  let examDate = $(this).data('exam_date');
  let shift = $(this).data('shift');
  let startTime = $(this).data('start_time');
  let endTime = $(this).data('end_time');

  $('#edit_exam_id').val(id);
  $('#edit_class').val(className);
  $('#edit_stream').val(stream);
  $('#edit_subject').val(subject);
  $('#edit_exam_type').val(examType);
  $('#edit_exam_date').val(examDate);
  $('#edit_shift').val(shift);
  $('#edit_start_time').val(startTime);
  $('#edit_end_time').val(endTime);

  $('#editExamForm').attr('action', '/exam-timetable/update/' + id);
});

// Bulk Create Datesheet Script
$('#bulkClass').change(function () {
  const classVal = $(this).val();
  $('#bulkStream').empty().append('<option value="">Select</option>');
  $('#subjectsContainer').hide();
  $('#subjectsTableBody').empty();
  if (classVal) {
    $.post('/exam-timetable/get-streams', {
      _token: '{{ csrf_token() }}',
      class: classVal
    }, function (data) {
      data.forEach(stream => {
        $('#bulkStream').append(`<option value="${stream}">${stream}</option>`);
      });
    });
  }
});

$('#bulkStream').change(function () {
  const classVal = $('#bulkClass').val();
  const streamVal = $(this).val();
  const examType = $('#bulkExamType').val();
  $('#subjectsTableBody').empty();
  
  if (classVal && streamVal && examType) {
    loadSubjectsForBulkCreate(classVal, streamVal);
  }
});

$('#bulkExamType').change(function () {
  const classVal = $('#bulkClass').val();
  const streamVal = $('#bulkStream').val();
  const examType = $(this).val();
  
  if (classVal && streamVal && examType) {
    loadSubjectsForBulkCreate(classVal, streamVal);
  }
});

function loadSubjectsForBulkCreate(classVal, streamVal) {
  $.post('/exam-timetable/get-subjects', {
    _token: '{{ csrf_token() }}',
    class: classVal,
    stream: streamVal
  }, function (subjects) {
    $('#subjectsContainer').show();
    $('#subjectsTableBody').empty();

    subjects.forEach((subject, index) => {
      const rowId = `row-${index}`;
      $('#subjectsTableBody').append(`
        <tr id="${rowId}">
          <td>
            <input type="hidden" name="subjects[]" value="${subject}">
            ${subject}
          </td>
          <td><input type="date" name="exam_dates[]" class="form-control" required></td>
          <td>
            <select name="shifts[]" class="form-select form-select-sm" required>
              <option value="">Select Shift</option>
              <option value="Morning">Morning</option>
              <option value="Evening">Evening</option>
            </select>
          </td>
          <td>
            <input type="time" name="start_times[]" class="form-control start-time" data-index="${index}" required>
          </td>
          <td>
            <input type="time" name="end_times[]" class="form-control end-time" data-index="${index}" required>
          </td>
        </tr>
      `);
    });

    // Attach onchange to all newly added start time inputs
    $('.start-time').on('change', function () {
      const index = $(this).data('index');
      const startTime = $(this).val();
      if (startTime) {
        const [hours, minutes] = startTime.split(':').map(Number);
        const startDate = new Date(0, 0, 0, hours, minutes);
        startDate.setHours(startDate.getHours() + 3); // Add 3 hours

        const endHours = String(startDate.getHours()).padStart(2, '0');
        const endMinutes = String(startDate.getMinutes()).padStart(2, '0');
        const endTime = `${endHours}:${endMinutes}`;

        $(`.end-time[data-index="${index}"]`).val(endTime);
      }
    });
  });
}


// Bulk Edit Datesheet Script
$('#editBulkClass').change(function () {
  const classVal = $(this).val();
  $('#editBulkStream').empty().append('<option value="">Select</option>');
  $('#editBulkExamType').empty().append('<option value="">Select Exam Type</option>');
  $('#editSubjectsContainer').hide();
  $('#editSubjectsTableBody').empty();
  
  if (classVal) {
    $.post('/exam-timetable/get-streams', {
      _token: '{{ csrf_token() }}',
      class: classVal
    }, function (data) {
      data.forEach(stream => {
        $('#editBulkStream').append(`<option value="${stream}">${stream}</option>`);
      });
    });
  }
});

$('#editBulkStream').change(function () {
  const classVal = $('#editBulkClass').val();
  const streamVal = $(this).val();
  $('#editBulkExamType').empty().append('<option value="">Select Exam Type</option>');
  $('#editSubjectsContainer').hide();
  $('#editSubjectsTableBody').empty();
  
  if (classVal && streamVal) {
    // Get available exam types for this class and stream
    $.post('/exam-timetable/get-exam-types', {
      _token: '{{ csrf_token() }}',
      class: classVal,
      stream: streamVal
    }, function (examTypes) {
      examTypes.forEach(examType => {
        $('#editBulkExamType').append(`<option value="${examType}">${examType}</option>`);
      });
    });
  }
});

$('#editBulkExamType').change(function () {
  const classVal = $('#editBulkClass').val();
  const streamVal = $('#editBulkStream').val();
  const examType = $(this).val();
  
  if (classVal && streamVal && examType) {
    loadDatesheetForEdit(classVal, streamVal, examType);
  }
});

function loadDatesheetForEdit(classVal, streamVal, examType) {
  $.post('/exam-timetable/get-datesheet-entries', {
    _token: '{{ csrf_token() }}',
    class: classVal,
    stream: streamVal,
    exam_type: examType
  }, function (entries) {
    $('#editSubjectsContainer').show();
    $('#editSubjectsTableBody').empty();
    
    if (entries.length > 0) {
      entries.forEach(entry => {
        $('#editSubjectsTableBody').append(`
          <tr>
            <td>
              <input type="hidden" name="exam_ids[]" value="${entry.id}">
              <input type="hidden" name="subjects[]" value="${entry.subject}">
              ${entry.subject}
            </td>
            <td><input type="date" name="exam_dates[]" class="form-control" value="${entry.exam_date}" required></td>
            <td>
              <select name="shifts[]" class="form-control" required>
                <option value="Morning" ${entry.shift === 'Morning' ? 'selected' : ''}>Morning</option>
                <option value="Evening" ${entry.shift === 'Evening' ? 'selected' : ''}>Evening</option>
              </select>
            </td>
            <td><input type="time" name="start_times[]" class="form-control" value="${entry.start_time}" required></td>
            <td><input type="time" name="end_times[]" class="form-control" value="${entry.end_time}" required></td>
          </tr>
        `);
      });
    } else {
      $('#editSubjectsTableBody').append(`
        <tr>
          <td colspan="5" class="text-center text-muted">No datesheet found for the selected criteria.</td>
        </tr>
      `);
    }
  });
}
</script>