<?php
include("config.php");

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">
    <div class="container mx-auto mt-8 p-8 bg-white rounded-lg shadow-md">
        <h2 class="text-3xl font-semibold text-gray-800">Thank You for Your Purchase!</h2>
        <p class="text-gray-600 mt-2">Your payment was successful, and your items will be shipped shortly.</p>

        <p class="text-gray-600 mt-4">Order Details:</p>
        <ul class="list-disc pl-6 mt-2">
            <li>Order ID: <?php echo generateOrderID(); ?></li>
        </ul>

        <div class="mt-8">
            <h3 class="text-xl font-semibold text-gray-800">Tips for a Great Shopping Experience:</h3>
            <ul class="list-disc pl-6 mt-2 text-gray-600">
                <li>Keep your order confirmation for reference.</li>
                <li>Contact our support if you have any questions.</li>
                <li>Explore more products in our <a href="shop.php" class="text-blue-500">JoverShop</a>.</li>
            </ul>
        </div>
    </div>
</body>

</html>

<?php

function generateOrderID()
{
    return 'ORD' . strtoupper(substr(md5(uniqid()), 0, 8));
}
?>
