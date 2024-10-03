<?php
include("database/connection.php");
include("includes/header.php");


// Initialize variables
$status_code = $status_name = "";
$update = false;
$id = 0;

// Create or Update a status
if (isset($_POST['save'])) {

    $status_name = $_POST['status_name'];
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($id == 0) {
        // Insert new status
        $sql = "INSERT INTO status_table (status_name) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $status_name);
    } else {
        // Update existing status
        $sql = "UPDATE status_table SET  status_name=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si",  $status_name, $id);
    }

    if ($stmt->execute()) {
        header('Location: create_status');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Edit a status
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $update = true;
    $stmt = $conn->prepare("SELECT * FROM status_table WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $status_name = htmlspecialchars($row['status_name']);
    }
}

// Delete a status
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM status_table WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header('Location: create_status');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

?>



<!-- Page Wrapper -->
<div id="wrapper">
    <!-- Sidebar -->
    <?php include("nav.php"); ?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Topbar -->
            <?php include("includes/topnav.php"); ?>
            <!-- Begin Page Content -->

            <!-- ----------------------------------------------------------  -->
            <!-- ----------------------------------------------------------  -->

            <div class="p-3">
                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h4 class="h4 mb-0 text-gray-800">Status Managment</h4>
                </div>

                <!-- add form // create forms -->

                <div class="row mb-5">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header d-flex align-items-center" style="height: 60px;">
                                <span class="bg-dark text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                    <i class="fas fa-plus-circle"></i>
                                </span> &nbsp;&nbsp;&nbsp;&nbsp;
                                <h6 class="mb-0 me-2">Add Status</h6>
                            </div>
                            <div class="card-body">
                                <form action="" method="post" class="mb-3">

                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="status_name">Status Name:</label>
                                            </div>
                                            <div class="col">
                                                <input type="text" name="status_name" class="form-control" value="<?php echo htmlspecialchars($status_name); ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <!-- buttons  -->
                                        <?php if ($update == true): ?>
                                            <button type="submit" name="save" class="btn btn-info">Update Status</button>
                                        <?php else: ?>
                                            <button type="submit" name="save" class="btn btn-primary">Add Status</button>
                                        <?php endif; ?>

                                    </div>
                                </form>


                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ----------------------------------------------------------  -->
            <!-- ----------------------------------------------------------  -->
            <div class="container-fluid">
                <div class="card shadow mb-4" style="font-size: 13px;">
                    <div class="card-header d-flex align-items-center" style="height: 60px;">
                        <span class="bg-dark text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                            <i class="fas fa-list"></i>
                        </span> &nbsp;&nbsp;&nbsp;&nbsp;
                        <h6 class="mb-0">Current Status</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Status Name</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Fetch all statuses from the status_table
                                    $stmt = $conn->prepare("SELECT * FROM status_table");
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    // Loop through the results and display in the table
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<td>' . htmlspecialchars($row['status_name']) . '</td>';
                                        echo '<td>';
                                        echo '<a href="?edit=' . htmlspecialchars($row['id']) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a> &nbsp;';
                                        echo '<a href="?delete=' . htmlspecialchars($row['id']) . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this status?\')"><i class="fas fa-trash-alt"></i></a>';
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
    </div>
    <!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->


<!-- Page level plugins -->
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

<link rel="stylesheet" href="./vendor/datatables/dataTables.bootstrap4.min.css">
<!-- Page level custom scripts -->
<script src="js/demo/datatables-demo.js"></script>


<!-- ------------------ new concoet css js  -->
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css"> -->


</body>

</html>