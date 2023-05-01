<?php
// establish connection to MySQL database
$servername = "localhost";
$username = "u96kbujupxtov";
$password = "cujxib-6nurfY-zetcib";
$dbname = "dbw3ghaodzjq1g";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// check if connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// check if book id is set
if(isset($_GET['id'])) {
    $book_id = $_GET['id'];

    // delete associated reservations from the 'reservations' table
    $sql_reservations = "DELETE FROM reservations WHERE book_id = $book_id";

    if(mysqli_query($conn, $sql_reservations)) {
        // delete book from the 'books' table
        $sql_books = "DELETE FROM books WHERE id = $book_id";

        if(mysqli_query($conn, $sql_books)) {
            echo "<p>Book and associated reservations deleted successfully.</p>";
        } else {
            echo "Error: " . $sql_books . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Error: " . $sql_reservations . "<br>" . mysqli_error($conn);
    }
} else {
    echo "<p>Book id not provided.</p>";
}

mysqli_close($conn);
?>

echo '<a href="index.php?ts=' . time() . '">Go back to main page</a>'; // Add a unique timestamp parameter
