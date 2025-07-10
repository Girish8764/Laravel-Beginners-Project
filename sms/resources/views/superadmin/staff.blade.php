@include('superadmin.header')
@include('admin.sidebar')

<div class="main-panel">
  <div class="content-wrapper">
    <h4 class="mb-4 font-weight-bold text-dark">View Staff by School</h4>

    <form action="{{ route('superadmin.staff.index') }}" method="GET" class="row g-3 mb-4">
      <div class="col-md-6">
        <label for="school_id" class="form-label">Select School</label>
        <select name="school_id" id="school_id" class="form-select" required>
          <option value="">-- Select School --</option>
          @foreach($schools as $school)
            <option value="{{ $school->id }}" {{ request('school_id') == $school->id ? 'selected' : '' }}>
              {{ $school->school_name }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3 align-self-end">
        <button type="submit" class="btn btn-primary btn-sm">Confirm</button>
      </div>
    </form>

    @if($selectedSchool)
      <div class="card mb-4">
        <div class="card-header bg-primary text-white">
          <strong>{{ $selectedSchool->school_name }}</strong> ({{ $selectedSchool->email }})
        </div>
        <div class="card-body p-0">
          @if($teachers->count())
            <div class="table-responsive">
              <table class="table table-bordered mb-0 table-sm">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Teacher Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Gender</th>
                        <th>Category</th>
                        <th>Action</th> <!-- New column -->
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($teachers as $index => $teacher)
                    
                        <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $teacher->name }}</td>
                        <td>{{ $teacher->email }}</td>
                        <td>{{ $teacher->mobile }}</td>
                        <td>{{ ucfirst($teacher->gender) }}</td>
                        <td>{{ $teacher->category }}</td>
                        <td>
                            <!-- Button to trigger modal -->
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewTeacherModal{{ $teacher->id }}">
                            View
                            </button>
                        </td>
                        </tr>
                    @endforeach
                    </tbody>


              </table>
                @foreach($teachers as $teacher)
                <!-- Modal for Viewing Teacher Details -->
                <div class="modal fade" id="viewTeacherModal{{ $teacher->id }}" tabindex="-1" aria-labelledby="viewTeacherLabel{{ $teacher->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="viewTeacherLabel{{ $teacher->id }}">Teacher Details - {{ $teacher->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <table class="table table-bordered table-striped">
                            <tbody>
                            <tr><th>Full Name</th><td>{{ $teacher->name }}</td></tr>
                            <tr><th>Father's Name</th><td>{{ $teacher->f_name }}</td></tr>
                            <tr><th>Mother's Name</th><td>{{ $teacher->m_name }}</td></tr>
                            <tr><th>DOB</th><td>{{ $teacher->dob }}</td></tr>
                            <tr><th>Gender</th><td>{{ ucfirst($teacher->gender) }}</td></tr>
                            <tr><th>Religion</th><td>{{ $teacher->religion }}</td></tr>
                            <tr><th>Category</th><td>{{ $teacher->category }}</td></tr>
                            <tr><th>Email</th><td>{{ $teacher->email }}</td></tr>
                            <tr><th>Mobile</th><td>{{ $teacher->mobile }}</td></tr>
                            <tr><th>Aadhar</th><td>{{ $teacher->aadhar }}</td></tr>
                            <tr><th>Joining Date</th><td>{{ $teacher->joining }}</td></tr>
                            <tr><th>Subject</th><td>{{ $teacher->subject }}</td></tr>
                            <tr><th>Academic Qualification</th><td>{{ $teacher->accdmic }}</td></tr>
                            <tr><th>Professional Qualification</th><td>{{ $teacher->pro }}</td></tr>
                            <tr><th>Address</th><td>{{ $teacher->address }}</td></tr>
                            <tr><th>Status</th><td>{{ $teacher->status == 1 ? 'Active' : 'Inactive' }}</td></tr>
                            <tr><th>Card No</th><td>{{ $teacher->card }}</td></tr>
                            <tr><th>Created At</th><td>{{ $teacher->created_at }}</td></tr>
                            <tr><th>Updated At</th><td>{{ $teacher->updated_at }}</td></tr>
                            @if($teacher->img)
                                <tr><th>Photo</th><td><img src="{{ asset('path/to/teacher/images/' . $teacher->img) }}" width="100"></td></tr>
                            @endif
                            </tbody>
                        </table>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                    </div>
                </div>
                @endforeach
            </div>
          @else
            <p class="p-3 text-muted">No staff found for this school.</p>
          @endif
        </div>
      </div>
    @endif
  </div>
</div>
</div>
@include('admin.footer')
