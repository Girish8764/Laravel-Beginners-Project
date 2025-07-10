@include('superadmin.header')
@include('admin.sidebar')

<div class="content-wrapper">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="font-weight-bold text-dark">Contact Messages</h4>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered table-hover table-sm align-middle" id="contactsTable">
      <thead class="table-primary">
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Email</th>
          <th>Subject</th>
          <th>Received At</th>
        </tr>
      </thead>
      <tbody>
        @foreach($contacts as $contact)
          <tr class="contact-row"
              data-bs-toggle="modal"
              data-bs-target="#contactModal"
              data-id="{{ $contact->id }}"
              data-name="{{ $contact->name }}"
              data-email="{{ $contact->email }}"
              data-subject="{{ $contact->subject }}"
              data-message="{{ $contact->message }}"
              data-created="{{ $contact->created_at->format('d M Y, h:i A') }}">
            <td>{{ $loop->iteration }}</td>
            <td>{{ $contact->name }}</td>
            <td>{{ $contact->email }}</td>
            <td>{{ \Illuminate\Support\Str::limit($contact->subject, 30) }}</td>
            <td>{{ $contact->created_at->diffForHumans() }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="contactModalLabel">Contact Message Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><strong>Name:</strong> <span id="modal-name"></span></p>
        <p><strong>Email:</strong> <span id="modal-email"></span></p>
        <p><strong>Subject:</strong> <span id="modal-subject"></span></p>
        <p><strong>Message:</strong></p>
        <p id="modal-message" class="border p-3 bg-light rounded"></p>
        <p class="text-muted small text-end"><strong>Received:</strong> <span id="modal-created"></span></p>
      </div>
    </div>
  </div>
</div>
</div>
@include('admin.footer')

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('contactModal');
    modal.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;

      document.getElementById('modal-name').textContent = button.getAttribute('data-name');
      document.getElementById('modal-email').textContent = button.getAttribute('data-email');
      document.getElementById('modal-subject').textContent = button.getAttribute('data-subject');
      document.getElementById('modal-message').textContent = button.getAttribute('data-message');
      document.getElementById('modal-created').textContent = button.getAttribute('data-created');
    });
  });
</script>
