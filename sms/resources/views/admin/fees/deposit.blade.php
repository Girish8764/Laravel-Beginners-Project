{{-- resources/views/admin/fees/deposit.blade.php --}}
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
    width: 210mm;        /* Full A4 width */
    height: 148.5mm;     /* Half A4 height */
    padding: 10mm;
    background: white;
    box-sizing: border-box;
  }

  .modal,
  .modal-backdrop {
    display: none !important;
  }

  .btn,
  .btn-close {
    display: none !important;
  }

  @page {
    size: A4 portrait;
    margin: 0;
  }

  html, body {
    overflow: hidden !important;
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

/* Affiliation/Code Row Styling */
.code-row {
  display: flex;
  justify-content: space-between;
  margin-top: 5px;
  font-size: 12px;
  text-align: center;
}

.code-col {
  width: 33.33%;
  font-size: 12px;
}

/* Table */
table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  border: 1px solid #ccc;
  padding: 4px;
  font-size: 12px;
}
</style>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="font-weight-bold text-dark">Student Fee Deposit</h4>
      <div>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#depositModal">
          + Deposit Fee
        </button>
      </div>
    </div>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
      <table id="studentsTable" class="table table-bordered table-striped table-sm align-middle">
        <thead class="table-success">
          <tr>
            <th>#</th>
            <th>Student</th>
            <th>Class</th>
            <th>Category</th>
            <th>Total Fee</th>
            <th>Paid</th>
            <th>Pending</th>
            <th>Status</th>
            <th>Slips</th>
          </tr>
        </thead>
        <tbody>
          @foreach($students as $student)
          @php
            $classCode = \DB::table('classes')
                          ->where('name', $student->admission_class)
                          ->value('code');

            $fee = App\Models\Fee::where('dice_code', $student->dice_code)
                     ->where('class_code', $classCode)
                     ->where(function($query) use ($student) {
                         $query->where('stream', $student->stream)
                               ->orWhereNull('stream')
                               ->orWhere('stream', '');
                     })
                     ->orderByRaw("FIELD(stream, ?, '', NULL)", [$student->stream])
                     ->first();

            $isRTE = strtoupper($student->category) === 'RTE';
            $total = 0;
            if ($fee) {
                if ($isRTE) {
                    $total = $fee->rte_fee + $fee->late_fee - $fee->concession_amount;
                } else {
                    $total = $fee->admission_fee + $fee->tuition_fee + $fee->late_fee - $fee->concession_amount;
                }
            }
            $total = max(0, $total);
            $paid = optional($student->feeDeposits)->sum('amount_paid') ?? 0;
            $pending = max(0, $total - $paid);

            $statusClass = '';
            $statusText = '';
            if ($pending == 0 && $total > 0) {
                $statusClass = 'text-success fw-bold';
                $statusText = 'Paid';
            } elseif ($pending > 0) {
                $statusClass = 'text-warning fw-bold';
                $statusText = 'Partial';
            } else {
                $statusClass = 'text-danger fw-bold';
                $statusText = 'Pending';
            }
          @endphp
          <tr class="{{ $isRTE ? 'table-danger' : '' }}">
            <td>{{ $loop->iteration }}</td>
            <td>{{ $student->student_name }}</td>
            <td>{{ $student->admission_class }}</td>
            <td><span class="badge {{ $isRTE ? 'bg-danger' : 'bg-primary' }}">{{ strtoupper($student->category) }}</span></td>
            <td>₹{{ number_format($total, 2) }}</td>
            <td>₹{{ number_format($paid, 2) }}</td>
            <td>₹{{ number_format($pending, 2) }}</td>
            <td><span class="{{ $statusClass }}">{{ $statusText }}</span></td>
            <td>
              @foreach($student->feeDeposits as $index => $deposit)
                <button 
                  class="btn btn-sm btn-outline-secondary mb-1 slipBtn"
                  data-bs-toggle="modal"
                  data-bs-target="#slipModal"

                  {{-- Student Info --}}
                  data-student="{{ $student->student_name }}"
                  data-father="{{ $student->father_name }}"
                  data-mother="{{ $student->mother_name }}"
                  data-class="{{ $student->admission_class }}"
                  data-rollno="{{ $student->rollno }}"
                  data-gender="{{ $student->gender }}"
                  data-dob="{{ $student->dob }}"
                  data-category="{{ $student->category }}"
                  data-session="{{ $student->session }}"
                  
                  {{-- Payment Info --}}
                  data-amount="{{ $deposit->amount_paid }}"
                  data-date="{{ $deposit->paid_on }}"
                  data-mode="{{ $deposit->payment_mode }}"
                  data-remarks="{{ $deposit->remarks }}"
                  data-pending="₹{{ number_format($pending, 2) }}"
                  data-total="{{ number_format($total, 2) }}"
                  data-late="{{ $fee->late_fee ?? 0 }}"
                  
                  {{-- School Info --}}
                  data-school="{{ $admin->school_name }}"
                  data-logo="{{ asset($admin->image) }}"
                  data-address="{{ $admin->address }}, {{ $admin->village }}, {{ $admin->district }}, {{ $admin->state }}"
                  data-phone="{{ $admin->phone }}"
                  data-email="{{ $admin->email }}"
                  data-affno="{{ $admin->Aff_no }}"
                  data-schcode="{{ $admin->Sch_code }}"
                  data-pspcode="{{ $admin->Psp_code }}"
                >
                  Slip {{ $index + 1 }}
                </button>
              @endforeach
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>
@include('admin.footer')
<!-- Fee Slip Modal -->
<div class="modal fade" id="slipModal" tabindex="-1" aria-labelledby="slipModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content p-3">
      <div class="text-end">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="slipContent">
        <div id="printableArea">
          <!-- School Header -->
          <div class="text-center">
            <img id="schoolLogo" src="" alt="School Logo" style="height: 80px;">
            <h4 class="fw-bold mb-1 mt-2" id="schoolName"></h4>
            <p class="mb-0 small text-muted" id="schoolAddress"></p>
            <p class="mb-0 small text-muted">
              Email: <span id="schoolEmail"></span> |
              Phone: <span id="schoolPhone"></span>
            </p>

            <!-- Affiliation Row -->
            <div class="d-flex justify-content-between mt-1">
              <div class="text-center" style="width: 33.33%; font-size: 12px;">
                Affiliation No: <span id="schoolAffNo"></span>
              </div>
              <div class="text-center" style="width: 33.33%; font-size: 12px;">
                School Code: <span id="schoolSchCode"></span>
              </div>
              <div class="text-center" style="width: 33.33%; font-size: 12px;">
                PSP Code: <span id="schoolPspCode"></span>
              </div>
            </div>
          </div>
          <hr>
          <!-- Student & Receipt Details -->
          <div class="row mb-3">
            <div class="col-md-6">
              <p><strong>Session:</strong> <span id="slipSession"></span></p>
              <p><strong>Class:</strong> <span id="slipClass">-</span></p>
              <p><strong>Roll No:</strong> <span id="slipRoll"></span></p>
              <p><strong>Student Name:</strong> <span id="slipStudent"></span></p>
              <p><strong>Father's Name:</strong> <span id="slipFather">-</span></p>
              <p><strong>Mother's Name:</strong> <span id="slipMother">-</span></p>
              <p><strong>DOB:</strong> <span id="slipDOB"></span></p>
              <p><strong>Gender:</strong> <span id="slipGender"></span></p>
              <p><strong>Category:</strong> <span id="slipCategory"></span></p>
            </div>
            <div class="col-md-6">
              <p><strong>Receipt No:</strong> <span id="slipNumber">Auto</span></p>
              <p><strong>Receipt Date:</strong> <span id="slipDate"></span></p>
              <p><strong>Payment Mode:</strong> <span id="slipMode"></span></p>
              <p><strong>Remarks / Note:</strong> <span id="slipRemarks"></span></p>
            </div>
          </div>

          <!-- Fee Table -->
          <table class="table table-bordered">
            <thead class="table-light">
              <tr>
                <th>Description</th>
                <th>Amount (₹)</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Fee Amount</td>
                <td id="slipTotal">0.00</td>
              </tr>
              <tr>
                <td>Late Fee</td>
                <td id="slipLate">0.00</td>
              </tr>
              <tr>
                <td>Amount Paid</td>
                <td><strong>₹<span id="slipAmount">0.00</span></strong></td>
              </tr>
              <tr>
                <td>Pending Fee</td>
                <td><span id="slipPending">0.00</span></td>
              </tr>
            </tbody>
          </table>

          <!-- Amount in Words -->
          <p class="mt-3"><strong>Amount in Words:</strong> <span id="amountInWords">-</span></p>

          <!-- Signature -->
          <div class="text-end mt-5">
            <p><strong>Authorized Signature</strong></p>
          </div>
        </div>

        <!-- Print Button -->
        <div class="text-center mt-3 no-print">
          <button onclick="printSlip()" class="btn btn-outline-primary btn-sm">🖨️ Print</button>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
