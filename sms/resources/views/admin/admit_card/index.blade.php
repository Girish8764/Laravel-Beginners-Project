{{-- resources/views/admin/admit_card/index.blade.php --}}
@include('admin.header')
@include('admin.sidebar')

<style>
@media print {
  body * {
    visibility: hidden;
  }

  #printableArea, #printableArea * {
    visibility: visible;
  }

  #printableArea {
    position: absolute;
    top: 0;
    left: 0;
    width: 210mm;
    height: 297mm;
    padding: 5mm;
    background: white;
    box-sizing: border-box;
  }

  .modal,
  .modal-backdrop {
    display: none !important;
  }

  .btn,
  .btn-close,
  .no-print {
    display: none !important;
  }

  @page {
    size: A4 portrait;
    margin: 0;
  }

  html, body {
    overflow: hidden !important;
  }

  /* Single admit card takes half page */
  .single-admit-card {
    height: 140mm !important;
    page-break-after: always;
    border-bottom: 2px dashed #000;
    margin-bottom: 5mm;
    padding-bottom: 5mm;
  }

  .single-admit-card:last-child {
    page-break-after: avoid;
    border-bottom: none;
    margin-bottom: 0;
  }

  /* Two column layout for student details */
  .student-details-columns {
    display: flex !important;
    justify-content: space-between !important;
    gap: 10px !important;
  }

  .student-details-left,
  .student-details-right {
    flex: 1 !important;
  }
}

/* Print all styles - Two cards per page */
@media print {
  .print-all-container {
    display: block !important;
  }
  
  .print-all-container .admit-card-item {
    height: 140mm;
    page-break-inside: avoid;
    border-bottom: 2px dashed #000;
    margin-bottom: 5mm;
    padding-bottom: 5mm;
  }

  /* Every second card should break to new page */
  .print-all-container .admit-card-item:nth-child(2n) {
    page-break-after: always;
    border-bottom: none;
  }

  .print-all-container .admit-card-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
  }
}

/* Reusable utility classes */
.text-center {
  text-align: center;
}

.text-start {
  text-align: left;
}

.text-end {
  text-align: right;
}

.fw-bold {
  font-weight: bold;
}

.mb-0 {
  margin-bottom: 0;
}

.mb-1 {
  margin-bottom: 0.25rem;
}

.mt-2 {
  margin-top: 0.5rem;
}

.mt-3 {
  margin-top: 1rem;
}

.mt-5 {
  margin-top: 3rem;
}

.small {
  font-size: 11px;
}

.d-flex {
  display: flex;
}

.justify-content-between {
  justify-content: space-between;
}

.align-items-center {
  align-items: center;
}

.flex-grow-1 {
  flex-grow: 1;
}

/* Table */
table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  border: 1px solid #ccc;
  padding: 4px;
  font-size: 10px;
}

/* Compact admit card styles */
.compact-header {
  margin-bottom: 8px;
}

.compact-title {
  font-size: 14px;
  margin: 5px 0;
}

.compact-info {
  font-size: 10px;
  line-height: 1.2;
}

.student-details-columns {
  display: flex;
  justify-content: space-between;
  gap: 15px;
  margin-bottom: 10px;
}

.student-details-left,
.student-details-right {
  flex: 1;
}

.student-details-left div,
.student-details-right div {
  margin-bottom: 3px;
  font-size: 10px;
}

.photo-container {
  width: 80px;
  height: 100px;
  border: 1px solid #000;
  margin: 0 auto;
}

.signature-section {
  margin-top: 20px;
  display: flex;
  justify-content: space-between;
}

.signature-box {
  width: 120px;
  text-align: center;
  border-top: 1px solid #000;
  padding-top: 5px;
  font-size: 9px;
}

/* Header layout improvements */
.school-header {
  display: flex;
  align-items: center;
  gap: 15px;
  margin-bottom: 8px;
}

.school-logo {
  width: 80px;
  flex-shrink: 0;
}

.school-info {
  flex: 1;
  text-align: center;
}

.school-codes {
  display: flex;
  justify-content: center;
  gap: 20px;
  margin-bottom: 5px;
  font-size: 10px;
}

.school-codes > div {
  white-space: nowrap;
}
</style>

