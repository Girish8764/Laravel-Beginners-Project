@include('superadmin.header')
@include('admin.sidebar')

<div class="main-panel">
  <div class="content-wrapper">
    <h4 class="mb-4 font-weight-bold text-dark">View Students</h4>

    <form action="{{ route('superadmin.students.index') }}" method="GET" class="row g-3 mb-4">
      <div class="col-md-4">
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

      <div class="col-md-4">
        <label for="class" class="form-label">Select Class</label>
        <select name="class" id="class" class="form-select">
          <option value="">-- Select Class --</option>
          @foreach($classes as $class)
            <option value="{{ $class->code }}" {{ request('class') == $class->code ? 'selected' : '' }}>
              {{ $class->name }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="col-md-3 align-self-end">
        <button type="submit" class="btn btn-primary btn-sm">Confirm</button>
      </div>
    </form>

    @if($students && count($students))
      <div class="card mb-4">
        <div class="card-header bg-primary text-white">
          Showing students for: 
          <strong>{{ $selectedSchool->school_name ?? '' }}</strong>
          @if(request('class')) - Class: <strong>{{ request('class') }}</strong> @endif
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm mb-0">
              <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Stream</th>
                    <th>Gender</th>
                    <th>Father</th>
                    <th>Mobile</th>
                    <th>Action</th> <!-- NEW -->
                </tr>
                </thead>
                <tbody>
                @foreach($students as $index => $student)
                    <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $student->student_name }}</td>
                    <td>{{ $student->admission_class }}</td>
                    <td>{{ $student->stream }}</td>
                    <td>{{ ucfirst($student->gender) }}</td>
                    <td>{{ $student->father_name }}</td>
                    <td>{{ $student->mobile }}</td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewStudentModal{{ $student->id }}">
                        View
                        </button>
                    </td>
                    </tr>
                @endforeach
                </tbody>
                </table>
                @foreach($students as $student)
                    <div class="modal fade" id="viewStudentModal{{ $student->id }}" tabindex="-1" aria-labelledby="viewStudentLabel{{ $student->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="viewStudentLabel{{ $student->id }}">Student Details - {{ $student->student_name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered table-striped">
                            <tbody>
                                <tr><th>Roll No</th><td>{{ $student->rollno }}</td></tr>
                                <tr><th>Board Roll No</th><td>{{ $student->b_rollno }}</td></tr>
                                <tr><th>Admission Date</th><td>{{ $student->admission_date }}</td></tr>
                                <tr><th>SR No</th><td>{{ $student->sr_no }}</td></tr>
                                <tr><th>Class</th><td>{{ $student->admission_class }}</td></tr>
                                <tr><th>Stream</th><td>{{ $student->stream }}</td></tr>
                                <tr><th>Section</th><td>{{ $student->section }}</td></tr>
                                <tr><th>Medium</th><td>{{ $student->medium }}</td></tr>
                                <tr><th>Subjects</th>
                                <td>
                                    {{ implode(', ', array_filter([$student->subject1, $student->subject2, $student->subject3, $student->subject4, $student->subject5, $student->subject6, $student->subject7, $student->subject8, $student->subject9])) }}
                                </td>
                                </tr>
                                <tr><th>Student Name</th><td>{{ $student->student_name }}</td></tr>
                                <tr><th>Father's Name</th><td>{{ $student->father_name }}</td></tr>
                                <tr><th>Mother's Name</th><td>{{ $student->mother_name }}</td></tr>
                                <tr><th>DOB</th><td>{{ $student->dob }}</td></tr>
                                <tr><th>Gender</th><td>{{ ucfirst($student->gender) }}</td></tr>
                                <tr><th>Caste</th><td>{{ $student->caste }}</td></tr>
                                <tr><th>Category</th><td>{{ $student->category }}</td></tr>
                                <tr><th>Religion</th><td>{{ $student->religion }}</td></tr>
                                <tr><th>Aadhar</th><td>{{ $student->aadhar }}</td></tr>
                                <tr><th>Father Aadhar</th><td>{{ $student->f_aadhar }}</td></tr>
                                <tr><th>Mobile</th><td>{{ $student->mobile }}</td></tr>
                                <tr><th>Email</th><td>{{ $student->email }}</td></tr>
                                <tr><th>Address</th><td>{{ $student->address }}</td></tr>
                                <tr><th>District</th><td>{{ $student->district }}</td></tr>
                                <tr><th>Tehsil</th><td>{{ $student->tehsil }}</td></tr>
                                <tr><th>Gram</th><td>{{ $student->gram }}</td></tr>
                                <tr><th>Father Occupation</th><td>{{ $student->occupation }}</td></tr>
                                <tr><th>Family Income</th><td>{{ $student->income }}</td></tr>
                                <tr><th>Session</th><td>{{ $student->session }}</td></tr>
                                <tr><th>RTE</th><td>{{ $student->rte }}</td></tr>
                                <tr><th>Add Fee</th><td>{{ $student->add_fee }}</td></tr>
                                <tr><th>Tuition Fee</th><td>{{ $student->tution_fee }}</td></tr>
                                <tr><th>Concession</th><td>{{ $student->con_fee }}</td></tr>
                                <tr><th>Total Fee</th><td>{{ $student->total_fee }}</td></tr>
                                <tr><th>Status</th><td>{{ $student->status == 1 ? 'Active' : 'Inactive' }}</td></tr>
                                <tr><th>Created At</th><td>{{ $student->created_at }}</td></tr>
                                <tr><th>Updated At</th><td>{{ $student->updated_at }}</td></tr>
                                @if($student->img)
                                <tr><th>Photo</th><td><img src="{{ asset('path/to/student/images/'.$student->img) }}" width="100"></td></tr>
                                @endif
                            </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                        </div>
                    </div>
                    </div>
                    @endforeach
          </div>
        </div>
      </div>
    @elseif(request()->has('school_id'))
      <div class="alert alert-warning">No students found for selected filters.</div>
    @endif

  </div>
</div>
</div>
@include('admin.footer')
