<?php
include "db.php";

// DATA COUNTS
$members = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) total FROM members"))['total'];
$books = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) total FROM books"))['total'];
$issued = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) total FROM issued_books"))['total'];
$returned = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) total FROM returned_books"))['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Statistics Report — BookHive</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body{
  font-family: Arial, sans-serif;
  padding:30px;
  background:#f8f9fa;
}
h2{
  text-align:center;
}
.chart-box{
  width:400px;
  margin:40px auto;
}
button{
  display:block;
  margin:30px auto;
  padding:10px 20px;
  font-size:16px;
}
</style>
</head>

<body>

<h2>📊 Library Statistics Report (Pie Charts)</h2>

<div class="chart-box">
  <canvas id="libraryChart"></canvas>
</div>

<button onclick="window.print()">🖨️ Print / Save as PDF</button>

<script>
new Chart(document.getElementById("libraryChart"),{
  type:"pie",
  data:{
    labels:[
      "Members",
      "Books",
      "Issued Books",
      "Returned Books"
    ],
    datasets:[{
      data:[
        <?php echo $members ?>,
        <?php echo $books ?>,
        <?php echo $issued ?>,
        <?php echo $returned ?>
      ],
      backgroundColor:[
        "#00a497",
        "#ff7a00",
        "#0d6efd",
        "#dc3545"
      ]
    }]
  },
  options:{
    responsive:true,
    plugins:{
      legend:{
        position:"bottom"
      }
    }
  }
});
</script>

</body>
</html>
