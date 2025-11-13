<?php
include 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $umur = $_POST['umur'];
    $jk   = $_POST['jenis_kelamin'];
    $tinggi = $_POST['tinggi']; 

    // 1. Simpan data ke tabel 'users'
    $query_user = "INSERT INTO users (nama, umur, jenis_kelamin) VALUES ('$nama', '$umur', '$jk')";
    
    if (mysqli_query($conn, $query_user)) {
        // 2. Ambil ID user yang baru saja di-insert
        $id_user_baru = mysqli_insert_id($conn);
        
        // 3. Simpan data ke tabel 'data_ukur' menggunakan ID baru
        // (Saya asumsikan nama kolom tanggalmu adalah 'tanggal_input')
        $query_ukur = "INSERT INTO data_ukur (tinggi, id, tanggal_input) VALUES ('$tinggi', '$id_user_baru', NOW())";
        
        if (mysqli_query($conn, $query_ukur)) {
            echo "<script>alert('Data berhasil disimpan!'); window.location.href='tabel.php';</script>";
        } else {
            echo "Error (data_ukur): " . mysqli_error($conn);
        }

    } else {
        echo "Error (users): " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cek Tinggi - HeightCheck</title>
  <link rel="stylesheet" href="css/style.css"> 
</head>
<body>

  <div class="container">
    <h3>Cek Tinggi</h3>

    <form method="POST" action="">
      <div class="form-group">
        <input type="text" name="nama" placeholder="Nama" required>
        <input type="number" name="umur" placeholder="Umur" required>
        <select name="jenis_kelamin" required>
            <option value="">Pilih Gender</option>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select>
      </div>

      <div style="margin: 50px 0;">
          <p>Masukkan Tinggi (Simulasi Sensor)</p>
          <input type="number" name="tinggi" step="0.1" placeholder="0" style="font-size: 3rem; text-align: center; border: none; background: transparent; width: 150px;" required>
          <span style="font-size: 1.5rem;">CM</span>
          <p>....................................</p>
      </div>

      <div style="display: flex; justify-content: space-between; align-items: center;">
          <a href="index.php" class="btn btn-black">Kembali</a>
          <button type="submit" class="btn btn-green" style="width: auto; padding: 12px 40px;">Simpan</button>
      </div>
    </form>
  </div>

</body>
</html>