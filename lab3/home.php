<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <title>home</title>
</head>
<body>
  <div class="container">
    <h2 class="display-3">welcome <?php echo $_SESSION['name'];?></h2>
    <h4 class="display-4">Room: <?php echo $_SESSION['room']; ?></h4>
    <img src="<?php echo $_SESSION['imageUrl'] ?>" alt="img" width="160"/>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