<div class="main-panel">
  <div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="font-weight-bold text-dark">Generate Admit Cards</h4>
    </div>

    <form method="GET" action="{{ route('admit-cards.index') }}" class="row g-3 mb-4">
      <div class="col-md-4">
        <label class="form-label">Select Class</label>
        <select name="class" class="form-select" required>
          <option value="">-- Select Class --</option>
          @foreach($classes as $class)
            <option value="{{ $class->name }}" {{ request('class') == $class->name ? 'selected' : '' }}>
              {{ $class->name }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Select Stream</label>
        <select name="stream" class="form-select" required>
          <option value="">-- Select Stream --</option>
          <option value="General" {{ request('stream') == 'General' ? 'selected' : '' }}>General</option>
          <option value="Science" {{ request('stream') == 'Science' ? 'selected' : '' }}>Science</option>
          <option value="Commerce" {{ request('stream') == 'Commerce' ? 'selected' : '' }}>Commerce</option>
        </select>
      </div>
      <div class="col-md-3 align-self-end">
        <button type="submit" class="btn btn-primary btn-sm">Generate</button>
      </div>
    </form>

    @if(count($students))
    <div class="mb-3">
      <button 
        class="btn btn-primary btn-sm" 
        onclick="printAllAdmitCards()"
        id="printAllBtn">
        🖨️ Print All Admit Cards
      </button>
    </div>

    <div class="table-responsive">
      <table id="studentsTable" class="table table-bordered table-striped table-sm align-middle">
        <thead class="table-success">
          <tr>
            <th>#</th>
            <th>Student Name</th>
            <th>Father's Name</th>
            <th>Class</th>
            <th>Stream</th>
            <th>Gender</th>
            <th>Mobile</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($students as $index => $student)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $student->student_name }}</td>
            <td>{{ $student->father_name }}</td>
            <td>{{ $student->admission_class }}</td>
            <td>{{ $student->stream }}</td>
            <td>{{ $student->gender }}</td>
            <td>{{ $student->mobile }}</td>
            <td>
              <button 
                class="btn btn-sm btn-outline-primary admitCardBtn"
                data-bs-toggle="modal"
                data-bs-target="#admitCardModal"
                data-student="{{ $student->student_name }}"
                data-father="{{ $student->father_name }}"
                data-mother="{{ $student->mother_name }}"
                data-class="{{ $student->admission_class }}"
                data-stream="{{ $student->stream }}"
                data-rollno="{{ $student->rollno }}"
                data-gender="{{ $student->gender }}"
                data-dob="{{ $student->dob }}"
                data-category="{{ $student->category }}"
                data-session="{{ $student->session }}"
                data-mobile="{{ $student->mobile }}"
                data-address="{{ $student->address }}"
                data-photo="{{ $student->img ? asset($student->img) : '' }}"
                data-school="{{ $admin->school_name }}"
                data-logo="{{ asset($admin->image) }}"
                data-address-school="{{ $admin->address }}, {{ $admin->village }}, {{ $admin->district }}, {{ $admin->state }}"
                data-phone="{{ $admin->phone }}"
                data-email="{{ $admin->email }}"
                data-affno="{{ $admin->Aff_no }}"
                data-schcode="{{ $admin->Sch_code }}"
                data-pspcode="{{ $admin->Psp_code }}"
                data-student-id="{{ $student->id }}"
              >
                Print Admit Card
              </button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- Hidden container for print all functionality -->
    <div id="printAllContainer" class="print-all-container" style="display: none;">
      <!-- This will be populated by JavaScript -->
    </div>
    @endif
  </div>
</div>
</div>
@include('admin.footer')

<!-- Admit Card Modal -->
<div class="modal fade" id="admitCardModal" tabindex="-1" aria-labelledby="admitCardModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content p-3">
      <div class="text-end">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="admitCardContent">
        <div id="printableArea">
          <div class="single-admit-card">
            
            <!-- Improved School Header -->
            <div class="school-header">
              <div class="school-logo">
                <img id="schoolLogo" src="" alt="School Logo" style="height: 50px; width: 80px; object-fit: contain;">
              </div>
              
              <div class="school-info">
                <style>
  .school-codes {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
  }

  .school-codes > div {
    width: 33%;
    text-align: center;
    font-weight: bold;
  }
</style>

<div class="school-codes">
  <div>Aff No: <span id="schoolAffNo">12345</span></div>
  <div>Sch Code: <span id="schoolSchCode">SC6789</span></div>
  <div>PSP Code: <span id="schoolPspCode">PSP001</span></div>
