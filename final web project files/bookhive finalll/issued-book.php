<?php
include 'db.php';

/* ISSUE BOOK */
if (isset($_POST['issue_book'])) {
    $member_id   = mysqli_real_escape_string($conn, $_POST['member_id']);
    $book_id     = mysqli_real_escape_string($conn, $_POST['book_id']);
    $issue_date  = $_POST['issue_date'];
    $return_date = $_POST['return_date'];
    $remarks     = mysqli_real_escape_string($conn, $_POST['remarks']);

    if ($member_id && $book_id && $issue_date && $return_date) {
        mysqli_query($conn,
            "INSERT INTO issued_books (member_id, book_id, issue_date, return_date, remarks)
             VALUES ('$member_id','$book_id','$issue_date','$return_date','$remarks')"
        );
    }
}

/* FETCH ISSUED BOOKS */
$issued = mysqli_query($conn,
    "SELECT * FROM issued_books ORDER BY created_at DESC"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Issued Books — BookHive</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="theme.css">

  <!-- ⚠️ YOUR ORIGINAL STYLES (UNCHANGED) -->
  <style>
    :root{
      --teal:#00a497;
      --orange:#ff7a00;
      --dark-slate:#2F4F4F;
      --card-bg:#ffffff;
    }

    .form-wrapper{
      width:950px;
      max-width:96%;
      background:linear-gradient(180deg,rgba(255,255,255,0.96),rgba(255,255,255,0.92));
      box-shadow:0 15px 40px rgba(0,0,0,0.25);
      border-radius:12px;
      overflow:hidden;
      animation:float 6s ease-in-out infinite alternate;
    }

    @keyframes float {
      from { transform: translateY(0px); }
      to { transform: translateY(-10px); }
    }

    .left-panel{
      background:linear-gradient(135deg,rgba(0,164,151,0.95),rgba(255,122,0,0.95));
      color:#fff;
      min-height:500px;
    }

    .brand-title{ font-weight:700; }

    .right-panel{
      background:var(--card-bg);
      min-height:500px;
      overflow-y:auto;
      padding-bottom:25px;
    }

    .form-control{
      border-radius:10px;
    }

    .btn-issue{
      background:linear-gradient(90deg,var(--teal),var(--orange));
      border:none;
      color:#fff;
      border-radius:10px;
      padding:12px 18px;
      font-weight:600;
    }

    table thead{
      background:linear-gradient(90deg,var(--teal),var(--orange));
      color:#fff;
    }

    .table-container{
      max-height:200px;
      overflow-y:auto;
    }
  </style>
</head>

<body>

<main class="d-flex align-items-center justify-content-center min-vh-100">
<section class="form-wrapper shadow-lg rounded-4 overflow-hidden">
<div class="row g-0">

<!-- LEFT -->
<div class="col-md-5 left-panel d-flex flex-column justify-content-center align-items-center text-center p-4">
  <img src="assets/logo.png" width="120" class="mb-3">
  <h2 class="brand-title">Issued Books</h2>
  <p class="small">Keep track of all issued books efficiently</p>
</div>

<!-- RIGHT -->
<div class="col-md-7 right-panel p-4">

<h3>Book Issue Form</h3>
<p class="text-muted">Record details of books issued to members</p>

<form method="POST">

  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Member ID</label>
      <input type="text" name="member_id" class="form-control" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Book ID</label>
      <input type="text" name="book_id" class="form-control" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Issue Date</label>
      <input type="date" name="issue_date" class="form-control" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Return Date</label>
      <input type="date" name="return_date" class="form-control" required>
    </div>

    <div class="col-12">
      <label class="form-label">Remarks</label>
      <textarea name="remarks" class="form-control" rows="2"></textarea>
    </div>
  </div>

  <div class="d-grid mt-4">
    <button type="submit" name="issue_book" class="btn btn-issue btn-lg">
      Issue Book
    </button>
  </div>
</form>

<!-- TABLE -->
<div class="mt-5">
<h5>Recently Issued Books</h5>

<div class="table-container">
<table class="table table-bordered table-striped align-middle">
<thead>
<tr>
  <th>Member ID</th>
  <th>Book ID</th>
  <th>Issue Date</th>
  <th>Return Date</th>
</tr>
</thead>
<tbody>

<?php while($row = mysqli_fetch_assoc($issued)): ?>
<tr>
  <td><?= htmlspecialchars($row['member_id']) ?></td>
  <td><?= htmlspecialchars($row['book_id']) ?></td>
  <td><?= $row['issue_date'] ?></td>
  <td><?= $row['return_date'] ?></td>
</tr>
<?php endwhile; ?>

</tbody>
</table>
</div>
</div>

</div>
</div>
</section>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", () => {
  if (localStorage.getItem("theme") === "dark") {
    document.body.classList.add("dark-mode");
  }
});
</script>

</body>
</html>
