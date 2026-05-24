<?php
include 'db.php';

/* ADD BOOK */
if (isset($_POST['add_book'])) {
    $title    = mysqli_real_escape_string($conn, $_POST['title']);
    $author   = mysqli_real_escape_string($conn, $_POST['author']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $quantity = (int) $_POST['quantity'];

    if ($title && $author && $category && $quantity > 0) {
        mysqli_query($conn,
          "INSERT INTO books (title, author, category, quantity)
           VALUES ('$title','$author','$category',$quantity)"
        );
    }
}

/* DELETE BOOK */
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    mysqli_query($conn, "DELETE FROM books WHERE id=$id");
}

/* FETCH BOOKS */
$books = mysqli_query($conn, "SELECT * FROM books ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>📚 Manage Books — BookHive</title>
  <link rel="icon" type="image/png" href="assets/logo.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a2e8b3b9bb.js" crossorigin="anonymous"></script>

  <style>
    :root {
      --teal: #00a497;
      --orange: #ff7a00;
      --dark-slate: #2F4F4F;
      --card-bg: #ffffff;
    }

    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: url('https://img.freepik.com/premium-photo/bookshelves-library-education-knowledge-concept-with-ai-generated_144089-1479.jpg') 
                  no-repeat center center/cover;
      min-height: 100vh;
      position: relative;
      color: #333;
    }

    body::before {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(0,0,0,0.6);
      z-index: 0;
    }

    main {
      position: relative;
      z-index: 1;
      padding: 2rem;
    }

    /* Sidebar */
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: 250px;
      background: linear-gradient(135deg, rgba(0,164,151,0.95), rgba(255,122,0,0.95));
      color: #fff;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      box-shadow: 0 10px 30px rgba(0,0,0,0.3);
      z-index: 10;
    }

    .sidebar h2 {
      text-align: center;
      margin-top: 1.5rem;
      font-weight: 700;
      letter-spacing: 1px;
    }

    .sidebar ul {
      list-style: none;
      padding: 0;
      margin-top: 2rem;
    }

    .sidebar ul li {
      padding: 15px 25px;
      cursor: pointer;
      transition: 0.3s;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .sidebar ul li:hover {
      background-color: rgba(255,255,255,0.2);
      border-left: 4px solid #fff;
    }

    .sidebar footer {
      text-align: center;
      font-size: 0.85rem;
      padding: 1rem;
      background: rgba(0,0,0,0.2);
    }

    /* Navbar */
    .navbar {
      margin-left: 250px;
      background: linear-gradient(90deg, rgba(255,255,255,0.95), rgba(255,255,255,0.85));
      backdrop-filter: blur(15px);
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 15px rgba(0,0,0,0.15);
      border-radius: 10px;
    }

    .navbar h4 {
      color: var(--dark-slate);
      font-weight: 700;
    }

    /* Button */
    .btn-add {
      background: linear-gradient(90deg, var(--teal), var(--orange));
      border: none;
      color: #fff;
      padding: 10px 20px;
      border-radius: 10px;
      font-weight: 600;
      transition: 0.3s;
    }

    .btn-add:hover {
      opacity: 0.85;
      transform: scale(1.05);
    }

    /* Table Card */
    .card {
      margin-left: 250px;
      margin-top: 2rem;
      background: rgba(255,255,255,0.95);
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.25);
      padding: 2rem;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      border-radius: 10px;
      overflow: hidden;
    }

    thead {
      background: linear-gradient(90deg, var(--teal), var(--orange));
      color: #fff;
    }

    th, td {
      text-align: center;
      padding: 12px;
      border-bottom: 1px solid rgba(0,0,0,0.1);
    }

    tbody tr:hover {
      background-color: rgba(0,164,151,0.05);
    }

    .btn-danger {
      background-color: var(--orange);
      border: none;
    }

    .btn-danger:hover {
      background-color: #ff5500;
    }

    /* Modal */
    .modal-content {
      border-radius: 12px;
      border: none;
      background: linear-gradient(180deg, #fff, #fefefe);
      box-shadow: 0 10px 30px rgba(0,0,0,0.25);
    }
  </style>
</head>

<body>

<!-- Sidebar -->
<div class="sidebar">
  <div>
    <h2>📚 BookHive</h2>
    <ul>
      <li onclick="location.href='dashboard.html'"><i class="fas fa-home"></i> Home</li>
      <li><i class="fas fa-book"></i> Books</li>
      <li onclick="location.href='issued-book.html'"><i class="fas fa-hand-holding"></i> Issued</li>
      <li onclick="location.href='returned-book.html'"><i class="fas fa-undo-alt"></i> Returns</li>
      <li onclick="location.href='share.html'"><i class="fas fa-chart-pie"></i> Reports</li>
      <li onclick="location.href='setting.html'"><i class="fas fa-cog"></i> Settings</li>
    </ul>
  </div>
  <footer>© 2025 BookHive</footer>
</div>

<!-- Main -->
<main>
  <nav class="navbar">
    <h4>Manage Books</h4>
    <button class="btn-add" data-bs-toggle="modal" data-bs-target="#addBookModal">➕ Add Book</button>
  </nav>

  <div class="card">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Book Title</th>
          <th>Author</th>
          <th>Category</th>
          <th>Quantity</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = mysqli_fetch_assoc($books)): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['title']) ?></td>
          <td><?= htmlspecialchars($row['author']) ?></td>
          <td><?= htmlspecialchars($row['category']) ?></td>
          <td><?= $row['quantity'] ?></td>
          <td>
            <a href="books.php?delete=<?= $row['id'] ?>"
               class="btn btn-danger btn-sm"
               onclick="return confirm('Delete this book?')">
              Delete
            </a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</main>

<!-- Add Book Modal -->
<div class="modal fade" id="addBookModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" class="modal-content p-3">
      <div class="modal-header border-0">
        <h5 class="modal-title">Add New Book</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="text" name="title" class="form-control mb-3" placeholder="Book Title" required>
        <input type="text" name="author" class="form-control mb-3" placeholder="Author Name" required>
        <input type="text" name="category" class="form-control mb-3" placeholder="Category" required>
        <input type="number" name="quantity" class="form-control mb-3" placeholder="Quantity" required>
        <button type="submit" name="add_book" class="btn-add w-100">Add Book</button>
      </div>
    </form>
  </div>
</div>

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
