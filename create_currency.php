<?php
include './database/connection.php';

// Initialize variables
$currency_code = $currency_name = $short_name = $symbol = "";
$update = false;
$id = 0;

// Create or Update a currency
if (isset($_POST['save'])) {
    $currency_code = $_POST['currency_code'];
    $currency_name = $_POST['currency_name'];
    $short_name = $_POST['short_name'];
    $symbol = $_POST['symbol'];
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($id == 0) {
        // Insert new currency
        $sql = "INSERT INTO currency_table (currency_code, currency_name, short_name, symbol) 
                VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $currency_code, $currency_name, $short_name, $symbol);
    } else {
        // Update existing currency
        $sql = "UPDATE currency_table SET currency_code=?, currency_name=?, short_name=?, symbol=? 
                WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $currency_code, $currency_name, $short_name, $symbol, $id);
    }

    if ($stmt->execute()) {
        header('Location: create_currency');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Edit a currency
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $update = true;
    $stmt = $conn->prepare("SELECT * FROM currency_table WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currency_code = htmlspecialchars($row['currency_code']);
        $currency_name = htmlspecialchars($row['currency_name']);
        $short_name = htmlspecialchars($row['short_name']);
        $symbol = htmlspecialchars($row['symbol']);
    }
}

// Delete a currency
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM currency_table WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header('Location: create_currency');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currency Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2 class="text-center mt-4">Currency Management</h2>

        <!-- Form to Create/Update a Currency -->
        <form action="" method="POST" class="mt-4">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <div class="form-group">
                <label for="currency_code">Currency Code:</label>
                <input type="text" name="currency_code" class="form-control" value="<?php echo htmlspecialchars($currency_code); ?>"  required>
            </div>
            <div class="form-group">
                <label for="currency_name">Currency Name:</label>
                <input type="text" name="currency_name" class="form-control" value="<?php echo htmlspecialchars($currency_name); ?>" required>
            </div>
            <div class="form-group">
                <label for="short_name">Short Name:</label>
                <input type="text" name="short_name" class="form-control" value="<?php echo htmlspecialchars($short_name); ?>" required>
            </div>
            <div class="form-group">
                <label for="symbol">Symbol:</label>
                <input type="text" name="symbol" class="form-control" value="<?php echo htmlspecialchars($symbol); ?>" required>
            </div>
            <div class="form-group">
                <?php if ($update == true): ?>
                    <button type="submit" name="save" class="btn btn-info">Update Currency</button>
                <?php else: ?>
                    <button type="submit" name="save" class="btn btn-primary">Add Currency</button>
                <?php endif; ?>
            </div>
        </form>

        <!-- Display Currency Records -->
        <h3 class="mt-4">Currency List</h3>
        <table class="table table-bordered table-striped mt-2">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Currency Code</th>
                    <th>Currency Name</th>
                    <th>Short Name</th>
                    <th>Symbol</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $conn->prepare("SELECT * FROM currency_table");
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['currency_code']); ?></td>
                        <td><?php echo htmlspecialchars($row['currency_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['short_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['symbol']); ?></td>
                        <td>
                            <a href="?edit=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-info">Edit</a>
                            <a href="?delete=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this currency?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>

<?php
$conn->close();
?>
