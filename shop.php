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

        $stmtCheckExisting = $conn->prepare("
            SELECT quantity
            FROM cart
            WHERE user_id = ? AND item_id = ?
        ");
        $stmtCheckExisting->execute([$user_id, $item_id]);
        $result = $stmtCheckExisting->fetch();

        if ($result) {
         
            $quantity = $result['quantity'] + 1;
            $stmtUpdateQuantity = $conn->prepare("
                UPDATE cart
                SET quantity = ?
                WHERE user_id = ? AND item_id = ?
            ");
            $stmtUpdateQuantity->execute([$quantity, $user_id, $item_id]);
        } else {
       
            $stmtPurchase = $conn->prepare("
                INSERT INTO cart (user_id, item_id, quantity)
                VALUES (?, ?, 1)
            ");
            $stmtPurchase->execute([$user_id, $item_id]);
        }
    }
}


$stmtGenres = $conn->query("SELECT genre_id, name FROM genres");
$genres = $stmtGenres->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="bg-yellow-500 p-8 flex items-center justify-between">
        <a href="shop.php" class="text-white">
            <h2 class="text-3xl font-bold">Shop</h2>
        </a>

   
        <div class="md:hidden relative">
            <button id="mobileMenuBtn" class="text-white">
                &#9776; Menu
            </button>
            <ul id="menuDropdown" class="fixed hidden bg-white border rounded-md py-2 mt-1 space-y-2 w-full">
                <?php foreach ($genres as $genre): ?>
                    <li>
                        <a href="crud.php?genre_id=<?= $genre['genre_id'] ?>"
                            class="block px-4 py-2 text-gray-800 hover:bg-gray-200 w-full">
                            <?= $genre['name'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                <li>
                    <a href="cart.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-200 w-full">Cart</a>
                </li>
                <li>
                    <form action="logout.php" method="post">
                        <button type="submit"
                            class="block px-4 py-2 text-red-800 hover:bg-gray-200 w-full">Logout</button>
                    </form>
                </li>
            </ul>
        </div>

        <ul id="navLinks" class="flex space-x-4 md:flex hidden">
            <?php foreach ($genres as $genre): ?>
                <li>
                    <a href="crud.php?genre_id=<?= $genre['genre_id'] ?>">
                        <button
                            class="bg-gradient-to-r from-yellow-500  via-orange-400 to-orange-900 text-white px-4 py-2 rounded">
                            <?= $genre['name'] ?>
                        </button>
                    </a>
                </li>
            <?php endforeach; ?>

            <li>
                <a href="cart.php">
                    <button class="bg-green-500 text-white px-4 py-2 rounded">Cart</button>
                </a>
            </li>
            <li>
                <form action="logout.php" method="post">
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 w-full">Logout</button>
                </form>
            </li>
        </ul>
    </div>

    <div class="p-8 mt-8">
        <?php foreach ($genres as $genre): ?>
            <h3 class="text-xl mb-4">
                <?= $genre['name'] ?>
            </h3>

            <?php
            $stmtItems = $conn->prepare("SELECT item_id, name, image_path FROM items WHERE genre_id = ? LIMIT 3");
            $stmtItems->execute([$genre['genre_id']]);
            $items = $stmtItems->fetchAll();
            ?>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($items as $item): ?>
                    <div class="bg-white p-4 rounded-md">
                        <img src="<?= $item['image_path'] ?>" alt="<?= $item['name'] ?>" class="w-full h-32 object-cover mb-4">
                        <span class="block font-bold text-lg mb-2">
                            <?= $item['name'] ?>
                        </span>
                        <form method="post" action="" class="mt-2">
                            <input type="hidden" name="item_id" value="<?= $item['item_id'] ?>">
                            <button type="submit" name="purchase" class="bg-blue-500 text-white px-4 py-2 rounded">Add To Cart</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <footer class="bg-yellow-500 text-white p-4 text-center">
        &copy; 2024 JOVERSHOP. All rights reserved.
    </footer>

    <script>

        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const menuDropdown = document.getElementById('menuDropdown');

        mobileMenuBtn.addEventListener('click', () => {
            menuDropdown.classList.toggle('hidden');
        });
    </script>
</body>

</html>