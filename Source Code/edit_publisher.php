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
        $country = $row['country'];
    } else {
        header("Location: publishers.php");
    }
} else {
    header("Location: publishers.php");
}

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $country = $_POST['country'];

    $sql = "UPDATE publishers SET name = '$name', country = '$country' WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: publishers.php?ts=" . time());
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Publisher</title>
</head>
<body>

<h2>Edit Publisher</h2>

<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>
    <br>
    <label for="country">Country:</label>
    <input type="text" id="country" name="country" value="<?php echo $country; ?>" required>
    <br>
    <input type="submit" name="submit" value="Update Publisher">
</form>

</body>
</html>
