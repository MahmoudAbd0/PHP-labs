<?php
    session_start();
    $id = $_GET['id'];
    if (!isset($id) && !is_numeric($id)){
        header('Location: index.php');
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
<div style="margin-top: 100px" class="container">
    <?php if (isset($_SESSION['edit_errors'])): ?>
        <div class="alert alert-danger">
            <?php foreach ($_SESSION['edit_errors'] as $error): ?>
                <p><?php echo $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php
        require_once 'DataBase.php';
        $db = new Database();
        $user = $db->selectById('users', $id);
        if (!$user) {
            header('Location: index.php');
        }
    ?>

    <form action="update.php?id=<?php echo $user['id'] ?>" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input required type="text" class="form-control" id="name" name="name" value="<?php echo $user['name'] ?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input required type="email" class="form-control" id="email" name="email" value="<?php echo $user['email'] ?>">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input  type="password" class="form-control" id="password" name="password" value="">
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input  type="password" class="form-control" id="confirm_password" name="confirm_password" value="">
        </div>
        <div class="mb-3">
            <label for="room" class="form-label">Room</label>
            <input required type="number" class="form-control" id="room" name="room" value="<?php echo $user['room'] ?>">
        </div>
        <div class="mb-3">
            <label for="ext" class="form-label">Ext</label>
            <input required type="text" class="form-control" id="ext" name="ext" value="<?php echo $user['ext'] ?>">
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="index.php" class="btn btn-secondary">Back</a>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>    <title>Home Page</title>


</body>
</html>