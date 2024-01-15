<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

include("config.php");

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT admin FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user || !$user['admin']) {
    header("Location: shop.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <header class="bg-yellow-500 p-4 flex justify-between items-center">
        <h2 class="text-2xl text-white uppercase">Admin Page</h2>
        <form action="logout.php" method="post">
            <button type="submit" class="bg-red-500 text-white px-4 py-2">Logout</button>
        </form>
    </header>

    <?php include("charts.php"); ?>
    <footer class="bg-yellow-500 text-white p-4 text-center">
        &copy; 2024 JOVERSHOP. All rights reserved.
    </footer>
</body>

</html>