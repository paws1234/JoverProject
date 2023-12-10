<?php
// Include the database connection file
require_once 'db/db.php';

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    // Redirect to the login page if not logged in
    header("Location: login-form.php");
    exit();
}

// Get the user role from the session
$userRole = $_SESSION['user']['role'];

// Check if the user role is not 'user'
if ($userRole !== 'user') {
    // Redirect to an appropriate page (admin.php in this case)
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Interface</title>
</head>
<body>
    <h1>User Interface</h1>

    <h2>Add Record</h2>
    <form method="POST" action="admin.php">
        <label for="daily_sales">Daily Sales:</label>
        <input type="text" name="daily_sales" required>

        <label for="weekly_sales">Weekly Sales:</label>
        <input type="text" name="weekly_sales" required>

        <label for="monthly_sales">Monthly Sales:</label>
        <input type="text" name="monthly_sales" required>

        <label for="yearly_sales">Yearly Sales:</label>
        <input type="text" name="yearly_sales" required>

        <button type="submit" name="insert">Insert</button>
    </form>


    <h2>Update Record</h2>
    <form method="POST" action="admin.php">
        <label for="daily_sales">Daily Sales:</label>
        <input type="text" name="daily_sales" required>

        <label for="weekly_sales">Weekly Sales:</label>
        <input type="text" name="weekly_sales" required>

        <label for="monthly_sales">Monthly Sales:</label>
        <input type="text" name="monthly_sales" required>

        <label for="yearly_sales">Yearly Sales:</label>
        <input type="text" name="yearly_sales" required>

        <button type="submit" name="insert">Insert</button>
    </form>

    <h2>Delete Record</h2>
    <form method="POST" action="admin.php">
        <label for="id">Record ID:</label>
        <input type="text" name="id" required>

        <button type="submit" name="delete">Delete</button>
    </form>


</body>
</html>
