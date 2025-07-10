@include('admin.header')
@include('admin.sidebar')

<div class="main-panel">
  <div class="content-wrapper">
    <h4 class="mb-3 font-weight-bold text-dark">Generate Admit Card</h4>

    <form method="GET" action="{{ route('admin.admit-card.index') }}" class="row g-3 mb-4">
      <div class="col-md-4">
        <label>Class</label>
        <select name="class" class="form-control" required>
          <option value="">Select Class</option>
          @foreach($classes as $cls)
            <option value="{{ $cls->name }}" {{ request('class') == $cls->name ? 'selected' : '' }}>
              {{ $cls->name }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="col-md-4">
        <label>Stream</label>
        <select name="stream" class="form-control" required>
          <option value="">Select Stream</option>
          <option value="General" {{ request('stream') == 'General' ? 'selected' : '' }}>General</option>
          <option value="Science" {{ request('stream') == 'Science' ? 'selected' : '' }}>Science</option>
          <option value="Commerce" {{ request('stream') == 'Commerce' ? 'selected' : '' }}>Commerce</option>
          <option value="Arts" {{ request('stream') == 'Arts' ? 'selected' : '' }}>Arts</option>
        </select>
      </div>

      <div class="col-md-4 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100">Filter Students</button>
      </div>
    </form>

    @if(count($students))
      <div class="table-responsive">
        <table class="table table-bordered table-striped">
          <thead class="table-primary">
            <tr>
              <th>#</th>
              <th>Student Name</th>
              <th>Father's Name</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($students as $student)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->father_name }}</td>
                <td>
                  <a href="{{ route('admin.admit-card.canvas', $student->id) }}" class="btn btn-sm btn-warning">
                    <i class="mdi mdi-pencil"></i> Design Admit Card
                  </a>
                  <a href="{{ route('admin.admit-card.print', $student->id) }}" target="_blank" class="btn btn-sm btn-success">
                    <i class="mdi mdi-printer"></i> Print Admit Card
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @else
      <p class="text-muted mt-3">No students found. Please filter by class and stream.</p>
    @endif

  </div>
</div>
</div>
@include('admin.footer')
