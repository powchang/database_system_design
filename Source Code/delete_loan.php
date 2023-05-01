<?php
$servername = "localhost";
$username = "u96kbujupxtov";
$password = "cujxib-6nurfY-zetcib";
$dbname = "dbw3ghaodzjq1g";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$loan_id = $_GET['loan_id'];

if (isset($_POST['confirm'])) {
    // Check if there are unpaid penalties for the loan
    $sql = "SELECT COUNT(*) as penalty_count FROM penalties WHERE loan_id = ? AND paid = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $loan_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $penalty_count = $result->fetch_assoc()['penalty_count'];

    if ($penalty_count > 0) {
        $warning = "This loan has outstanding unpaid penalties. Please resolve the penalties before deleting the loan.";
    } else {
        $sql = "DELETE FROM loans WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $loan_id);
        $stmt->execute();

        echo "Loan deleted successfully. ";
        echo '<a href="loans.php?ts=' . time() . '">Go back to Loans page</a>';
        exit;
    }
} else {
    $sql = "SELECT * FROM loans WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $loan_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $member_id = $row["member_id"];
        $book_id = $row["book_id"];
        $issue_date = $row["issue_date"];
        $due_date = $row["due_date"];
        $return_date = $row["return_date"];
    } else {
        echo "Loan not found.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Loan</title>
</head>
<body>
    <h2>Delete Loan Confirmation</h2>
    <?php if (isset($warning)): ?>
        <div><?php echo $warning; ?></div>
        <a href="loans.php?ts=<?php echo time(); ?>">Go back to Loans page</a>
    <?php else: ?>
        <form method="post">
            <p>Are you sure you want to delete this loan?</p>
            <p><strong>Member ID:</strong> <?php echo $member_id; ?></p>
            <p><strong>Book ID:</strong> <?php echo $book_id; ?></p>
            <p><strong>Issue Date:</strong> <?php echo $issue_date; ?></p>
            <p><strong>Due Date:</strong> <?php echo $due_date; ?></p>
            <p><strong>Return Date:</strong> <?php echo $return_date; ?></p>
            <input type="submit" name="confirm" value="Confirm">
            <a href="loans.php?ts=<?php echo time(); ?>">Cancel</a>
        </form>
    <?php endif; ?>
</body>
</html>
