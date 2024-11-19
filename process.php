<?php
include 'config/config.php';

// Langkah 1: Ambil data kriteria, bobot, dan tipe
$kriteria = [];
$result = $conn->query("SELECT * FROM kriteria");
while ($row = $result->fetch_assoc()) {
    $kriteria[] = $row;
}

// Langkah 2: Ambil data nilai alternatif
$alternatif = [];
$nilaiAlternatif = [];
$result = $conn->query("SELECT na.alternatif_id, na.kriteria_id, na.nilai, a.nama_alternatif 
                        FROM nilai na
                        JOIN alternatif a ON na.alternatif_id = a.id");
while ($row = $result->fetch_assoc()) {
    $alternatif[$row['alternatif_id']] = $row['nama_alternatif'];
    $nilaiAlternatif[$row['alternatif_id']][$row['kriteria_id']] = $row['nilai'];
}

// Langkah 3: Normalisasi data
$normalisasi = [];
foreach ($kriteria as $k) {
    $kriteriaId = $k['id'];
    $tipe = $k['tipe'];
    $columnValues = array_column($nilaiAlternatif, $kriteriaId);

    foreach ($nilaiAlternatif as $altId => $values) {
        if ($tipe === 'benefit') {
            $normalisasi[$altId][$kriteriaId] = $values[$kriteriaId] / max($columnValues);
        } else { // cost
            $normalisasi[$altId][$kriteriaId] = min($columnValues) / $values[$kriteriaId];
        }
    }
}

// Langkah 4: Hitung skor preferensi
$skor = [];
foreach ($normalisasi as $altId => $values) {
    $total = 0;
    foreach ($kriteria as $k) {
        $kriteriaId = $k['id'];
        $bobot = $k['bobot'];
        $total += $values[$kriteriaId] * $bobot;
    }
    $skor[$altId] = $total;
}

// Langkah 5: Urutkan hasil berdasarkan skor tertinggi
arsort($skor);

// Kembalikan hasil
$response = [];
foreach ($skor as $altId => $total) {
    $response[] = [
        'nama_alternatif' => $alternatif[$altId],
        'skor' => round($total, 2),
    ];
}

// Kirim hasil sebagai JSON
header('Content-Type: application/json');
echo json_encode($response);
