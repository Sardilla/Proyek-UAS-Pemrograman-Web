<?php
if (session_status() == PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delicia by Dilla</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: #fff0f5;
        }
        header {
            background: linear-gradient(135deg, #ff69b4, #ed92b8);
            padding: 20px;
            color: white;
            text-align: center;
            box-shadow: 0 2px 10px rgba(255, 105, 180, 0.3);
        }
        header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        header p {
            margin: 5px 0 0 0;
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <header>
        <h1>🧁 Delicia by Dilla</h1>
        <p>Selamat datang, <?= $_SESSION['user']['username'] ?? 'Tamu'; ?>!</p>
    </header>
