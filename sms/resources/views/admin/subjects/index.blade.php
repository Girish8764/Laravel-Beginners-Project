@include('admin.header')
@include('admin.sidebar')

<div class="main-panel">
  <div class="content-wrapper">
    <h3 class="mb-4">Manage Subjects</h3>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Filter Section -->
    <form method="GET" class="row mb-3" action="{{ url()->current() }}">
      <div class="col-md-4">
        <label>Filter by Class</label>
        <select name="class" class="form-control class-select">
          <option value="">All Classes</option>
          @foreach($classes as $class)
              <option value="{{ $class->name }}" {{ request('class') == $class->name ? 'selected' : '' }}>
                  {{ $class->name }}
              </option>
          @endforeach
        </select>
      </div>

      <div class="col-md-4">
        <label>Filter by Stream</label>
        <select name="stream" class="form-control stream-select">
          <option value="">All Streams</option>
          <option value="General" {{ request('stream') == 'General' ? 'selected' : '' }}>General</option>
          <option value="Science" {{ request('stream') == 'Science' ? 'selected' : '' }}>Science</option>
          <option value="Arts" {{ request('stream') == 'Arts' ? 'selected' : '' }}>Arts</option>
          <option value="Commerce" {{ request('stream') == 'Commerce' ? 'selected' : '' }}>Commerce</option>
        </select>
      </div>

      <div class="col-md-4">
        <label>Filter by 3rd Language</label>
        <select name="third_lang" class="form-control stream-select">
          <option value="">All</option>
          <option value="1" {{ request('third_lang') === '1' ? 'selected' : '' }}>Only Third Language</option>
          <option value="0" {{ request('third_lang') === '0' ? 'selected' : '' }}>Non Third Language</option>
        </select>
      </div>
    </form>


    <!-- Dual Pane -->
    <div class="row">
      <!-- Left Panel -->
      <div class="col-md-6">
        <div class="card">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Available Subjects</h5>
          </div>
          <div class="card-body">
            <form id="assignForm" method="POST" action="{{ url('admin/subjects/assign-multiple') }}">
              @csrf
              <input type="hidden" name="class" value="{{ request('class') }}">
              <input type="hidden" name="stream" value="{{ request('stream') }}">
              <input type="hidden" name="third_lang" value="{{ request('third_lang') }}">
              <table class="table table-bordered table-sm">
                <thead class="table-light">
                  <tr>
                    <th><input type="checkbox" id="checkAll"></th>
                    <th>#</th>
                    <th>Class</th>
                    <th>Stream</th>
                    <th>Subject</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($available as $g)
                    <tr>
                      <td><input type="checkbox" name="global_ids[]" value="{{ $g->id }}"></td>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $g->class }}</td>
                      <td>{{ $g->stream }}</td>
                      <!-- <td>{{ $g->name }}</td> -->
                      <td>
                        {{ $g->name }}
                        @if($g->is_third_language)
                          <span class="badge bg-warning text-white">Third Language</span>
                        @endif
                      </td>

                    </tr>
                  @empty
                    <tr><td colspan="5" class="text-center">No available subjects</td></tr>
                  @endforelse
                </tbody>
              </table>
              <div class="mt-3 text-center">
                <button type="submit" class="btn btn-primary">Add Selected →</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Right Panel -->
      <div class="col-md-6">
        <div class="card">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">My School Subjects</h5>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-sm">
              <thead class="table-light">
                <tr>
                  <th>#</th>
                  <th>Class</th>
                  <th>Stream</th>
                  <th>Subject</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
               @foreach($mine as $s)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $s->class }}</td>
                  <td>{{ $s->stream }}</td>
                  <td>
                    {{ $s->name }}
                    @if($s->is_third_language)
                      <span class="badge bg-warning text-white">Third Language</span>
                    @endif
                  </td>
                  <td>
                    <form method="POST" action="{{ url('admin/subjects/'.$s->id) }}">
                      @csrf @method('DELETE')
                      <button class="btn btn-danger btn-sm">Remove</button>
                    </form>
                  </td>
                </tr>
                @endforeach
                @if($mine->isEmpty())
                  <tr>
                    <td colspan="5" class="text-center">No subjects assigned yet.</td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(255,255,255,0.7); z-index:9999; text-align:center; padding-top:20%;">
  <div class="spinner-border text-primary" role="status" style="width: 4rem; height: 4rem;">
    <span class="visually-hidden">Loading...</span>
  </div>
  <h5 class="mt-3">Please wait...</h5>
</div>
</div>
@include('admin.footer')

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function () {
    // Check/Uncheck all checkboxes in the available subjects table
    $('#checkAll').on('change', function () {
      $('input[name="global_ids[]"]').prop('checked', this.checked);
    });

    // When any filter dropdown is changed, show loader and submit the form
    $('select[name="class"], select[name="stream"], select[name="third_lang"]').on('change', function () {
      $('#loadingOverlay').show();
      $(this).closest('form').submit();
    });
  });
</script>
