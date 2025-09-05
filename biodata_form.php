<?php
// biodata_form.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Biodata Lengkap</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .form-container {
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
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }
        input:focus, select:focus, textarea:focus {
            border-color: #4CAF50;
            outline: none;
        }
        .radio-group, .checkbox-group {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        .radio-group input, .checkbox-group input {
            width: auto;
            margin-right: 5px;
        }
        .submit-btn {
            background-color: #4CAF50;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px;
        }
        .submit-btn:hover {
            background-color: #45a049;
        }
        .reset-btn {
            background-color: #f44336;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .reset-btn:hover {
            background-color: #da190b;
        }
        .color-preview {
            margin-top: 5px;
            height: 30px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        .range-output {
            margin-left: 10px;
            font-weight: bold;
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>📝 Form Biodata Lengkap</h1>
        
        <form action="test.php" method="POST" enctype="multipart/form-data">
            
            <!-- Input Text -->
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap:</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan nama lengkap Anda" required>
            </div>

            <!-- Input Email -->
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="nama@email.com" required>
            </div>

            <!-- Input Password -->
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
            </div>

            <!-- Input Number -->
            <div class="form-group">
                <label for="umur">Umur:</label>
                <input type="number" id="umur" name="umur" min="1" max="120" placeholder="Masukkan umur">
            </div>

            <!-- Input Tel -->
            <div class="form-group">
                <label for="telepon">Nomor Telepon:</label>
                <input type="tel" id="telepon" name="telepon" placeholder="08123456789" pattern="[0-9]{10,13}">
            </div>

            <!-- Input URL -->
            <div class="form-group">
                <label for="website">Website/Portfolio:</label>
                <input type="url" id="website" name="website" placeholder="https://example.com">
            </div>

            <!-- Input Date -->
            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir:</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir">
            </div>

            <!-- Input Time -->
            <div class="form-group">
                <label for="jam_lahir">Jam Lahir:</label>
                <input type="time" id="jam_lahir" name="jam_lahir">
            </div>

            <!-- Input Datetime-local -->
            <div class="form-group">
                <label for="waktu_pendaftaran">Waktu Pendaftaran:</label>
                <input type="datetime-local" id="waktu_pendaftaran" name="waktu_pendaftaran">
            </div>

            <!-- Input Month -->
            <div class="form-group">
                <label for="bulan_mulai_kerja">Bulan Mulai Kerja:</label>
                <input type="month" id="bulan_mulai_kerja" name="bulan_mulai_kerja">
            </div>

            <!-- Input Week -->
            <div class="form-group">
                <label for="minggu_target">Minggu Target Penyelesaian:</label>
                <input type="week" id="minggu_target" name="minggu_target">
            </div>

            <!-- Input Color -->
            <div class="form-group">
                <label for="warna_favorit">Warna Favorit:</label>
                <input type="color" id="warna_favorit" name="warna_favorit" value="#4CAF50">
                <div class="color-preview" id="color-preview"></div>
            </div>

            <!-- Input Range -->
            <div class="form-group">
                <label for="tingkat_kepuasan">Tingkat Kepuasan (1-100):</label>
                <input type="range" id="tingkat_kepuasan" name="tingkat_kepuasan" min="1" max="100" value="50" oninput="updateRangeValue(this.value)">
                <span class="range-output" id="range-value">50</span>
            </div>

            <!-- Input File -->
            <div class="form-group">
                <label for="foto_profil">Foto Profil:</label>
                <input type="file" id="foto_profil" name="foto_profil" accept="image/*">
            </div>

            <!-- Input Search -->
            <div class="form-group">
                <label for="pencarian_hobi">Cari Hobi:</label>
                <input type="search" id="pencarian_hobi" name="pencarian_hobi" placeholder="Cari hobi favorit...">
            </div>

            <!-- Input Radio -->
            <div class="form-group">
                <label>Jenis Kelamin:</label>
                <div class="radio-group">
                    <label><input type="radio" name="jenis_kelamin" value="laki-laki"> Laki-laki</label>
                    <label><input type="radio" name="jenis_kelamin" value="perempuan"> Perempuan</label>
                    <label><input type="radio" name="jenis_kelamin" value="lainnya"> Lainnya</label>
                </div>
            </div>

            <!-- Input Checkbox -->
            <div class="form-group">
                <label>Hobi (pilih yang sesuai):</label>
                <div class="checkbox-group">
                    <label><input type="checkbox" name="hobi[]" value="membaca"> Membaca</label>
                    <label><input type="checkbox" name="hobi[]" value="olahraga"> Olahraga</label>
                    <label><input type="checkbox" name="hobi[]" value="musik"> Musik</label>
                    <label><input type="checkbox" name="hobi[]" value="traveling"> Traveling</label>
                    <label><input type="checkbox" name="hobi[]" value="memasak"> Memasak</label>
                    <label><input type="checkbox" name="hobi[]" value="gaming"> Gaming</label>
                </div>
            </div>

            <!-- Input Hidden -->
            <input type="hidden" name="form_token" value="<?php echo md5(time()); ?>">
            <input type="hidden" name="form_version" value="1.0">

            <!-- Input Image (Submit Button dengan gambar) -->
            <div class="form-group">
                <label>Submit dengan Image Button:</label>
                <input type="image" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjQwIiB2aWV3Qm94PSIwIDAgMTAwIDQwIiBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8cmVjdCB3aWR0aD0iMTAwIiBoZWlnaHQ9IjQwIiBmaWxsPSIjNENBRjUwIiByeD0iNSIvPgo8dGV4dCB4PSI1MCIgeT0iMjUiIGZpbGw9IndoaXRlIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBmb250LWZhbWlseT0iQXJpYWwsIHNhbnMtc2VyaWYiIGZvbnQtc2l6ZT0iMTQiPktJUklNPC90ZXh0Pgo8L3N2Zz4K" alt="Kirim Data" width="100" height="40">
            </div>

            <!-- Input Submit & Reset -->
            <div class="form-group">
                <input type="submit" class="submit-btn" value="Kirim Data" name="submit_normal">
                <input type="reset" class="reset-btn" value="Reset Form">
            </div>

        </form>
    </div>

    <script>
        // Update range value display
        function updateRangeValue(value) {
            document.getElementById('range-value').textContent = value;
        }

        // Update color preview
        document.getElementById('warna_favorit').addEventListener('input', function() {
            document.getElementById('color-preview').style.backgroundColor = this.value;
        });

        // Initialize color preview
        window.onload = function() {
            const colorInput = document.getElementById('warna_favorit');
            document.getElementById('color-preview').style.backgroundColor = colorInput.value;
        }

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const requiredFields = ['nama_lengkap', 'email', 'password'];
            let isValid = true;
            
            requiredFields.forEach(function(fieldName) {
                const field = document.getElementById(fieldName);
                if (!field.value.trim()) {
                    alert('Field ' + field.previousElementSibling.textContent + ' harus diisi!');
                    isValid = false;
                    field.focus();
                    return false;
                }
            });
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>