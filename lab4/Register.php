<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $errors = [];
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];
  $room = $_POST['room'];
  $image = $_FILES['image'];

  include 'connectDB.php';

  if (empty($name)) {
    $errors['name'] = 'Please enter your name';
  }

  if (empty($email)) {
    $errors['email'] = 'Please enter your email';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Please enter a valid email';
  }

  if (empty($password)) {
    $errors['password'] = 'Please enter your password';
  } elseif (strlen($password) < 8) {
    $errors['password'] = 'Password must be at least 8 characters long';
  }

  if (empty($confirmPassword)) {
    $errors['confirmPassword'] = 'Please confirm your password';
  } elseif ($password !== $confirmPassword) {
    $errors['confirmPassword'] = 'Passwords do not match';
  }

  if (empty($room)) {
    $errors['room'] = 'Please select a room';
  }

  if (empty($image['name'])) {
    $errors['image'] = 'Please choose an image';
  } elseif ($image['error'] !== 0) {
    $errors['image'] = 'There was an error uploading the image';
  } elseif (!in_array($image['type'], ['image/jpeg', 'image/png'])) {
    $errors['image'] = 'Please choose a JPEG or PNG image';
  }

  if (isset($_FILES['image'])) {

    $targetDir = 'images/';

    $targetFile = $targetDir . basename($image['name']);

    if (move_uploaded_file($image['tmp_name'], $targetFile)) {

      $_SESSION['user_image'] = $targetFile;

      echo 'File uploaded successfully.';
    }
  }


  if (empty($errors)) {
    $stmt = $pdo->prepare('INSERT INTO users (name, email, password, room, image) 
                            VALUES (:name, :email, :password, :room, :image)');

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':room', $room);
    $stmt->bindParam(':image', $_SESSION['user_image'], PDO::PARAM_LOB);

    if ($stmt->execute()) {
      echo '<span class="alert alert-success">User created successfully</span>';
    } else {
      echo '<span class="alert alert-danger">Error creating user</span>';
    }
    header('Location: login.php');
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <title>Registration Form</title>
</head>

<body>
  <div class="container">

    <h2>Registration Form</h2>
    <form method="POST" enctype="multipart/form-data" class="form-group" action="Register.php">

      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
      </div>

      <div class="form-group">
        <label for="confirm-password">Confirm Password</label>
        <input type="password" class="form-control" id="confirm-password" name="confirmPassword" placeholder="Confirm your password">
      </div>

      <div class="form-group">
        <label for="room">Room No</label>
        <select name="room" id="room" class="form-control">
          <option value="1">Application1</option>
          <option value="2">Application2</option>
          <option value="3">Application3</option>
        </select>
      </div>

      <div class="form-group">
        <label for="image">Choose Image</label>
        <input type="file" class="form-control" id="image" name="image" placeholder="Enter your name">
      </div>
      <button type="submit" class="btn btn-primary" name="submit">Submit</button>
      <a href="./Login.php" class="nav-link">Login</a>

      <?php
      if (!empty($errors)) {
        foreach ($errors as $err) {
          echo '<span class="alert alert-danger">' . $err . '</span><br><br>';
        }
      }


      ?>
    </form>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>