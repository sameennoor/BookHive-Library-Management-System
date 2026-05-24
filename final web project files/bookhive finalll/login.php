<?php
// Include your database connection
include 'db.php';

$message = ''; // feedback message

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    if (empty($fullname) || empty($email) || empty($password) || empty($confirm)) {
        $message = "All fields are required!";
    } elseif ($password !== $confirm) {
        $message = "Passwords do not match!";
    } else {
        // Hash the password
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        // Insert into database
        $sql = "INSERT INTO librarians (fullname, email, password) VALUES ('$fullname', '$email', '$hashed')";
        if (mysqli_query($conn, $sql)) {
            $message = "Signup successful! You can now login.";
            // Optionally redirect to login/dashboard page:
            // header("Location: dashboard.html"); exit;
        } else {
            if (strpos(mysqli_error($conn), "Duplicate entry") !== false) {
                $message = "Email already exists!";
            } else {
                $message = "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Library Signup — BookHive</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root{
      --teal:#00a497; --orange:#ff7a00; --dark-slate:#2F4F4F; --card-bg:#ffffff;
    }
    body{
      margin:0;
      font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, Arial;
      background-image: url('https://img.freepik.com/premium-photo/bookshelves-library-education-knowledge-concept-with-ai-generated_144089-1479.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      position: relative;
      min-height: 100vh;
    }
    body::before{
      content:"";
      position: absolute;
      inset: 0;
      background: rgba(0,0,0,0.55);
      z-index: 0;
    }
    main{ position: relative; z-index: 1; }
    .login-wrapper{
      width: 920px; max-width: 96%;
      background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(255,255,255,0.92));
      box-shadow: 0 15px 40px rgba(0,0,0,0.25);
      border-radius: 12px;
      overflow: hidden;
    }
    .left-panel{
      background: linear-gradient(135deg, rgba(0,164,151,0.95), rgba(255,122,0,0.95));
      color:#fff; min-height:360px;
    }
    .brand-title{ font-weight:700; letter-spacing:0.2px; }
    .right-panel{ background: var(--card-bg); min-height:360px; }
    .form-control{ border-radius:10px; border:1px solid #e6e8eb; box-shadow:none; }
    .btn-login{ background: linear-gradient(90deg,var(--teal),var(--orange)); border:none; color:#fff; border-radius:10px; padding:12px 18px; font-weight:600; }
  </style>
</head>
<body>
  <main class="d-flex align-items-center justify-content-center min-vh-100">
    <section class="login-wrapper shadow-lg rounded-4 overflow-hidden">
      <div class="row g-0">
        <div class="col-md-5 left-panel d-flex flex-column justify-content-center align-items-center text-center p-4">
          <img src="assets/logo.png" alt="Library Logo" width="120" height="120" class="mb-3">
          <h2 class="brand-title mt-3">Join BookHive</h2>
          <p class="text-light small px-3">Create your librarian account and start managing records.</p>
        </div>
        <div class="col-md-7 p-4 right-panel">
          <div class="p-3">
            <h3 class="mb-1 text-dark-slate">Create Account</h3>
            <p class="text-muted mb-4">Fill the details to sign up</p>

            <?php if($message != ''): ?>
              <div class="alert alert-info"><?= $message ?></div>
            <?php endif; ?>

            <form id="signupForm" method="post" novalidate>
              <div class="mb-3">
                <label for="fullname" class="form-label">Full Name</label>
                <input type="text" name="fullname" id="fullname" class="form-control form-control-lg" placeholder="Enter your name" required>
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="Enter your email" required>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Enter password" required>
              </div>

              <div class="mb-3">
                <label for="confirm" class="form-label">Confirm Password</label>
                <input type="password" name="confirm" id="confirm" class="form-control form-control-lg" placeholder="Re-enter password" required>
              </div>

              <div class="d-grid mb-3">
                <button type="submit" class="btn btn-lg btn-primary btn-login">Sign Up</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </main>

<script>
  // Optional: front-end validation
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('signupForm');
    const name = document.getElementById('fullname');
    const email = document.getElementById('email');
    const pwd = document.getElementById('password');
    const confirm = document.getElementById('confirm');

    form.addEventListener('submit', function (e) {
      let valid = true;
      if (!name.value.trim()) { name.classList.add('is-invalid'); valid = false; } else { name.classList.remove('is-invalid'); }
      if (!email.value.trim() || !email.value.includes('@')) { email.classList.add('is-invalid'); valid = false; } else { email.classList.remove('is-invalid'); }
      if (!pwd.value.trim()) { pwd.classList.add('is-invalid'); valid = false; } else { pwd.classList.remove('is-invalid'); }
      if (confirm.value !== pwd.value || !confirm.value.trim()) { confirm.classList.add('is-invalid'); valid = false; } else { confirm.classList.remove('is-invalid'); }
      if (!valid) e.preventDefault();
    });
  });

  // Theme
  document.addEventListener("DOMContentLoaded", () => {
    const savedTheme = localStorage.getItem("theme");
    if (savedTheme === "dark") {
      document.body.classList.add("dark-mode");
    }
  });
</script>
</body>
</html>
