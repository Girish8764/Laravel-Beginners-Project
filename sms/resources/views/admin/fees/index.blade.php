{{-- resources/views/admin/fees/index.blade.php --}}
@include('admin.header')
@include('admin.sidebar')
<div class="main-panel">
  <div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="font-weight-bold text-dark">Set Class Fees</h4>
      <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#setFeeModal">
        + Set Fee
      </button>
    </div>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
      <table id="feesTable" class="table table-bordered table-striped table-sm align-middle">
        <thead class="table-primary">
          <tr>
            <th>#</th>
            <th>Class</th>
            <th>Stream</th>
            <th>Admission Fee</th>
            <th>Tuition Fee</th>
            <th>RTE Fee</th>
            <th>Late Fee</th>
            <th>Concession</th>
            <th>Total Fee</th>
          </tr>
        </thead>
        <tbody>
          @foreach($fees as $fee)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ \App\Models\Classe::where('code', $fee->class_code)->value('name') ?? $fee->class_code }}</td>
              <td>{{ $fee->stream ?? '—' }}</td>
              <td>₹{{ number_format($fee->admission_fee, 2) }}</td>
              <td>₹{{ number_format($fee->tuition_fee, 2) }}</td>
              <td>₹{{ number_format($fee->rte_fee, 2) }}</td>
              <td>₹{{ number_format($fee->late_fee, 2) }}</td>
              <td>₹{{ number_format($fee->concession_amount, 2) }}</td>
              <td>₹{{ number_format($fee->total_fee, 2) }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>
@include('admin.footer')

<!-- Set Fee Modal -->
<div class="modal fade" id="setFeeModal" tabindex="-1" aria-labelledby="setFeeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ url('admin/fees/store') }}" method="POST">
        @csrf
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="setFeeModalLabel">Set Class Fee</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Class <span class="text-danger">*</span></label>
              <select name="class_code" class="form-select" required>
                <option value="" selected disabled>Select Class</option>
                @foreach($classes as $class)
                  <option value="{{ $class->code }}">{{ $class->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Stream</label>
              <input type="text" name="stream" class="form-control" placeholder="Optional">
            </div>
            <div class="col-md-6">
              <label class="form-label">Admission Fee <span class="text-danger">*</span></label>
              <input type="number" step="0.01" name="admission_fee" class="form-control" required min="0" value="0">
            </div>
            <div class="col-md-6">
              <label class="form-label">Tuition Fee <span class="text-danger">*</span></label>
              <input type="number" step="0.01" name="tuition_fee" class="form-control" required min="0" value="0">
            </div>
            <div class="col-md-6">
              <label class="form-label">RTE Fee <span class="text-danger">*</span></label>
              <input type="number" step="0.01" name="rte_fee" class="form-control" required min="0" value="0">
              <small class="text-muted">This fee applies only to RTE students</small>
            </div>
            <div class="col-md-6">
              <label class="form-label">Late Fee</label>
              <input type="number" step="0.01" name="late_fee" class="form-control" min="0" value="0">
              <small class="text-muted">Additional fee for late payments</small>
            </div>
            <div class="col-md-6">
              <label class="form-label">Concession Amount</label>
              <input type="number" step="0.01" name="concession_amount" class="form-control" min="0" value="0">
              <small class="text-muted">Amount to be deducted from total fee</small>
            </div>
            <div class="col-md-6">
              <label class="form-label">Calculated Total</label>
              <div class="border rounded p-2 bg-light">
                <span id="calculatedTotal">₹0.00</span>
                <small class="text-muted d-block">
                  Regular: (Admission + Tuition + Late) - Concession<br>
                  RTE: (RTE + Late) - Concession
                </small>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="submit" class="btn btn-primary">Save Fee Structure</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- DataTables & Script -->
<script>
  $(function () {
    $('#feesTable').DataTable({
      responsive: true,
      ordering: true,
      searching: true,
      paging: true,
      processing: true,
      pageLength: 10,
      lengthMenu: [5, 10, 25, 50, 100],
      language: {
        processing: "<span class='text-primary fw-bold'>⏳ Processing, please wait...</span>",
        search: "🔍 Search Class Fee:",
        lengthMenu: "Show _MENU_ entries per page",
        zeroRecords: "No fee record found.",
        info: "Showing _START_ to _END_ of _TOTAL_ fees",
        infoEmpty: "No fee records available",
        infoFiltered: "(filtered from _MAX_ total fees)"
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

    // Calculate total fee dynamically
    function calculateTotal() {
      const admission = parseFloat($('input[name="admission_fee"]').val()) || 0;
      const tuition = parseFloat($('input[name="tuition_fee"]').val()) || 0;
      const rte = parseFloat($('input[name="rte_fee"]').val()) || 0;
      const late = parseFloat($('input[name="late_fee"]').val()) || 0;
      const concession = parseFloat($('input[name="concession_amount"]').val()) || 0;
      
      const regularTotal = Math.max(0, admission + tuition + late - concession);
      const rteTotal = Math.max(0, rte + late - concession);
      
      $('#calculatedTotal').html(`
        Regular: ₹${regularTotal.toFixed(2)}<br>
        RTE: ₹${rteTotal.toFixed(2)}
      `);
    }

    // Bind calculation to input changes
    $('input[name="admission_fee"], input[name="tuition_fee"], input[name="rte_fee"], input[name="late_fee"], input[name="concession_amount"]').on('input', calculateTotal);
    
    // Calculate on modal show
    $('#setFeeModal').on('shown.bs.modal', calculateTotal);
  });
</script>