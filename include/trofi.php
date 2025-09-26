<?php
$conn = mysqli_connect("localhost", "root", "", "data_pemain_bola");

if (isset($_POST['simpan'])) {
    $id_pemain = $_POST['id_pemain'];
    $nama_trofi = $_POST['nama_trofi'];
    $tahun = $_POST['tahun'];

    mysqli_query($conn, "INSERT INTO trofi (id_pemain, nama_trofi, tahun) 
                         VALUES ('$id_pemain','$nama_trofi','$tahun')");
    header("Location: trofi.php");
    exit;
}

if (isset($_POST['update'])) {
    $id_trofi = $_POST['id_trofi'];
    $id_pemain = $_POST['id_pemain'];
    $nama_trofi = $_POST['nama_trofi'];
    $tahun = $_POST['tahun'];

    mysqli_query($conn, "UPDATE trofi 
                         SET id_pemain='$id_pemain', nama_trofi='$nama_trofi', tahun='$tahun' 
                         WHERE id_trofi='$id_trofi'");
    header("Location: trofi.php");
    exit;
}

if (isset($_GET['hapus'])) {
    $id_trofi = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM trofi WHERE id_trofi='$id_trofi'");
    header("Location: trofi.php");
    exit;
}

$edit_id = "";
$id_pemain = "";
$nama_trofi = "";
$tahun = "";

if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM trofi WHERE id_trofi='$edit_id'");
    $data = mysqli_fetch_assoc($result);

    $id_pemain = $data['id_pemain'];
    $nama_trofi = $data['nama_trofi'];
    $tahun = $data['tahun'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Trofi Pemain</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        background: #137bdbff;
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
        background: #de6b14ff;
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
    <h2 style="text-align: center">Data Trofi Pemain</h2>
    <form method="POST" action="trofi.php">
    <input type="hidden" name="id_trofi" value="<?php echo $edit_id; ?>">

    <select name="id_pemain" required>
        <option value="">--Pilih Pemain--</option>
        <?php
        $pemain = mysqli_query($conn, "SELECT * FROM pemain");
        while ($row = mysqli_fetch_assoc($pemain)) {
            $selected = ($row['id_pemain'] == $id_pemain) ? "selected" : "";
            echo "<option value='".$row['id_pemain']."' $selected>".$row['nama']."</option>";
        }
        ?>
    </select>

    <input type="text" name="nama_trofi" placeholder="Nama Trofi" value="<?php echo $nama_trofi; ?>" required>
    <input type="number" name="tahun" placeholder="Tahun" value="<?php echo $tahun; ?>" required>

    <?php if ($edit_id) { ?>
        <button type="submit" name="update">Update</button>
    <?php } else { ?>
        <button type="submit" name="simpan">Simpan</button>
    <?php } ?>
</form>

<br>

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Pemain</th>
        <th>Trofi</th>
        <th>Tahun</th>
        <th>Aksi</th>
    </tr>
    <?php
    $no = 1;
    $result = mysqli_query($conn, "SELECT trofi.id_trofi, trofi.nama_trofi, trofi.tahun, pemain.nama 
                                   FROM trofi 
                                   LEFT JOIN pemain ON trofi.id_pemain = pemain.id_pemain");
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>".$no++."</td>
                <td>".$row['nama']."</td>
                <td>".$row['nama_trofi']."</td>
                <td>".$row['tahun']."</td>
                <td>
                    <a href='trofi.php?edit=".$row['id_trofi']."'>Edit</a> | 
                    <a href='trofi.php?hapus=".$row['id_trofi']."' onclick=\"return confirm('Yakin hapus data?')\">Hapus</a>
                </td>
              </tr>";
    }
    ?>
</table>
</body>
</html>