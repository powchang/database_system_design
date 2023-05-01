<!-- <?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?> -->

<?php
// Include the database connection file
  $servername = "localhost";
  $username = "u96kbujupxtov";
  $password = "cujxib-6nurfY-zetcib";
  $dbname = "dbw3ghaodzjq1g";

  $conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if the loan_id is set
if (isset($_GET['loan_id'])) {
    $loan_id = $_GET['loan_id'];

    // Check if there are unpaid penalties for the loan
    $sql = "SELECT COUNT(*) as penalty_count FROM penalties WHERE loan_id = ? AND paid = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $loan_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $penalty_count = $result->fetch_assoc()['penalty_count'];

    if ($penalty_count > 0) {
        echo "This loan has outstanding unpaid penalties. Please resolve the penalties before deleting the loan.";
        echo "<br>";
        echo "<a href='loans.php'>Back to Loans</a>";
    } else {
        // Delete the loan from the database
        $sql = "DELETE FROM loans WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $loan_id);
        $stmt->execute();

        // Redirect back to the loans page
       
        ob_start(); // Start output buffering
        // Redirect back to the loans page if the loan ID is not set
        header("Location: loans.php");
        ob_end_flush(); // Flush output buffer
        exit;
    }
} else {
    ob_start(); // Start output buffering
    // Redirect back to the loans page if the loan ID is not set
    header("Location: loans.php");
    ob_end_flush(); // Flush output buffer
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Loan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <?php if (isset($warning)): ?>
            <div class="alert alert-danger mt-3" role="alert">
                <?php echo $warning; ?>
            </div>
            <a href="loans.php?<?php echo time(); ?>" class="btn btn-secondary">Go back to loans page</a>

        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
