<?php

include 'connectDB.php';


$sql = "SELECT * FROM users";
// Execute the statement
$stmt = $conn->query($sql);
// Fetch the user information
$data = $stmt->fetch(PDO::FETCH_ASSOC);

echo $data['name'];

if (isset($_POST["delete"])) {
  $index = $_POST["index"];
 
  header("Location: ".$_SERVER["PHP_SELF"]);
  exit();
}

echo "<div class='container'>";
echo "<table class='table table-striped'>";
echo "<thead><tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Gender</th><th>Action</th></tr></thead>";
echo "<tbody>";
foreach ($data as $index) {
  echo "<tr>";
    echo "<td>" . $index . "</td>";
  }
  echo "<td><form method='post' action='".$_SERVER["PHP_SELF"]."'><input type='hidden' name='index' value='$index'><button type='submit' name='delete' class='btn btn-danger'>Delete</button></form></td>";
  echo "</tr>";
echo "</tbody>";
echo "</table>";
echo "</div>";

?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>