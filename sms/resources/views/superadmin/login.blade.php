<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Super Admin Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow w-100" style="max-width: 400px;">
      <div class="card-body">
        <h4 class="mb-3 text-center">Super Admin Login</h4>

        @if($errors->any())
          <div class="alert alert-danger">
            @foreach($errors->all() as $error)
              <div>{{ $error }}</div>
            @endforeach
          </div>
        @endif

        <form method="POST" action="{{ route('superadmin.login.submit') }}">
          @csrf
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required autofocus>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary">Login</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
