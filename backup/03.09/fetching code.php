<!-- fetch student 1st updated code  -->
<!-- -----------------------------------------------------------------  -->
<!-- -----------------------------------------------------------------  -->
<!-- -----------------------------------------------------------------  -->


<?php
include("database/connection.php"); // Update the path to your database connection

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



<!-- fetch student 2nd updated code  -->
<!-- -----------------------------------------------------------------  -->
<!-- -----------------------------------------------------------------  -->
<!-- -----------------------------------------------------------------  -->
<!-- -----------------------------------------------------------------  -->



<?php
include("database/connection.php");

$limit = isset($_POST['limit']) ? intval($_POST['limit']) : 3;
$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$offset = ($page - 1) * $limit;

$query = "SELECT COUNT(*) AS total FROM students";
$result = $conn->query($query);
$total = $result->fetch_assoc()['total'];
$totalPages = ceil($total / $limit);

$query = "SELECT * FROM students LIMIT $limit OFFSET $offset";
$result = $conn->query($query);

$students = [];
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}

echo json_encode([
    'data' => $students,
    'totalPages' => $totalPages
]);

$conn->close();
?>











<!-- old fetching code  -->

<!-- scripts  -->
<script>
    $(document).ready(function() {
        const limit = 10;

        function loadStudents(page) {
            $.ajax({
                url: "fetch_students.php",
                type: "POST",
                data: {
                    limit: limit,
                    page: page,
                },
                success: function(response) {
                    const data = JSON.parse(response);
                    let tableBody = "";
                    data.data.forEach((student) => {
                        tableBody += `<tr>
                                <td>${student.first_name}</td>
                                <td>${student.last_name}</td>
                                <td>${student.certificate_name}</td>
                                <td>${student.date_of_birth}</td>
                                <td>${student.permanent_address}</td>
                                <td>${student.telephone}</td>
                                <td>${student.mobile}</td>
                                <td>${student.nic}</td>
                                <td>${student.passport}</td>
                                <td>${student.personal_email}</td>
                                <td>${student.occupation}</td>
                            </tr>`;
                    });
                    $("#studentTableBody").html(tableBody);

                },
            });
        }

        // Load initial data
        loadStudents(1);


    });
</script>