<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img1/apple-icon.png">
  <link rel="icon" type="image/png" href="assets1/images/logo-mini.png">
  <title>
    SchoolDiGi
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/6.5.95/css/materialdesignicons.min.css">
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css1/argon-dashboard.css?v=2.1.0" rel="stylesheet" />

</head>

<body class="">
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
              <div class="card card-plain">
                <div class="card-header pb-0 text-start">
                  <h4 class="font-weight-bolder">Sign In</h4>
                  <p class="mb-0">Enter your email and password to sign in</p>
                </div>
                <div class="card-body">
                  @if($errors->any())
                      @foreach($errors->all() as $error)
                          <p class="text-danger mb-1">{{ $error }}</p>
                      @endforeach
                  @endif

                  <form method="POST" action="{{ route('login.submit') }}">
                    @csrf
                    <div class="mb-3">
                      <label for="role" class="form-label">Select Role</label>
                      <div class="input-group align-items-center">
                        <span class="input-group-text bg-white border-end-0">
                          <i class="mdi mdi-account-switch fs-5"></i>
                        </span>
                        <select name="role" class="form-select border-start-0 py-2" required>
                          <option value="school"  {{ old('role') == 'school' ? 'selected' : '' }}>Login as School</option>
                          <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Login as Teacher</option>
                          <option value="student" {{ old('role', 'student') == 'student' ? 'selected' : '' }}>Login as Student</option>
                        </select>
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="dice_code" class="form-label">School Disc Code</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="mdi mdi-numeric"></i></span>
                        <input type="text" class="form-control form-control-lg" name="dice_code"
                              value="{{ old('dice_code') }}" placeholder="School Disc Code" required>
                      </div>
                    </div>

                    <div class="mb-3">
                      <label for="email" class="form-label">Email</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="mdi mdi-email"></i></span>
                        <input type="email" class="form-control form-control-lg" name="email"
                              value="{{ old('email') }}" placeholder="Email" required>
                      </div>
                    </div>

                    <div class="mb-3">
                      <label for="password" class="form-label">Password</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="mdi mdi-lock"></i></span>
                        <input type="password" class="form-control form-control-lg" name="password"
                              placeholder="Password" required>
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-lg btn-primary w-100 mt-4 mb-2">
                        <i class="mdi mdi-login me-1"></i> Sign in
                      </button>
                      <button type="button" class="btn btn-outline-secondary w-100 mb-0" data-bs-toggle="modal" data-bs-target="#otpModal">
  <i class="mdi mdi-cellphone-key me-1"></i> Login with OTP
</button>

                    </div>
                  </form>

                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-4 text-sm mx-auto">
                    Don't have an account?
                    <a href="/signup" class="text-primary text-gradient font-weight-bold">Sign up</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
              <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('../assets/img1/login.webp');
                background-size: cover;">
                <span class="mask bg-gradient-primary opacity-6"></span>
                <!-- <h4 class="mt-5 text-white font-weight-bolder position-relative">"Attention is the new currency"</h4>
                <p class="text-white position-relative">The more effortless the writing looks, the more effort the writer actually put into the process.</p> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>





  <!-- OTP LOGIN MODAL -->
<div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="otpLoginForm">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Login via OTP</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter: invert(1);"></button>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <label>Role</label>
            <select name="role" id="otpRole" class="form-select" required>
              <option value="school">School</option>
              <option value="teacher">Teacher</option>
              <option value="student" selected>Student</option>
            </select>
          </div>
          <div class="mb-2">
            <label>DICE Code</label>
            <input type="text" class="form-control" id="otpDice" placeholder="Enter School Disc Code" required>
          </div>
          <div class="mb-2">
            <label>Email</label>
            <input type="email" class="form-control" id="otpEmail" placeholder="Enter Your Email" required>
          </div>
          <div class="mb-2 d-none" id="otpBox">
            <label>OTP</label>
            <input type="text" class="form-control" id="otpCode" placeholder="Enter OTP" maxlength="6">
          </div>
          <div id="otpMsg" class="text-danger small mt-1"></div>
        </div>
        <div class="modal-footer">
          <button type="button" id="sendOtpBtn" class="btn btn-primary">Send OTP</button>
          <button type="submit" class="btn btn-success d-none" id="verifyOtpBtn">Verify & Login</button>
        </div>
      </form>
    </div>
  </div>
</div>




  <!--   Core JS Files   -->
  <script src="../assets/js1/core/popper.min.js"></script>
  <script src="../assets/js1/core/bootstrap.min.js"></script>
  <script src="../assets/js1/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js1/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js1/argon-dashboard.min.js?v=2.1.0"></script>

  <script>
document.getElementById('sendOtpBtn').addEventListener('click', function (e) {
    e.preventDefault();

    const sendBtn = this;
    const email = document.getElementById('otpEmail').value;
    const dice = document.getElementById('otpDice').value;
    const role = document.getElementById('otpRole').value;
    const msg = document.getElementById('otpMsg');

    // Disable button and show spinner
    sendBtn.disabled = true;
    const originalText = sendBtn.innerHTML;
    sendBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Sending...`;

    fetch('{{ route("send.email.otp") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email, dice_code: dice, role }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            msg.classList.remove('text-danger');
            msg.classList.add('text-success');
            msg.innerText = data.message;

            document.getElementById('otpBox').classList.remove('d-none');
            document.getElementById('verifyOtpBtn').classList.remove('d-none');
        } else {
            msg.classList.remove('text-success');
            msg.classList.add('text-danger');
            msg.innerText = data.message || 'Error sending OTP.';
        }
    })
    .catch(error => {
        console.error(error);
        msg.classList.remove('text-success');
        msg.classList.add('text-danger');
        msg.innerText = 'Something went wrong.';
    })
    .finally(() => {
        // Re-enable button and restore text
        sendBtn.disabled = false;
        sendBtn.innerHTML = originalText;
    });
});


document.getElementById('otpLoginForm').onsubmit = function (e) {
  e.preventDefault();
  const email = document.getElementById('otpEmail').value;
  const otp = document.getElementById('otpCode').value;
  const role = document.getElementById('otpRole').value;
  const dice = document.getElementById('otpDice').value;

  fetch('{{ route("verify.email.otp") }}', {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ email, otp, role, dice_code: dice })
  }).then(res => res.json()).then(data => {
    if (data.success) {
      window.location.href = data.redirect;
    } else {
      document.getElementById('otpMsg').classList.remove('text-success');
      document.getElementById('otpMsg').classList.add('text-danger');
      document.getElementById('otpMsg').innerText = data.message;
    }
  });
};
</script>

</body>
</html>