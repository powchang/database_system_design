<!DOCTYPE html>
<html>
<head>
  <h1>Delete Author</h1>
</head>
<body>
    <?php
    $servername = "localhost";
    $username = "u96kbujupxtov";
    $password = "cujxib-6nurfY-zetcib";
    $dbname = "dbw3ghaodzjq1g";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $author = null;
    if (isset($_GET['id'])) {
        $author_id = $_GET['id'];
        $sql = "SELECT * FROM authors WHERE id = $author_id";
        $result = mysqli_query($conn, $sql);
        $author = mysqli_fetch_assoc($result);
    }

    if (isset($_POST['confirm'])) {
        $author_id = $_POST['author_id'];
        $sql = "DELETE FROM authors WHERE id = $author_id";
        if (mysqli_query($conn, $sql)) {
            echo "<p>Author deleted successfully!</p>";
            echo '<a href="authors.php?ts=' . time() . '">Go back to author page</a>';
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    mysqli_close($conn);
    ?>

    <?php if ($author): ?>
        <p>Are you sure you want to delete the author "<?php echo $author['name']; ?>"?</p>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="author_id" value="<?php echo $author['id']; ?>">
            <button type="submit" class="btn btn-danger" name="confirm">Yes, delete author</button>
            <a href="authors.php?ts=<?php echo time(); ?>" class="btn btn-secondary">No, go back to authors page</a>
        </form>
    <?php else: ?>
        <p>Author is verified no longer in the database. <a href="authors.php">Go back to authors page</a></p>
    <?php endif; ?>
</body>
</html>