</div>

                
                <h5 class="fw-bold mb-1 compact-title" id="schoolName">School Name</h5>
                <p class="mb-0 compact-info" id="schoolAddress">Full Address</p>
                <p class="mb-0 compact-info">
                  Email: <span id="schoolEmail"></span> | Phone: <span id="schoolPhone"></span>
                </p>
              </div>
            </div>

            <hr style="margin: 5px 0;">

            <!-- Admit Card Title -->
            <div class="text-center">
              <h6 class="fw-bold text-primary compact-title">ADMIT CARD <span id="cardSession"></span></h6>
            </div>

            <!-- Student Details in Two Columns with Photo -->
            <div class="d-flex justify-content-between mb-3">
              <div class="student-details-columns" style="flex: 1;">
                <div class="student-details-left">
                  <div><strong>Roll No:</strong> <span id="cardRoll"></span></div>
                  <div><strong>Class:</strong> <span id="cardClass"></span> (<span id="cardStream"></span>)</div>
                  
                  <div><strong>Father's Name:</strong> <span id="cardFather"></span></div>
                </div>
                <div class="student-details-right">
                  <div><strong>Student Name:</strong> <span id="cardStudent"></span></div>
                  <div><strong>Date of Birth:</strong> <span id="cardDOB"></span></div>
                  <!-- <div><strong>Gender:</strong> <span id="cardGender"></span></div> -->
                  <div><strong>Category:</strong> <span id="cardCategory"></span></div>
                </div>
              </div>
              <div class="text-center" style="margin-left: 10px;">
                <div class="photo-container">
                  <img id="studentPhoto" src="" alt="Student Photo" 
                       style="width: 100%; height: 100%; object-fit: cover; display: none;">
                  <div id="photoPlaceholder" class="d-flex align-items-center justify-content-center h-100">
                    <span class="text-muted compact-info"></span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Compact Exam Schedule -->
            <div class="mt-3">
              <!-- <h6 class="fw-bold text-primary" style="font-size: 12px;">EXAMINATION SCHEDULE</h6> -->
              <table class="table table-bordered">
                <thead class="table-light">
                  <tr>
                    <th style="width: 8%;">S.No.</th>
                    <th style="width: 25%;">Subject</th>
                    <th style="width: 15%;">Date</th>
                    <th style="width: 12%;">Day</th>
                    <th style="width: 20%;">Time</th>
                    <th style="width: 20%;">Teacher Signature</th>
                  </tr>
                </thead>
                <tbody id="examScheduleBody">
                  <!-- Schedule will be populated by JavaScript -->
                </tbody>
              </table>
            </div>
            <br><br>
            <!-- Compact Signatures -->
            <div class="signature-section">
              <div class="signature-box">
                <strong>Student's Signature</strong>
              </div>
              <div class="signature-box">
                <strong>Principal's Signature</strong>
              </div>
            </div>
          </div>
        </div>

        <!-- Print Button -->
        <div class="text-center mt-3 no-print">
          <button onclick="printAdmitCard()" class="btn btn-outline-primary btn-sm">🖨️ Print Admit Card</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// Store all students data for print all functionality
let allStudentsData = [];

$(document).ready(function() {
  // Store students data
  $('.admitCardBtn').each(function() {
    const studentData = {
      student: $(this).data('student'),
      father: $(this).data('father'),
      mother: $(this).data('mother'),
      class: $(this).data('class'),
      stream: $(this).data('stream'),
      rollno: $(this).data('rollno'),
      gender: $(this).data('gender'),
      dob: $(this).data('dob'),
      category: $(this).data('category'),
      session: $(this).data('session'),
      mobile: $(this).data('mobile'),
      address: $(this).data('address'),
      photo: $(this).data('photo'),
      school: $(this).data('school'),
      logo: $(this).data('logo'),
      addressSchool: $(this).data('address-school'),
      phone: $(this).data('phone'),
      email: $(this).data('email'),
      affno: $(this).data('affno'),
      schcode: $(this).data('schcode'),
      pspcode: $(this).data('pspcode'),
      studentId: $(this).data('student-id')
    };
    allStudentsData.push(studentData);
  });

  // Initialize DataTable
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
      search: "🔍 Search Student:",
      lengthMenu: "Show _MENU_ entries per page",
      zeroRecords: "No student found.",
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

  // Handle admit card button click
  $('.admitCardBtn').on('click', function() {
    populateAdmitCard(this);
  });
});

