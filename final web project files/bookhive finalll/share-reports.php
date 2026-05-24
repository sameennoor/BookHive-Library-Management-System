<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Share Reports — BookHive</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    :root{
      --teal:#00a497;
      --orange:#ff7a00;
      --dark:#1e1e1e;
      --light:#ffffff;
    }

    body{
      font-family: 'Poppins', sans-serif;
      background-image: url('assets/tag1.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      position: relative;
      min-height: 100vh;
    }

    body::before{
      content:"";
      position:absolute;
      inset:0;
      background:rgba(0,0,0,0.55);
      z-index:0;
    }

    main{
      position:relative;
      z-index:1;
    }

    .card{
      border-radius:15px;
      box-shadow:0 10px 25px rgba(0,0,0,0.3);
      transition:.3s;
      backdrop-filter: blur(10px);
    }

    .card:hover{
      transform: translateY(-5px);
      box-shadow:0 20px 40px rgba(0,0,0,0.45);
    }

    .report-btn{
      background:linear-gradient(90deg,var(--teal),var(--orange));
      color:white;
      border:none;
      padding:12px 18px;
      border-radius:10px;
      font-weight:600;
    }
  </style>
</head>

<body>

<main class="container py-5">

  <h2 class="text-center text-light mb-4">
    <i class="fas fa-share-alt"></i> Share & Export Reports
  </h2>

  <div class="row g-4">

    <!-- REPORT TYPE -->
    <div class="col-md-6">
      <div class="card p-4 bg-light">
        <h4 class="mb-3"><i class="fas fa-filter"></i> Select Report Duration</h4>
        <select id="reportType" class="form-select">
          <option value="current">📌 Current Report</option>
          <option value="monthly">📅 Monthly Report</option>
          <option value="yearly">📆 Yearly Report</option>
        </select>
      </div>
    </div>

    <!-- FORMAT -->
    <div class="col-md-6">
      <div class="card p-4 bg-light">
        <h4 class="mb-3"><i class="fas fa-chart-line"></i> Report Format</h4>
        <select id="formatType" class="form-select">
          <option value="simple">📄 Simple Report</option>
          <option value="stat">📊 Statistics Report (Charts)</option>
        </select>
      </div>
    </div>

    <!-- DOWNLOAD OPTIONS -->
    <div class="col-md-4">
      <div class="card p-4 bg-light text-center">
        <i class="fas fa-file-excel fa-3x mb-3 text-success"></i>
        <h5>Download Excel</h5>
        <button class="btn report-btn w-100" onclick="downloadExcel()">Download</button>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card p-4 bg-light text-center">
        <i class="fas fa-file-csv fa-3x mb-3 text-primary"></i>
        <h5>Download CSV</h5>
        <button class="btn report-btn w-100" onclick="downloadCSV()">Download</button>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card p-4 bg-light text-center">
        <i class="fas fa-file-pdf fa-3x mb-3 text-danger"></i>
        <h5>Download PDF</h5>
        <button class="btn report-btn w-100" onclick="downloadPDF()">Download</button>
      </div>
    </div>

  </div>
</main>

<script>
function downloadExcel(){
  const format = document.getElementById("formatType").value;

  if(format === "stat"){
    // charts only make sense in PDF
    window.open("stat-report.php","_blank");
  }else{
    window.location.href = "download-report.php?type=excel";
  }
}

function downloadCSV(){
  const format = document.getElementById("formatType").value;

  if(format === "stat"){
    alert("Statistics report cannot be downloaded as CSV. Please use PDF.");
  }else{
    window.location.href = "download-report.php?type=csv";
  }
}

function downloadPDF(){
  const format = document.getElementById("formatType").value;

  if(format === "stat"){
    window.open("stat-report.php","_blank");
  }else{
    window.location.href = "download-report.php?type=pdf";
  }
}
</script>

</body>
</html>
