<?php
    session_start();

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $room = $_POST['room'];
    $ext = $_POST['ext'];
    $image = $_FILES['image']['name'];
    $target = "images/";

    // validate the form
    $errors = [];
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    if (empty($email)) {
        $errors[] = "Email is required";
    }else{
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        }
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    }else{
        if (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters";
        }
    }
    if (empty($confirm_password)) {
        $errors[] = "Confirm Password is required";
    }else{
        if (strlen($confirm_password) < 8) {
            $errors[] = "Confirm Password must be at least 8 characters";
        }
        if ($password != $confirm_password) {
            $errors[] = "Password and Confirm Password must be the same";
        }
    }
    if (empty($room)) {
        $errors[] = "Room is required";
    }else{
        if (!is_numeric($room)) {
            $errors[] = "Room must be a number";
        }
    }
    if (empty($ext)) {
        $errors[] = "Ext is required";
    }
    if (empty($image)) {
        $errors[] = "Image is required";
    }else{
        $imageFileType = strtolower(pathinfo($image,PATHINFO_EXTENSION));
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $errors[] = "Sorry, only JPG, JPEG, PNG files are allowed.";
        }
    }
    $password = md5($password);
    require_once 'DataBase.php';
    $db = new DataBase();

    $emailExists = $db->selectByCondition('users', "email = '$email'");
    if(count($emailExists) > 0){
        $errors[] = "Email is already taken";
    }

    // if there are errors, redirect back to the create page
    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        header("Location: create.php");
        exit();
    }

    // if there are no errors, insert the new user into the database
    unset($_SESSION['errors']);
     // give image a unique name
    $image = time().'_'.$image;

    $db->insert('users', [
        'name' => $name,
        'email' => $email,
        'password' => $password,
        'room' => $room,
        'ext' => $ext,
        'image' => $image
    ]);

    move_uploaded_file($_FILES['image']['tmp_name'], $target.$image);
    header("Location: index.php");
    exit();
?>


