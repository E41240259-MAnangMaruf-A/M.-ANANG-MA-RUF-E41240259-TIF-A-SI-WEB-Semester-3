<?php
session_start();
include 'koneksi.php';

$popup_message = ""; 
$popup_type = "error";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($email) || empty($password)) {
        $popup_message = "Semua field harus diisi.";
    } else {
        $stmt_check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt_check->bind_param("s", $username);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $popup_message = "Username sudah digunakan, silakan gunakan username lain.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Registrasi berhasil! Silakan login.";
                header("Location: login.php");
                exit();
            } else {
                $popup_message = "Registrasi gagal: " . $stmt->error;
            }
            $stmt->close();
        }
        $stmt_check->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background: #f5f6fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .register-container {
            display: flex;
            width: 800px;
            height: 500px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-radius: 15px;
            overflow: hidden;
            background: #fff;
        }

        .left-panel {
            flex: 1;
            background: url('anang.jpg') no-repeat center center;
            background-size: cover;
        }

        .right-panel {
            flex: 1;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .right-panel h2 {
            margin-bottom: 30px;
            color: #333;
            font-size: 28px;
        }

        input[type=text], input[type=email], input[type=password] {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 14px;
            outline: none;
        }

        input:focus {
            border-color: #6a11cb;
        }

        button {
            padding: 15px;
            width: 100%;
            background: linear-gradient(90deg, #6a11cb, #2575fc);
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: linear-gradient(90deg, #2575fc, #6a11cb);
        }

        .footer-text {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .footer-text a {
            color: #2575fc;
            text-decoration: none;
        }

        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #ff4d4d;
            color: #fff;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            display: none;
            z-index: 9999;
            font-size: 16px;
            text-align: center;
        }

        .popup.success { background-color: #28a745; }

        .popup.show {
            display: block;
            animation: fadeInOut 3s forwards;
        }

        @keyframes fadeInOut {
            0% {opacity:0; transform:translate(-50%, -60%);}
            10% {opacity:1; transform:translate(-50%, -50%);}
            90% {opacity:1; transform:translate(-50%, -50%);}
            100% {opacity:0; transform:translate(-50%, -60%);}
        }

        @media(max-width:900px){
            .register-container{ flex-direction: column; height:auto; }
            .left-panel{ height:200px; }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="left-panel"></div>
        <div class="right-panel">
            <h2>Welcome to AnangFun!</h2>
            <form action="register.php" method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Register</button>
            </form>
            <div class="footer-text">
                Sudah punya akun? <a href="login.php">Login</a>
            </div>
        </div>
    </div>

    <div id="popup" class="popup <?php if(isset($_SESSION['success_message'])) echo 'success'; ?>">
        <?php 
            if(isset($_SESSION['success_message'])){
                echo htmlspecialchars($_SESSION['success_message']);
                unset($_SESSION['success_message']);
            } else {
                echo htmlspecialchars($popup_message);
            }
        ?>
    </div>

    <script>
        var popup = document.getElementById('popup');
        if(popup.textContent.trim() !== "") {
            popup.classList.add('show');
        }
    </script>
</body>
</html>