function convertNumberToWords(amount) {
  const a = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten',
             'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
  const b = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

  if (isNaN(amount)) return 'Invalid Number';
  if (Number(amount) === 0) return 'Zero Only';
  if (amount.toString().length > 9) return 'Overflow';

  const num = ('000000000' + amount).substr(-9);
  const n = {
    crore: Number(num.substr(0, 2)),
    lakh: Number(num.substr(2, 2)),
    thousand: Number(num.substr(4, 2)),
    hundred: Number(num.substr(6, 1)),
    rest: Number(num.substr(7, 2)),
  };

  let str = '';

  if (n.crore) {
    str += (n.crore < 20) ? a[n.crore] : b[Math.floor(n.crore / 10)] + ' ' + a[n.crore % 10];
    str += ' Crore ';
  }

  if (n.lakh) {
    str += (n.lakh < 20) ? a[n.lakh] : b[Math.floor(n.lakh / 10)] + ' ' + a[n.lakh % 10];
    str += ' Lakh ';
  }

  if (n.thousand) {
    str += (n.thousand < 20) ? a[n.thousand] : b[Math.floor(n.thousand / 10)] + ' ' + a[n.thousand % 10];
    str += ' Thousand ';
  }

  if (n.hundred) {
    str += a[n.hundred] + ' Hundred ';
  }

  if (n.rest) {
    str += (str !== '' ? 'and ' : '') + ((n.rest < 20) ? a[n.rest] : b[Math.floor(n.rest / 10)] + ' ' + a[n.rest % 10]);
  }

  return str.trim() + ' Only';
}

  $(document).ready(function () {
    $('.slipBtn').on('click', function () {
      // Student
      $('#slipStudent').text($(this).data('student'));
      $('#slipFather').text($(this).data('father'));
      $('#slipMother').text($(this).data('mother'));
      $('#slipClass').text($(this).data('class'));
      $('#slipRoll').text($(this).data('rollno'));
      $('#slipDOB').text($(this).data('dob'));
      $('#slipGender').text($(this).data('gender'));
      $('#slipCategory').text($(this).data('category'));
      $('#slipSession').text($(this).data('session'));

      // Payment
      let amount = parseFloat($(this).data('amount')).toFixed(2);
      $('#slipAmount').text(amount);
      $('#slipDate').text($(this).data('date'));
      $('#slipMode').text($(this).data('mode') || '-');
      $('#slipRemarks').text($(this).data('remarks') || '-');
      $('#slipPending').text($(this).data('pending'));
      $('#slipTotal').text($(this).data('total').replace('₹', ''));
      $('#slipLate').text($(this).data('late') || '0.00');

      // School
      $('#schoolName').text($(this).data('school'));
      $('#schoolLogo').attr('src', $(this).data('logo'));
      $('#schoolAddress').text($(this).data('address'));
      $('#schoolPhone').text($(this).data('phone'));
      $('#schoolEmail').text($(this).data('email'));
      $('#schoolAffNo').text($(this).data('affno'));
      $('#schoolSchCode').text($(this).data('schcode'));
      $('#schoolPspCode').text($(this).data('pspcode'));

      // Amount in words
      $('#amountInWords').text(convertNumberToWords(Math.floor(amount)));
    });
  });

