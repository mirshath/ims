<?php
include("database/connection.php");
include("includes/header.php");


// Initialize variables
$batch_name = $university = $programme = $year_batch_code = $intake_date = $end_date = "";
$update = false;
$id = 0;


// Fetch universities for the dropdown
$universities_result = mysqli_query($conn, "SELECT * FROM universities");
$universities = [];
while ($row = mysqli_fetch_assoc($universities_result)) {
    $universities[] = $row;
}

// Fetch programs for dropdown
$sql = "SELECT * FROM program_table";
$result = mysqli_query($conn, $sql);
$programsOptions = [];
while ($row = mysqli_fetch_assoc($result)) {
    $programsOptions[] = $row;
}


// Create or Update a batch
if (isset($_POST['save'])) {
    $batch_name = $_POST['batch_name'];
    $university = $_POST['university'];
    $programme = $_POST['programme'];
    $year_batch_code = $_POST['year_batch_code'];
    $intake_date = $_POST['intake_date'];
    $end_date = $_POST['end_date'];
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($id == 0) {
        // Insert new batch
        $sql = "INSERT INTO batch_table (batch_name, university, programme, year_batch_code, intake_date, end_date) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $batch_name, $university, $programme, $year_batch_code, $intake_date, $end_date);
    } else {
        // Update existing batch
        $sql = "UPDATE batch_table SET batch_name=?, university=?, programme=?, year_batch_code=?, intake_date=?, end_date=? 
                WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $batch_name, $university, $programme, $year_batch_code, $intake_date, $end_date, $id);
    }

    if ($stmt->execute()) {
        // header('Location: create_batch');
        echo '<script>window.location.href = "create_batch";</script>';
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Edit a batch
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $update = true;
    $stmt = $conn->prepare("SELECT * FROM batch_table WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $batch_name = htmlspecialchars($row['batch_name']);
        $university = htmlspecialchars($row['university']);
        $programme = htmlspecialchars($row['programme']);
        $year_batch_code = htmlspecialchars($row['year_batch_code']);
        $intake_date = htmlspecialchars($row['intake_date']);
        $end_date = htmlspecialchars($row['end_date']);
    }
}

// Delete a batch
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM batch_table WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        // header('Location: create_batch');
        echo '<script>window.location.href = "create_batch";</script>';

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
                    <h4 class="h4 mb-0 text-gray-800">Batches Managment</h4>
                </div>


                <!-- add form // create forms -->

                <div class="row mb-5">
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header d-flex align-items-center" style="height: 60px;">
                                <span class="bg-dark text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                    <i class="fas fa-plus-circle"></i>
                                </span> &nbsp;&nbsp;&nbsp;&nbsp;
                                <h6 class="mb-0 me-2">Add Batches</h6>
                            </div>

                            <div class="card-body">
                                <form action="" method="post" class="mb-3">

                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3"> <label for="batch_name">Batch Name:</label></div>
                                            <div class="col">
                                                <input type="text" name="batch_name" class="form-control" value="<?php echo htmlspecialchars($batch_name); ?>" placeholder="Batch Name" required>
                                            </div>
                                        </div>

                                    </div>


                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3"> <label for="university">University:</label></div>
                                            <div class="col">
                                                <select class="form-control select2" id="university" name="university" required>
                                                    <option value="">Select University</option>
                                                    <?php foreach ($universities as $uni): ?>
                                                        <option value="<?php echo htmlspecialchars($uni['id']); ?>" <?php echo $uni['id'] == $university ? 'selected' : ''; ?>>
                                                            <?php echo htmlspecialchars($uni['university_name']); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3"> <label for="programme">Programme:</label></div>
                                            <div class="col">
                                                <select class="form-control" id="programme" name="programme" required>
                                                    <option value="">Select Programme</option>
                                                    <!-- Programs will be dynamically loaded here -->
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

                                    <script>
                                        $(document).ready(function() {

                                            var selectedProgramme = '<?php echo $programme; ?>';

                                            $('#university').on('change', function() {
                                                var universityID = $(this).val();
                                                if (universityID) {
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: 'get_programs.php',
                                                        data: {
                                                            university_id: universityID
                                                        },
                                                        dataType: 'json',
                                                        success: function(data) {
                                                            $('#programme').html('<option value="">Select Programme</option>');
                                                            $.each(data, function(key, value) {
                                                                var isSelected = value.program_code == selectedProgramme ? 'selected' : '';
                                                                $('#programme').append('<option value="' + value.program_code + '" ' + isSelected + '>' + value.program_name + '</option>');
                                                            });

                                                        }
                                                    });
                                                } else {
                                                    $('#programme').html('<option value="">Select Programme</option>');
                                                }
                                            });

                                            // Trigger change event to load programs if university is already selected (for edit mode)
                                            <?php if ($update && !empty($university)): ?>
                                                $('#university').trigger('change');
                                            <?php endif; ?>
                                        });
                                    </script>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3"> <label for="year_batch_code">Year Batch Code:</label></div>
                                            <div class="col">
                                                <input type="text" name="year_batch_code" class="form-control" placeholder="Year Batch Code" value="<?php echo htmlspecialchars($year_batch_code); ?>" required>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3"> <label for="intake_date">Intake Date:</label></div>
                                            <div class="col">
                                                <input type="date" name="intake_date" class="form-control" value="<?php echo htmlspecialchars($intake_date); ?>" required>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3"> <label for="end_date">End Date:</label></div>
                                            <div class="col">
                                                <input type="date" name="end_date" class="form-control" value="<?php echo htmlspecialchars($end_date); ?>" required>
                                            </div>
                                        </div>

                                    </div>


                                    <div class="text-right">
                                        <!-- buttons  -->
                                        <?php if ($update == true): ?>
                                            <button type="submit" name="save" class="btn btn-info">Update Batch</button>
                                        <?php else: ?>
                                            <button type="submit" name="save" class="btn btn-primary">Add Batch</button>
                                        <?php endif; ?>

                                    </div>
                                </form>
                                
                                
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">

                        <ul style="font-size: 12px;">
                            <li>MBA IHM - MBA IHM ()</li>
                            <li>Qualifi Health And Social Care - QLHS BG()</li>
                            <li>Foundation and Diploma in Project Management - IIPM BG()</li>
                            <li>Business Psychology - BP BG()</li>
                            <li>MBA - General - MBAG BG()</li>
                        </ul>
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
                        <h6 class="mb-0">Current Batches</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Batch Name</th>
                                        <th>University</th>
                                        <th>Programme</th>
                                        <th>Year & Batch</th>
                                        <th>Intake Date</th>
                                        <th>End Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Fetch all batches from the batch_table
                                    $stmt = $conn->prepare("SELECT * FROM batch_table");
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    while ($row = $result->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<td>' . htmlspecialchars($row['batch_name']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['university']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['programme']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['year_batch_code']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['intake_date']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['end_date']) . '</td>';
                                        echo '<td>';
                                        echo '<a href="?edit=' . htmlspecialchars($row['id']) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a> &nbsp;';
                                        echo '<a href="?delete=' . htmlspecialchars($row['id']) . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this batch?\')"> <i class="fas fa-trash-alt"></i></a>';
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