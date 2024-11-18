<?php
include 'config.php';

// Fetch kriteria data
$kriteria = $conn->query("SELECT * FROM kriteria");
$alternatif = $conn->query("SELECT * FROM alternatif");

// Prepare matrices
$matrix = [];
$bobot = [];
$tipe = [];

// Store bobot dan tipe kriteria
while ($row = $kriteria->fetch_assoc()) {
    $bobot[$row['id']] = $row['bobot'];
    $tipe[$row['id']] = $row['tipe'];
}

// Fetch nilai alternatif
$nilai = $conn->query("SELECT * FROM nilai");

// Build matrix
while ($row = $nilai->fetch_assoc()) {
    $matrix[$row['alternatif_id']][$row['kriteria_id']] = $row['nilai'];
}

// Normalisasi
$normalized = [];
foreach ($matrix as $alt_id => $criteria) {
    foreach ($criteria as $crit_id => $value) {
        if ($tipe[$crit_id] == 'benefit') {
            $max = max(array_column(array_map(null, $matrix), $crit_id));
            $normalized[$alt_id][$crit_id] = $value / $max;
        } elseif ($tipe[$crit_id] == 'cost') {
            $min = min(array_column(array_map(null, $matrix), $crit_id));
            $normalized[$alt_id][$crit_id] = $min / $value;
        }
    }
}

// Menghitung skor preferensi
$scores = [];
foreach ($normalized as $alt_id => $criteria) {
    $scores[$alt_id] = 0;
    foreach ($criteria as $crit_id => $value) {
        $scores[$alt_id] += $value * $bobot[$crit_id];
    }
}

// Urutkan skor
arsort($scores);

// Tampilkan hasil
echo "<h1>Hasil Perhitungan SAW</h1>";
echo "<table border='1' cellpadding='10' cellspacing='0'>";
echo "<tr><th>Alternatif</th><th>Skor</th></tr>";
foreach ($scores as $alt_id => $score) {
    $alt_name = $conn->query("SELECT nama FROM alternatif WHERE id = $alt_id")->fetch_assoc()['nama'];
    echo "<tr><td>{$alt_name}</td><td>{$score}</td></tr>";
}
echo "</table>";
