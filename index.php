<?php
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Aplikasi Sepak Bola</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #0d4882ff, #105eabff);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    h1 {
      color: #ffffffff;
      text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
    }
    .card {
      border: none;
      border-radius: 15px;
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 18px rgba(0,0,0,0.15);
    }
    .card-title {
      font-weight: bold;
      color: #333;
    }
    .card-text {
      color: #442dc6ff;
      font-size: 0.95rem;
    }
    .btn {
      border-radius: 30px;
      padding: 8px 20px;
      font-weight: 500;
    }
  </style>
</head>
<body>

<div class="container mt-5">
  <div class="text-center mb-4">
    <h1 class="fw-bold">Aplikasi Menambah Data Pemain Sepak Bola</h1>
  </div>

  <div class="row g-4">
    <div class="col-md-4">
      <div class="card shadow-sm h-100 text-center p-3">
        <div class="card-body d-flex flex-column">
          <h4 class="card-title mb-2">Klub</h4>
          <p class="card-text flex-grow-1">Kelola data klub sepak bola.</p>
          <a href="include/klub.php" class="btn btn-primary mt-auto">Kelola Klub</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card shadow-sm h-100 text-center p-3">
        <div class="card-body d-flex flex-column">
          <h4 class="card-title mb-2">Pemain</h4>
          <p class="card-text flex-grow-1">Kelola data pemain dan market value.</p>
          <a href="include/pemain.php" class="btn btn-success mt-auto">Kelola Pemain</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card shadow-sm h-100 text-center p-3">
        <div class="card-body d-flex flex-column">
          <h4 class="card-title mb-2">Trofi</h4>
          <p class="card-text flex-grow-1">Catat trofi yang pernah diraih pemain.</p>
          <a href="include/trofi.php" class="btn btn-warning mt-auto">Kelola Trofi</a>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
