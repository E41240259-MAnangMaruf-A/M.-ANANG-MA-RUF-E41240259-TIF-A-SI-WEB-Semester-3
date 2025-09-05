<?php
// test.php
session_start();

// Fungsi untuk membersihkan input
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Fungsi untuk format file size
function formatFileSize($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' bytes';
    }
}

// Handle file upload
function handleFileUpload($file) {
    if ($file['error'] == UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        
        // Buat direktori jika belum ada
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $new_filename = 'profile_' . uniqid() . '.' . $file_extension;
        $upload_path = $upload_dir . $new_filename;
        
        // Validasi tipe file
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array(strtolower($file_extension), $allowed_types)) {
            if (move_uploaded_file($file['tmp_name'], $upload_path)) {
                return [
                    'success' => true,
                    'filename' => $new_filename,
                    'path' => $upload_path,
                    'size' => formatFileSize($file['size']),
                    'type' => $file['type']
                ];
            }
        }
    }
    return ['success' => false, 'error' => 'Gagal upload file'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Form Biodata</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
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
        .error {
            background-color: #ffebee;
            color: #c62828;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .success {
            background-color: #e8f5e8;
            color: #2e7d32;
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
        .file-info {
            background-color: #f0f8ff;
            padding: 10px;
            border-radius: 5px;
            border-left: 4px solid #2196F3;
        }
        .hidden-data {
            background-color: #fff3e0;
            padding: 10px;
            border-radius: 5px;
            border-left: 4px solid #ff9800;
        }
    </style>
</head>
<body>
    <div class="result-container">
        <h1>📊 Hasil Data Biodata</h1>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo '<div class="success">✅ Data berhasil diterima dan diproses!</div>';
            
            echo '<table class="data-table">';
            echo '<thead><tr><th>Field</th><th>Type</th><th>Value</th></tr></thead>';
            echo '<tbody>';

            // Process Text Input
            if (isset($_POST['nama_lengkap'])) {
                $nama = clean_input($_POST['nama_lengkap']);
                echo '<tr><td>Nama Lengkap</td><td>text</td><td>' . $nama . '</td></tr>';
            }

            // Process Email Input
            if (isset($_POST['email'])) {
                $email = clean_input($_POST['email']);
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo '<tr><td>Email</td><td>email</td><td>' . $email . '</td></tr>';
                } else {
                    echo '<tr><td>Email</td><td>email</td><td><span style="color:red;">Email tidak valid!</span></td></tr>';
                }
            }

            // Process Password Input (tidak ditampilkan untuk keamanan)
            if (isset($_POST['password'])) {
                $password_length = strlen($_POST['password']);
                echo '<tr><td>Password</td><td>password</td><td>*** (panjang: ' . $password_length . ' karakter)</td></tr>';
            }

            // Process Number Input
            if (isset($_POST['umur']) && $_POST['umur'] !== '') {
                $umur = clean_input($_POST['umur']);
                echo '<tr><td>Umur</td><td>number</td><td>' . $umur . ' tahun</td></tr>';
            }

            // Process Tel Input
            if (isset($_POST['telepon']) && $_POST['telepon'] !== '') {
                $telepon = clean_input($_POST['telepon']);
                echo '<tr><td>Telepon</td><td>tel</td><td>' . $telepon . '</td></tr>';
            }

            // Process URL Input
            if (isset($_POST['website']) && $_POST['website'] !== '') {
                $website = clean_input($_POST['website']);
                if (filter_var($website, FILTER_VALIDATE_URL)) {
                    echo '<tr><td>Website</td><td>url</td><td><a href="' . $website . '" target="_blank">' . $website . '</a></td></tr>';
                } else {
                    echo '<tr><td>Website</td><td>url</td><td><span style="color:red;">URL tidak valid!</span></td></tr>';
                }
            }

            // Process Date Input
            if (isset($_POST['tanggal_lahir']) && $_POST['tanggal_lahir'] !== '') {
                $tanggal_lahir = clean_input($_POST['tanggal_lahir']);
                $formatted_date = date('d F Y', strtotime($tanggal_lahir));
                echo '<tr><td>Tanggal Lahir</td><td>date</td><td>' . $formatted_date . '</td></tr>';
            }

            // Process Time Input
            if (isset($_POST['jam_lahir']) && $_POST['jam_lahir'] !== '') {
                $jam_lahir = clean_input($_POST['jam_lahir']);
                echo '<tr><td>Jam Lahir</td><td>time</td><td>' . $jam_lahir . '</td></tr>';
            }

            // Process Datetime-local Input
            if (isset($_POST['waktu_pendaftaran']) && $_POST['waktu_pendaftaran'] !== '') {
                $waktu_pendaftaran = clean_input($_POST['waktu_pendaftaran']);
                $formatted_datetime = date('d F Y, H:i', strtotime($waktu_pendaftaran));
                echo '<tr><td>Waktu Pendaftaran</td><td>datetime-local</td><td>' . $formatted_datetime . '</td></tr>';
            }

            // Process Month Input
            if (isset($_POST['bulan_mulai_kerja']) && $_POST['bulan_mulai_kerja'] !== '') {
                $bulan_kerja = clean_input($_POST['bulan_mulai_kerja']);
                $formatted_month = date('F Y', strtotime($bulan_kerja . '-01'));
                echo '<tr><td>Bulan Mulai Kerja</td><td>month</td><td>' . $formatted_month . '</td></tr>';
            }

            // Process Week Input
            if (isset($_POST['minggu_target']) && $_POST['minggu_target'] !== '') {
                $minggu = clean_input($_POST['minggu_target']);
                echo '<tr><td>Minggu Target</td><td>week</td><td>Minggu ' . $minggu . '</td></tr>';
            }

            // Process Color Input
            if (isset($_POST['warna_favorit'])) {
                $warna = clean_input($_POST['warna_favorit']);
                echo '<tr><td>Warna Favorit</td><td>color</td><td>' . $warna . '<span class="color-box" style="background-color: ' . $warna . ';"></span></td></tr>';
            }

            // Process Range Input
            if (isset($_POST['tingkat_kepuasan'])) {
                $kepuasan = clean_input($_POST['tingkat_kepuasan']);
                echo '<tr><td>Tingkat Kepuasan</td><td>range</td><td>' . $kepuasan . '/100</td></tr>';
            }

            // Process Search Input
            if (isset($_POST['pencarian_hobi']) && $_POST['pencarian_hobi'] !== '') {
                $pencarian = clean_input($_POST['pencarian_hobi']);
                echo '<tr><td>Pencarian Hobi</td><td>search</td><td>' . $pencarian . '</td></tr>';
            }

            // Process Radio Input
            if (isset($_POST['jenis_kelamin'])) {
                $gender = clean_input($_POST['jenis_kelamin']);
                echo '<tr><td>Jenis Kelamin</td><td>radio</td><td>' . ucfirst($gender) . '</td></tr>';
            }

            // Process Checkbox Input
            if (isset($_POST['hobi']) && is_array($_POST['hobi'])) {
                $hobi_list = [];
                foreach ($_POST['hobi'] as $hobi) {
                    $hobi_list[] = clean_input($hobi);
                }
                echo '<tr><td>Hobi</td><td>checkbox</td><td>' . implode(', ', $hobi_list) . '</td></tr>';
            }

            echo '</tbody></table>';

            // Process Hidden Inputs
            echo '<div class="hidden-data">';
            echo '<h3>🔒 Data Hidden Input:</h3>';
            if (isset($_POST['form_token'])) {
                echo '<p><strong>Form Token:</strong> ' . clean_input($_POST['form_token']) . '</p>';
            }
            if (isset($_POST['form_version'])) {
                echo '<p><strong>Form Version:</strong> ' . clean_input($_POST['form_version']) . '</p>';
            }
            echo '</div>';

            // Process File Upload
            if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] != UPLOAD_ERR_NO_FILE) {
                echo '<div class="file-info">';
                echo '<h3>📁 Informasi File Upload:</h3>';
                
                $file_result = handleFileUpload($_FILES['foto_profil']);
                
                if ($file_result['success']) {
                    echo '<p><strong>Nama File:</strong> ' . $_FILES['foto_profil']['name'] . '</p>';
                    echo '<p><strong>File Tersimpan:</strong> ' . $file_result['filename'] . '</p>';
                    echo '<p><strong>Ukuran File:</strong> ' . $file_result['size'] . '</p>';
                    echo '<p><strong>Tipe File:</strong> ' . $file_result['type'] . '</p>';
                    echo '<p><strong>Status:</strong> <span style="color:green;">✅ Upload berhasil!</span></p>';
                } else {
                    echo '<p><strong>Status:</strong> <span style="color:red;">❌ ' . $file_result['error'] . '</span></p>';
                }
                echo '</div>';
            }

            // Informasi tambahan tentang form submission
            echo '<div style="margin-top: 30px; padding: 15px; background-color: #e3f2fd; border-radius: 5px;">';
            echo '<h3>ℹ️ Informasi Teknis:</h3>';
            echo '<p><strong>Method:</strong> ' . $_SERVER['REQUEST_METHOD'] . '</p>';
            echo '<p><strong>User Agent:</strong> ' . $_SERVER['HTTP_USER_AGENT'] . '</p>';
            echo '<p><strong>IP Address:</strong> ' . $_SERVER['REMOTE_ADDR'] . '</p>';
            echo '<p><strong>Timestamp:</strong> ' . date('Y-m-d H:i:s') . '</p>';
            
            // Tampilkan semua POST data (untuk debugging)
            echo '<h4>🔍 Debug - Semua Data POST:</h4>';
            echo '<pre style="background-color: #f5f5f5; padding: 10px; border-radius: 3px; overflow-x: auto;">';
            print_r($_POST);
            echo '</pre>';
            
            // Tampilkan semua FILES data (untuk debugging)
            if (!empty($_FILES)) {
                echo '<h4>📎 Debug - Semua Data FILES:</h4>';
                echo '<pre style="background-color: #f5f5f5; padding: 10px; border-radius: 3px; overflow-x: auto;">';
                print_r($_FILES);
                echo '</pre>';
            }
            echo '</div>';

        } else {
            echo '<div class="error">❌ Tidak ada data yang dikirim!</div>';
        }
        ?>

        <div style="text-align: center; margin-top: 30px;">
            <a href="biodata_form.php" class="back-btn">🔙 Kembali ke Form</a>
        </div>

        <div style="margin-top: 30px; padding: 20px; background-color: #f8f9fa; border-radius: 5px;">
            <h3>📚 Penjelasan Tipe Input yang Digunakan:</h3>
            <ul style="line-height: 1.8;">
                <li><strong>text:</strong> Input teks biasa untuk nama</li>
                <li><strong>email:</strong> Validasi format email otomatis</li>
                <li><strong>password:</strong> Input tersembunyi untuk password</li>
                <li><strong>number:</strong> Input hanya angka dengan min/max</li>
                <li><strong>tel:</strong> Input untuk nomor telepon</li>
                <li><strong>url:</strong> Validasi format URL otomatis</li>
                <li><strong>date:</strong> Date picker untuk tanggal</li>
                <li><strong>time:</strong> Time picker untuk waktu</li>
                <li><strong>datetime-local:</strong> Kombinasi date dan time</li>
                <li><strong>month:</strong> Picker untuk bulan dan tahun</li>
                <li><strong>week:</strong> Picker untuk minggu dalam tahun</li>
                <li><strong>color:</strong> Color picker untuk memilih warna</li>
                <li><strong>range:</strong> Slider untuk nilai dalam rentang</li>
                <li><strong>file:</strong> Upload file dengan validasi</li>
                <li><strong>search:</strong> Input pencarian dengan fitur clear</li>
                <li><strong>radio:</strong> Pilihan tunggal dari beberapa opsi</li>
                <li><strong>checkbox:</strong> Pilihan multiple dari beberapa opsi</li>
                <li><strong>hidden:</strong> Data tersembunyi untuk token/metadata</li>
                <li><strong>image:</strong> Submit button menggunakan gambar</li>
                <li><strong>submit:</strong> Tombol submit standar</li>
                <li><strong>reset:</strong> Tombol untuk reset form</li>
            </ul>
        </div>
    </div>
</body>
</html>