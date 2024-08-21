<?php
include("database/connection.php");
include("includes/header.php");

// Initialize variables
$date = $type = $university = $programme = $intake = $first_name = $last_name = $contact = $email = $details = $status = "";
$update = false;
$id = 0;


// Fetch distinct 'type' values from leads_table
$sql_lead = "SELECT DISTINCT lead_type FROM leads_table";
$result_lead = $conn->query($sql_lead);



// Create or Update a lead
if (isset($_POST['save'])) {
    $date = $_POST['date'];
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
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($id == 0) {
        // Insert new lead
        $sql = "INSERT INTO leads (date, type, university, programme, intake, first_name, last_name, contact, email, details, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssss", $date, $type, $university, $programme, $intake, $first_name, $last_name, $contact, $email, $details, $status);
    } else {
        // Update existing lead
        $sql = "UPDATE leads SET date=?, type=?, university=?, programme=?, intake=?, first_name=?, last_name=?, contact=?, email=?, details=?, status=? 
                WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssssi", $date, $type, $university, $programme, $intake, $first_name, $last_name, $contact, $email, $details, $status, $id);
    }

    if ($stmt->execute()) {
        echo '<script>window.location.href = "addLeads.php";</script>';
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Edit a lead
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $update = true;
    $stmt = $conn->prepare("SELECT * FROM leads WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $date = htmlspecialchars($row['date']);
        $type = htmlspecialchars($row['type']);
        $university = htmlspecialchars($row['university']);
        $programme = htmlspecialchars($row['programme']);
        $intake = htmlspecialchars($row['intake']);
        $first_name = htmlspecialchars($row['first_name']);
        $last_name = htmlspecialchars($row['last_name']);
        $contact = htmlspecialchars($row['contact']);
        $email = htmlspecialchars($row['email']);
        $details = htmlspecialchars($row['details']);
        $status = htmlspecialchars($row['status']);
    }
}

// Delete a lead
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM leads WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo '<script>window.location.href = "addLeads.php";</script>';
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
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
                    <h4 class="h4 mb-0 text-gray-800">Lead Management</h4>
                </div>

                <!-- Add/Edit Lead Form -->
                <form action="addLeads.php" method="POST" class="mt-4">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

                    <!-- Form fields for lead details -->
                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input type="date" name="date" class="form-control" value="<?php echo htmlspecialchars($date); ?>" required>
                    </div>

                    <!-- ----------------------------------  -->


                    <div class="form-group">
                        <label for="type">Type:</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="" disabled>Select Type</option>
                            <?php
                            // Populate the dropdown with lead types
                            if ($result_lead->num_rows > 0) {
                                while ($row = $result_lead->fetch_assoc()) {
                                    $selected = ($row['lead_type'] === $type) ? 'selected' : '';
                                    echo '<option value="' . htmlspecialchars($row['lead_type']) . '" ' . $selected . '>' . htmlspecialchars($row['lead_type']) . '</option>';
                                }
                            } else {
                                echo '<option value="" disabled>No types available</option>';
                            }
                            ?>
                        </select>
                    </div>


                    <!-- -----------------------------------  -->
                    <div class="form-group">
                        <label for="university">University:</label>
                        <input type="text" name="university" class="form-control" value="<?php echo htmlspecialchars($university); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="programme">Programme:</label>
                        <input type="text" name="programme" class="form-control" value="<?php echo htmlspecialchars($programme); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="intake">Intake Date:</label>
                        <input type="date" name="intake" class="form-control" value="<?php echo htmlspecialchars($intake); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="first_name">First Name:</label>
                        <input type="text" name="first_name" class="form-control" value="<?php echo htmlspecialchars($first_name); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name:</label>
                        <input type="text" name="last_name" class="form-control" value="<?php echo htmlspecialchars($last_name); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="contact">Contact:</label>
                        <input type="text" name="contact" class="form-control" value="<?php echo htmlspecialchars($contact); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="details">Details:</label>
                        <textarea name="details" class="form-control"><?php echo htmlspecialchars($details); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <input type="text" name="status" class="form-control" value="<?php echo htmlspecialchars($status); ?>" required>
                    </div>

                    <div class="form-group">
                        <?php if ($update == true): ?>
                            <button type="submit" name="save" class="btn btn-info">Update Lead</button>
                        <?php else: ?>
                            <button type="submit" name="save" class="btn btn-primary">Add Lead</button>
                        <?php endif; ?>
                    </div>
                </form>

                <!-- Lead List Table -->
                <h3 class="mt-4">Lead List</h3>
                <table class="table table-bordered table-striped mt-2">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>University</th>
                            <th>Programme</th>
                            <th>Intake Date</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Details</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM leads");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['date']); ?></td>
                                <td><?php echo htmlspecialchars($row['type']); ?></td>
                                <td><?php echo htmlspecialchars($row['university']); ?></td>
                                <td><?php echo htmlspecialchars($row['programme']); ?></td>
                                <td><?php echo htmlspecialchars($row['intake']); ?></td>
                                <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['contact']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['details']); ?></td>
                                <td><?php echo htmlspecialchars($row['status']); ?></td>
                                <td>
                                    <a href="addLeads.php?edit=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="addLeads.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this lead?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Wrapper -->

    <?php include("includes/footer.php"); ?>

</div>
<!-- End of Page Wrapper -->

<!-- Bootstrap core JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>