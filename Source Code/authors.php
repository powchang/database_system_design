<!DOCTYPE html>
<html>
<head>
  <title>powpage</title>
  <h1>Pow Library Management System - Authors</h1>
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
  </ul>
 

  <h1>Authors</h1>

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
  if (isset($_POST['submit'])) {
      // get form data
      $name = $_POST['name'];
      $birth_year = $_POST['birth_year'];
      $nationality = $_POST['nationality'];

      // insert new author into 'authors' table
      $sql = "INSERT INTO authors (name, birth_year, nationality) VALUES ('$name', $birth_year, '$nationality')";

      if (mysqli_query($conn, $sql)) {
          echo "<p>Author added to the database successfully.</p>";
      } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
  }

  // retrieve all authors from the 'authors' table
  $sql = "SELECT * FROM authors";
  $result = mysqli_query($conn, $sql);

  // check if any authors were found
  if (mysqli_num_rows($result) > 0) {
      // display all the authors in a table
      echo "<table>";
      echo "<tr><th>Name</th><th>Birth Year</th><th>Nationality</th><th>Actions</th></tr>";
      while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          echo "<td>" . $row["name"] . "</td>";
          echo "<td>" . $row["birth_year"] . "</td>";
          echo "<td>" . $row["nationality"] . "</td>";
          echo "<td>";
          echo "<a href='edit_author.php?id=" . $row["id"] . "'>Edit</a> | ";
          echo "<a href='delete_author.php?id=" . $row["id"] . "'>Delete</a>";
          echo "</td>";
          echo "</tr>";
      }
      echo "</table>";
      } else {
echo "No authors found.";
}
mysqli_close($conn);
?>
  <!-- add author form -->
  <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <h2>Add Author</h2>
      <div class="form-group">
          <label for="name">Name:</label>
          <input type="text" id="name" name="name" class="form-control">
      </div>
      <div class="form-group">
          <label for="birth_year">Birth Year:</label>
          <input type="number" id="birth_year" name="birth_year" class="form-control">
      </div>
      <div class="form-group">
          <label for="nationality">Nationality:</label>
          <input type="text" id="nationality" name="nationality" class="form-control">
      </div>
      <button type="submit" class="btn btn-primary" name="submit">Add Author</button>
  </form>

</body>
</html>