</script>

<script>
function printSlip() {
  const content = document.getElementById('printableArea').innerHTML;

  const printWindow = window.open('', '', 'width=842,height=595'); // A4 size

  printWindow.document.write(`
    <html>
    <head>
      <title>Print Fee Receipt</title>
      <style>
        @page {
          size: A4 portrait;
          margin: 0;
        }
        body {
          font-family: Arial, sans-serif;
          font-size: 12px;
          margin: 0;
          padding: 0;
        }
        .print-container {
          width: 210mm;
          height: 148.5mm; /* Half A4 */
          padding: 10mm;
          box-sizing: border-box;
          background-color: #fff;
        }
        table {
          width: 100%;
          border-collapse: collapse;
        }
        th, td {
          border: 1px solid #ccc;
          padding: 4px;
          font-size: 12px;
        }
        .text-end {
          text-align: right;
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
        .text-center {
          text-align: center;
        }
        .text-start {
          text-align: left;
        }
        .text-muted {
          color: #6c757d;
        }
        .fw-bold {
          font-weight: bold;
        }
        .mb-0 {
          margin-bottom: 0;
        }
        .mb-1 {
          margin-bottom: 4px;
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
        img {
          height: 60px;
        }
        .row {
          display: flex;
          flex-wrap: wrap;
        }
        .col-4 {
          width: 33.33%;
        }
        .col-md-6 {
          width: 50%;
        }
        p {
          margin: 4px 0;
        }
      </style>
    </head>
    <body onload="window.print(); window.close();">
      <div class="print-container">
        ${content}
      </div>
    </body>
    </html>
  `);

  printWindow.document.close();
}
</script>
<!-- Fee Deposit Modal -->
<div class="modal fade" id="depositModal" tabindex="-1" aria-labelledby="depositModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ url('admin/fees/deposit/store') }}" method="POST">
        @csrf
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="depositModalLabel">Deposit Fee</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Student <span class="text-danger">*</span></label>
              <select name="student_id" id="studentSelect" class="form-select" required>
                <option value="" selected disabled>Select Student</option>
                @foreach($students as $student)
                  @php
                    $isRTE = strtoupper($student->category) === 'RTE';
                  @endphp
                  <option value="{{ $student->id }}" data-category="{{ $student->category }}">
                    {{ $student->student_name }} 
                    @if($isRTE) (RTE) @endif
                    - {{ $student->admission_class }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6" id="feeDetailsDiv" style="display: none;">
              <label class="form-label">Fee Details</label>
              <div class="border rounded p-2 bg-light">
                <div id="feeBreakdown"></div>
              </div>
            </div>
            <div class="col-md-6">
              <label class="form-label">Amount Paid <span class="text-danger">*</span></label>
              <input type="number" step="0.01" name="amount_paid" class="form-control" required min="0">
            </div>
            <div class="col-md-6">
              <label class="form-label">Late Fee</label>
              <input type="number" step="0.01" name="late_fee" class="form-control" min="0" value="0">
            </div>
            <div class="col-md-6">
              <label class="form-label">Concession Amount</label>
              <input type="number" step="0.01" name="concession_amount" class="form-control" min="0" value="0">
              <small class="text-muted">Amount to deduct from total</small>
            </div>
            <div class="col-md-6">
              <label class="form-label">Paid On <span class="text-danger">*</span></label>
              <input type="date" name="paid_on" class="form-control" required value="{{ date('Y-m-d') }}">
            </div>
            <div class="col-md-6">
              <label class="form-label">Payment Mode</label>
              <select name="payment_mode" class="form-select">
                <option value="">Select Payment Mode</option>
                <option value="Cash">Cash</option>
                <option value="Cheque">Cheque</option>
                <option value="Online">Online Transfer</option>
                <option value="UPI">UPI</option>
                <option value="Card">Debit/Credit Card</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Transaction ID</label>
              <input type="text" name="transaction_id" class="form-control" placeholder="For online payments">
            </div>
            <div class="col-12">
              <label class="form-label">Remarks</label>
              <textarea name="remarks" class="form-control" rows="3" placeholder="Any additional notes..."></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="submit" class="btn btn-primary">Submit Payment</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- DataTables & Script -->
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

    // Handle student selection to show fee details
    $('#studentSelect').on('change', function() {
      const studentId = $(this).val();
      const category = $(this).find('option:selected').data('category');
      
      if (studentId) {
        // Show loading
        $('#feeDetailsDiv').show();
        $('#feeBreakdown').html('<div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>');
        
        // Fetch student fee details
        fetch(`/admin/fees/student-details/${studentId}`)
          .then(response => response.json())
          .then(data => {
            if (data.error) {
              $('#feeBreakdown').html(`<div class="text-danger">${data.error}</div>`);
            } else {
              const isRTE = data.is_rte;
              const fee = data.fee_structure;
              
              let breakdown = `
                <div class="small">
                  <strong class="${isRTE ? 'text-danger' : 'text-primary'}">${isRTE ? 'RTE Student' : 'Regular Student'}</strong><br>
              `;
              
              if (isRTE) {
                breakdown += `
                  RTE Fee: ₹${parseFloat(fee.rte_fee).toFixed(2)}<br>
                  Late Fee: ₹${parseFloat(fee.late_fee).toFixed(2)}<br>
                  Concession: -₹${parseFloat(fee.concession_amount).toFixed(2)}<br>
                `;
              } else {
                breakdown += `
                  Admission Fee: ₹${parseFloat(fee.admission_fee).toFixed(2)}<br>
                  Tuition Fee: ₹${parseFloat(fee.tuition_fee).toFixed(2)}<br>
                  Late Fee: ₹${parseFloat(fee.late_fee).toFixed(2)}<br>
                  Concession: -₹${parseFloat(fee.concession_amount).toFixed(2)}<br>
                `;
              }
              
              breakdown += `
                  <hr class="my-1">
                  <strong>Total: ₹${parseFloat(data.total_fee).toFixed(2)}</strong><br>
                  <span class="text-success">Paid: ₹${parseFloat(data.total_paid).toFixed(2)}</span><br>
                  <span class="text-warning">Pending: ₹${parseFloat(data.pending_amount).toFixed(2)}</span>
                </div>
              `;
              
              $('#feeBreakdown').html(breakdown);
              
              // Set max amount for payment
              $('input[name="amount_paid"]').attr('max', data.pending_amount);
              $('input[name="amount_paid"]').attr('placeholder', `Max: ₹${parseFloat(data.pending_amount).toFixed(2)}`);
            }
          })
          .catch(error => {
            console.error('Error:', error);
            $('#feeBreakdown').html('<div class="text-danger">Error loading fee details</div>');
          });
      } else {
        $('#feeDetailsDiv').hide();
      }
    });

    // Reset form when modal closes
    $('#depositModal').on('hidden.bs.modal', function() {
      $(this).find('form')[0].reset();
      $('#feeDetailsDiv').hide();
    });
  });
</script>