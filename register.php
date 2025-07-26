<?php
session_start();
include 'config/koneksi.php';

if (isset($_POST['register'])) {
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']); // pakai MD5 seperti admin default
    $role     = 'user'; // default user biasa

    // Cek username sudah ada?
    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($cek) > 0) {
        $error = "Username sudah digunakan!";
    } else {
        $query = mysqli_query($conn, "INSERT INTO users (nama_lengkap, username, password, role) VALUES 
            ('$nama', '$username', '$password', '$role')");

        if ($query) {
            // Set session dengan format yang benar
            $_SESSION['user'] = [
                'id_user' => mysqli_insert_id($conn),
                'username' => $username,
                'role' => $role
            ];
            header("Location: user/dashboard.php");
            exit;
        } else {
            $error = "Gagal daftar akun!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Delicia by Dilla</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #ffb6c1, #ff69b4);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-container {
            background-color: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 420px;
            text-align: center;
        }

        .register-container h2 {
            margin-bottom: 25px;
            color: deeppink;
            font-size: 24px;
        }

        .register-container .error {
            background: #ffebee;
            color: #c62828;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #ffcdd2;
        }

        .register-container input[type="text"],
        .register-container input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }

        .register-container button {
            width: 100%;
            padding: 12px;
            background-color: deeppink;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .register-container button:hover {
            background-color: #c2185b;
        }

        .register-container p {
            margin-top: 20px;
            color: #666;
        }

        .register-container a {
            color: deeppink;
            text-decoration: none;
            font-weight: bold;
        }

        .register-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="register-container">
        <h2>Daftar Akun Baru</h2>
        <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
        <form method="post">
            <input type="text" name="nama" placeholder="Nama Lengkap" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="register">Daftar</button>
        </form>
        <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </div>

</body>
</html>
