<?php
require_once 'db/db.php';

session_start();

function connectToDatabase()
{
    global $hostname, $database, $username, $password;

    try {
        $db = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $db;
    } catch (PDOException $e) {
        exit();
    }
}

function redirectToLoginPage()
{
    header("Location: login-form.php");
    exit();
}

if ($_SESSION['user']['role'] === 'user' && $_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        insertRecord($db);
    } elseif (isset($_POST['update'])) {
        updateRecord($db);
    } elseif (isset($_POST['delete'])) {
        deleteRecord($db);
    }
}
function insertRecord($db)
{
    if (isset($_POST['insert'])) {
        $daily_sales = $_POST['daily_sales'];
        $weekly_sales = $_POST['weekly_sales'];
        $monthly_sales = $_POST['monthly_sales'];
        $yearly_sales = $_POST['yearly_sales'];
        $date = $_POST['date'];

        $insertStmt = $db->prepare("INSERT INTO sales (daily_sales, weekly_sales, monthly_sales, yearly_sales,date) VALUES (:daily_sales, :weekly_sales, :monthly_sales, :yearly_sales, :date)");
        $insertStmt->bindParam(':daily_sales', $daily_sales);
        $insertStmt->bindParam(':weekly_sales', $weekly_sales);
        $insertStmt->bindParam(':monthly_sales', $monthly_sales);
        $insertStmt->bindParam(':yearly_sales', $yearly_sales);
        $insertStmt->bindParam(':date', $date);

        if ($insertStmt->execute()) {
            echo "Record inserted successfully.";
        } else {
            echo "Error inserting record.";
        }
    }

}


function updateRecord($db)
{
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $daily_sales = $_POST['daily_sales'];
        $weekly_sales = $_POST['weekly_sales'];
        $monthly_sales = $_POST['monthly_sales'];
        $yearly_sales = $_POST['yearly_sales'];
        $date = $_POST['date'];
    
        $updateStmt = $db->prepare("UPDATE sales SET daily_sales = :daily_sales, weekly_sales = :weekly_sales, monthly_sales = :monthly_sales, yearly_sales = :yearly_sales, date = :date WHERE id = :id");
        $updateStmt->bindParam(':id', $id);
        $updateStmt->bindParam(':daily_sales', $daily_sales);
        $updateStmt->bindParam(':weekly_sales', $weekly_sales);
        $updateStmt->bindParam(':monthly_sales', $monthly_sales);
        $updateStmt->bindParam(':yearly_sales', $yearly_sales);
        $updateStmt->bindParam(':date', $date);
    
        if ($updateStmt->execute()) {
            echo "Record updated successfully.";
        } else {
            echo "Error updating record.";
        }
    }
    
    
    
}

