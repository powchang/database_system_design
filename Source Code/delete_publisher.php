<?php
$servername = "localhost";
$username = "u96kbujupxtov";
$password = "cujxib-6nurfY-zetcib";
$dbname = "dbw3ghaodzjq1g";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM publishers WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
    } else {
        header("Location: publishers.php");
    }
} else {
    header("Location: publishers.php");
}

if (isset($_POST['confirm'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM publishers WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: publishers.php?ts=" . time());
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
}
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Publisher</title>
</head>
<body>
<h2>Delete Publisher</h2>
<p>Are you sure you want to delete the publisher '<?php echo $name; ?>'?</p>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <input type="submit" name="confirm" value="Yes, delete publisher">
    <a href="publishers.php?ts=<?php echo time(); ?>" class="btn btn-secondary">No, go back to publishers page</a>
</form>
</body>
</html>
