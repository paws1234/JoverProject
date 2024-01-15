<?php
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $genre = $_POST['genre'];

    try {
        $stmtAllItems = $conn->prepare("SELECT name FROM items WHERE genre_id = (SELECT genre_id FROM genres WHERE name = ?)");
        $stmtAllItems->execute([$genre]);
        $allItems = $stmtAllItems->fetchAll(PDO::FETCH_ASSOC);

        $stmtPurchaseCount = $conn->prepare("SELECT i.name, SUM(p.quantity) as total_quantity
                                            FROM items i
                                            LEFT JOIN purchases p ON i.item_id = p.item_id
                                            LEFT JOIN genres g ON i.genre_id = g.genre_id
                                            WHERE g.name = ?
                                            GROUP BY i.name");
        $stmtPurchaseCount->execute([$genre]);
        $result = $stmtPurchaseCount->fetchAll(PDO::FETCH_ASSOC);

        $chartData = [
            'labels' => [],
            'datasets' => [
                [
                    'label' => 'Items Purchased in ' . $genre,
                    'data' => [],
                    'backgroundColor' => [],
                    'borderColor' => [],
                    'borderWidth' => 1
                ]
            ]
        ];

        foreach ($allItems as $item) {
            $chartData['labels'][] = $item['name'];
            $totalQuantity = 0;

            foreach ($result as $row) {
                if ($row['name'] === $item['name']) {
                    $totalQuantity = $row['total_quantity'];
                    break;
                }
            }


            $randomColor = sprintf('#%06X', mt_rand(0, 0xFFFFFF));

            $chartData['datasets'][0]['data'][] = $totalQuantity;
            $chartData['datasets'][0]['backgroundColor'][] = $randomColor;
            $chartData['datasets'][0]['borderColor'][] = $randomColor;
        }

        header('Content-Type: application/json');
        echo json_encode($chartData);
    } catch (PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Invalid request method']);
}
?>