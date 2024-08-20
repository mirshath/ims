<?php
include("database/connection.php");
include("includes/header.php");

$results_per_page = 10; // Number of results per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$start = ($page - 1) * $results_per_page;


// ------------------------------------------------------------------------ 
// Fetch distinct 'type' values from leads_table
$sql_lead = "SELECT  lead_type FROM leads_table";
$result_lead = $conn->query($sql_lead);


// ------------------------------------------------------------------------ 


// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_lead'])) {
        // Add new lead
        $lead_date = $_POST['lead_date'];
        $type = $_POST['type'];
        $university = $_POST['university'];
        $programme = $_POST['programme'];
        $intake = $_POST['intake'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $contact = $_POST['contact'];
        $email = $_POST['email'];
        $details = $_POST['details'];
        $status = $_POST['status'];

        $stmt = $conn->prepare("INSERT INTO leads (lead_date, type, university, programme, intake, first_name, last_name, contact, email, details, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssss", $lead_date, $type, $university, $programme, $intake, $first_name, $last_name, $contact, $email, $details, $status);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['update_lead'])) {
        // Update lead
        $id = $_POST['id'];
        $lead_date = $_POST['lead_date'];
        $type = $_POST['type'];
        $university = $_POST['university'];
        $programme = $_POST['programme'];
        $intake = $_POST['intake'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $contact = $_POST['contact'];
        $email = $_POST['email'];
        $details = $_POST['details'];
        $status = $_POST['status'];

        $stmt = $conn->prepare("UPDATE leads SET lead_date=?, type=?, university=?, programme=?, intake=?, first_name=?, last_name=?, contact=?, email=?, details=?, status=? WHERE id=?");
        $stmt->bind_param("sssssssssssi", $lead_date, $type, $university, $programme, $intake, $first_name, $last_name, $contact, $email, $details, $status, $id);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['update_lead_status'])) {
        // Update lead status
        $id = $_POST['id'];
        $status = $_POST['status'];

        $stmt = $conn->prepare("UPDATE leads SET status=? WHERE id=?");
        $stmt->bind_param("si", $status, $id);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['delete_lead'])) {
        // Delete lead
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM leads WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch leads for the current page
$sql = "SELECT * FROM leads LIMIT $start, $results_per_page";
$result = $conn->query($sql);

// Fetch total number of leads for pagination controls
$sql_total = "SELECT COUNT(*) as total FROM leads";
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
                    <h4 class="h4 mb-0 text-gray-800">Leads Management</h4>
                </div>

                <div class="container">

                    <!-- Add Lead Form -->
                    <form action="" method="post" class="mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lead_date">Lead Date</label>
                                    <input type="date" class="form-control" id="lead_date" name="lead_date" required>
                                </div>
                            </div>
                            <!-- <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <input type="text" class="form-control" id="type" name="type" required>
                                </div>
                            </div> -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <select class="form-control" id="type" name="type" required>
                                        <option value="" disabled selected>Select Type</option>
                                        <?php
                                        // Check if there are results and populate the dropdown
                                        if ($result_lead->num_rows > 0) {
                                            while ($row = $result_lead->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row['lead_type']) . '">' . htmlspecialchars($row['lead_type']) . '</option>';
                                            }
                                        } else {
                                            echo '<option value="" disabled>No types available</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="university">University</label>
                                    <input type="text" class="form-control" id="university" name="university" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="programme">Programme</label>
                                    <input type="text" class="form-control" id="programme" name="programme" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="intake">Intake</label>
                                    <input type="date" class="form-control" id="intake" name="intake" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact">Contact</label>
                                    <input type="text" class="form-control" id="contact" name="contact" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="details">Details</label>
                                    <textarea class="form-control" id="details" name="details"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="New">New</option>
                                        <option value="Contacted">Contacted</option>
                                        <option value="Qualified">Qualified</option>
                                        <option value="Lost">Lost</option>
                                        <option value="Converted">Converted</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="add_lead" class="btn btn-primary">Add Lead</button>
                    </form>
                </div>

                <!-- Leads Table -->
                <!-- Leads Table -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <!-- <th>ID</th> -->
                            <th>Lead Date</th>
                            <th>Type</th>
                            <!-- <th>University</th> -->
                            <th>Programme</th>
                            <th>Intake</th>
                            <th> Name</th>
                            <!-- <th>Last Name</th> -->
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Details</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody style="font-size: 12px;">
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <!-- <td><?php echo $row['id']; ?></td> -->
                                <td><?php echo $row['lead_date']; ?></td>
                                <td><?php echo $row['type']; ?></td>
                                <!-- <td><?php echo $row['university']; ?></td> -->
                                <td><?php echo $row['programme']; ?></td>
                                <td><?php echo $row['intake']; ?></td>
                                <td><?php echo $row['first_name']; ?>&nbsp;<?php echo $row['last_name']; ?></td>
                                <!-- <td><?php echo $row['last_name']; ?></td> -->
                                <td><?php echo $row['contact']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['details']; ?></td>
                                <td>
                                    <form class="update-status-form" style="display: inline;">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <select class="form-control select2 form-control-sm" name="status">
                                            <option value="New" <?php if ($row['status'] == 'New') echo 'selected'; ?>>New</option>
                                            <option value="Contacted" <?php if ($row['status'] == 'Contacted') echo 'selected'; ?>>Contacted</option>
                                            <option value="Qualified" <?php if ($row['status'] == 'Qualified') echo 'selected'; ?>>Qualified</option>
                                            <option value="Lost" <?php if ($row['status'] == 'Lost') echo 'selected'; ?>>Lost</option>
                                            <option value="Converted" <?php if ($row['status'] == 'Converted') echo 'selected'; ?>>Converted</option>
                                        </select>
                                        <button type="button" class="btn btn-primary btn-sm mt-2 update-status-btn w-100">Update</button>
                                    </form>
                                </td>

                                <td>
                                    <form class="delete-lead-form" style="display: inline;">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <button type="button" class="btn btn-danger btn-sm delete-lead-btn">Delete</button>
                                    </form>
                                </td>

                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    $(document).ready(function() {
                        // Handle update status
                        $('.update-status-btn').click(function() {
                            var form = $(this).closest('.update-status-form');
                            var id = form.find('input[name="id"]').val();
                            var status = form.find('select[name="status"]').val();

                            $.ajax({
                                url: 'ajax_leads.php',
                                type: 'POST',
                                data: {
                                    action: 'update_status',
                                    id: id,
                                    status: status
                                },
                                success: function(response) {
                                    var result = JSON.parse(response);
                                    if (result.success) {
                                        // alert('Lead status updated successfully.');
                                    } else {
                                        alert('Failed to update lead status.');
                                    }
                                }
                            });
                        });

                        // Handle delete lead
                        $('.delete-lead-btn').click(function() {
                            if (confirm('Are you sure you want to delete this lead?')) {
                                var form = $(this).closest('.delete-lead-form');
                                var id = form.find('input[name="id"]').val();

                                $.ajax({
                                    url: 'ajax_leads.php',
                                    type: 'POST',
                                    data: {
                                        action: 'delete',
                                        id: id
                                    },
                                    success: function(response) {
                                        var result = JSON.parse(response);
                                        if (result.success) {
                                            // alert('Lead deleted successfully.');
                                            form.closest('tr').remove(); // Remove the row from the table
                                        } else {
                                            alert('Failed to delete lead.');
                                        }
                                    }
                                });
                            }
                        });
                    });
                </script>


                <!-- Pagination Controls -->
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>


            </div>
            <!-- End of Page Content -->

        </div>
        <!-- End of Main Content -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<?php include("includes/footer.php"); ?>