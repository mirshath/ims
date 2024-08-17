<?php
include("database/connection.php");
include("includes/header.php");

// Pagination settings
$results_per_page = 10; // Number of results per page
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
            <div class="container">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h4 class="h4 mb-0 text-gray-800">Coordinator Management</h4>
                </div>

                <!-- Add Coordinator Form -->
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
                <table class="table table-striped">
                    <thead>
                        <tr>
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
                                <form action="" method="post" class="form-inline">
                                    <td><input type="text" class="form-control mb-2 mr-sm-2" name="coordinator_code" value="<?php echo htmlspecialchars($row['coordinator_code']); ?>" required></td>
                                    <td>
                                        <select class="form-control mb-2 mr-sm-2" name="title" required>
                                            <option value="Mr" <?php echo $row['title'] == 'Mr' ? 'selected' : ''; ?>>Mr</option>
                                            <option value="Mrs" <?php echo $row['title'] == 'Mrs' ? 'selected' : ''; ?>>Mrs</option>
                                            <option value="Ms" <?php echo $row['title'] == 'Ms' ? 'selected' : ''; ?>>Ms</option>
                                            <option value="Dr" <?php echo $row['title'] == 'Dr' ? 'selected' : ''; ?>>Dr</option>
                                            <option value="Prof" <?php echo $row['title'] == 'Prof' ? 'selected' : ''; ?>>Prof</option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control mb-2 mr-sm-2" name="coordinator_name" value="<?php echo htmlspecialchars($row['coordinator_name']); ?>" required></td>
                                    <td><input type="email" class="form-control mb-2 mr-sm-2" name="bms_email" value="<?php echo htmlspecialchars($row['bms_email']); ?>" required></td>
                                    <td>
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" name="update_coordinator" class="btn btn-info btn-sm mb-2">Update</button>
                                        <button type="submit" name="delete_coordinator" class="btn btn-danger btn-sm mb-2">Delete</button>
                                    </td>
                                </form>
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

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

</body>

</html>

<?php $conn->close(); ?>