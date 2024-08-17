<?php
include("database/connection.php");
include("includes/header.php");


$results_per_page = 5; // Number of results per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$start = ($page - 1) * $results_per_page;

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_lead'])) {
        // Add new lead
        $lead_type = $_POST['lead_type'];
        $sql = "INSERT INTO leads_table (lead_type) VALUES ('$lead_type')";
        $conn->query($sql);
    } elseif (isset($_POST['update_lead'])) {
        // Update lead
        $id = $_POST['id'];
        $lead_type = $_POST['lead_type'];
        $sql = "UPDATE leads_table SET lead_type='$lead_type' WHERE id=$id";
        $conn->query($sql);
    } elseif (isset($_POST['delete_lead'])) {
        // Delete lead
        $id = $_POST['id'];
        $sql = "DELETE FROM leads_table WHERE id=$id";
        $conn->query($sql);
    }
}

// Fetch leads for the current page
$sql = "SELECT * FROM leads_table LIMIT $start, $results_per_page";
$result = $conn->query($sql);

// Fetch total number of leads for pagination controls
$sql_total = "SELECT COUNT(*) as total FROM leads_table";
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
                    <h4 class="h4 mb-0 text-gray-800">Lead managment</h4>
                </div>


                <!-- Add Criteria Form -->
                <form action="" method="post" class="mb-3">
                    <div class="form-group">
                        <label for="lead_type">Lead Type</label>
                        <input type="text" class="form-control" id="lead_type" name="lead_type" required>
                    </div>
                    <button type="submit" name="add_lead" class="btn btn-primary">Add Lead</button>
                </form>

                <!-- Criteria Table -->

                <table class="table table-striped table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Lead Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['lead_type']); ?></td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#editModal" data-id="<?php echo $row['id']; ?>" data-lead_type="<?php echo htmlspecialchars($row['lead_type']); ?>">Edit</button>
                                    <form action="" method="post" class="d-inline">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" name="delete_lead" class="btn btn-danger btn-sm">Delete</button>
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
                                <h5 class="modal-title" id="editModalLabel">Edit Lead</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post">
                                    <input type="hidden" id="edit_id" name="id">
                                    <div class="form-group">
                                        <label for="edit_lead_type">Lead Type</label>
                                        <input type="text" class="form-control" id="edit_lead_type" name="lead_type" required>
                                    </div>
                                    <button type="submit" name="update_lead" class="btn btn-primary">Update Lead</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>

</div>

<script>
    $('#editModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id = button.data('id'); // Extract info from data-* attributes
        var lead_type = button.data('lead_type');

        var modal = $(this);
        modal.find('#edit_id').val(id);
        modal.find('#edit_lead_type').val(lead_type);
    });
</script>


</body>

</html>
<?php $conn->close(); ?>
