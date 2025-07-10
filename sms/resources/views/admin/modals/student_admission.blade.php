<!-- Student Admission Modal -->
<div class="modal fade" id="studentAdmissionModal" tabindex="-1" aria-labelledby="studentAdmissionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="studentAdmissionModalLabel">Student Admission Form</h5>
        <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('student.admission.store') }}">
          @csrf
          <div class="row g-3"> <!-- 'g-3' adds some gutter (spacing) between columns -->

            <div class="col-md-4">
              <label class="form-label">SR Number</label>
              <input type="text" class="form-control" name="sr_no" placeholder="SR Number" required>
            </div>

            <div class="col-md-4">
              <label class="form-label">Admission Date</label>
              <input type="date" class="form-control" name="admission_date" value="{{ old('admission_date', now()->format('Y-m-d')) }}">
            </div>


            <div class="col-md-4">
              <label class="form-label">Admission Class</label>
              <select class="form-select" name="admission_class" required>
                  @foreach($classes as $class)
                      <option value="{{ $class->code }}">{{ $class->name }}</option>
                  @endforeach
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label">Student Name</label>
              <input type="text" class="form-control" name="student_name" placeholder="Student Name" required>
            </div>

            <div class="col-md-4">
              <label class="form-label">Father's Name</label>
              <input type="text" class="form-control" name="father_name" placeholder="Father's Name">
            </div>

            <div class="col-md-4">
              <label class="form-label">Mother's Name</label>
              <input type="text" class="form-control" name="mother_name" placeholder="Mother's Name">
            </div>

            <div class="col-md-4">
              <label class="form-label">Date of Birth</label>
              <input type="date" class="form-control" name="dob">
            </div>

            <div class="col-md-4">
              <label class="form-label">Gender</label>
              <select class="form-select" name="gender" required>
                <option>Boy</option>
                <option>Girl</option>
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label">Mobile No</label>
              <input type="text" class="form-control" name="mobile" placeholder="Mobile No">
            </div>

            <div class="col-md-4">
              <label class="form-label">Category</label>
              <select class="form-select" name="category" required>
                <option>ST</option>
                <option>SC</option>
                <option>OBC</option>
                <option>GENERAL</option>
                <option>MINORITY</option>
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label">Caste</label>
              <input type="text" class="form-control" name="caste" placeholder="Caste">
            </div>

            <div class="col-md-4">
              <label class="form-label">Stream</label>
              <select class="form-select" name="stream" required>
                <option>Agriculture</option>
                <option>Arts</option>
                <option>Commerce</option>
                <option>General</option>
                <option>Science</option>
              </select>
            </div>

            <!-- <div class="col-md-4">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" name="email" placeholder="Email">
            </div>

            <div class="col-md-4">
              <label class="form-label">Password</label>
              <input type="password" class="form-control" name="password" placeholder="Password">
            </div> -->

          </div>

          <div class="mt-3 text-end">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
