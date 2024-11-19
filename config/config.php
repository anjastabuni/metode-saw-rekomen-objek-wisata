<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "spk_saw";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("koneksi gagal: " . $conn->connect_error);
}

// Proses simpan data kriteria
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nama_kriteria']) && isset($_POST['bobot']) && isset($_POST['tipe'])) {
        $nama_kriteria = $_POST['nama_kriteria'];
        $bobot = $_POST['bobot'];
        $tipe = $_POST['tipe'];

        $sql = "INSERT INTO kriteria (nama_kriteria, bobot, tipe) VALUES ('$nama_kriteria', $bobot, '$tipe')";
        if ($conn->query($sql) === TRUE) {
            // Redirect kembali ke halaman form dengan parameter status sukses
            header("Location: ../input-data.php?status=kriteria_berhasil");
            exit();
        } else {
            // Redirect kembali ke halaman form dengan parameter status error
            header("Location: ../input-data.php?status=kriteria_gagal");
            exit();
        }
    }

    // Proses simpan data alternatif
    if (isset($_POST['nama_alternatif'])) {
        $nama_alternatif = $_POST['nama_alternatif'];

        $sql = "INSERT INTO alternatif (nama_alternatif) VALUES ('$nama_alternatif')";
        if ($conn->query($sql) === TRUE) {
            // Redirect kembali ke halaman form dengan parameter status sukses
            header("Location: ../input-data.php?status=alternatif_berhasil");
            exit();
        } else {
            // Redirect kembali ke halaman form dengan parameter status error
            header("Location: ../input-data.php?status=alternatif_gagal");
            exit();
        }
    }

    // Proses simpan nilai alternatif
    if (isset($_POST['alternatif']) && isset($_POST['kriteria']) && isset($_POST['nilai'])) {
        $alternatif = $_POST['alternatif'];
        $kriteria = $_POST['kriteria'];
        $nilai = $_POST['nilai'];

        
        // Ambil ID alternatif dan kriteria berdasarkan nama
        $queryAlternatif = $conn->query("SELECT id FROM alternatif WHERE nama_alternatif = '$alternatif'");
        $queryKriteria = $conn->query("SELECT id FROM kriteria WHERE nama_kriteria = '$kriteria'");

        if ($queryAlternatif->num_rows > 0 && $queryKriteria->num_rows > 0) {
            $alternatif_id = $queryAlternatif->fetch_assoc()['id'];
            $kriteria_id = $queryKriteria->fetch_assoc()['id'];

            $sql = "INSERT INTO nilai (alternatif_id, kriteria_id, nilai) VALUES ($alternatif_id, $kriteria_id, $nilai)";
            if ($conn->query($sql) === TRUE) {
                // Redirect kembali ke halaman form dengan parameter status sukses
                header("Location: ../input-data.php?status=alternatif_berhasil");
                exit();
            } else {
                // Redirect kembali ke halaman form dengan parameter status error
                header("Location: ../input-data.php?status=alternatif_gagal");
                exit();
            }
        } else {
            echo "Alternatif atau Kriteria tidak ditemukan.";
        }
    }
}

// Tutup koneksi
// $conn->close();
