<?php
include 'db.php'; // Make sure this file connects to your database

/* DELETE MEMBER */
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    mysqli_query($conn, "DELETE FROM members WHERE id=$id");
    header("Location: display-info.php"); // Refresh after deletion
    exit;
}

/* FETCH MEMBERS */
$members = mysqli_query($conn, "SELECT * FROM members ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Members — BookHive</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      margin: 0;
      font-family: "Poppins", sans-serif;
      height: 100vh;
      background: linear-gradient(120deg, #00a497, #ff7a00, #6A5ACD);
      background-size: 300% 300%;
      animation: gradientBG 10s ease infinite;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    @keyframes gradientBG {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .glass-card {
      width: 100%;
      max-width: 900px;
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.25);
      animation: fadeIn 0.8s ease-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    h2 {
      font-weight: 700;
      color: white;
      text-shadow: 0 2px 10px rgba(0,0,0,0.4);
    }

    .btn-main {
      background: linear-gradient(90deg, #00a497, #ff7a00);
      border: none;
      color: white;
      font-weight: 600;
      border-radius: 10px;
      padding: 12px 20px;
      transition: 0.3s;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    .btn-main:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }

    .inner-card {
      background: rgba(255,255,255,0.8);
      border-radius: 15px;
      padding: 25px;
      animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
      from { opacity: 0; transform: translateY(15px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>

<body>

<div class="glass-card">

  <h2 class="text-center mb-4">Library Volunteers (Members)</h2>

  <!-- Buttons -->
  <div class="text-center mb-4">
    <button class="btn btn-main me-2" onclick="showForm()">➕ Add Member</button>
    <button class="btn btn-light" onclick="showTable()">📋 View Members</button>
  </div>

  <!-- Add Member Form -->
  <div id="memberForm" class="inner-card" style="display:none;">
    <h4>Add New Volunteer</h4>
    <form method="POST" action="new-member.php"> <!-- Send data to your new-member.php -->
      <div class="row g-3 mt-1">
        <div class="col-md-6">
          <label class="form-label">First Name</label>
          <input type="text" name="first_name" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Last Name</label>
          <input type="text" name="last_name" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Phone</label>
          <input type="text" name="phone" class="form-control" required>
        </div>
        <div class="col-12">
          <label class="form-label">Reason for Volunteering</label>
          <textarea name="reason" class="form-control" rows="2"></textarea>
        </div>
      </div>
      <div class="text-end mt-3">
        <button type="submit" class="btn btn-main">Save Member</button>
      </div>
    </form>
  </div>

  <!-- Members Table -->
  <div id="memberTable" class="inner-card" style="display:block;">
    <h4>Volunteers List</h4>

    <table class="table table-striped mt-3">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Action</th>
        </tr>
      </thead>

      <tbody>
        <?php while($row = mysqli_fetch_assoc($members)): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['phone']) ?></td>
          <td>
            <a href="edit-member.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
            <a href="display-info.php?delete=<?= $row['id'] ?>" 
               onclick="return confirm('Are you sure you want to delete this member?')" 
               class="btn btn-danger btn-sm">Delete</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

  </div>

</div>

<script>
function showForm() {
  document.getElementById("memberForm").style.display = "block";
  document.getElementById("memberTable").style.display = "none";
}

function showTable() {
  document.getElementById("memberForm").style.display = "none";
  document.getElementById("memberTable").style.display = "block";
}
</script>

</body>
</html>
