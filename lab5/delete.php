<?php
    require_once 'DataBase.php';
    $db = new Database();

    $id = $_GET['id'];
    if(!is_numeric($id)){
        header("Location: index.php");
        exit();
    }

    $user = $db->selectById("users", $id);
    if (!$user) {
        header("Location: index.php");
        exit();
    }

    $image = $user['image'];
    unlink("images/$image");
    $db->delete("users", $id);

    header("Location: index.php");
    exit();
?>

