<?php
include("database/connection.php");
include("includes/header.php");

// Pagination settings
$results_per_page = 5; // Number of results per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$start = ($page - 1) * $results_per_page;

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_coordinator'])) {
        // Add new coordinator
        $coordinator_code = $_POST['coordinator_code'];
        $title = $_POST['title'];
        $coordinator_name = $_POST['coordinator_name'];
        $bms_email = $_POST['bms_email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $sql = "INSERT INTO coordinator_table (coordinator_code, title, coordinator_name, bms_email, password_hash) VALUES ('$coordinator_code', '$title', '$coordinator_name', '$bms_email', '$password')";
        $conn->query($sql);
    } elseif (isset($_POST['update_coordinator'])) {
        // Update coordinator
        $id = $_POST['id'];
        $coordinator_code = $_POST['coordinator_code'];
        $title = $_POST['title'];
        $coordinator_name = $_POST['coordinator_name'];
        $bms_email = $_POST['bms_email'];

        $sql = "UPDATE coordinator_table SET coordinator_code='$coordinator_code', title='$title', coordinator_name='$coordinator_name', bms_email='$bms_email' WHERE id=$id";
        $conn->query($sql);
    } elseif (isset($_POST['delete_coordinator'])) {
        // Delete coordinator
        $id = $_POST['id'];
        $sql = "DELETE FROM coordinator_table WHERE id=$id";
        $conn->query($sql);
    }
}

// Fetch coordinators for the current page
$sql = "SELECT * FROM coordinator_table LIMIT $start, $results_per_page";
$result = $conn->query($sql);

// Fetch total number of coordinators for pagination controls
$sql_total = "SELECT COUNT(*) as total FROM coordinator_table";
$result_total = $conn->query($sql_total);
$total_rows = $result_total->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $results_per_page);
?>

<!-- Page Wrapper -->
<div id="wrapper">

    <?php include("nav.php"); ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <?php include("includes/topnav.php"); ?>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h4 class="h4 mb-0 text-gray-800">Coordinator managment</h4>
                </div>


                <form action="" method="post" class="mb-3">
            <div class="form-group">
                <label for="coordinator_code">Coordinator Code</label>
                <input type="text" class="form-control" id="coordinator_code" name="coordinator_code" required>
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <select class="form-control" id="title" name="title" required>
                    <option value="Mr">Mr</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Ms">Ms</option>
                    <option value="Dr">Dr</option>
                    <option value="Prof">Prof</option>
                </select>
            </div>
            <div class="form-group">
                <label for="coordinator_name">Coordinator Name</label>
                <input type="text" class="form-control" id="coordinator_name" name="coordinator_name" required>
            </div>
            <div class="form-group">
                <label for="bms_email">BMS Email</label>
                <input type="email" class="form-control" id="bms_email" name="bms_email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" name="add_coordinator" class="btn btn-primary">Add Coordinator</button>
        </form>

        <!-- Coordinators Table -->
        <table class="table table-striped table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Coordinator Code</th>
                    <th>Title</th>
                    <th>Coordinator Name</th>
                    <th>BMS Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['coordinator_code']); ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['coordinator_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['bms_email']); ?></td>
                        <td>
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#editModal" data-id="<?php echo $row['id']; ?>" data-coordinator_code="<?php echo htmlspecialchars($row['coordinator_code']); ?>" data-title="<?php echo htmlspecialchars($row['title']); ?>" data-coordinator_name="<?php echo htmlspecialchars($row['coordinator_name']); ?>" data-bms_email="<?php echo htmlspecialchars($row['bms_email']); ?>">Edit</button>
                            <form action="" method="post" class="d-inline">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete_coordinator" class="btn btn-danger btn-sm">Delete</button>
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
        </div>
    </div>
</div>







<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Coordinator</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="form-group">
                            <label for="edit_coordinator_code">Coordinator Code</label>
                            <input type="text" class="form-control" id="edit_coordinator_code" name="coordinator_code" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_title">Title</label>
                            <select class="form-control" id="edit_title" name="title" required>
                                <option value="Mr">Mr</option>
                                <option value="Mrs">Mrs</option>
                                <option value="Ms">Ms</option>
                                <option value="Dr">Dr</option>
                                <option value="Prof">Prof</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_coordinator_name">Coordinator Name</label>
                            <input type="text" class="form-control" id="edit_coordinator_name" name="coordinator_name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_bms_email">BMS Email</label>
                            <input type="email" class="form-control" id="edit_bms_email" name="bms_email" required>
                        </div>
                        <button type="submit" name="update_coordinator" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Populate the edit modal with the selected coordinator's data
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var coordinator_code = button.data('coordinator_code');
            var title = button.data('title');
            var coordinator_name = button.data('coordinator_name');
            var bms_email = button.data('bms_email');

            var modal = $(this);
            modal.find('#edit_id').val(id);
            modal.find('#edit_coordinator_code').val(coordinator_code);
            modal.find('#edit_title').val(title);
            modal.find('#edit_coordinator_name').val(coordinator_name);
            modal.find('#edit_bms_email').val(bms_email);
        });
    </script>






</div>


</body>

</html>

<?php $conn->close(); ?>