function populateAdmitCard(button) {
  // Student Info
  $('#cardStudent').text($(button).data('student'));
  $('#cardFather').text($(button).data('father'));
  $('#cardMother').text($(button).data('mother'));
  $('#cardClass').text($(button).data('class'));
  $('#cardStream').text($(button).data('stream'));
  $('#cardRoll').text($(button).data('rollno') || 'N/A');
  $('#cardDOB').text($(button).data('dob'));
  $('#cardGender').text($(button).data('gender'));
  $('#cardCategory').text($(button).data('category'));
  $('#cardSession').text($(button).data('session'));
  $('#cardMobile').text($(button).data('mobile'));

  // School Info
  $('#schoolName').text($(button).data('school'));
  $('#schoolLogo').attr('src', $(button).data('logo'));
  $('#schoolAddress').text($(button).data('address-school'));
  $('#schoolPhone').text($(button).data('phone'));
  $('#schoolEmail').text($(button).data('email'));
  $('#schoolAffNo').text($(button).data('affno'));
  $('#schoolSchCode').text($(button).data('schcode'));
  $('#schoolPspCode').text($(button).data('pspcode'));

  // Student Photo
  const photoUrl = $(button).data('photo');
  if (photoUrl) {
    $('#studentPhoto').attr('src', photoUrl).show();
    $('#photoPlaceholder').hide();
  } else {
    $('#studentPhoto').hide();
    $('#photoPlaceholder').show();
  }

  // Fetch and populate exam schedule
  const studentId = $(button).data('student-id');
  fetchExamSchedule(studentId);
}

function fetchExamSchedule(studentId) {
  $('#examScheduleBody').html('<tr><td colspan="6" class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</td></tr>');
  
  const csrfToken = $('meta[name="csrf-token"]').attr('content');
  
  fetch(`/admin/admit-cards/exam-schedule/${studentId}`, {
    method: 'GET',
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrfToken,
      'X-Requested-With': 'XMLHttpRequest'
    },
    credentials: 'same-origin'
  })
    .then(response => {
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      return response.json();
    })
    .then(data => {
      let scheduleHtml = '';
      
      if (data.error) {
        scheduleHtml = `<tr><td colspan="6" class="text-center text-danger">${data.error}</td></tr>`;
      } else if (Array.isArray(data) && data.length > 0) {
        data.forEach((exam, index) => {
          try {
            const examDate = new Date(exam.exam_date);
            const dayName = examDate.toLocaleDateString('en-US', { weekday: 'short' });
            const formattedDate = examDate.toLocaleDateString('en-GB');
            
            let timeRange = 'N/A';
            if (exam.start_time && exam.end_time) {
              try {
                const startTime = new Date(`2000-01-01T${exam.start_time}`).toLocaleTimeString('en-US', { 
                  hour: '2-digit', 
                  minute: '2-digit', 
                  hour12: true 
                });
                const endTime = new Date(`2000-01-01T${exam.end_time}`).toLocaleTimeString('en-US', { 
                  hour: '2-digit', 
                  minute: '2-digit', 
                  hour12: true 
                });
                timeRange = `${startTime} - ${endTime}`;
              } catch (timeError) {
                timeRange = `${exam.start_time} - ${exam.end_time}`;
              }
            }
            
            scheduleHtml += `
              <tr>
                <td>${index + 1}</td>
                <td>${exam.subject || 'N/A'}</td>
                <td>${formattedDate}</td>
                <td>${dayName} (${exam.shift})</td>
                <td>${timeRange}</td>
                <td></td>
              </tr>
            `;
          } catch (examError) {
            scheduleHtml += `
              <tr>
                <td>${index + 1}</td>
                <td colspan="5" class="text-center text-warning">Error processing exam data</td>
              </tr>
            `;
          }
        });
      } else {
        scheduleHtml = '<tr><td colspan="6" class="text-center text-muted">No exam schedule available</td></tr>';
      }
      
      $('#examScheduleBody').html(scheduleHtml);
    })
    .catch(error => {
      console.error('Fetch error:', error);
      let errorMessage = 'Error loading exam schedule';
      $('#examScheduleBody').html(`<tr><td colspan="6" class="text-center text-danger">${errorMessage}</td></tr>`);
    });
}

