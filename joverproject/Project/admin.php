<?php
require_once 'db/db.php';

session_start();

try {
    $db = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    exit(); 
}

if (!isset($_SESSION['user'])) {
    header("Location: login-form.php");
    exit();
}

if ($_SESSION['user']['role'] === 'admin') {
    $stmt = $db->prepare("SELECT * FROM sales");
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        foreach ($result as $row) {
            echo "Daily Sales: " . $row['daily_sales'] . ", Weekly Sales: " . $row['weekly_sales'] . ", Monthly Sales: " . $row['monthly_sales'] . ", Yearly Sales: " . $row['yearly_sales'] . "<br>";
        }
    } else {
        echo "No sales data available.";
    }
}

if ($_SESSION['user']['role'] === 'user') {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST['insert'])) {
           
            $daily_sales = $_POST['daily_sales'];
            $weekly_sales = $_POST['weekly_sales'];
            $monthly_sales = $_POST['monthly_sales'];
            $yearly_sales = $_POST['yearly_sales'];

            $insertStmt = $db->prepare("INSERT INTO sales (daily_sales, weekly_sales, monthly_sales, yearly_sales) VALUES (:daily_sales, :weekly_sales, :monthly_sales, :yearly_sales)");
            $insertStmt->bindParam(':daily_sales', $daily_sales);
            $insertStmt->bindParam(':weekly_sales', $weekly_sales);
            $insertStmt->bindParam(':monthly_sales', $monthly_sales);
            $insertStmt->bindParam(':yearly_sales', $yearly_sales);

            if ($insertStmt->execute()) {
                echo "Record inserted successfully.";
            } else {
                echo "Error inserting record.";
            }
        }

        if (isset($_POST['update'])) {
           
            $id = $_POST['id'];
            $daily_sales = $_POST['daily_sales'];
            $weekly_sales = $_POST['weekly_sales'];
            $monthly_sales = $_POST['monthly_sales'];
            $yearly_sales = $_POST['yearly_sales'];

            $updateStmt = $db->prepare("UPDATE sales SET daily_sales = :daily_sales, weekly_sales = :weekly_sales, monthly_sales = :monthly_sales, yearly_sales = :yearly_sales WHERE id = :id");
            $updateStmt->bindParam(':id', $id);
            $updateStmt->bindParam(':daily_sales', $daily_sales);
            $updateStmt->bindParam(':weekly_sales', $weekly_sales);
            $updateStmt->bindParam(':monthly_sales', $monthly_sales);
            $updateStmt->bindParam(':yearly_sales', $yearly_sales);

            if ($updateStmt->execute()) {
                echo "Record updated successfully.";
            } else {
                echo "Error updating record.";
            }
        }


        if (isset($_POST['delete'])) {

            $id = $_POST['id'];

            $deleteStmt = $db->prepare("DELETE FROM sales WHERE id = :id");
            $deleteStmt->bindParam(':id', $id);

            if ($deleteStmt->execute()) {
                echo "Record deleted successfully.";
            } else {
                echo "Error deleting record.";
            }
        }
    }
}

$db = null;
?>