function deleteRecord($db)
{
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

$db = connectToDatabase();

if (!isset($_SESSION['user'])) {
    redirectToLoginPage();
}

if ($_SESSION['user']['role'] === 'user' && $_SERVER["REQUEST_METHOD"] == "POST") {
    insertRecord($db);
    updateRecord($db);
    deleteRecord($db);
}

$db = null;
?>

<?php
$conn = mysqli_connect('localhost', 'paws', 'paws', 'salesdb');
$sql = "SELECT * FROM sales";
$result = mysqli_query($conn, $sql);

$dataPoints1 = $dataPoints2 = $dataPoints3 = $dataPoints4 = array();

while ($row = mysqli_fetch_assoc($result)) {
    $dataPoints1[] = array("label" => $row['date'], "y" => $row['daily_sales']);
    $dataPoints2[] = array("label" => $row['date'], "y" => $row['weekly_sales']);
    $dataPoints3[] = array("label" => $row['date'], "y" => $row['monthly_sales']);
    $dataPoints4[] = array("label" => $row['date'], "y" => $row['yearly_sales']);
}
?>

<?php

$conn = mysqli_connect('localhost', 'paws', 'paws', 'salesdb');
$sql = "SELECT * FROM sales";
$result = mysqli_query($conn, $sql);


$dataPoints1 = array();
$dataPoints2 = array();
$dataPoints3 = array();
$dataPoints4 = array();

while ($row = mysqli_fetch_assoc($result)) {
    $dataPoints1[] = array("label" => $row['date'], "y" => $row['daily_sales']);
    $dataPoints2[] = array("label" => $row['date'], "y" => $row['weekly_sales']);
    $dataPoints3[] = array("label" => $row['date'], "y" => $row['monthly_sales']);
    $dataPoints4[] = array("label" => $row['date'], "y" => $row['yearly_sales']);
}
?>

<?php
$conn = mysqli_connect('localhost', 'paws', 'paws', 'salesdb');
$sql = "SELECT * FROM sales";
$result = mysqli_query($conn, $sql);


$dataPoints1 = array();
$dataPoints2 = array();
$dataPoints3 = array();
$dataPoints4 = array();
$dataPoints5 = array();

while ($row = mysqli_fetch_assoc($result)) {
    $dataPoints1[] = array("label" => $row['date'], "y" => $row['daily_sales']);
    $dataPoints2[] = array("label" => $row['date'], "y" => $row['weekly_sales']);
    $dataPoints3[] = array("label" => $row['date'], "y" => $row['monthly_sales']);
    $dataPoints4[] = array("label" => $row['date'], "y" => $row['yearly_sales']);
    $dataPoints5[] = array("label" => $row['date'], "y" => $row['daily_sales'],
        "weekly" => $row['weekly_sales'],
        "monthly" => $row['monthly_sales'],
        "yearly" => $row['yearly_sales']
    );
}

?>

<?php
$conn = mysqli_connect('localhost', 'paws', 'paws', 'salesdb');
$sql = "SELECT * FROM sales";
$result = mysqli_query($conn, $sql);


$dataPoints1 = array();
$dataPoints2 = array();
$dataPoints3 = array();
$dataPoints4 = array();
$dataPoints5 = array();

while ($row = mysqli_fetch_assoc($result)) {
    $dataPoints1[] = array("label" => $row['date'], "y" => $row['daily_sales']);
    $dataPoints2[] = array("label" => $row['date'], "y" => $row['weekly_sales']);
    $dataPoints3[] = array("label" => $row['date'], "y" => $row['monthly_sales']);
    $dataPoints4[] = array("label" => $row['date'], "y" => $row['yearly_sales']);
    $dataPoints5[] = array("label" => $row['date'], "y" => $row['daily_sales'],
        "weekly" => $row['weekly_sales'],
        "monthly" => $row['monthly_sales'],
        "yearly" => $row['yearly_sales']
    );
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<header>
    <nav class="px-10 py-5 bg-[#f90] text-white text-md m-0 text-right ">
        <a class="px-3 font-bold font-arial hover:text-[#808080]" href="user.php">Dashboard</a>
        <a class="px-3 font-bold font-arial hover:text-[#808080]" href="login-form.php">Log in</a>
        <a class="px-3 font-bold font-arial hover:text-[#808080]" href="register-form.php">Register</a>
    </nav>
</header>

<body class="bg-[#1b1b1b] mb-10">
    <div class="m-5">
        <!-- <h1 class="text-center text-white text-2xl">Bar Chart 1 (Weekly Sales)</h1> -->
        <h2 style="text-align:center;color:green"></h2>
        <div id="chartContainer2" class="px-7 py-2 m-5 bg-[#ffa31a]" style="height: 160px; width: 95%;"></div>
        <div class="flex">
            <!-- <h1 style="text-align:center;color:orange">Line Chart 3 (Monthly Sales)</h1> -->
            <h2 style="text-align:center;color:green"></h2>
            <div id="chartContainer3" class="px-6 py-2 m-5 bg-[#ffa31a]" style="height: 370px; width: 58%;"></div>


            <!-- <h1 class="text-center text-2xl">Pie Chart 2</h1> -->
            <h2 style="text-align:center;color:green"></h2>
            <div id="chartContainer" class="px-6 p-5 py-2 m-5 bg-[#ffa31a]" style="height: 370px; width: 35%;"></div>
        </div>
        <div class="flex">
            <!-- <h1 style="text-align:center;color:black">Scatter Chart 4 (Yearly Sales)</h1> -->
            <h2 style="text-align:center;color:green"></h2>
            <div id="chartContainer4" class="px-6 py-2 m-5 bg-[#ffa31a]" style="height: 370px; width: 58%;"></div>

            <!-- <h1 style="text-align:center;color:orange">Doughnut Chart 5 (Yearly Sales)</h1> -->
            <h2 style="text-align:center;color:green"></h2>
            <div id="chartContainer5" class="px-6 py-2 m-5 bg-[#ffa31a]" style="height: 370px; width: 35%;"></div>
        </div>
    </div>
    <div class="mb-8 flex space-x-4">
        <button onclick="showForm('add-form')"
            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition duration-300">Add
            Record</button>
        <button onclick="showForm('update-form')"
            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md transition duration-300">Update
            Record</button>
        <button onclick="showForm('delete-form')"
            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition duration-300">Delete
            Record</button>
    </div>

    <script>
        window.onload = function () {

            var chart1 = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                backgroundColor: "#ffffff",

                subtitles: [{
                    fontSize: 20,
                    text: "Pie Chart ( Daily Sales ) -------------  Year 2023-24"
                }],
                data: [{
                    type: "pie",
                    yValueFormatString: "#,##0.\"\"",
                    indexLabel: "({y} daily)",
                    dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart1.render();


            var chart2 = new CanvasJS.Chart("chartContainer2", {
                animationEnabled: true,
                subtitles: [{
                    fontSize: 20,
                    text: "Bar Chart ( Weekly Sales )  -----------  Year 2023-24"
                }],
                data: [{
                    type: "bar",
                    yValueFormatString: "#,##0.\"\"",
                    indexLabel: "({y} weekly)   ",
                    dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart2.render();


            var chart3 = new CanvasJS.Chart("chartContainer3", {
                animationEnabled: true,
                subtitles: [{
                    fontSize: 20,
                    text: " Line Chart (Monthly Sales)  -------------  Year 2023-24"
                }],
                data: [{
                    type: "line",
                    yValueFormatString: "#,##0.\"\"",
                    indexLabel: "({y} monthly)",
                    dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart3.render();


            var chart4 = new CanvasJS.Chart("chartContainer4", {
                animationEnabled: true,
                subtitles: [{
                    fontSize: 20,
                    text: "Scatter Chart (Yearly Sales)  ---------------  Year 2023-24"
                }],
                data: [{
                    type: "scatter",
                    yValueFormatString: "#,##0.\"\"",
                    indexLabel: "({y} yearly)",
                    dataPoints: <?php echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart4.render();

            var chart5 = new CanvasJS.Chart("chartContainer5", {
                animationEnabled: true,
                subtitles: [{
                    fontSize: 20,
                    text: " Doughnut Chart (Over All Sales)  ----  Year 2023-24"
                }],
                data: [{
                    type: "doughnut",
                    yValueFormatString: "#,##0.\"\"",
                    indexLabel: "{y} daily, {weekly} weekly, {monthly} monthly, {yearly} yearly",
                    dataPoints: <?php echo json_encode($dataPoints5, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart5.render();
        }
    </script>
    <div id="add-form" class="hidden">
        <h2 class="text-2xl mb-4">Add Record</h2>
        <form method="POST" action="user.php" class="max-w-md bg-white p-6 rounded-md shadow-md">
            <div class="mb-4">
                <label for="date" class="block text-sm font-medium text-gray-600">Sales Date:</label>
                <input type="date" name="date" required class="mt-1 p-2 w-full border rounded-md text-black">
            </div>
            <div class="mb-4">
                <label for="daily_sales" class="block text-sm font-medium text-gray-600">Daily Sales:</label>
                <input type="text" name="daily_sales" required class="mt-1 p-2 w-full border rounded-md text-black">
            </div>

            <div class="mb-4">
                <label for="weekly_sales" class="block text-sm font-medium text-gray-600">Weekly Sales:</label>
                <input type="text" name="weekly_sales" required class="mt-1 p-2 w-full border rounded-md text-black">
            </div>

            <div class="mb-4">
                <label for="monthly_sales" class="block text-sm font-medium text-gray-600">Monthly Sales:</label>
                <input type="text" name="monthly_sales" required class="mt-1 p-2 w-full border rounded-md text-black">
            </div>

            <div class="mb-4">
                <label for="yearly_sales" class="block text-sm font-medium text-gray-600">Yearly Sales:</label>
                <input type="text" name="yearly_sales" required class="mt-1 p-2 w-full border rounded-md text-black">
            </div>

            <button type="submit" name="insert"
                class="bg-blue-500 text-white p-2 rounded-md hover:bg-green-600">Add</button>
        </form>
    </div>


    <div id="update-form" class="hidden">
        <h2 class="text-2xl mb-4">Update Record</h2>
        <form method="POST" action="user.php" class="max-w-md bg-white p-6 rounded-md shadow-md">
            <div class="mb-4">
                <label for="id" class="block text-sm font-medium text-gray-600">Record ID:</label>
                <input type="text" id="id" name="id" required class="mt-1 p-2 w-full border rounded-md text-black">
            </div>
            <div class="mb-4">
                <label for="date" class="block text-sm font-medium text-gray-600">Sales Date:</label>
                <input type="date" name="date" required class="mt-1 p-2 w-full border rounded-md text-black">
            </div>
            <div class="mb-4">
                <label for="daily_sales" class="block text-sm font-medium text-gray-600">Daily Sales:</label>
                <input type="text" name="daily_sales" required class="mt-1 p-2 w-full border rounded-md text-black">
            </div>

            <div class="mb-4">
                <label for="weekly_sales" class="block text-sm font-medium text-gray-600">Weekly Sales:</label>
                <input type="text" name="weekly_sales" required class="mt-1 p-2 w-full border rounded-md text-black">
            </div>

            <div class="mb-4">
                <label for="monthly_sales" class="block text-sm font-medium text-gray-600">Monthly Sales:</label>
                <input type="text" name="monthly_sales" required class="mt-1 p-2 w-full border rounded-md text-black">
            </div>

            <div class="mb-4">
                <label for="yearly_sales" class="block text-sm font-medium text-gray-600">Yearly Sales:</label>
                <input type="text" name="yearly_sales" required class="mt-1 p-2 w-full border rounded-md text-black">
            </div>

            <button type="submit" name="update"
                class="bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600">Update</button>
        </form>
    </div>

    <div id="delete-form" class="hidden">
        <h2 class="text-2xl mb-4">Delete Record</h2>
        <form method="POST" action="user.php" class="max-w-md bg-white p-6 rounded-md shadow-md">
            <div class="mb-4">
                <label for="id" class="block text-sm font-medium text-gray-600">Record ID:</label>
                <input type="text" name="id" required class="mt-1 p-2 w-full border rounded-md text-black">
            </div>
            <button type="submit" name="delete"
                class="bg-blue-500 text-white p-2 rounded-md hover:bg-red-600">Delete</button>
        </form>
    </div>

    </div>

    <script>
        function showForm(formId) {

            document.getElementById('add-form').style.display = 'none';
            document.getElementById('update-form').style.display = 'none';
            document.getElementById('delete-form').style.display = 'none';


            document.getElementById(formId).style.display = 'block';
        }
    </script>
</body>

</html>