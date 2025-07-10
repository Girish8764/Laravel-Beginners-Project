<!-- Add Staff Modal -->
<div class="modal fade" id="addStaffModal" tabindex="-1" aria-labelledby="addStaffModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('staff.store') }}" method="POST">
        @csrf
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="addStaffModalLabel">Add New Staff</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Name</label>
              <input type="text" class="form-control" name="name" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Father Name</label>
              <input type="text" class="form-control" name="f_name">
            </div>
            <div class="col-md-6">
              <label class="form-label">Mother Name</label>
              <input type="text" class="form-control" name="m_name">
            </div>
            <div class="col-md-6">
              <label class="form-label">Gender</label>
              <select class="form-select" name="gender">
                <option>Male</option>
                <option>Female</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">DOB</label>
              <input type="date" class="form-control" name="dob">
            </div>
            <div class="col-md-6">
              <label class="form-label">Religion</label>
              <input type="text" class="form-control" name="religion">
            </div>
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" name="email">
            </div>
            <div class="col-md-6">
              <label class="form-label">Mobile</label>
              <input type="text" class="form-control" name="mobile">
            </div>
            <div class="col-md-6">
              <label class="form-label">Subject</label>
              <input type="text" class="form-control" name="subject">
            </div>
            <div class="col-md-6">
              <label class="form-label">Joining Date</label>
              <input type="date" class="form-control" name="joining">
            </div>
            <div class="col-md-6">
              <label class="form-label">Category</label>
              <input type="text" class="form-control" name="category">
            </div>
            <div class="col-md-6">
              <label class="form-label">Aadhar</label>
              <input type="text" class="form-control" name="aadhar">
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="submit" class="btn btn-primary">Save Staff</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
