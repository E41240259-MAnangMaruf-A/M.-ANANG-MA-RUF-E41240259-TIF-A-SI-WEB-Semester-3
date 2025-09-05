<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
        if (password_verify($password, $hashed_password)) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
            exit();
        } else {
            $popup_message = "Password salah.";
            $popup_type = "error";
        }
    } else {
        $popup_message = "Username tidak ditemukan.";
        $popup_type = "error";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        .login-container {
            display: flex;
            width: 800px;
            height: 500px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-radius: 15px;
            overflow: hidden;
            background: #fff;
        }

        /* Left image panel */
        .left-panel {
            flex: 1;
            background: url('anangFun.jpg') no-repeat center center;
            background-size: cover;
        }

        /* Right form panel */
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

        input[type=text], input[type=password] {
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
            .login-container{ flex-direction: column; height:auto; }
            .left-panel{ height:200px; }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="left-panel"></div>
        <div class="right-panel">
            <h2>Login to AnangFun</h2>
            <form action="login.php" method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            <div class="footer-text">
                Belum punya akun? <a href="register.php">Daftar di sini</a>
            </div>
        </div>
    </div>

    <div id="popup" class="popup <?php if(isset($_SESSION['success_message'])) echo 'success'; ?>">
        <?php 
            if(isset($_SESSION['success_message'])){
                echo htmlspecialchars($_SESSION['success_message']);
                unset($_SESSION['success_message']);
            } else {
                if(isset($popup_message)) echo htmlspecialchars($popup_message);
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
