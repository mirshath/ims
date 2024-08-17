<?php
include("database/connection.php");
include("includes/header.php");

$results_per_page = 10; // Number of results per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$start = ($page - 1) * $results_per_page;

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_semester'])) {
        // Add new semester
        $semester_name = $_POST['semester_name'];
        $sql = "INSERT INTO semester_table (semester_name) VALUES ('$semester_name')";
        $conn->query($sql);
    } elseif (isset($_POST['update_semester'])) {
        // Update semester
        $id = $_POST['id'];
        $semester_name = $_POST['semester_name'];
        $sql = "UPDATE semester_table SET semester_name='$semester_name' WHERE id=$id";
        $conn->query($sql);
    } elseif (isset($_POST['delete_semester'])) {
        // Delete semester
        $id = $_POST['id'];
        $sql = "DELETE FROM semester_table WHERE id=$id";
        $conn->query($sql);
    }
}

// Fetch semesters for the current page
$sql = "SELECT * FROM semester_table LIMIT $start, $results_per_page";
$result = $conn->query($sql);

// Fetch total number of semesters for pagination controls
$sql_total = "SELECT COUNT(*) as total FROM semester_table";
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
                    <h4 class="h4 mb-0 text-gray-800">Semester Management</h4>
                </div>

                <!-- Add Semester Form -->
                <form action="" method="post" class="mb-3">
                    <div class="form-group">
                        <label for="semester_name">Semester Name</label>
                        <input type="text" class="form-control" id="semester_name" name="semester_name" required>
                    </div>
                    <button type="submit" name="add_semester" class="btn btn-primary">Add Semester</button>
                </form>

                <!-- Semesters Table -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Semester Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <form action="" method="post" class="d-inline">
                                    <td><?php echo $row['id']; ?></td>
                                    <td>
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <input type="text" class="form-control form-control-sm" name="semester_name" value="<?php echo htmlspecialchars($row['semester_name']); ?>" required>
                                    </td>
                                    <td>
                                        <button type="submit" name="update_semester" class="btn btn-info btn-sm">Update</button>
                                        <button type="submit" name="delete_semester" class="btn btn-danger btn-sm">Delete</button>
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

<?php $conn->close(); ?>

</body>
</html>
