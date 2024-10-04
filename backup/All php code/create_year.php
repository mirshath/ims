<?php
include("database/connection.php");
include("includes/header.php");

// Pagination settings
$results_per_page = 10; // Number of results per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$start = ($page - 1) * $results_per_page;

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_year'])) {
        // Add new year
        $year_name = $_POST['year_name'];
        $sql = "INSERT INTO year_table (year_name) VALUES ('$year_name')";
        $conn->query($sql);
    } elseif (isset($_POST['update_year'])) {
        // Update year
        $id = $_POST['id'];
        $year_name = $_POST['year_name'];
        $sql = "UPDATE year_table SET year_name='$year_name' WHERE id=$id";
        $conn->query($sql);
    } elseif (isset($_POST['delete_year'])) {
        // Delete year
        $id = $_POST['id'];
        $sql = "DELETE FROM year_table WHERE id=$id";
        $conn->query($sql);
    }
}

// Fetch years for the current page
$sql = "SELECT * FROM year_table LIMIT $start, $results_per_page";
$result = $conn->query($sql);

// Fetch total number of years for pagination controls
$sql_total = "SELECT COUNT(*) as total FROM year_table";
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
                    <h4 class="h4 mb-0 text-gray-800">Year Management</h4>
                </div>

                <!-- Add Year Form -->
                <form action="" method="post" class="mb-3">
                    <div class="form-group">
                        <label for="year_name">Year Name</label>
                        <input type="text" class="form-control" id="year_name" name="year_name" required>
                    </div>
                    <button type="submit" name="add_year" class="btn btn-primary">Add Year</button>
                </form>

                <!-- Year Table -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Year Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <form action="" method="post" class="form-inline">
                                    <td><?php echo $row['id']; ?></td>
                                    <td>
                                        <input type="text" class="form-control" name="year_name" value="<?php echo htmlspecialchars($row['year_name']); ?>" required>
                                    </td>
                                    <td>
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" name="update_year" class="btn btn-info btn-sm">Update</button>
                                        <button type="submit" name="delete_year" class="btn btn-danger btn-sm">Delete</button>
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

<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script> -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
<?php $conn->close(); ?>