<?php
include("config.php");

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['purchase'])) {
        $item_id = $_POST['item_id'];


        $stmtCheckPurchase = $conn->prepare("SELECT COUNT(*) FROM cart WHERE user_id = ? AND item_id = ?");
        $stmtCheckPurchase->execute([$user_id, $item_id]);
        $purchaseCount = $stmtCheckPurchase->fetchColumn();

        if ($purchaseCount > 0) {

            $stmtUpdateQuantity = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND item_id = ?");
            $stmtUpdateQuantity->execute([$user_id, $item_id]);
        } else {

            $stmtPurchase = $conn->prepare("INSERT INTO cart (user_id, item_id, quantity) VALUES (?, ?, 1)");
            $stmtPurchase->execute([$user_id, $item_id]);
        }
    }
}

if (isset($_GET['genre_id'])) {
    $genre_id = $_GET['genre_id'];
    $stmt = $conn->prepare("SELECT item_id, name, price FROM items WHERE genre_id = ?");
    $stmt->execute([$genre_id]);
    $items = $stmt->fetchAll();
} else {
    header("Location: index.php");
    exit();

}
$stmtGenres = $conn->query("SELECT genre_id, name FROM genres");
$genres = $stmtGenres->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Items</title>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex flex-col min-h-screen">
    <div class="bg-yellow-500 p-4 md:p-8 flex flex-col md:flex-row items-center justify-between">
        <a href="shop.php" class="text-white">
            <h2 class="text-3xl font-bold">Shop</h2>
        </a>

        <div class="flex items-center space-x-4 md:space-x-0 md:hidden">
            <button id="mobileMenuBtn" class="text-white">
                &#9776; Menu
            </button>
        </div>

        <ul id="navLinks" class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 hidden md:flex">
            <?php foreach ($genres as $genre): ?>
                <li>
                    <a href="crud.php?genre_id=<?= $genre['genre_id'] ?>">
                        <button
                            class="bg-gradient-to-r from-yellow-500 via-orange-400 to-orange-900 text-white px-2 md:px-4 py-2 rounded">
                            <?= $genre['name'] ?>
                        </button>
                    </a>
                </li>
            <?php endforeach; ?>

            <li>
                <a href="cart.php">
                    <button class="bg-green-500 text-white px-2 md:px-4 py-2 rounded">Cart</button>
                </a>
            </li>
            <li>
                <form action="logout.php" method="post">
                    <button type="submit" class="bg-red-500 text-white px-2 md:px-4 py-2 rounded">Logout</button>
                </form>
            </li>
        </ul>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach ($items as $item): ?>
        <div class="bg-white p-4 rounded-md">
            <?php
            $stmtItem = $conn->prepare("SELECT name, image_path FROM items WHERE item_id = ?");
            $stmtItem->execute([$item['item_id']]);
            $itemData = $stmtItem->fetch();

            $imageSrc = (!empty($itemData['image_path']) && file_exists($itemData['image_path']))
                ? $itemData['image_path']
                : 'default_image.jpg'; 
            ?>
            <img src="<?= $imageSrc ?>" alt="<?= $itemData['name'] ?>" class="w-full h-32 object-cover mb-4">

            <span class="block font-bold text-lg mb-2">
                <?= $itemData['name'] ?> - $
                <?= $item['price'] ?>
            </span>
            <form method="post" action="" class="mt-2">
                <input type="hidden" name="item_id" value="<?= $item['item_id'] ?>">
                <button type="submit" name="purchase" class="bg-blue-500 text-white px-4 py-2 rounded">Add to Cart</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>


    <footer class="bg-yellow-500 text-white p-4 text-center">
        &copy; 2024 JOVERSHOP. All rights reserved.
    </footer>

    <script>

        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const navLinks = document.getElementById('navLinks');

        mobileMenuBtn.addEventListener('click', () => {
            navLinks.classList.toggle('hidden');
        });
    </script>
</body>

</html>