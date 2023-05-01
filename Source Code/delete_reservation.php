<?php
$servername = "localhost";
$username = "u96kbujupxtov";
$password = "cujxib-6nurfY-zetcib";
$dbname = "dbw3ghaodzjq1g";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$reservation_id = $_GET['reservation_id'];

if (isset($_POST['confirm'])) {
    $sql = "DELETE FROM reservations WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $reservation_id);
    $stmt->execute();

    echo "Reservation deleted successfully. ";
    echo '<a href="reservations.php?ts=' . time() . '">Go back to Reservations page</a>';
    exit;
} else {
    $sql = "SELECT * FROM reservations WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $reservation_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $member_id = $row["member_id"];
        $book_id = $row["book_id"];
        $reserve_date = $row["reserve_date"];
    } else {
        echo "Reservation not found.";
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Reservation</title>
</head>
<body>
    <h2>Delete Reservation Confirmation</h2>
    <form method="post">
        <p>Are you sure you want to delete this reservation?</p>
        <p><strong>Member ID:</strong> <?php echo $member_id; ?></p>
        <p><strong>Book ID:</strong> <?php echo $book_id; ?></p>
        <p><strong>Reserve Date:</strong> <?php echo $reserve_date; ?></p>
        <input type="submit" name="confirm" value="Confirm">
        <a href="reservations.php?ts=<?php echo time(); ?>">Cancel</a>
    </form>
</body>
</html>


