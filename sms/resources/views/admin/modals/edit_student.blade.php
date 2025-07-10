<div class="modal fade" id="studentEditModal" tabindex="-1" aria-labelledby="studentEditModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="studentEditModalLabel">Edit Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('student.update') }}" enctype="multipart/form-data">
  @csrf
  <input type="hidden" name="id" id="edit_id">

  <!-- Image Upload -->
  <div class="mb-3">
    <label class="form-label">Student Image</label>
    <input type="file" class="form-control" name="img" id="edit_img">
  </div>

  <!-- Personal Information -->
  <div class="row g-3">
    <div class="col-md-4">
      <label>Student Name</label>
      <input type="text" class="form-control" name="student_name" id="edit_name">
    </div>
    <div class="col-md-4">
      <label>Session</label>
      <input type="text" class="form-control" name="session" id="edit_session">
    </div>
    <div class="col-md-4">
      <label>Section</label>
      <input type="text" class="form-control" name="section" id="edit_section">
    </div>
    <div class="col-md-4">
      <label>Father's Name</label>
      <input type="text" class="form-control" name="father_name" id="edit_father">
    </div>
    <div class="col-md-4">
      <label>Mother's Name</label>
      <input type="text" class="form-control" name="mother_name" id="edit_mother">
    </div>
    <div class="col-md-4">
      <label>SR No.</label>
      <input type="text" class="form-control" name="sr_no" id="edit_sr_no">
    </div>
    <div class="col-md-4">
      <label>Class</label>
      <select class="form-select" name="admission_class" id="edit_class">
        @foreach($classes as $class)
        <option value="{{ $class->code }}">{{ $class->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-4">
      <label>Roll No.</label>
      <input type="text" class="form-control" name="rollno" id="edit_rollno">
    </div>
    <div class="col-md-4">
      <label>Board Roll No.</label>
      <input type="text" class="form-control" name="b_rollno" id="edit_b_rollno">
    </div>
    <div class="col-md-4">
      <label>Admission Date</label>
      <input type="date" class="form-control" name="admission_date" id="edit_admission_date">
    </div>
    <div class="col-md-4">
      <label>Date of Birth</label>
      <input type="date" class="form-control" name="dob" id="edit_dob">
    </div>
    <div class="col-md-4">
      <label>Gender</label>
      <select class="form-select" name="gender" id="edit_gender">
        <option value="Boy">Boy</option>
        <option value="Girl">Girl</option>
      </select>
    </div>

    <div class="col-md-4">
      <label>Stream</label>
      <select class="form-select" name="stream" id="edit_stream">
        <option value="General">General</option>
        <option value="Arts">Arts</option>
        <option value="Science">Science</option>
        <option value="Commerce">Commerce</option>
        <option value="Agriculture">Agriculture</option>
      </select>
    </div>
    <div class="col-md-4">
      <label>Category</label>
      <select class="form-select" name="category" id="edit_category">
        <option value="ST">ST</option>
        <option value="SC">SC</option>
        <option value="OBC">OBC</option>
        <option value="GENERAL">GENERAL</option>
        <option value="MINORITY">MINORITY</option>
      </select>
    </div>
    <div class="col-md-4">
      <label>Caste</label>
      <input type="text" class="form-control" name="caste" id="edit_caste">
    </div>
    <div class="col-md-4">
      <label>Third Language</label>
      <input type="text" class="form-control" name="third" id="edit_third">
    </div>
    <div class="col-md-4">
      <label>Medium</label>
      <select class="form-select" name="medium" id="edit_medium">
        <option value="Hindi">Hindi</option>
        <option value="English">English</option>
      </select>
    </div>
    <div class="col-md-4">
      <label>Religion</label>
      <input type="text" class="form-control" name="religion" id="edit_religion">
    </div>
    <div class="col-md-4">
      <label>Aadhar</label>
      <input type="text" class="form-control" name="aadhar" id="edit_aadhar">
    </div>
    <div class="col-md-4">
      <label>Jan Aadhar</label>
      <input type="text" class="form-control" name="jan_aadhar" id="edit_jan_aadhar">
    </div>
    <div class="col-md-4">
      <label>Email</label>
      <input type="email" class="form-control" name="gmail" id="edit_email">
    </div>
    <div class="col-md-4">
      <label>Mobile</label>
      <input type="text" class="form-control" name="mobile" id="edit_mobile">
    </div>
    <div class="col-md-4">
      <label>RTE / Non-RTE</label>
      <select class="form-select" name="rte" id="edit_rte">
        <option value="RTE">RTE</option>
        <option value="Non-RTE">Non-RTE</option>
      </select>
    </div>

    <!-- Address Info -->
    <div class="col-md-4">
      <label>Address</label>
      <input type="text" class="form-control" name="address" id="edit_address">
    </div>
    <div class="col-md-4">
      <label>Gram</label>
      <input type="text" class="form-control" name="gram" id="edit_gram">
    </div>
    <div class="col-md-4">
      <label>Tehsil</label>
      <input type="text" class="form-control" name="tehsil" id="edit_tehsil">
    </div>
    <div class="col-md-4">
      <label>District</label>
      <input type="text" class="form-control" name="district" id="edit_district">
    </div>

    <!-- Father's Details -->
    <div class="col-md-4">
      <label>Father PAN</label>
      <input type="text" class="form-control" name="pan_no" id="edit_pan_no">
    </div>
    <div class="col-md-4">
      <label>Father DOB</label>
      <input type="date" class="form-control" name="f_dob" id="edit_f_dob">
    </div>
    <div class="col-md-4">
      <label>Father Place</label>
      <input type="text" class="form-control" name="f_place" id="edit_f_place">
    </div>
    <div class="col-md-4">
      <label>Father Aadhar</label>
      <input type="text" class="form-control" name="f_aadhar" id="edit_f_aadhar">
    </div>
    <div class="col-md-4">
      <label>Occupation</label>
      <input type="text" class="form-control" name="occupation" id="edit_occupation">
    </div>
    <div class="col-md-4">
      <label>Income</label>
      <input type="text" class="form-control" name="income" id="edit_income">
    </div>
    <div class="col-md-4">
      <label>Grandfather Age</label>
      <input type="number" class="form-control" name="g_age" id="edit_g_age">
    </div>

    <!-- Labour Card Info -->
    <div class="col-md-4">
      <label>Labour Card Holder</label>
      <input type="text" class="form-control" name="labour_card" id="edit_labour_card">
    </div>
    <div class="col-md-4">
      <label>Aadhar of Labour Card Holder</label>
      <input type="text" class="form-control" name="father_mother_aadhar" id="edit_father_mother_aadhar">
    </div>
    <div class="col-md-4">
      <label>Labour Card No.</label>
      <input type="text" class="form-control" name="labour_no" id="edit_labour_no">
    </div>
    <div class="col-md-4">
      <label>Issue Date</label>
      <input type="date" class="form-control" name="labour_date" id="edit_labour_date">
    </div>
    <div class="col-md-4">
      <label>Validity Date</label>
      <input type="date" class="form-control" name="validity_date" id="edit_validity_date">
    </div>
    <div class="col-md-4">
      <label>Issuing Officer</label>
      <input type="text" class="form-control" name="officer_issuing" id="edit_officer_issuing">
    </div>

    <!-- Old Class Details -->
    @for ($i = 1; $i <= 3; $i++)
    <div class="col-md-3">
      <label>Class {{ $i }}</label>
      <input type="text" class="form-control" name="class{{ $i }}" id="edit_class{{ $i }}">
    </div>
    <div class="col-md-3">
      <label>Year {{ $i }}</label>
      <input type="text" class="form-control" name="year{{ $i }}" id="edit_year{{ $i }}">
    </div>
    <div class="col-md-3">
      <label>Old Roll No. {{ $i }}</label>
      <input type="text" class="form-control" name="old_rollno{{ $i }}" id="edit_old_rollno{{ $i }}">
    </div>
    <div class="col-md-3">
      <label>Result {{ $i }}</label>
      <input type="text" class="form-control" name="old_result{{ $i }}" id="edit_old_result{{ $i }}">
    </div>
    <div class="col-md-12">
      <label>School / Board Name {{ $i }}</label>
      <input type="text" class="form-control" name="old_board{{ $i }}" id="edit_old_board{{ $i }}">
    </div>
    @endfor
  </div>

  <div class="mt-4 text-end">
    <button type="submit" class="btn btn-primary">Update Student</button>
  </div>
</form>

      </div>
    </div>
  </div>
</div>
