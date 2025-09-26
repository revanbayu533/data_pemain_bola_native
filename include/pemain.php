<?php
$conn = mysqli_connect("localhost", "root", "", "data_pemain_bola");

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $posisi = $_POST['posisi'];
    $nomor = $_POST['nomor'];
    $id_klub = $_POST['id_klub'];
    $mv = $_POST['market_value'];

    mysqli_query($conn, "INSERT INTO pemain (nama, posisi, nomor_punggung, id_klub, market_value) 
                         VALUES ('$nama','$posisi','$nomor','$id_klub','$mv')");
    header("Location: pemain.php");
    exit;
}

if (isset($_POST['update'])) {
    $id_pemain = $_POST['id_pemain'];
    $nama = $_POST['nama'];
    $posisi = $_POST['posisi'];
    $nomor = $_POST['nomor'];
    $id_klub = $_POST['id_klub'];
    $mv = $_POST['market_value'];

    mysqli_query($conn, "UPDATE pemain SET nama='$nama', posisi='$posisi', nomor_punggung='$nomor',
                         id_klub='$id_klub', market_value='$mv' WHERE id_pemain=$id_pemain");
    header("Location: pemain.php");
    exit;
}

if (isset($_GET['hapus'])) {
    $id_pemain = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM pemain WHERE id_pemain=$id_pemain");
    header("Location: pemain.php");
    exit;
}

$edit_mode = false;
$edit_data = [];
if (isset($_GET['edit'])) {
    $edit_mode = true;
    $id_pemain = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM pemain WHERE id_pemain=$id_pemain");
    $edit_data = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Pemain</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        background: #10ce20ff;
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
        background: #007BFF;
        color: white;
        border: none;
        cursor: pointer;
    }
    form button:hover {
        background: #0056b3;
    }
    table {
        border-collapse: collapse;
        width: 100%;
        background: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    th, td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: center;
    }
    th {
        background: #3dba54ff;
        color: white;
    }
    tr:nth-child(even) {
        background: #f9f9f9;
    }
    a {
        text-decoration: none;
        color: #007BFF;
        font-weight: bold;
    }
    a:hover {
        color: #0056b3;
    }
</style>
</head>
<body>

<h2 style="text-align: center">Data Pemain</h2>
<form method="POST">
    <?php if ($edit_mode): ?>
        <input type="hidden" name="id_pemain" value="<?= $edit_data['id_pemain'] ?>">
    <?php endif; ?>

    <input type="text" name="nama" placeholder="Nama Pemain" 
           value="<?= $edit_mode ? $edit_data['nama'] : '' ?>" required>
    <input type="text" name="posisi" placeholder="Posisi" 
           value="<?= $edit_mode ? $edit_data['posisi'] : '' ?>" required>
    <input type="number" name="nomor" placeholder="Nomor Punggung" 
           value="<?= $edit_mode ? $edit_data['nomor_punggung'] : '' ?>" required>

    <select name="id_klub" required>
        <option value="">--Pilih Klub--</option>
        <?php
        $klub = mysqli_query($conn, "SELECT * FROM klub");
        while ($k = mysqli_fetch_assoc($klub)) {
            $selected = ($edit_mode && $edit_data['id_klub'] == $k['id_klub']) ? 'selected' : '';
            echo "<option value='".$k['id_klub']."' $selected>".$k['nama_klub']."</option>";
        }
        ?>
    </select>

    <input type="number" name="market_value" placeholder="Market Value" 
           value="<?= $edit_mode ? $edit_data['market_value'] : '' ?>" required>

    <button type="submit" name="<?= $edit_mode ? 'update' : 'simpan' ?>">
        <?= $edit_mode ? 'Update' : 'Simpan' ?>
    </button>
</form>

<table border="1" cellpadding="5">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Posisi</th>
        <th>No</th>
        <th>Klub</th>
        <th>Market Value</th>
        <th>Aksi</th>
    </tr>
    <?php
    $no=1;
    $sql = "SELECT pemain.*, klub.nama_klub
            FROM pemain
            LEFT JOIN klub ON pemain.id_klub = klub.id_klub";
    $result = mysqli_query($conn, $sql) or die("Query error: ".mysqli_error($conn));

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
            <td>".$no++."</td>
            <td>".$row['nama']."</td>
            <td>".$row['posisi']."</td>
            <td>".$row['nomor_punggung']."</td>
            <td>".$row['nama_klub']."</td>
            <td>".$row['market_value']."</td>
            <td>
                <a href='?edit=".$row['id_pemain']."'>Edit</a> |
                <a href='?hapus=".$row['id_pemain']."' onclick=\"return confirm('Hapus?')\">Hapus</a>
            </td>
        </tr>";
    }
    ?>
</table>

</body>
</html>
