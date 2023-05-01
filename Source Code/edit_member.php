<?php
$servername = "localhost";
$username = "u96kbujupxtov";
$password = "cujxib-6nurfY-zetcib";
$dbname = "dbw3ghaodzjq1g";

$conn = mysqli_connect($servername, $username, $password, $dbname);

$id = isset($_GET['id']) ? $_GET['id'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $id) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $query = "UPDATE members SET name = ?, address = ?, phone = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssi', $name, $address, $phone, $email, $id);

    if ($stmt->execute()) {
        echo "Member updated successfully.<br>";
        echo "<a href='members.php?ts=" . time() . "' class='btn btn-secondary'>Go back to members page</a>";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
    exit;
}

if ($id) {
    $query = "SELECT * FROM members WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        echo "Invalid ID.";
        exit;
    }
} else {
    echo "Invalid ID.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit Member</title>
</head>
<body>
    <div class="container">
        <h1>Edit Member</h1>
        <form method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="address" class="
orm-label">Address:</label>
<input type="text" class="form-control" id="address" name="address" value="<?php echo $row['address']; ?>" required>
</div>
<div class="mb-3">
<label for="phone" class="form-label">Phone:</label>
<input type="text" class="form-control" id="phone" name="phone" value="<?php echo $row['phone']; ?>" required>
</div>
<div class="mb-3">
<label for="email" class="form-label">Email:</label>
<input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>" required>
</div>
<button type="submit" class="btn btn-primary">Update</button>
<a href="members.php" class="btn btn-secondary">Cancel</a>
</form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
