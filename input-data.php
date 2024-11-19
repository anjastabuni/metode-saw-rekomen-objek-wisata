<?php
include 'config/config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SPK SAW - Input Data</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
  <div class="container my-5">
    <h1 class="text-center mb-4">Input Data SPK</h1>
    <a href="hasil.html">Lihat Rekomendasi</a>
    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs" id="inputDataTabs" role="tablist">
      <li class="nav-item">
        <button class="nav-link active" id="kriteria-tab" data-bs-toggle="tab" data-bs-target="#kriteria" type="button" role="tab">Kriteria</button>
      </li>
      <li class="nav-item">
        <button class="nav-link" id="alternatif-tab" data-bs-toggle="tab" data-bs-target="#alternatif" type="button" role="tab">Alternatif</button>
      </li>
      <li class="nav-item">
        <button class="nav-link" id="nilai-tab" data-bs-toggle="tab" data-bs-target="#nilai" type="button" role="tab">Nilai Alternatif</button>
      </li>
    </ul>

    <!-- Tabs Content -->
    <div class="tab-content mt-4" id="inputDataTabsContent">
      <!-- Tab Kriteria -->
      <div class="tab-pane fade show active" id="kriteria" role="tabpanel">
        <h3>Input Kriteria</h3>
        <form action="config/config.php" method="post">
          <div class="mb-3">
            <label for="namaKriteria" class="form-label">Nama Kriteria</label>
            <input type="text" class="form-control" id="namaKriteria" name="nama_kriteria" placeholder="Contoh: Biaya" />
          </div>
          <div class="mb-3">
            <label for="bobot" class="form-label">Bobot</label>
            <input type="number" class="form-control" name="bobot" id="bobot" placeholder="Contoh: 0.3" step="0.01" />
          </div>
          <div class="mb-3">
            <label for="tipe" class="form-label">Tipe</label>
            <select id="tipe" class="form-select" name="tipe">
              <option value="benefit">Benefit</option>
              <option value="cost">Cost</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Simpan Kriteria</button>
        </form>
        <hr />
        <!-- Table for Kriteria -->
        <h4>Daftar Kriteria</h4>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama Kriteria</th>
              <th>Bobot</th>
              <th>Tipe</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $result = $conn->query("SELECT * FROM kriteria");
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "<tr>
                      <td>{$row['id']}</td>
                      <td>{$row['nama_kriteria']}</td>
                      <td>{$row['bobot']}</td>
                      <td>{$row['tipe']}</td>
                      <td>
                        <button class='btn btn-warning btn-sm'>Edit</button>
                        <button class='btn btn-danger btn-sm'>Hapus</button>
                      </td>
                    </tr>";
              }
            } else {
              echo "<tr><td colspan='5'>Tidak ada data kriteria</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>

      <!-- Tab Alternatif -->
      <div class="tab-pane fade" id="alternatif" role="tabpanel">
        <h3>Input Alternatif</h3>
        <form action="config/config.php" method="post">
          <div class="mb-3">
            <label for="namaAlternatif" class="form-label">Nama Alternatif</label>
            <input type="text" class="form-control" id="namaAlternatif" name="nama_alternatif" placeholder="Contoh: Pantai A" />
          </div>
          <button type="submit" class="btn btn-primary">Simpan Alternatif</button>
        </form>
        <hr />
        <!-- Table for Alternatif -->
        <h4>Daftar Alternatif</h4>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama Alternatif</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $result = $conn->query("SELECT * FROM alternatif");
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "<tr>
                      <td>{$row['id']}</td>
                      <td>{$row['nama_alternatif']}</td>
                      <td>
                        <button class='btn btn-warning btn-sm'>Edit</button>
                        <button class='btn btn-danger btn-sm'>Hapus</button>
                      </td>
                    </tr>";
              }
            } else {
              echo "<tr><td colspan='3'>Tidak ada data alternatif</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>

      <!-- Tab Nilai Alternatif -->
      <div class="tab-pane fade" id="nilai" role="tabpanel">
        <h3>Input Nilai Alternatif</h3>
        <form action="config/config.php" method="post">
          <div class="mb-3">
            <label for="alternatif" class="form-label">Alternatif</label>
            <select id="alternatif" class="form-select" name="alternatif">
              <option value="Pantai Base-G">Pantai Base-G</option>
              <option value="Danau Love">Danau Love</option>
              <option value="Pantai Holtekam">Pantai Holtekam</option>
              <option value="Air Terjun Syclop">Air Terjun Syclop</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="kriteria" class="form-label">Kriteria</label>
            <select id="kriteria" class="form-select" name="kriteria">
              <option value="Biaya">Biaya</option>
              <option value="Jarak">Jarak</option>
              <option value="Fasilitas">Fasilitas</option>
              <option value="Keamanan">Keamanan</option>
              <option value="Ulasan Pengunjung">Ulasan Pengunjung</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="nilai" class="form-label">Nilai</label>
            <input type="number" class="form-control" id="nilai" name="nilai" placeholder="Contoh: 5" />
          </div>
          <button type="submit" class="btn btn-primary">Simpan Nilai</button>
        </form>
        <hr />
        <!-- Table for Nilai Alternatif -->
        <h4>Daftar Nilai Alternatif</h4>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>#</th>
              <th>Alternatif</th>
              <th>Kriteria</th>
              <th>Nilai</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $result = $conn->query("SELECT na.id, a.nama_alternatif, k.nama_kriteria, na.nilai
                              FROM nilai na
                              JOIN alternatif a ON na.alternatif_id = a.id
                              JOIN kriteria k ON na.kriteria_id = k.id");
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "<tr>
                      <td>{$row['id']}</td>
                      <td>{$row['nama_alternatif']}</td>
                      <td>{$row['nama_kriteria']}</td>
                      <td>{$row['nilai']}</td>
                      <td>
                        <button class='btn btn-warning btn-sm'>Edit</button>
                        <button class='btn btn-danger btn-sm'>Hapus</button>
                      </td>
                    </tr>";
              }
            } else {
              echo "<tr><td colspan='5'>Tidak ada data nilai alternatif</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>