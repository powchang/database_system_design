<?php
// Include the database connection file
  $servername = "localhost";
  $username = "u96kbujupxtov";
  $password = "cujxib-6nurfY-zetcib";
  $dbname = "dbw3ghaodzjq1g";

  $conn = mysqli_connect($servername, $username, $password, $dbname);


// Check if the form was submitted and the loan ID is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['loan_id'])) {
    $loan_id = $_GET['loan_id'];

    // Get the submitted form data
    $member_id = $_POST['member_id'];
    $book_id = $_POST['book_id'];
    $issue_date = $_POST['issue_date'];
    $due_date = $_POST['due_date'];
    $return_date = $_POST['return_date'];

    // Update the loan in the database
    $sql = "UPDATE loans SET member_id = ?, book_id = ?, issue_date = ?, due_date = ?, return_date = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissss", $member_id, $book_id, $issue_date, $due_date, $return_date, $loan_id);
    if ($stmt->execute()) {
        $message = "Loan updated successfully.<br>";
        echo $message .= "<a href='loans.php?ts=" . time() . "' class='btn btn-secondary'>Go back to loans page</a>";
    } else {
        echo $message = "Error: " . $query . "<br>" . $conn->error;
    }
}

// Retrieve the loan data from the database
if (isset($_GET['loan_id'])) {
    $loan_id = $_GET['loan_id'];
    $sql = "SELECT * FROM loans WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $loan_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $loan = $result->fetch_assoc();
} else {
    
    // Redirect back to the loans page if the loan ID is not set
    header("Location: loans.php");
    exit;
}

?>


<!-- The rest of the HTML code for edit_loan.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Loan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Edit Loan</h1>
        <form action="edit_loan.php?loan_id=<?php echo $loan_id; ?>" method="post">
            <div class="mb-3">
                <label for="member_id" class="form-label">Member ID:</label>
                <input type="number" class="form-control" id="member_id" name="member_id" value="<?php echo $loan['member_id']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="book_id" class="form-label">Book ID:</label>
                <input type="number" class="form-control" id="book_id" name="book_id" value="<?php echo $loan['book_id']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="issue_date" class="form-label">Issue Date:</label>
                <input type="date" class="form-control" id="issue_date" name="issue_date" value="<?php echo $loan['issue_date']; ?>" required>
            </div>
            <div class="mb-3">
            <label for="due_date" class="form-label">Due Date:</label>
            <input type="date" class="form-control" id="due_date" name="due_date" value="<?php echo $loan['due_date']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="return_date" class="form-label">Return Date:</label>
                <input type="date" class="form-control" id="return_date" name="return_date" value="<?php echo $loan['return_date']; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update Loan</button>
            <button type="button" class="btn btn-primary" onclick="window.location.href='loans.php';">Cancel</button>

    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>

</body>
</html>
