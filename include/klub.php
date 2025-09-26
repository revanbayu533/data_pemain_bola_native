<?php
$conn = mysqli_connect("localhost", "root", "", "data_pemain_bola");

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $negara = $_POST['negara'];
    $stadion = $_POST['stadion'];
    $tahun = $_POST['tahun'];

    mysqli_query($conn, "INSERT INTO klub (nama_klub, negara, stadion, tahun_berdiri) 
                         VALUES ('$nama','$negara','$stadion','$tahun')");
    header("Location: klub.php");
    exit;
}

if (isset($_POST['update'])) {
    $id_klub = $_POST['id_klub'];
    $nama = $_POST['nama'];
    $negara = $_POST['negara'];
    $stadion = $_POST['stadion'];
    $tahun = $_POST['tahun'];

    mysqli_query($conn, "UPDATE klub SET nama_klub='$nama', negara='$negara', 
                         stadion='$stadion', tahun_berdiri='$tahun' WHERE id_klub=$id_klub");
    header("Location: klub.php");
    exit;
}

if (isset($_GET['hapus'])) {
    $id_klub = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM klub WHERE id_klub=$id_klub");
    header("Location: klub.php");
    exit;
}

$edit_mode = false;
$edit_data = [];
if (isset($_GET['edit'])) {
    $edit_mode = true;
    $id_klub = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM klub WHERE id_klub=$id_klub");
    $edit_data = mysqli_fetch_assoc($result);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Klub</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        background: #c7b722ff;
    }
    h2 {
        color: #333;
    }
    form {
        margin-bottom: 20px;
        background: #fff;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    form input, form select, form button {
        padding: 8px;
        margin: 5px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    form button {
        background: #c7b722ff;
        color: white;
        border: none;
        cursor: pointer;
    }
    form button:hover {
        background: #c7b722ff;
    }
    table {
        border-collapse: collapse;
        width: 100%;
        background: #000000ff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    th, td {
        padding: 10px;
        border: 1px solid #000000ff;
        text-align: center;
    }
    th {
        background: #000000ff;
        color: white;
    }
    tr:nth-child(even) {
        background: #f9f9f9;
    }
    a {
        text-decoration: none;
        color: #c7b722ff;
        font-weight: bold;
    }
    a:hover {
        color: #c7b722ff;
    }
</style>
</head>
<body>
    <h2 style="text-align: center">Data Klub</h2>
    <form method="POST">
    <?php if ($edit_mode): ?>
        <input type="hidden" name="id_klub" value="<?= $edit_data['id_klub'] ?>">
    <?php endif; ?>

    <input type="text" name="nama" placeholder="Nama Klub" 
           value="<?= $edit_mode ? $edit_data['nama_klub'] : '' ?>" required>
    <input type="text" name="negara" placeholder="Negara" 
           value="<?= $edit_mode ? $edit_data['negara'] : '' ?>" required>
    <input type="text" name="stadion" placeholder="Stadion" 
           value="<?= $edit_mode ? $edit_data['stadion'] : '' ?>" required>
    <input type="date" name="tahun" placeholder="Tahun Berdiri" 
           value="<?= $edit_mode ? $edit_data['tahun_berdiri'] : '' ?>" required>

    <button type="submit" name="<?= $edit_mode ? 'update' : 'simpan' ?>">
        <?= $edit_mode ? 'Update' : 'Simpan' ?>
    </button>
</form>

<table border="1" cellpadding="5">
    <tr>
        <th>No</th>
        <th>Nama Klub</th>
        <th>Negara</th>
        <th>Stadion</th>
        <th>Tahun</th>
        <th>Aksi</th>
    </tr>
    <?php
    $no=1;
    $result = mysqli_query($conn, "SELECT * FROM klub");
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
            <td>".$no++."</td>
            <td>".$row['nama_klub']."</td>
            <td>".$row['negara']."</td>
            <td>".$row['stadion']."</td>
            <td>".$row['tahun_berdiri']."</td>
            <td>
                <a href='?edit=".$row['id_klub']."'>Edit</a> | 
                <a href='?hapus=".$row['id_klub']."' onclick=\"return confirm('Yakin ingin menghapus?')\">Hapus</a>
            </td>
        </tr>";
    }
    ?>
</table>

</body>
</html>