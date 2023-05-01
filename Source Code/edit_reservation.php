<?php
// Include the database connection file
$servername = "localhost";
$username = "u96kbujupxtov";
$password = "cujxib-6nurfY-zetcib";
$dbname = "dbw3ghaodzjq1g";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if the form was submitted and the reservation ID is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['reservation_id'])) {
    $reservation_id = $_GET['reservation_id'];

    // Get the submitted form data
    $member_id = $_POST['member_id'];
    $book_id = $_POST['book_id'];
    $reserve_date = $_POST['reserve_date'];
   
    // Update the reservation in the database
    $sql = "UPDATE reservations SET member_id = ?, book_id = ?, reserve_date = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "Error: " . $conn->error;
        exit;
    }
    $stmt->bind_param("iisi", $member_id, $book_id, $reserve_date, $reservation_id);
    if ($stmt->execute()) {
        $message = "Reservation updated successfully.<br>";
        echo $message .= "<a href='reservations.php?ts=" . time() . "' class='btn btn-secondary'>Go back to reservations page</a>";
    } else {
        echo $message = "Error: " . $stmt->error;
    }
}


// Retrieve the reservation data from the database
if (isset($_GET['reservation_id'])) {
    $reservation_id = $_GET['reservation_id'];
    $sql = "SELECT * FROM reservations WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $reservation_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $reservation = $result->fetch_assoc();
} else {
    // Redirect back to the reservations page if the reservation ID is not set
    header("Location: reservations.php");
    exit;
}

// Retrieve the list of members and books from the database
$sql = "SELECT * FROM members";
$result = mysqli_query($conn, $sql);
$members = mysqli_fetch_all($result, MYSQLI_ASSOC);

$sql = "SELECT * FROM books";
$result = mysqli_query($conn, $sql);
$books = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<!-- The rest of the HTML code for edit_reservation.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Edit Reservation</h1>
        <form action="edit_reservation.php?reservation_id=<?php echo $reservation_id; ?>" method="post">
            <div class="mb-3">
                <label for="member_id" class="form-label">Member ID:</label>
                <select class="form-control" id="member_id" name="member_id" required>
                    <?php
                    // Loop through all members and create an option for each one
                    foreach ($members as $member) {
                        $selected = "";
                        if ($member['id'] == $reservation['member_id']) {
                            $selected = "selected";
                        }
                        echo "<option value='" . $member['id'] . "' $selected>" . $member['id'] . "</option>";
}
?>
</select>
</div>
<div class="mb-3">
<label for="book_id" class="form-label">Book:</label>
<select class="form-control" id="book_id" name="book_id" required>
<?php
// Retrieve all books from the database
$sql = "SELECT * FROM books";
$result = mysqli_query($conn, $sql);
                // Loop through all books and create an option for each one
                while ($book = mysqli_fetch_assoc($result)) {
                    $selected = "";
                    if ($book['id'] == $reservation['book_id']) {
                        $selected = "selected";
                    }
                    echo "<option value='" . $book['id'] . "' $selected>" . $book['title'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="reserve_date" class="form-label">Reserved Date:</label>
            <input type="date" class="form-control" id="reserve_date" name="reserve_date" value="<?php echo $reservation['reserve_date']; ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Reservation</button>
        <a href="reservations.php?ts=<?php echo time(); ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>

</body>
<!-- JavaScript dependencies for Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>

</html>
