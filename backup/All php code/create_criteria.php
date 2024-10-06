<?php
include("database/connection.php");
include("includes/header.php");

// Pagination settings
$results_per_page = 10; // Number of results per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$start = ($page - 1) * $results_per_page;

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_criteria'])) {
        // Add new criteria
        $criteria_code = $_POST['criteria_code'];
        $criteria_name = $_POST['criteria_name'];
        $sql = "INSERT INTO criterias (criteria_code, criteria_name) VALUES ('$criteria_code', '$criteria_name')";
        $conn->query($sql);
    } elseif (isset($_POST['update_criteria'])) {
        // Update criteria
        $id = $_POST['id'];
        $criteria_code = $_POST['criteria_code'];
        $criteria_name = $_POST['criteria_name'];
        $sql = "UPDATE criterias SET criteria_code='$criteria_code', criteria_name='$criteria_name' WHERE id=$id";
        $conn->query($sql);
    } elseif (isset($_POST['delete_criteria'])) {
        // Delete criteria
        $id = $_POST['id'];
        $sql = "DELETE FROM criterias WHERE id=$id";
        $conn->query($sql);
    }
}

// Fetch criteria for the current page
$sql = "SELECT * FROM criterias LIMIT $start, $results_per_page";
$result = $conn->query($sql);

// Fetch total number of criteria for pagination controls
$sql_total = "SELECT COUNT(*) as total FROM criterias";
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
                    <h4 class="h4 mb-0 text-gray-800">Criteria Management</h4>
                </div>



                <!-- ------------------------------------------------------------------------------  -->

                <div class="row mb-5">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header d-flex align-items-center" style="height: 60px;">
                                <span class="bg-dark text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                    <i class="fas fa-plus-circle"></i>
                                </span> &nbsp;&nbsp;&nbsp;&nbsp;
                                <h6 class="mb-0 me-2">Add Criteria</h6>
                            </div>

                            <div class="card-body">
                                <form action="" method="post" class="mb-3">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="criteria_code">Criteria Code</label>
                                                    </div>
                                                    <div class="col">
                                                        <input type="text" class="form-control" id="criteria_code" name="criteria_code" placeholder="Criteria Code" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="criteria_name">Criteria Name</label>
                                                    </div>
                                                    <div class="col">
                                                        <input type="text" class="form-control" id="criteria_name" name="criteria_name" placeholder="Criteria Name" required>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <button type="submit" name="add_criteria" class="btn btn-primary">Add Criterias</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- ------------------------------------------------------------------------------  -->




                <div class="card">
                    <div class="card-header d-flex align-items-center" style="height: 60px;"> <!-- Added d-flex and align-items-center -->
                        <span class="bg-dark text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                            <i class="fas fa-list"></i>
                        </span> &nbsp;&nbsp;&nbsp;&nbsp;
                        <h6 class="mb-0">Current Criterias</h6>
                    </div>

                    <div class="card-body">

                        <!-- Criteria Table -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Criteria Code</th>
                                    <th>Criteria Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <form action="" method="post">
                                            <td>
                                                <input type="text" name="criteria_code" value="<?php echo htmlspecialchars($row['criteria_code']); ?>" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="criteria_name" value="<?php echo htmlspecialchars($row['criteria_name']); ?>" class="form-control">
                                            </td>
                                            <td>
                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" name="update_criteria" class="btn btn-info btn-sm">Update</button>
                                                <button type="submit" name="delete_criteria" class="btn btn-danger btn-sm">Delete</button>
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









                <!-- ------------------------------------------------------------------------------  -->
                <!-- ------------------------------------------------------------------------------  -->



            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

<?php $conn->close(); ?>