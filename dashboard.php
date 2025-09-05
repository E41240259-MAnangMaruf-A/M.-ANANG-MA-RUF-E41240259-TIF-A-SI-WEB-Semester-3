<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(-45deg, #6a11cb, #2575fc, #1e1e1e, #444);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }

        @keyframes gradientBG {
            0% {background-position: 0% 50%;}
            25% {background-position: 50% 50%;}
            50% {background-position: 100% 50%;}
            75% {background-position: 50% 50%;}
            100% {background-position: 0% 50%;}
        }

        .dashboard-container {
            display: flex;
            width: 800px;
            height: 500px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            border-radius: 20px;
            overflow: hidden;
            background: #fff;
        }

        /* Panel kiri: gambar */
        .left-panel {
            flex: 1;
            background: url('anangFun.jpg') no-repeat center center;
            background-size: cover;
            position: relative;
        }

        /* overlay gelap */
        .left-panel::before {
            content: '';
            position: absolute;
            top:0; left:0; right:0; bottom:0;
            background: rgba(0,0,0,0.3);
        }

        /* Panel kanan: info dashboard */
        .right-panel {
            flex: 1;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .right-panel h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 28px;
            text-align: center;
        }

        .right-panel p {
            color: #555;
            font-size: 16px;
            text-align: center;
            margin-bottom: 30px;
        }

        .right-panel a {
            display: inline-block;
            padding: 12px 25px;
            background: linear-gradient(90deg, #6a11cb, #2575fc);
            color: #fff;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
            text-align: center;
        }

        .right-panel a:hover {
            background: linear-gradient(90deg, #2575fc, #6a11cb);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }

        @media(max-width:900px){
            .dashboard-container { flex-direction: column; height:auto; }
            .left-panel { height:200px; }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="left-panel"></div>
        <div class="right-panel">
            <h2>Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
            <p>Ini adalah halaman dashboard Anda. Hanya pengguna yang terautentikasi yang bisa melihatnya.</p>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