function createAdmitCardHTML(studentData, examSchedule = []) {
  return `
    <div class="admit-card-item">
      <!-- Improved School Header -->
      <div class="school-header">
        <div class="school-logo">
          <img src="${studentData.logo}" alt="School Logo" style="height: 50px; width: 80px; object-fit: contain;">
        </div>
        
        <div class="school-info">
          <style>
            .school-codes {
              display: flex;
              justify-content: space-between;
              margin-bottom: 10px;
            }

            .school-codes > div {
              width: 33%;
              text-align: center;
              font-weight: bold;
            }
          </style>

          <div class="school-codes">
            <div>Aff No: ${studentData.affno}</div>
            <div>Sch Code: ${studentData.schcode}</div>
            <div>PSP Code: ${studentData.pspcode}</div>
          </div>
         
          <h5 class="fw-bold mb-1 compact-title">${studentData.school}</h5>
          <p class="mb-0 compact-info">${studentData.addressSchool}</p>
          <p class="mb-0 compact-info">
            Email: ${studentData.email} | Phone: ${studentData.phone}
          </p>
        </div>
      </div>

      <hr style="margin: 5px 0;">

      <!-- Admit Card Title -->
      <div class="text-center">
        <h6 class="fw-bold text-primary compact-title">ADMIT CARD ${studentData.session}</h6>
      </div>

      <!-- Student Details with Photo -->
      <div class="d-flex justify-content-between mb-3">
        <div class="student-details-columns" style="flex: 1;">
          <div class="student-details-left">
            <div><strong>Roll No:</strong> ${studentData.rollno || 'N/A'}</div>
            <div><strong>Class:</strong> ${studentData.class} (${studentData.stream})</div>
            <div><strong>Father's Name:</strong> ${studentData.father}</div>
            
          </div>
          <div class="student-details-right">
            <div><strong>Student Name:</strong> ${studentData.student}</div>
            <div><strong>Date of Birth:</strong> ${studentData.dob}</div>
            <div><strong>Category:</strong> ${studentData.category}</div> 
            
          </div>
        </div>
        <div class="text-center" style="margin-left: 10px;">
          <div class="photo-container" style="width: 80px; height: 100px; border: 1px solid #ccc;">
            ${
              studentData.photo
                ? `<img src="${studentData.photo}" alt="Student Photo" style="width: 100%; height: 100%; object-fit: cover;">`
                : `<div class="d-flex align-items-center justify-content-center h-100"><span class="text-muted compact-info">Photo</span></div>`
            }
          </div>
        </div>
      </div>

      <!-- Exam Schedule -->
      <div class="mt-3">
      
        <table class="table table-bordered">
          <thead class="table-light">
            <tr>
              <th style="width: 8%;">S.No.</th>
              <th style="width: 25%;">Subject</th>
              <th style="width: 15%;">Date</th>
              <th style="width: 12%;">Day</th>
              <th style="width: 20%;">Time</th>
              <th style="width: 20%;">Teacher Signature</th>
            </tr>
          </thead>
          <tbody>
            ${
              examSchedule.length > 0
                ? examSchedule
                    .map(
                      (exam, index) => `
                  <tr>
                    <td>${index + 1}</td>
                    <td>${exam.subject || 'N/A'}</td>
                    <td>${new Date(exam.exam_date).toLocaleDateString('en-GB')}</td>
                    <td>${new Date(exam.exam_date).toLocaleDateString('en-US', { weekday: 'short' })}</td>
                    <td>${exam.start_time && exam.end_time ? `${exam.start_time} - ${exam.end_time}` : 'N/A'}</td>
                    <td></td>
                  </tr>
                `
                    )
                    .join('')
                : `<tr><td colspan="6" class="text-center text-muted">No exam schedule available</td></tr>`
            }
          </tbody>
        </table>
      </div>

      <!-- Signatures -->
      <div class="signature-section mt-4 d-flex justify-content-between">
        <div class="signature-box text-center">
          <strong>Student's Signature</strong>
        </div>
        <div class="signature-box text-center">
          <strong>Principal's Signature</strong>
        </div>
      </div>
    </div>
  `;
}
async function printAllAdmitCards() {
  if (allStudentsData.length === 0) {
    alert('No students data available');
    return;
  }

  // Show loading
  $('#printAllBtn').html('⏳ Please Wait...').prop('disabled', true);

  const printContainer = document.getElementById('printAllContainer');
  let allCardsHTML = '';

  // Process each student
  for (let i = 0; i < allStudentsData.length; i++) {
    const student = allStudentsData[i];
    
    try {
      // Fetch exam schedule for each student
      const response = await fetch(`/admin/admit-cards/exam-schedule/${student.studentId}`, {
        method: 'GET',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
      });

      let examSchedule = [];
      if (response.ok) {
        const data = await response.json();
        if (Array.isArray(data)) {
          examSchedule = data;
        }
      }

      allCardsHTML += createAdmitCardHTML(student, examSchedule);
    } catch (error) {
      console.error('Error fetching schedule for student:', student.student, error);
      allCardsHTML += createAdmitCardHTML(student, []);
    }
  }

  printContainer.innerHTML = allCardsHTML;

  // Print with updated styles
  const printWindow = window.open('', '', 'width=842,height=1190');
  printWindow.document.write(`
    <!DOCTYPE html>
    <html>
    <head>
      <title>Print All Admit Cards</title>
      <style>
        @page {
          size: A4 portrait;
          margin: 0;
        }
        
        body {
          font-family: Arial, sans-serif;
          font-size: 12px;
          margin: 0;
          padding: 5mm;
          background: white;
          line-height: 1.3;
        }
        
        .admit-card-item {
          height: 140mm;
          page-break-inside: avoid;
          border-bottom: 2px dashed #000;
          margin-bottom: 5mm;
          padding-bottom: 5mm;
        }
        
        .admit-card-item:nth-child(2n) {
          page-break-after: always;
          border-bottom: none;
        }
        
        .admit-card-item:last-child {
          border-bottom: none;
          margin-bottom: 0;
        }
        
        .school-header {
          display: flex;
          align-items: center;
          gap: 15px;
          margin-bottom: 8px;
        }
        
        .school-logo {
          width: 80px;
          flex-shrink: 0;
        }
        
        .school-info {
          flex: 1;
          text-align: center;
        }
        
        .school-codes {
          display: flex;
          justify-content: center;
          gap: 20px;
          margin-bottom: 5px;
          font-size: 10px;
        }
        
        .compact-title {
          font-size: 14px;
          margin: 5px 0;
          font-weight: bold;
        }
        
        .compact-info {
          font-size: 10px;
          line-height: 1.2;
          margin: 0;
        }
        
        .student-details-columns {
          display: flex;
          justify-content: space-between;
          gap: 15px;
          margin-bottom: 10px;
        }
        
        .student-details-left,
        .student-details-right {
          flex: 1;
        }
        
        .student-details-left div,
        .student-details-right div {
          margin-bottom: 3px;
          font-size: 10px;
        }
        
        .photo-container {
          width: 80px;
          height: 100px;
          border: 1px solid #000;
          margin: 0 auto;
          display: flex;
          align-items: center;
          justify-content: center;
        }
        
        .signature-section {
          margin-top: 20px;
          display: flex;
          justify-content: space-between;
        }
        
        .signature-box {
          width: 120px;
          text-align: center;
          border-top: 1px solid #000;
          padding-top: 5px;
          font-size: 9px;
          font-weight: bold;
        }
        
        table {
          width: 100%;
          border-collapse: collapse;
          margin-top: 10px;
        }
        
        th, td {
          border: 1px solid #ccc;
          padding: 4px;
          font-size: 10px;
          text-align: left;
        }
        
        .table-light th {
          background-color: #f8f9fa;
          font-weight: bold;
        }
        
        .text-center {
          text-align: center;
        }
        
        .text-primary {
          color: #0d6efd;
        }
        
        .text-muted {
          color: #6c757d;
        }
        
        .fw-bold {
          font-weight: bold;
        }
        
        .mb-0 { margin-bottom: 0; }
        .mb-1 { margin-bottom: 0.25rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-3 { margin-bottom: 1rem; }
        .mt-3 { margin-top: 1rem; }
        .mt-4 { margin-top: 1.5rem; }
        
        .d-flex {
          display: flex;
        }
        
        .justify-content-between {
          justify-content: space-between;
        }
        
        .align-items-center {
          align-items: center;
        }
        
        .h-100 {
          height: 100%;
        }
        
        hr {
          border: none;
          border-top: 1px solid #000;
          margin: 5px 0;
        }
      </style>
    </head>
    <body>
      ${allCardsHTML}
    </body>
    </html>
  `);
  
  printWindow.document.close();
  
  // Wait for images to load before printing
  setTimeout(() => {
    printWindow.focus();
    printWindow.print();
    printWindow.close();
    
    // Reset button
    $('#printAllBtn').html('🖨️ Print All Admit Cards').prop('disabled', false);
  }, 1000);
}

