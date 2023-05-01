<?php
$servername = "localhost";
$username = "u96kbujupxtov";
$password = "cujxib-6nurfY-zetcib";
$dbname = "dbw3ghaodzjq1g";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM members WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        echo "Invalid ID.";
        exit;
    }

    if (isset($_POST['confirm'])) {
        $sql = "DELETE FROM members WHERE id = $id";
        if (mysqli_query($conn, $sql)) {
            echo "Member deleted successfully.<br>";
            echo "<a href='members.php?ts=" . time() . "' class='btn btn-secondary'>Go back to members page</a>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <title>Delete Member</title>
        </head>
        <body>
            <div class="container">
                <h1>Delete Member</h1>
                <p>Are you sure you want to delete member '<?php echo $row['name']; ?>'?</p>
                <form action="" method="post">
                    <input type="submit" name="confirm" value="Yes, delete member" class="btn btn-danger">
                    <a href="members.php?ts=<?php echo time(); ?>" class="btn btn-secondary">No, go back to members page</a>
                </form>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
        </body>
        </html>
        <?php
    }
} else {
    echo "Invalid ID.";
}

// Close the connection
mysqli_close($conn);
?>
