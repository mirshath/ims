<?php
include("database/connection.php");
include("includes/header.php");

// Pagination settings
$results_per_page = 10; // Number of results per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$start = ($page - 1) * $results_per_page;

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_university'])) {
        // Add new university
        $university_code = $_POST['university_code'];
        $university_name = $_POST['university_name'];
        $address = $_POST['address'];
        $uni_code = $_POST['uni_code'];
        $sql = "INSERT INTO universities (university_code, university_name, address, uni_code) VALUES ('$university_code', '$university_name', '$address', '$uni_code')";
        $conn->query($sql);
    } elseif (isset($_POST['update_university'])) {
        // Update university
        $id = $_POST['id'];
        $university_code = $_POST['university_code'];
        $university_name = $_POST['university_name'];
        $address = $_POST['address'];
        $uni_code = $_POST['uni_code'];
        $sql = "UPDATE universities SET university_code='$university_code', university_name='$university_name', address='$address', uni_code='$uni_code' WHERE id=$id";
        $conn->query($sql);
    } elseif (isset($_POST['delete_university'])) {
        // Delete university
        $id = $_POST['id'];
        $sql = "DELETE FROM universities WHERE id=$id";
        $conn->query($sql);
    }
}

// Fetch universities for the current page
$sql = "SELECT * FROM universities LIMIT $start, $results_per_page";
$result = $conn->query($sql);

// Fetch total number of universities for pagination controls
$sql_total = "SELECT COUNT(*) as total FROM universities";
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
                    <h4 class="h4 mb-0 text-gray-800">University Management</h4>
                </div>

                <!-- Add University Form -->
                <!-- <form action="" method="post" class="mb-3">
                    <div class="form-group">
                        <label for="university_code">University Code</label>
                        <input type="text" class="form-control" id="university_code" name="university_code" required>
                    </div>
                    <div class="form-group">
                        <label for="university_name">University Name</label>
                        <input type="text" class="form-control" id="university_name" name="university_name" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="uni_code">Uni Code</label>
                        <input type="text" class="form-control" id="uni_code" name="uni_code">
                    </div>
                    <button type="submit" name="add_university" class="btn btn-primary">Add University</button>
                </form> -->




                <!-- -----------------------------------------------------------------------------------  -->
                <!-- -----------------------------------------------------------------------------------  -->

                <!-- add form // create forms -->
                <div class="row mb-5">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header d-flex align-items-center" style="height: 60px;">
                                <span class="bg-dark text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                    <i class="fas fa-plus-circle"></i>
                                </span> &nbsp;&nbsp;&nbsp;&nbsp;
                                <h6 class="mb-0 me-2">Add University</h6>
                            </div>

                            <div class="card-body">
                                <form action="" method="post" class="mb-3">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3"> <label for="university_code">University Code</label></div>
                                            <div class="col"> <input type="text" class="form-control" id="university_code" name="university_code" required></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3"> <label for="university_name">University Name</label></div>
                                            <div class="col"> <input type="text" class="form-control" id="university_name" name="university_name" required></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3"> <label for="address">Address</label></div>
                                            <div class="col"> <textarea class="form-control" id="address" name="address" rows="3"></textarea></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3"> <label for="uni_code">Uni Code</label></div>
                                            <div class="col"> <input type="text" class="form-control" id="uni_code" name="uni_code"></div>
                                        </div>
                                    </div>


                                    <div class="text-right">
                                        <button type="submit" name="add_university" class="btn btn-primary">Add University</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- -----------------------------------------------------------------------------------  -->
                <!-- -----------------------------------------------------------------------------------  -->






                <div class="card">
                    <div class="card-header d-flex align-items-center" style="height: 60px;"> <!-- Added d-flex and align-items-center -->
                        <span class="bg-dark text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                            <i class="fas fa-list"></i>
                        </span> &nbsp;&nbsp;&nbsp;&nbsp;
                        <h6 class="mb-0">Current Universities</h6>
                    </div>

                    <div class="card-body">

                        <!-- Leads Table -->

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>University Code</th>
                                    <th>University Name</th>
                                    <th>Address</th>
                                    <th>Uni Code</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <form action="" method="post" class="d-inline">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <td><input type="text" class="form-control" name="university_code" value="<?php echo htmlspecialchars($row['university_code']); ?>" required></td>
                                            <td><input type="text" class="form-control" name="university_name" value="<?php echo htmlspecialchars($row['university_name']); ?>" required></td>
                                            <td><textarea class="form-control" name="address" rows="3"><?php echo htmlspecialchars($row['address']); ?></textarea></td>
                                            <td><input type="text" class="form-control" name="uni_code" value="<?php echo htmlspecialchars($row['uni_code']); ?>"></td>
                                            <td>
                                                <button type="submit" name="update_university" class="btn btn-info btn-sm">Update</button>
                                                <button type="submit" name="delete_university" class="btn btn-danger btn-sm">Delete</button>
                                            </td>
                                        </form>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>


                        <!-- Pagination Controls -->
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
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

</body>

</html>

<?php $conn->close(); ?>