function printAdmitCard() {
  // Get the printable area content
  const printContent = document.getElementById('printableArea').innerHTML;
  
  // Create print window with proper styles
  const printWindow = window.open('', '', 'width=842,height=1190');
  printWindow.document.write(`
    <!DOCTYPE html>
    <html>
    <head>
      <title>Print Admit Card</title>
      <style>
        @page {
          size: A4 portrait;
          margin: 5mm;
        }
        
        body {
          font-family: Arial, sans-serif;
          font-size: 12px;
          margin: 0;
          padding: 0;
          background: white;
          line-height: 1.3;
        }
        
        .single-admit-card {
          width: 100%;
          height: auto;
          padding: 0;
          margin: 0;
        }
        
        .school-header {
          display: flex;
          align-items: center;
          gap: 15px;
          margin-bottom: 8px;
        }
        
        .school-logo {
          width: 80px;
          flex-shrink: 0;
        }
        
        .school-info {
          flex: 1;
          text-align: center;
        }
        
        .school-codes {
          display: flex;
          justify-content: center;
          gap: 20px;
          margin-bottom: 5px;
          font-size: 10px;
        }
        
        .compact-title {
          font-size: 14px;
          margin: 5px 0;
          font-weight: bold;
        }
        
        .compact-info {
          font-size: 10px;
          line-height: 1.2;
          margin: 0;
        }
        
        .student-details-columns {
          display: flex;
          justify-content: space-between;
          gap: 15px;
          margin-bottom: 10px;
        }
        
        .student-details-left,
        .student-details-right {
          flex: 1;
        }
        
        .student-details-left div,
        .student-details-right div {
          margin-bottom: 3px;
          font-size: 10px;
        }
        
        .photo-container {
          width: 80px;
          height: 100px;
          border: 1px solid #000;
          margin: 0 auto;
          display: flex;
          align-items: center;
          justify-content: center;
        }
        
        .signature-section {
          margin-top: 20px;
          display: flex;
          justify-content: space-between;
        }
        
        .signature-box {
          width: 120px;
          text-align: center;
          border-top: 1px solid #000;
          padding-top: 5px;
          font-size: 9px;
          font-weight: bold;
        }
        
        table {
          width: 100%;
          border-collapse: collapse;
          margin-top: 10px;
        }
        
        th, td {
          border: 1px solid #ccc;
          padding: 4px;
          font-size: 10px;
          text-align: left;
        }
        
        .table-light th {
          background-color: #f8f9fa;
          font-weight: bold;
        }
        
        .text-center { text-align: center; }
        .text-primary { color: #0d6efd; }
        .text-muted { color: #6c757d; }
        .fw-bold { font-weight: bold; }
        .mb-0 { margin-bottom: 0; }
        .mb-1 { margin-bottom: 0.25rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-3 { margin-bottom: 1rem; }
        .mt-3 { margin-top: 1rem; }
        .mt-4 { margin-top: 1.5rem; }
        .d-flex { display: flex; }
        .justify-content-between { justify-content: space-between; }
        .align-items-center { align-items: center; }
        .h-100 { height: 100%; }
        
        hr {
          border: none;
          border-top: 1px solid #000;
          margin: 5px 0;
        }
      </style>
    </head>
    <body>
      ${printContent}
    </body>
    </html>
  `);
  
  printWindow.document.close();
  
  // Wait for images to load before printing
  setTimeout(() => {
    printWindow.focus();
    printWindow.print();
    printWindow.close();
  }, 500);
}

// Helper function to format date
function formatDate(dateString) {
  try {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-GB'); // DD/MM/YYYY format
  } catch (error) {
    return dateString;
  }
}

// Helper function to format time
function formatTime(timeString) {
  try {
    const time = new Date(`2000-01-01T${timeString}`);
    return time.toLocaleTimeString('en-US', { 
      hour: '2-digit', 
      minute: '2-digit', 
      hour12: true 
    });
  } catch (error) {
    return timeString;
  }
}

// Helper function to get day name
function getDayName(dateString) {
  try {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { weekday: 'short' });
  } catch (error) {
    return 'N/A';
  }
}
</script>