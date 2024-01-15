<?php
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        if ($user['admin']) {
            session_start();
            $_SESSION['user_id'] = $user['user_id'];
            header("Location: admin.php");
            exit();
        } else {
            session_start();
            $_SESSION['user_id'] = $user['user_id'];
            header("Location: shop.php");
            exit();
        }
    } else {
        $error = "Invalid login credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="flex items-center bg-yellow-600 justify-center h-screen">
    <div class="container mx-auto p-8 border-2 border-gray-300 bg-white rounded-md shadow-lg md:w-96">
        <h2 class="text-3xl font-semibold mb-6 text-center text-blue-700">Welcome Back!</h2>

        <?php
        if (isset($error)) {
            echo "<p class='text-red-500 mb-4'>$error</p>";
        }
        ?>

        <form method="POST" action="" class="space-y-4">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username:</label>
                <input type="text" name="username" required
                    class="mt-1 p-2 block w-full border rounded-md focus:outline-none focus:shadow-outline-blue transition duration-150 ease-in-out sm:text-sm sm:leading-5">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
                <input type="password" name="password" required
                    class="mt-1 p-2 block w-full border rounded-md focus:outline-none focus:shadow-outline-blue transition duration-150 ease-in-out sm:text-sm sm:leading-5">
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                <button type="submit"
                    class="w-full sm:w-auto p-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue active:bg-blue-800 transition duration-150 ease-in-out">
                    Login
                </button>

                <a href="register.php"
                    class="w-full sm:w-auto p-2 mt-2 sm:mt-0 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:shadow-outline-blue active:bg-green-800 transition duration-150 ease-in-out text-center">
                    Register
                </a>
            </div>
        </form>
    </div>
</body>

</html>
