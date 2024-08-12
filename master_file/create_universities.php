<?php

include("../database/database.php"); // Update the path to your database connection

// Pagination settings
$results_per_page = 5; // Number of results per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$start = ($page - 1) * $results_per_page;

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_university'])) {
        // Add new university
        $university_code = $_POST['university_code'];
        $university_name = $_POST['university_name'];
        $address = $_POST['address'];
        $uni_code = $_POST['uni_code'];
        $sql = "INSERT INTO universities (university_code, university_name, address, uni_code) VALUES ('$university_code', '$university_name', '$address', '$uni_code')";
        $conn->query($sql);
    } elseif (isset($_POST['update_university'])) {
        // Update university
        $id = $_POST['id'];
        $university_code = $_POST['university_code'];
        $university_name = $_POST['university_name'];
        $address = $_POST['address'];
        $uni_code = $_POST['uni_code'];
        $sql = "UPDATE universities SET university_code='$university_code', university_name='$university_name', address='$address', uni_code='$uni_code' WHERE id=$id";
        $conn->query($sql);
    } elseif (isset($_POST['delete_university'])) {
        // Delete university
        $id = $_POST['id'];
        $sql = "DELETE FROM universities WHERE id=$id";
        $conn->query($sql);
    }
}

// Fetch universities for the current page
$sql = "SELECT * FROM universities LIMIT $start, $results_per_page";
$result = $conn->query($sql);

// Fetch total number of universities for pagination controls
$sql_total = "SELECT COUNT(*) as total FROM universities";
$result_total = $conn->query($sql_total);
$total_rows = $result_total->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $results_per_page);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>University Management</h2>

        <!-- Add University Form -->
        <form action="" method="post" class="mb-3">
            <div class="form-group">
                <label for="university_code">University Code</label>
                <input type="text" class="form-control" id="university_code" name="university_code" required>
            </div>
            <div class="form-group">
                <label for="university_name">University Name</label>
                <input type="text" class="form-control" id="university_name" name="university_name" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="uni_code">Uni Code</label>
                <input type="text" class="form-control" id="uni_code" name="uni_code">
            </div>
            <button type="submit" name="add_university" class="btn btn-primary">Add University</button>
        </form>

        <!-- Universities Table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>University Code</th>
                    <th>University Name</th>
                    <th>Address</th>
                    <th>Uni Code</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['university_code']); ?></td>
                        <td><?php echo htmlspecialchars($row['university_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['address']); ?></td>
                        <td><?php echo htmlspecialchars($row['uni_code']); ?></td>
                        <td>
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#editModal" data-id="<?php echo $row['id']; ?>" data-university_code="<?php echo htmlspecialchars($row['university_code']); ?>" data-university_name="<?php echo htmlspecialchars($row['university_name']); ?>" data-address="<?php echo htmlspecialchars($row['address']); ?>" data-uni_code="<?php echo htmlspecialchars($row['uni_code']); ?>">Edit</button>
                            <form action="" method="post" class="d-inline">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete_university" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Pagination Controls -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-end">
                <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit University</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="form-group">
                            <label for="edit_university_code">University Code</label>
                            <input type="text" class="form-control" id="edit_university_code" name="university_code" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_university_name">University Name</label>
                            <input type="text" class="form-control" id="edit_university_name" name="university_name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_address">Address</label>
                            <textarea class="form-control" id="edit_address" name="address" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_uni_code">Uni Code</label>
                            <input type="text" class="form-control" id="edit_uni_code" name="uni_code">
                        </div>
                        <button type="submit" name="update_university" class="btn btn-primary">Update University</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $('#editModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var university_code = button.data('university_code');
            var university_name = button.data('university_name');
            var address = button.data('address');
            var uni_code = button.data('uni_code');

            var modal = $(this);
            modal.find('#edit_id').val(id);
            modal.find('#edit_university_code').val(university_code);
            modal.find('#edit_university_name').val(university_name);
            modal.find('#edit_address').val(address);
            modal.find('#edit_uni_code').val(uni_code);
        });
    </script>
</body>

</html>


<style>
    .form-control:focus {
        border-color: red;
        box-shadow: 0 0 0 0.2rem rgba(255, 0, 0, 0.25);
    }

   
</style>