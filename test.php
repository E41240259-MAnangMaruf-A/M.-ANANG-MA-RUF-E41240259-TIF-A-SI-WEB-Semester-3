<?php
session_start();

function clean_input($data) {
    return htmlspecialchars(trim($data));
}

function handleFileUpload($file, $type = 'image') {
    if ($file['error'] == UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        
        if ($type === 'image') {
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        } else { // PDF
            $allowed_types = ['pdf'];
        }
        
        if (in_array(strtolower($file_extension), $allowed_types)) {
            $prefix = $type === 'image' ? 'profile_' : 'cv_';
            $new_filename = $prefix . uniqid() . '.' . $file_extension;
            $upload_path = $upload_dir . $new_filename;
            
            if (move_uploaded_file($file['tmp_name'], $upload_path)) {
                return ['success' => true, 'filename' => $new_filename];
            }
        }
    }
    return ['success' => false];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Form Biodata</title> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .result-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .data-table th, .data-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .data-table th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }
        .data-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .back-btn {
            display: inline-block;
            background-color: #2196F3;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .back-btn:hover {
            background-color: #1976D2;
        }
        .success {
            background-color: #e8f5e8;
            color: #2e7d32;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .error {
            background-color: #ffebee;
            color: #c62828;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .color-box {
            display: inline-block;
            width: 30px;
            height: 30px;
            border: 1px solid #333;
            vertical-align: middle;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="result-container">
        <h1>HASIL PENGISIAN BIODATA</h1>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo '<div class="success">Data berhasil diterima!</div>';
            
            echo '<table class="data-table">';
            echo '<thead><tr><th>Field</th><th>Nilai</th></tr></thead>';
            echo '<tbody>';

            // Data Pribadi
            if (isset($_POST['nama_lengkap']) && $_POST['nama_lengkap'] !== '') {
                echo '<tr><td>Nama Lengkap</td><td>' . clean_input($_POST['nama_lengkap']) . '</td></tr>';
            }

            if (isset($_POST['email']) && $_POST['email'] !== '') {
                $email = clean_input($_POST['email']);
                echo '<tr><td>Email</td><td>' . $email . '</td></tr>';
            }

            if (isset($_POST['password'])) {
                $password_length = strlen($_POST['password']);
                echo '<tr><td>Password</td><td>*** (' . $password_length . ' karakter)</td></tr>';
            }

            if (isset($_POST['umur']) && $_POST['umur'] !== '') {
                echo '<tr><td>Umur</td><td>' . clean_input($_POST['umur']) . ' tahun</td></tr>';
            }

            if (isset($_POST['telepon']) && $_POST['telepon'] !== '') {
                echo '<tr><td>Telepon</td><td>' . clean_input($_POST['telepon']) . '</td></tr>';
            }

            if (isset($_POST['website']) && $_POST['website'] !== '') {
                $website = clean_input($_POST['website']);
                echo '<tr><td>Website</td><td><a href="' . $website . '" target="_blank">' . $website . '</a></td></tr>';
            }

            if (isset($_POST['tanggal_lahir']) && $_POST['tanggal_lahir'] !== '') {
                $tanggal = date('d F Y', strtotime($_POST['tanggal_lahir']));
                echo '<tr><td>Tanggal Lahir</td><td>' . $tanggal . '</td></tr>';
            }

            if (isset($_POST['jam_kerja']) && $_POST['jam_kerja'] !== '') {
                echo '<tr><td>Jam Kerja</td><td>' . clean_input($_POST['jam_kerja']) . '</td></tr>';
            }

            if (isset($_POST['alamat']) && $_POST['alamat'] !== '') {
                echo '<tr><td>Alamat</td><td>' . nl2br(clean_input($_POST['alamat'])) . '</td></tr>';
            }

            // Data Pendidikan & Pekerjaan
            if (isset($_POST['pendidikan']) && $_POST['pendidikan'] !== '') {
                echo '<tr><td>Pendidikan</td><td>' . strtoupper(clean_input($_POST['pendidikan'])) . '</td></tr>';
            }

            if (isset($_POST['pekerjaan']) && $_POST['pekerjaan'] !== '') {
                echo '<tr><td>Pekerjaan</td><td>' . clean_input($_POST['pekerjaan']) . '</td></tr>';
            }

            if (isset($_POST['gaji'])) {
                $gaji = number_format(clean_input($_POST['gaji']), 0, ',', '.');
                echo '<tr><td>Gaji yang Diharapkan</td><td>Rp ' . $gaji . '</td></tr>';
            }

            if (isset($_POST['pengalaman_kerja']) && $_POST['pengalaman_kerja'] !== '') {
                echo '<tr><td>Pengalaman Kerja</td><td>' . clean_input($_POST['pengalaman_kerja']) . ' tahun</td></tr>';
            }

            // Data Preferensi
            if (isset($_POST['jenis_kelamin'])) {
                echo '<tr><td>Jenis Kelamin</td><td>' . ucfirst(clean_input($_POST['jenis_kelamin'])) . '</td></tr>';
            }

            if (isset($_POST['hobi']) && is_array($_POST['hobi'])) {
                $hobi_list = array_map('clean_input', $_POST['hobi']);
                echo '<tr><td>Hobi</td><td>' . implode(', ', $hobi_list) . '</td></tr>';
            }

            if (isset($_POST['warna_favorit'])) {
                $warna = clean_input($_POST['warna_favorit']);
                echo '<tr><td>Warna Favorit</td><td>' . $warna . '<span class="color-box" style="background-color: ' . $warna . ';"></span></td></tr>';
            }

            if (isset($_POST['tingkat_kepuasan'])) {
                echo '<tr><td>Tingkat Kepuasan Hidup</td><td>' . clean_input($_POST['tingkat_kepuasan']) . '/100</td></tr>';
            }

            // Data Tambahan
            if (isset($_POST['datetime_local']) && $_POST['datetime_local'] !== '') {
                $datetime = date('d F Y H:i', strtotime($_POST['datetime_local']));
                echo '<tr><td>Waktu Lokal Preferensi</td><td>' . $datetime . '</td></tr>';
            }

            if (isset($_POST['bulan_gaji']) && $_POST['bulan_gaji'] !== '') {
                $bulan = date('F Y', strtotime($_POST['bulan_gaji'] . '-01'));
                echo '<tr><td>Bulan Gaji Terakhir</td><td>' . $bulan . '</td></tr>';
            }

            if (isset($_POST['minggu_kerja']) && $_POST['minggu_kerja'] !== '') {
                echo '<tr><td>Minggu Kerja</td><td>' . clean_input($_POST['minggu_kerja']) . '</td></tr>';
            }

            echo '</tbody></table>';

            // Handle file upload (foto profil)
            if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] != UPLOAD_ERR_NO_FILE) {
                $file_result = handleFileUpload($_FILES['foto_profil'], 'image');
                
                if ($file_result['success']) {
                    echo '<div class="success">';
                    echo '<h3>File Upload Berhasil:</h3>';
                    echo '<p>File: ' . $_FILES['foto_profil']['name'] . '</p>';
                    echo '<p>Tersimpan sebagai: ' . $file_result['filename'] . '</p>';
                    echo '</div>';
                } else {
                    echo '<div class="error">Gagal upload foto profil! Pastikan file adalah gambar (JPG, PNG, GIF).</div>';
                }
            }

            // Handle file upload (CV)
            if (isset($_FILES['cv']) && $_FILES['cv']['error'] != UPLOAD_ERR_NO_FILE) {
                $file_result = handleFileUpload($_FILES['cv'], 'pdf');
                
                if ($file_result['success']) {
                    echo '<div class="success">';
                    echo '<h3>CV Upload Berhasil:</h3>';
                    echo '<p>File: ' . $_FILES['cv']['name'] . '</p>';
                    echo '<p>Tersimpan sebagai: ' . $file_result['filename'] . '</p>';
                    echo '</div>';
                } else {
                    echo '<div class="error">Gagal upload CV! Pastikan file adalah PDF.</div>';
                }
            }

        } else {
            echo '<div class="error">Tidak ada data yang dikirim!</div>';
        }
        ?>

        <div style="text-align: center;">
            <a href="biodata_form.php" class="back-btn">Kembali ke Form</a>
        </div>
    </div>
</body>
</html>