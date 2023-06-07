<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $errors = [];

  $email = trim($_POST['email']);
  $password = $_POST['password'];

  // Validate the email
  if (empty($email)) {
      $errors['email'] = 'Please enter your email';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = 'Please enter a valid email';
  }

  // Validate the password
  if (empty($password)) {
      $errors['password'] = 'Please enter your password';
  } elseif (strlen($password) < 8) {
      $errors['password'] = 'Password must be at least 8 characters long';
  }

  if(empty($errors)) {

    $file = fopen('data.txt','r') or die('file not exist');

    while(!feof($file)){

        $line = explode(':',fgets($file));
      
        if($email == $line[1] && $password == $line[2]){
        
          session_start();
        
        $_SESSION['name'] = $line[0];
        
        $_SESSION['image'] = $line[4];

        $_SESSION['room'] = $line[3];
        
        echo $line[1].':'.$line[2].'image:'.$line[4].'<br>';
        
        header('location:home.php');
      
      } else {
            echo " <span class='text-danger'> login failed </span><br>";
      }
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
        if(!empty($errors)) {
          foreach($errors as $err) {
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