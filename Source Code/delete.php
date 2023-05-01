<?php
$servername = "localhost";
$username = "u96kbujupxtov";
$password = "cujxib-6nurfY-zetcib";
$dbname = "dbw3ghaodzjq1g";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$book_id = $_GET['id'];

if (isset($_POST['confirm'])) {
    $sql = "DELETE FROM books WHERE id = $book_id";

    if (mysqli_query($conn, $sql)) {
        echo "Record deleted successfully. ";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    echo '<a href="index.php?ts=' . time() . '">Go back to main page</a>';
} else {
    $sql = "SELECT title FROM books WHERE id = $book_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $book_title = $row["title"];
    } else {
        echo "Book not found.";
    }
?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Delete Confirmation</title>
    </head>
    <body>
        <h2>Delete Book</h2>
        <p>Are you sure you want to delete the book "<?php echo $book_title; ?>"?</p>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $book_id; ?>">
            <button type="submit" name="confirm" value="yes">Confirm</button>
            <a href="index.php?ts=<?php echo time(); ?>">Cancel</a>
        </form>
    </body>
    </html>
<?php
}
mysqli_close($conn);
?>
