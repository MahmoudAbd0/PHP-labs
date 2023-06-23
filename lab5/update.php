<?php
    session_start();

    $id = $_GET['id'];
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

    if (!empty($password)) {
        if (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters";
        }
        if (empty($confirm_password)) {
            $errors[] = "Confirm Password is required";
        } else{
            if (strlen($confirm_password) < 8) {
                $errors[] = "Confirm Password must be at least 8 characters";
            }
            if ($password != $confirm_password) {
                $errors[] = "Password and Confirm Password must be the same";
            }
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

    if (isset($image) && !empty($image)){
        $imageFileType = strtolower(pathinfo($image,PATHINFO_EXTENSION));
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $errors[] = "Sorry, only JPG, JPEG, PNG files are allowed.";
        }
    }

    require_once 'DataBase.php';
    $db = new DataBase();
    $emailExits = $db->selectByCondition('users', "email = '$email'");
    if(count($emailExits) > 0 && $emailExits[0]['id'] != $id){
        $errors[] = "Email already exists";
    }

    // if there are errors, redirect back to the create page
    if (count($errors) > 0) {
        $_SESSION['edit_errors'] = $errors;
        header("Location: edit.php?id=$id");
        exit();
    }

    // if there are no errors, update the user in the database
    unset($_SESSION['edit_errors']);

    $data = [
        'name' => $name,
        'email' => $email,
        'password' => $password,
        'room' => $room,
        'ext' => $ext,
    ];

    if ($image) {
        $image = time().'_'.$image;
        move_uploaded_file($_FILES['image']['tmp_name'], $target.$image);
        // remove old image
        $row = $db->selectById('users', $id);
        unlink($target.$row->image);
        $data['image'] = $image;
    }
    if (!empty($password)) {
        $data['password'] = md5($password);
    }

    $db->update('users', $id, $data);

    header("Location: index.php");
    exit();
?>





