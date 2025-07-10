<!-- Edit Staff Modal -->
<div class="modal fade" id="editStaffModal" tabindex="-1" aria-labelledby="editStaffModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('staff.update') }}" method="POST">
        @csrf
        <input type="hidden" id="edit_staff_id" name="id">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="editStaffModalLabel">Edit Staff Details</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Name</label>
              <input type="text" id="edit_name" name="name" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Father Name</label>
              <input type="text" id="edit_f_name" name="f_name" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Mother Name</label>
              <input type="text" id="edit_m_name" name="m_name" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Gender</label>
              <select id="edit_gender" name="gender" class="form-select">
                <option>Male</option>
                <option>Female</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">DOB</label>
              <input type="date" id="edit_dob" name="dob" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Religion</label>
              <input type="text" id="edit_religion" name="religion" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" id="edit_email" name="email" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Mobile</label>
              <input type="text" id="edit_mobile" name="mobile" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Subject</label>
              <input type="text" id="edit_subject" name="subject" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Joining Date</label>
              <input type="date" id="edit_joining" name="joining" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Category</label>
              <input type="text" id="edit_category" name="category" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Aadhar</label>
              <input type="text" id="edit_aadhar" name="aadhar" class="form-control">
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="submit" class="btn btn-primary">Update Staff</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
