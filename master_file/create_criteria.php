<?php

include("../database/connection.php"); // Update the path to your database connection

// Pagination settings
$results_per_page = 5; // Number of results per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$start = ($page - 1) * $results_per_page;

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_criteria'])) {
        // Add new criteria
        $criteria_code = $_POST['criteria_code'];
        $criteria_name = $_POST['criteria_name'];
        $sql = "INSERT INTO criterias (criteria_code, criteria_name) VALUES ('$criteria_code', '$criteria_name')";
        $conn->query($sql);
    } elseif (isset($_POST['update_criteria'])) {
        // Update criteria
        $id = $_POST['id'];
        $criteria_code = $_POST['criteria_code'];
        $criteria_name = $_POST['criteria_name'];
        $sql = "UPDATE criterias SET criteria_code='$criteria_code', criteria_name='$criteria_name' WHERE id=$id";
        $conn->query($sql);
    } elseif (isset($_POST['delete_criteria'])) {
        // Delete criteria
        $id = $_POST['id'];
        $sql = "DELETE FROM criterias WHERE id=$id";
        $conn->query($sql);
    }
}

// Fetch criteria for the current page
$sql = "SELECT * FROM criterias LIMIT $start, $results_per_page";
$result = $conn->query($sql);

// Fetch total number of criteria for pagination controls
$sql_total = "SELECT COUNT(*) as total FROM criterias";
$result_total = $conn->query($sql_total);
$total_rows = $result_total->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $results_per_page);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criteria Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Criteria Management</h2>

    <!-- Add Criteria Form -->
    <form action="" method="post" class="mb-3">
        <div class="form-group">
            <label for="criteria_code">Criteria Code</label>
            <input type="text" class="form-control" id="criteria_code" name="criteria_code" required>
        </div>
        <div class="form-group">
            <label for="criteria_name">Criteria Name</label>
            <input type="text" class="form-control" id="criteria_name" name="criteria_name" required>
        </div>
        <button type="submit" name="add_criteria" class="btn btn-primary">Add Criteria</button>
    </form>

    <!-- Criteria Table -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Criteria Code</th>
                <th>Criteria Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['criteria_code']); ?></td>
                    <td><?php echo htmlspecialchars($row['criteria_name']); ?></td>
                    <td>
                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#editModal" data-id="<?php echo $row['id']; ?>" data-criteria_code="<?php echo htmlspecialchars($row['criteria_code']); ?>" data-criteria_name="<?php echo htmlspecialchars($row['criteria_name']); ?>">Edit</button>
                        <form action="" method="post" class="d-inline">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="delete_criteria" class="btn btn-danger btn-sm">Delete</button>
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
                <h5 class="modal-title" id="editModalLabel">Edit Criteria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="form-group">
                        <label for="edit_criteria_code">Criteria Code</label>
                        <input type="text" class="form-control" id="edit_criteria_code" name="criteria_code" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_criteria_name">Criteria Name</label>
                        <input type="text" class="form-control" id="edit_criteria_name" name="criteria_name" required>
                    </div>
                    <button type="submit" name="update_criteria" class="btn btn-primary">Update Criteria</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $('#editModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id = button.data('id'); // Extract info from data-* attributes
        var criteria_code = button.data('criteria_code');
        var criteria_name = button.data('criteria_name');

        var modal = $(this);
        modal.find('#edit_id').val(id);
        modal.find('#edit_criteria_code').val(criteria_code);
        modal.find('#edit_criteria_name').val(criteria_name);
    });
</script>
</body>
</html>

<?php $conn->close(); ?>
