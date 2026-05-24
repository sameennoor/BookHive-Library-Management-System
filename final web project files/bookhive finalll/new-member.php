<?php
include 'db.php'; // Your database connection file

// Handle form submission
if (isset($_POST['apply_membership'])) {
    $first_name       = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name        = mysqli_real_escape_string($conn, $_POST['last_name']);
    $semester         = mysqli_real_escape_string($conn, $_POST['semester']);
    $course           = mysqli_real_escape_string($conn, $_POST['course']);
    $degree           = mysqli_real_escape_string($conn, $_POST['degree']);
    $email            = mysqli_real_escape_string($conn, $_POST['email']);
    $phone            = mysqli_real_escape_string($conn, $_POST['phone']);
    $membership_type  = mysqli_real_escape_string($conn, $_POST['membership_type']);
    $from_date        = mysqli_real_escape_string($conn, $_POST['from_date']);
    $to_date          = mysqli_real_escape_string($conn, $_POST['to_date']);
    $reason           = mysqli_real_escape_string($conn, $_POST['reason']);

    $sql = "INSERT INTO members 
        (first_name, last_name, semester, course, degree, email, phone, membership_type, from_date, to_date, reason, created_at)
        VALUES 
        ('$first_name', '$last_name', '$semester', '$course', '$degree', '$email', '$phone', '$membership_type', '$from_date', '$to_date', '$reason', NOW())";

    if (mysqli_query($conn, $sql)) {
        $success = "Membership application submitted successfully!";
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Library Membership — BookHive</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="theme.css">

  <style>
    :root{ --teal:#00a497; --orange:#ff7a00; --dark-slate:#2F4F4F; --card-bg:#ffffff; }

    .form-wrapper{
      width: 950px; max-width: 96%;
      background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(255,255,255,0.92));
      box-shadow: 0 15px 40px rgba(0,0,0,0.25);
      border-radius: 12px;
      overflow: hidden;
      animation: float 6s ease-in-out infinite alternate;
    }

    @keyframes float { from { transform: translateY(0px); } to { transform: translateY(-10px); } }

    .left-panel{ background: linear-gradient(135deg, rgba(0,164,151,0.95), rgba(255,122,0,0.95)); color:#fff; min-height: 500px; }

    .brand-title{ font-weight:700; letter-spacing:0.2px; }

    .right-panel{ background: var(--card-bg); min-height: 500px; overflow-y: auto; padding-bottom: 25px; }

    .form-control{ border-radius:10px; border:1px solid #e6e8eb; box-shadow:none; }

    .btn-apply{ background: linear-gradient(90deg,var(--teal),var(--orange)); border:none; color:#fff; border-radius:10px; padding:12px 18px; font-weight:600; transition:0.3s; }
    .btn-apply:hover{ transform: translateY(-3px); box-shadow: 0 8px 18px rgba(0,0,0,0.2); }
  </style>
</head>
<body>

<main class="d-flex align-items-center justify-content-center min-vh-100">
<section class="form-wrapper shadow-lg rounded-4 overflow-hidden">
  <div class="row g-0">

    <!-- Left Panel -->
    <div class="col-md-5 left-panel d-flex flex-column justify-content-center align-items-center text-center p-4">
      <img src="assets/logo.png" alt="Library Logo" width="120" height="120" class="mb-3">
      <h2 class="brand-title mt-3">BookHive Membership</h2>
      <p class="text-light small px-3">Join our library and unlock access to books, knowledge, and community learning.</p>
    </div>

    <!-- Right Panel -->
    <div class="col-md-7 right-panel p-4">
      <div class="p-2">
        <h3 class="mb-1 text-dark-slate">Membership Form</h3>
        <p class="text-muted mb-4">Please fill in your details carefully</p>

        <?php if(isset($success)): ?>
          <div class="alert alert-success"><?= $success ?></div>
        <?php elseif(isset($error)): ?>
          <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form id="membershipForm" method="POST" novalidate>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">First Name</label>
              <input type="text" name="first_name" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Last Name</label>
              <input type="text" name="last_name" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Semester</label>
              <select name="semester" class="form-select" required>
                <option value="">Select</option>
                <option>1st</option><option>2nd</option><option>3rd</option>
                <option>4th</option><option>5th</option><option>6th</option>
                <option>7th</option><option>8th</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Course</label>
              <input type="text" name="course" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Degree</label>
              <input type="text" name="degree" class="form-control" placeholder="e.g. BS Computer Science" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Phone</label>
              <input type="number" name="phone" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Membership Type</label>
              <select name="membership_type" class="form-select" required>
                <option value="">Select</option>
                <option>Internship</option>
                <option>Volunteer</option>
                <option>Regular</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">From</label>
              <input type="date" name="from_date" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">To</label>
              <input type="date" name="to_date" class="form-control" required>
            </div>

            <div class="col-12">
              <label class="form-label">Reason / Objective</label>
              <textarea name="reason" class="form-control" placeholder="Why do you want to join?" rows="2"></textarea>
            </div>
          </div>

          <div class="d-grid mt-4">
            <button type="submit" name="apply_membership" class="btn btn-lg btn-apply">Apply for Membership</button>
          </div>
        </form>
      </div>
    </div>

  </div>
</section>
</main>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const savedTheme = localStorage.getItem("theme");
    if (savedTheme === "dark") document.body.classList.add("dark-mode");
  });
</script>

</body>
</html>
