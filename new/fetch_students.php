<?php
include("../database/database.php"); // Update the path to your database connection

$limit = isset($_POST['limit']) ? (int)$_POST['limit'] : 10;
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM students LIMIT $offset, $limit";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$sqlTotal = "SELECT COUNT(*) as total FROM students";
$resultTotal = $conn->query($sqlTotal);
$total = $resultTotal->fetch_assoc()['total'];

$response = [
    'data' => $data,
    'total' => $total,
    'pages' => ceil($total / $limit)
];

echo json_encode($response);

$conn->close();
?>
