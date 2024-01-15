<?php
include("config.php");

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pay'])) {
    try {
        $conn->beginTransaction();
    
        $lastPurchasesId = null;
    
        $stmtCartBeforeDeletion = $conn->prepare("
            SELECT item_id, quantity
            FROM cart
            WHERE user_id = ?
        ");
        $stmtCartBeforeDeletion->execute([$user_id]);
        $cartDataBeforeDeletion = $stmtCartBeforeDeletion->fetchAll();
    
        foreach ($cartDataBeforeDeletion as $cartItem) {
            $stmtUpdatePurchases = $conn->prepare("
                INSERT INTO purchases (user_id, item_id, quantity)
                VALUES (?, ?, ?)
            ");
            $stmtUpdatePurchases->execute([$user_id, $cartItem['item_id'], $cartItem['quantity']]);
            $lastPurchasesId = $conn->lastInsertId();
        }

        // Delete cart entries after successful purchases
        $stmtDeleteCart = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $stmtDeleteCart->execute([$user_id]);
    
        $conn->commit();
    
        header("Location: thankyou.php?purchases_id=" . $lastPurchasesId);
        exit();
    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_quantity'])) {
    if (isset($_POST['item_name'])) {
        $item_name = $_POST['item_name'];
        $quantity = $_POST['quantity'];

        $stmtUpdateQuantity = $conn->prepare("
            UPDATE cart
            SET quantity = ?
            WHERE user_id = ? AND item_id IN (SELECT item_id FROM items WHERE name = ?)
        ");
        $stmtUpdateQuantity->execute([$quantity, $user_id, $item_name]);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_item'])) {
    $item_name = $_POST['item_name'];

    $stmtRemoveItem = $conn->prepare("
        DELETE FROM cart
        WHERE user_id = ? AND item_id IN (SELECT item_id FROM items WHERE name = ?)
    ");
    $stmtRemoveItem->execute([$user_id, $item_name]);
}

$stmtCart = $conn->prepare("
    SELECT items.item_id, items.name, items.price, cart.quantity
    FROM items
    JOIN cart ON items.item_id = cart.item_id
    WHERE cart.user_id = ?
");
$stmtCart->execute([$user_id]);
$cartItems = $stmtCart->fetchAll();
$subtotals = array_map(function ($item) {
    return $item['price'] * $item['quantity'];
}, $cartItems);
$totalPrice = array_sum($subtotals);
$stmtGenres = $conn->query("SELECT genre_id, name FROM genres");
$genres = $stmtGenres->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<style>
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    main {
        flex-grow: 1;
    }

    footer {
        margin-top: auto;
    }
</style>

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

    <div class="p-8 mt-8">
        <h2 class="text-3xl font-bold mb-4">Shopping Cart</h2>

        <?php if (empty($cartItems)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Item</th>
                            <th class="py-2 px-4 border-b">Price</th>
                            <th class="py-2 px-4 border-b">Quantity</th>
                            <th class="py-2 px-4 border-b">Subtotal</th>
                            <th class="py-2 px-4 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartItems as $cartItem): ?>
                            <tr>
                                <td class="py-2 px-4 border-b">
                                    <?= $cartItem['name'] ?>
                                </td>
                                <td class="py-2 px-4 border-b">$
                                    <?= $cartItem['price'] ?>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <form method="post" action="">
                                        <input type="hidden" name="item_name" value="<?= $cartItem['name'] ?>">
                                        <input type="text" name="quantity" value="<?= $cartItem['quantity'] ?>"
                                            class="w-12 md:w-20 lg:w-24">
                                        <button type="submit" name="update_quantity"
                                            class="bg-blue-500 text-white px-2 py-1 rounded">Update</button>
                                    </form>
                                </td>
                                <td class="py-2 px-4 border-b">$
                                    <?= $cartItem['price'] * $cartItem['quantity'] ?>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <form method="post" action="">
                                        <input type="hidden" name="item_name" value="<?= $cartItem['name'] ?>">
                                        <button type="submit" name="remove_item"
                                            class="bg-red-500 text-white px-2 py-1 rounded">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="mt-4 flex flex-col md:flex-row items-center">
                <p class="md:mr-4">Total: $
                    <?= $totalPrice ?>
                </p>
                <button type="submit" name="pay"
                    class="bg-green-500 text-white px-4 py-2 rounded md:mr-2 mb-2 md:mb-0">Pay</button>
                <a href="shop.php" class="bg-yellow-500 text-white px-4 py-2 rounded">
                    <h2 class="text-1xl">Go back</h2>
                </a>
            </div>
            </form>
        <?php endif; ?>
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