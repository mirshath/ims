<?php
include("database/connection.php");
include("includes/header.php");


// Initialize variables
$title = $lecturer_name = $hourly_rate = $qualification = "";
$programs = []; // Initialize programs as an array
$id = 0;
$update = false;

// Fetch programs for the dropdown
$sql = "SELECT * FROM program_table";
$result = mysqli_query($conn, $sql);
$programsOptions = [];
while ($row = mysqli_fetch_assoc($result)) {
    $programsOptions[] = $row;
}


// Handle form submission
if (isset($_POST['save'])) {
    $title = $_POST['title'];
    $lecturer_name = $_POST['lecturer_name'];
    $hourly_rate = $_POST['hourly_rate'];
    $qualification = $_POST['qualification'];
    $programs = isset($_POST['programs']) ? implode(',', $_POST['programs']) : '';

    $sql = "INSERT INTO lecturer_table (title, lecturer_name, hourly_rate, qualification, programs) VALUES ('$title', '$lecturer_name', '$hourly_rate', '$qualification', '$programs')";
    if ($conn->query($sql) === TRUE) {
        echo '<script> window.location.href = "create_lecturer";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle record update
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $result = $conn->query("SELECT * FROM lecturer_table WHERE id=$id");
    $row = $result->fetch_assoc();
    $title = $row['title'];
    $lecturer_name = $row['lecturer_name'];
    $hourly_rate = $row['hourly_rate'];
    $qualification = $row['qualification'];
    $programs = explode(',', $row['programs']); // Convert string to array
}

// Handle form update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $lecturer_name = $_POST['lecturer_name'];
    $hourly_rate = $_POST['hourly_rate'];
    $qualification = $_POST['qualification'];
    $programs = isset($_POST['programs']) ? implode(',', $_POST['programs']) : '';

    $sql = "UPDATE lecturer_table SET title='$title', lecturer_name='$lecturer_name', hourly_rate='$hourly_rate', qualification='$qualification', programs='$programs' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo '<script> window.location.href = "create_lecturer";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle record deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM lecturer_table WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo '<script> window.location.href = "create_lecturer";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch all records
$result = $conn->query("SELECT * FROM lecturer_table");

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
                    <h4 class="h4 mb-0 text-gray-800">Lecture Managment</h4>
                </div>


                <!-- add form // create forms -->

                <div class="row mb-5">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header d-flex align-items-center" style="height: 60px;">
                                <span class="bg-dark text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                    <i class="fas fa-plus-circle"></i>
                                </span> &nbsp;&nbsp;&nbsp;&nbsp;
                                <h6 class="mb-0 me-2">Add Lecturer</h6>
                            </div>

                            <div class="card-body">
                                <form action="" method="post" class="mb-3">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3"> <label for="title">Title:</label></div>
                                            <div class="col">
                                                <select class="form-control" id="title" name="title" required>
                                                    <option value="Mr" <?php echo $title == 'Mr' ? 'selected' : ''; ?>>Mr</option>
                                                    <option value="Mrs" <?php echo $title == 'Mrs' ? 'selected' : ''; ?>>Mrs</option>
                                                    <option value="Ms" <?php echo $title == 'Ms' ? 'selected' : ''; ?>>Ms</option>
                                                    <option value="Dr" <?php echo $title == 'Dr' ? 'selected' : ''; ?>>Dr</option>
                                                    <option value="Prof" <?php echo $title == 'Prof' ? 'selected' : ''; ?>>Prof</option>
                                                </select>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3"> <label for="lecturer_name">Lecturer Name:</label></div>
                                            <div class="col">
                                                <input type="text" class="form-control" id="lecturer_name" name="lecturer_name" placeholder="Lecturer Name" value="<?php echo htmlspecialchars($lecturer_name); ?>" required>
                                            </div>
                                        </div>



                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3"> <label for="hourly_rate">Hourly Rate:</label></div>
                                            <div class="col">
                                                <input type="number" step="0.01" class="form-control" placeholder="Hourly Rate" id="hourly_rate" name="hourly_rate" value="<?php echo htmlspecialchars($hourly_rate); ?>">
                                            </div>
                                        </div>



                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3"> <label for="qualification">Qualification:</label></div>
                                            <div class="col"><textarea class="form-control" id="qualification" name="qualification" placeholder="Qualifications" rows="3" required><?php echo htmlspecialchars($qualification); ?></textarea></div>
                                        </div>



                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3"> <label>Programs</label></div>
                                            <div class="col">
                                                <?php foreach ($programsOptions as $program): ?>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="programs[]" value="<?php echo htmlspecialchars($program['program_name']); ?>"
                                                            <?php echo in_array($program['program_name'], $programs) ? 'checked' : ''; ?>>
                                                        <label class="form-check-label"><?php echo htmlspecialchars($program['program_name']); ?></label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>



                                    </div>

                                    <div class="text-right">
                                        <?php if ($update): ?>
                                            <button type="submit" class="btn btn-primary" name="update">Update</button>
                                        <?php else: ?>
                                            <button type="submit" class="btn btn-primary" name="save">Save</button>
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
                        <h6 class="mb-0">Current Lecturers</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <!-- <th>ID</th> -->
                                        <th>Title</th>
                                        <th>Lecturer Name</th>
                                        <th>Qualification</th>
                                        <th>Programs</th>
                                        <th>Hourly Rate</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Fetch all lecturers to display in the table
                                    $lecturers_result = mysqli_query($conn, "SELECT * FROM lecturer_table"); // Update the table name as needed
                                    while ($row = mysqli_fetch_assoc($lecturers_result)) {
                                        echo '<tr>';
                                        echo '<td>' . htmlspecialchars($row['title']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['lecturer_name']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['qualification']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['programs']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['hourly_rate']) . '</td>';
                                        echo '<td>';
                                        echo '<a href="?edit=' . htmlspecialchars($row['id']) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a> &nbsp;';
                                        echo '<a href="?delete=' . htmlspecialchars($row['id']) . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-trash-alt"></i></a>';
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


</body>

</html>