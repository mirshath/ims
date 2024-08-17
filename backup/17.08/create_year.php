<?php
include("database/connection.php");
include("includes/header.php");

// Pagination settings
$results_per_page = 5; // Number of results per page
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
                    <h4 class="h4 mb-0 text-gray-800">Year managment</h4>
                </div>


                <!-- Add Criteria Form -->



                <form action="" method="post" class="mb-3">
                    <div class="form-group">
                        <label for="year_name">Year Name</label>
                        <input type="text" class="form-control" id="year_name" name="year_name" required>
                    </div>
                    <button type="submit" name="add_year" class="btn btn-primary">Add Year</button>
                </form>

                <!-- Criteria Table -->

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
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['year_name']); ?></td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#editModal" data-id="<?php echo $row['id']; ?>" data-year_name="<?php echo htmlspecialchars($row['year_name']); ?>">Edit</button>
                                    <form action="" method="post" class="d-inline">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" name="delete_year" class="btn btn-danger btn-sm">Delete</button>
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




                <!-- Edit Modal -->
                <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Year</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post">
                                    <input type="hidden" id="edit_id" name="id">
                                    <div class="form-group">
                                        <label for="edit_year_name">Year Name</label>
                                        <input type="text" class="form-control" id="edit_year_name" name="year_name" required>
                                    </div>
                                    <button type="submit" name="update_year" class="btn btn-primary">Update Year</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    $('#editModal').on('show.bs.modal', function(event) {
                        var button = $(event.relatedTarget); // Button that triggered the modal
                        var id = button.data('id'); // Extract info from data-* attributes
                        var year_name = button.data('year_name');

                        var modal = $(this);
                        modal.find('#edit_id').val(id);
                        modal.find('#edit_year_name').val(year_name);
                    });
                </script>
                <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
              



            </div>
        </div>
    </div>
</div>

</div>

</body>

</html>
<?php $conn->close(); ?>