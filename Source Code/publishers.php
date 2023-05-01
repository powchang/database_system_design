<!DOCTYPE html>
<html>
<head>
  <title>powpage</title>
  <h1>Pow Library Management System - Publishers</h1>
  <style>
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

    table {
      border: 1px solid black;
    }
    td, th {
      border: 1px solid black;
      padding: 5px;
    }
  </style>
</head>
<body>
 
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
 

<h1>Publishers Update Page</h1>

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

// check if form was submitted
if(isset($_POST['submit'])) {
    // get form data
    $name = $_POST['name'];
    $country = $_POST['country'];
    
    // insert new publisher into 'publishers' table
    $sql = "INSERT INTO publishers (name, country) VALUES ('$name', '$country')";// insert new publisher into 'publishers' table
    
    if(mysqli_query($conn, $sql)) {
        echo "<p>Publisher added to the database successfully.</p>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// retrieve all publishers from the 'publishers' table
$sql = "SELECT * FROM publishers";
$result = mysqli_query($conn, $sql);

// check if any publishers were found
if (mysqli_num_rows($result) > 0) {
    // display all the publishers in a table
    echo "<table>";
    echo "<tr><th>ID</th><th>Name</th><th>Country</th><th>Actions</th></tr>";
    while($row = mysqli_fetch_assoc($result)) {
        // display the publisher information
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["country"] . "</td>";
        echo "<td><a href='edit_publisher.php?id=" . $row["id"] . "'>Edit</a> | <a href='delete_publisher.php?id=" . $row["id"] . "'>Delete</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No publishers found.";
}
mysqli_close($conn);
?>

<!-- add publisher form -->
<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">

  <h2>Add Publisher</h2>
  <label for="name">Name:</label>
  <input type="text" id="name" name="name" required>
  <br>
  <label for="country">Country:</label>
  <input type="text" id="country" name="country" required>
  <br>
  <input type="submit" name="submit" value="Add Publisher">
</form>

</body>
</html>
