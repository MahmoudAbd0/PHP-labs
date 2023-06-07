<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $errors = [];

  $email = trim($_POST['email']);
  $password = $_POST['password'];

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

  if (empty($errors)) {

    include 'connectDB.php';

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');

    $stmt->bindParam(':email', $email);

    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user['password'] == $password) {
      session_start();
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_name'] = $user['name'];
      $_SESSION['user_room'] = $user['room'];
      $_SESSION['user_image'] = $user['image'];
      header('location:home.php');
    } else {
      echo " <span class='text-danger'> Email Or Password Not Correct! </span><br>";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <title>Login Form</title>
</head>

<body>
  <div class="container">
    <h2>Login Form</h2>
    <form method="post">
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
      </div>
      <button type="submit" class="btn btn-primary" name="submit">Login</button>

      <a href="./Register.php" class="nav-link">Register</a>

      <?php
      if (!empty($errors)) {
        foreach ($errors as $err) {
          echo '<span class="alert alert-danger">' . $err . '</span>';
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