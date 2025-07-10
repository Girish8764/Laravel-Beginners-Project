<!-- Generate Roll No Modal -->
<div class="modal fade" id="generateRollNoModal" tabindex="-1" aria-labelledby="generateRollNoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="generateRollNoModalLabel">
          Generate Roll No. Classwise 
          <mark class="bg-warning text-dark">(Please select 'General' category for below 11th classes / कृपया 11वीं कक्षा से नीचे के लिए 'सामान्य' श्रेणी चुनें)</mark>
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('students.roll.generate') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label">Choose Class</label>
              <select class="form-select" name="admission_class" required>
                <option value="LKG">LKG</option>
                <option value="UKG">UKG</option>
                <option value="Nursery">Nursery</option>
                <option value="First">First</option>
                <option value="Second">Second</option>
                <option value="Third">Third</option>
                <option value="Fourth">Fourth</option>
                <option value="Fifth">Fifth</option>
                <option value="Sixth">Sixth</option>
                <option value="Seventh">Seventh</option>
                <option value="Eighth">Eighth</option>
                <option value="Ninth">Ninth</option>
                <option value="Tenth">Tenth</option>
                <option value="Eleventh">Eleventh</option>
                <option value="Tweleth">Tweleth</option>
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label">Choose Stream</label>
              <select class="form-select" name="stream">
                <option>Agriculture</option>
                <option>Arts</option>
                <option>Commerce</option>
                <option>General</option>
                <option>Science</option>
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label">Start From</label>
              <input type="number" class="form-control" name="rollno" placeholder="Start" required>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="submit" class="btn btn-primary">Generate</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
