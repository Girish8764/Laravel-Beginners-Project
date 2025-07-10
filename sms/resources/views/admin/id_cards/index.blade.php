@include('admin.header')
@include('admin.sidebar')
<div class="main-panel">
  <div class="content-wrapper">
    <div class="card">
      <div class="card-body">
        <h4>ID Card Generator</h4>
        <form action="{{ route('id-cards.generate') }}" method="POST" target="_blank">
          @csrf
          <div class="row">
            <div class="col-md-4">
              <label>Type</label>
              <select class="form-control" name="type" required>
                <option value="student">Student</option>
                <option value="staff">Staff</option>
              </select>
            </div>

            <div class="col-md-4">
              <label>Template</label>
              <select class="form-control" name="template" required>
                <option value="1">Template 1</option>
                <option value="2">Template 2</option>
                <option value="3">Template 3</option>
              </select>
            </div>

            <div class="col-md-4">
              <label>Class (for Students)</label>
              <select class="form-control" name="class">
                <option value="">-- Optional --</option>
                @foreach($classes as $class)
                  <option value="{{ $class->name }}">{{ $class->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-4 mt-2">
              <label>Stream (for Students)</label>
              <select class="form-control" name="stream">
                <option value="">-- Optional --</option>
                <option value="Science">Science</option>
                <option value="Commerce">Commerce</option>
                <option value="Arts">Arts</option>
              </select>
            </div>

            <div class="col-md-12 mt-3">
              <button type="submit" class="btn btn-primary">Generate ID Cards</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
@include('admin.footer')