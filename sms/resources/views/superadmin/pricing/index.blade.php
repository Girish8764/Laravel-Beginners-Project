@include('superadmin.header')
@include('admin.sidebar')

<div class="main-panel">
  <div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="font-weight-bold text-dark">Manage Pricing Plans</h4>
      <div>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addPlanModal">
          <i class="mdi mdi-plus-circle"></i> Add Plan
        </button>
      </div>
    </div>

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <div class="table-responsive">
      <table id="plansTable" class="table table-bordered table-striped table-sm align-middle">
        <thead class="table-primary">
          <tr>
            <th>#</th>
            <th>Title</th>
            <th>Price (₹)</th>
            <th>Duration</th>
            <th>Features</th>
            <th>Preview Plans <small>(Show to Yes)</small></th>
            <th class="no-sort">Action</th>
          </tr>
        </thead>
        <tbody>
  @forelse($plans as $index => $plan)
    <tr>
      <td>{{ $index + 1 }}</td>
      <td>{{ $plan->title ?? '—' }}</td>
      <td>₹{{ number_format($plan->price, 2) }}</td>
      <td>{{ $plan->duration }}</td>
      <td>
        @if($plan->features && count($plan->features) > 0)
          <ul class="mb-0 small">
            @foreach($plan->features as $feature)
              <li>{{ $feature }}</li>
            @endforeach
          </ul>
        @else
          <span class="text-muted">No features</span>
        @endif
      </td>
      <td>
  <form method="POST" action="{{ route('pricing-plans.toggle-featured', $plan->id) }}">
    @csrf
    <button type="submit" class="btn btn-md fw-bold px-4 py-2 {{ $plan->is_featured ? 'btn-success text-white' : 'btn-outline-secondary' }}">
      {{ $plan->is_featured ? 'Yes' : 'No' }}
      
    </button>
  </form>
  <small>Click on Yes/No</small>
</td>

      <td class="align-middle">
        <form method="POST" action="{{ route('pricing-plans.destroy', $plan->id) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this plan?')">
          @csrf 
          @method('DELETE')
          <button class="btn btn-danger btn-md fw-bold px-4 py-2 text-white" title="Delete Plan">
  <i class="mdi mdi-delete"></i> Delete Plan
</button>

        </form>
      </td>
    </tr>
  @empty
    {{-- Moved outside --}}
  @endforelse
</tbody>

@if($plans->isEmpty())
  <tr>
    <td colspan="7" class="text-center text-muted">No pricing plans found</td>
  </tr>
@endif

      </table>
    </div>
  </div>
</div>

<!-- Add Plan Modal -->
<div class="modal fade" id="addPlanModal" tabindex="-1" aria-labelledby="addPlanLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('pricing-plans.store') }}" class="modal-content">
      @csrf
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="addPlanLabel">Add New Plan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="add_title" class="form-label">Title (Optional)</label>
          <input type="text" name="title" id="add_title" class="form-control" placeholder="Enter plan title">
        </div>
        
        <div class="mb-3">
          <label for="add_price" class="form-label">Price (₹) *</label>
          <input type="number" name="price" id="add_price" class="form-control" step="0.01" min="0" placeholder="Enter price(Only Number Without ₹)" required>
        </div>
        
        <div class="mb-3">
          <label for="add_duration" class="form-label">Duration *</label>
          <input type="text" name="duration" id="add_duration" class="form-control" placeholder="e.g., 1 Month, 1Yearly" required>
        </div>
        
        <div class="mb-3">
          <label for="add_features" class="form-label">Features (one per line)</label>
          <textarea name="features" id="add_features" class="form-control" rows="4" placeholder="Detail 1
Detail 2
Detail 3
Detail 4"></textarea>

        </div>
        
        <!-- <div class="form-check">
          <input type="checkbox" name="is_featured" class="form-check-input" id="add_featured">
          <label for="add_featured" class="form-check-label">Featured Plan</label>
        </div> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary btn-sm">Save Plan</button>
      </div>
    </form>
  </div>
</div>
</div>
@include('admin.footer')

<!-- Initialize DataTable -->
<script>
  $(document).ready(function () {
    $('#plansTable').DataTable({
      responsive: true,
      ordering: true,
      searching: true,
      paging: true,
      pageLength: 10,
      lengthMenu: [5, 10, 25, 50, 100],
      language: {
        processing: "⏳ Processing...",
        search: "🔍 Search Plans:",
        lengthMenu: "Show _MENU_ plans per page",
        zeroRecords: "No matching plans found",
        info: "Showing _START_ to _END_ of _TOTAL_ plans",
        infoEmpty: "No plans available",
        infoFiltered: "(filtered from _MAX_ total plans)"
      },
      columnDefs: [
        { targets: 'no-sort', orderable: false }
      ]
    });

    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
      $('.alert').fadeOut('slow');
    }, 5000);
  });
</script>