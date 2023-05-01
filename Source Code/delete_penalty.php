<?php
$servername = "localhost";
$username = "u96kbujupxtov";
$password = "cujxib-6nurfY-zetcib";
$dbname = "dbw3ghaodzjq1g";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$penalty_id = $_GET['penalty_id'];

if (isset($_POST['confirm'])) {
    $sql = "DELETE FROM penalties WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $penalty_id);
    $stmt->execute();

    echo "Penalty deleted successfully. ";
    echo '<a href="penalties.php?ts=' . time() . '">Go back to Penalties page</a>';
    exit;
} else {
    $sql = "SELECT * FROM penalties WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $penalty_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $loan_id = $row["loan_id"];
        $penalty_amount = $row["penalty_amount"];
        $paid = $row["paid"];
    } else {
        echo "Penalty not found.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Penalty</title>
</head>
<body>
    <h2>Delete Penalty Confirmation</h2>
    <form method="post">
        <p>Are you sure you want to delete this penalty?</p>
        <p><strong>Loan ID:</strong> <?php echo $loan_id; ?></p>
        <p><strong>Penalty Amount:</strong> <?php echo $penalty_amount; ?></p>
        <p><strong>Paid:</strong> <?php echo $paid == 1 ? 'Yes' : 'No'; ?></p>
        <input type="submit" name="confirm" value="Confirm">
        <a href="penalties.php?ts=<?php echo time(); ?>">Cancel</a>
    </form>
</body>
</html>
