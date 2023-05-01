<!DOCTYPE html>
<html>
<head>
  <title>powpage</title>
  <h1>Pow Library Management System</h1>
  <style>
    /* Add CSS style block */

    table {
      border: 1px solid black;
    }
    td, th {
      border: 1px solid black;
      padding: 5px;
    }

    ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
      overflow: hidden;
      background-color: #333;
    }

    li {
      float: left;
    }

    li a {
      display: block;
      color: white;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
    }

    li a:hover {
      background-color: #111;
    }

  </style>
</head>
<body>
  <!-- Add this navigation menu right after the body tag -->
  
  <ul>
    <li><a href="index.php">Books</a></li>
    <li><a href="authors.php">Authors</a></li>
    <li><a href="publishers.php">Publishers</a></li>
    <li><a href="categories.php">Categories</a></li>
    <li><a href="members.php">Members</a></li>
    <li><a href="loans.php">Loans</a></li>
    <li><a href="reservations.php">Reservations</a></li>
    <li><a href="penalties.php">Penalties</a></li>
    <li><a href="display_book_view.php">Display Books View</a></li>
    <li><a href="display_loans_view.php">Display Loans View</a></li>
  </ul>
 
  
<h1>Books Details Page</h1>

<?php
// establish connection to MySQL database
$servername = "localhost";
$username = "u96kbujupxtov";
$password = "cujxib-6nurfY-zetcib";
$dbname = "dbw3ghaodzjq1g";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// check if connection was successful
if (!$conn) {
    die("Connection failed Pow: " . mysqli_connect_error());
}

// retrieve detailed book information from the 'vw_books_details' view
$sql = "SELECT * FROM vw_books_details";
$result = mysqli_query($conn, $sql);

// check if any books were found
if (mysqli_num_rows($result) > 0) {
    // display all the books in a table
    echo "<table>";
    echo "<tr><th>Title</th><th>Author</th><th>Publisher</th><th>Category</th></tr>";
    while($row = mysqli_fetch_assoc($result)) {
        // display the book information
        echo "<tr>";
        echo "<td>" . $row["title"] . "</td>";
        echo "<td>" . $row["author"] . "</td>";
        echo "<td>" . $row["publisher"] . "</td>";
        echo "<td>" . $row["category"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No books found.";
}
mysqli_close($conn);
?>

</body>
</html>
