<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
<div style="margin-top: 100px" class="container">
    <a style="margin-bottom: 30px" href="create.php" class="btn btn-success">Create New User</a>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Room</th>
            <th>Ext</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        include_once 'DataBase.php';
        $db = new Database();

        $rows = $db->select('users');

        foreach ($rows as $row) {
            ?>
            <tr>
                <td><?php echo $row['name'] ?></td>
                <td><?php echo $row['email'] ?></td>
                <td><?php echo $row['room'] ?></td>
                <td><?php echo $row['ext'] ?></td>
                <td><img src='images/<?php echo $row['image'] ?>' width='50' height='50'></td>
                <td>
                    <a href='edit.php?id=<?php echo $row['id']; ?>' class='btn btn-primary'>Edit</a>
                    <a href='delete.php?id=<?php echo $row['id']; ?>' class='btn btn-danger'
                       onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
<title>Home Page</title>
</body>
</html>