<?php
// Include the database connection file
$servername = "localhost";
$username = "u96kbujupxtov";
$password = "cujxib-6nurfY-zetcib";
$dbname = "dbw3ghaodzjq1g";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if the form was submitted and the penalty ID is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['penalty_id'])) {
    $penalty_id = $_GET['penalty_id'];

    // Get the submitted form data
    $loan_id = $_POST['loan_id'];
    $penalty_amount = $_POST['penalty_amount'];
    $paid = $_POST['paid'];

    // Update the penalty in the database
    $sql = "UPDATE penalties SET loan_id = ?, penalty_amount = ?, paid = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("idis", $loan_id, $penalty_amount, $paid, $penalty_id);
    if ($stmt->execute()) {
        $message = "Penalty updated successfully.<br>";
        echo $message .= "<a href='penalties.php?ts=" . time() . "' class='btn btn-secondary'>Go back to penalties page</a>";
    } else {
        echo $message = "Error: " . $query . "<br>" . $conn->error;
    }
}

// Retrieve the penalty data from the database
if (isset($_GET['penalty_id'])) {
    $penalty_id = $_GET['penalty_id'];
    $sql = "SELECT * FROM penalties WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $penalty_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $penalty = $result->fetch_assoc();
} else {
    // Redirect back to the penalties page if the penalty ID is not set
    header("Location: penalties.php");
    exit;
}

// Fetch all the loans from the database
$sql_loans = "SELECT * FROM loans";
$result_loans = mysqli_query($conn, $sql_loans);

// Close the connection
mysqli_close($conn);
?>


<!-- The rest of the HTML code for edit_penalty.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Penalty</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Edit Penalty</h1>
        <form action="edit_penalty.php?penalty_id=<?php echo $penalty_id; ?>" method="post">
            <div class="mb-3">
                <label for="loan_id" class="form-label">Loan ID:</label>
                <select class="form-control" id="loan_id" name="loan_id">
                    <?php while ($loan = mysqli_fetch_assoc($result_loans)) : ?>
                        <?php if ($loan['id'] == $penalty['loan_id']) : ?>
                            <option value="<?php echo $loan['id']; ?>" selected><?php echo $loan['id']; ?></option>
                        <?php else : ?>
                            <option value="<?php echo $loan['id']; ?>"><?php echo $loan['id']; ?></option>
<?php endif; ?>
<?php endwhile; ?>
</select>
</div>
    <div class="form-group">
    <label for="penalty_amount">Penalty Amount:</label>
    <input type="text" class="form-control" id="penalty_amount" name="penalty_amount" value="<?php echo $penalty['penalty_amount']; ?>" required>
    </div>
    
    <div class="form-group">
    <label for="paid">Paid:</label>
    <select class="form-control" id="paid" name="paid">
    <option value="0" <?php if ($penalty['paid'] == 0) echo "selected"; ?>>No</option>
    <option value="1" <?php if ($penalty['paid'] == 1) echo "selected"; ?>>Yes</option>
    </select>
    </div>
    <button type="submit" class="btn btn-primary">Update Penalty</button>
    <a href="penalties.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
