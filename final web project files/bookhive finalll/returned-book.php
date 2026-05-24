<?php
include 'db.php';

/* ADD RETURNED BOOK */
if (isset($_POST['return_book'])) {
    $member_id = (int)$_POST['member_id'];
    $book_id   = (int)$_POST['book_id'];
    $return_date = $_POST['return_date'];
    $condition   = mysqli_real_escape_string($conn, $_POST['condition']);

    if ($member_id && $book_id && $return_date && $condition) {
        $sql = "INSERT INTO returned_books (member_id, book_id, return_date, `condition`)
                VALUES ($member_id, $book_id, '$return_date', '$condition')";
        mysqli_query($conn, $sql);
    }
}

/* FETCH RETURNED BOOKS WITH BOOK TITLE */
$returned_books = mysqli_query($conn, "
    SELECT r.*, b.title AS book_title
    FROM returned_books r
    LEFT JOIN books b ON r.book_id = b.id
    ORDER BY r.id DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Returned Books — BookHive</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="theme.css">
  <style>
    :root { --teal:#00a497; --orange:#ff7a00; --card-bg:#ffffff; }
    main { position: relative; z-index: 1; }
    .form-wrapper { width: 950px; max-width: 95%; background: linear-gradient(180deg, rgba(255,255,255,0.95), rgba(255,255,255,0.92)); border-radius: 12px; padding-bottom: 20px; box-shadow: 0 15px 40px rgba(0,0,0,0.25); animation: float 6s ease-in-out infinite alternate; }
    @keyframes float { from { transform: translateY(0); } to { transform: translateY(-10px); } }
    .left-panel { background: linear-gradient(135deg, rgba(0,164,151,0.95), rgba(255,122,0,0.95)); color: #fff; min-height: 500px; }
    .btn-return { background: linear-gradient(90deg, var(--teal), var(--orange)); color: white; border: none; border-radius: 10px; padding: 12px; font-weight: 600; }
    table thead { background: linear-gradient(90deg,var(--teal),var(--orange)); color: #fff; }
    .table-container { max-height: 220px; overflow-y: auto; }
  </style>
</head>
<body>

<main class="d-flex justify-content-center align-items-center min-vh-100">
  <section class="form-wrapper">
    <div class="row g-0">

      <!-- LEFT PANEL -->
      <div class="col-md-5 left-panel d-flex flex-column align-items-center justify-content-center text-center p-4">
        <img src="assets/logo.png" width="110" height="110" class="mb-3">
        <h2 class="fw-bold">Returned Books</h2>
        <p class="text-light px-3">Record all returned books easily with BookHive.</p>
      </div>

      <!-- RIGHT PANEL -->
      <div class="col-md-7 p-4 bg-white">
        <h3 class="mb-1">Return Book Form</h3>
        <p class="text-muted mb-4">Fill in the details of returned books</p>

        <form method="POST">
          <div class="row g-3">

            <div class="col-md-6">
              <label class="form-label">Member ID</label>
              <input type="number" name="member_id" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Book ID</label>
              <input type="number" name="book_id" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Return Date</label>
              <input type="date" name="return_date" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Condition on Return</label>
              <select name="condition" class="form-select">
                <option>Good</option>
                <option>Damaged</option>
                <option>Lost Pages</option>
                <option>Minor Scratches</option>
              </select>
            </div>

          </div>

          <div class="d-grid mt-4">
            <button type="submit" name="return_book" class="btn-return btn-lg">Mark as Returned</button>
          </div>
        </form>

        <!-- Returned Books Table -->
        <div class="mt-5">
          <h5>Recently Returned Books</h5>
          <div class="table-container">
            <table class="table table-bordered table-striped align-middle">
              <thead>
                <tr>
                  <th>Member ID</th>
                  <th>Book ID</th>
                  <th>Book Title</th>
                  <th>Return Date</th>
                  <th>Condition</th>
                </tr>
              </thead>
              <tbody>
                <?php while($row = mysqli_fetch_assoc($returned_books)): ?>
                  <tr>
                    <td><?= $row['member_id'] ?></td>
                    <td><?= $row['book_id'] ?></td>
                    <td><?= htmlspecialchars($row['book_title']) ?></td>
                    <td><?= $row['return_date'] ?></td>
                    <td><?= $row['condition'] ?></td>
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

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const savedTheme = localStorage.getItem("theme");
    if (savedTheme === "dark") document.body.classList.add("dark-mode");
  });
</script>

</body>
</html>
