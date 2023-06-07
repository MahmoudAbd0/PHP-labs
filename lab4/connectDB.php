<?php 

try {
    $pdo = new PDO('mysql:host=localhost;dbname=phplabs', 'root', 'mangood1907');
    // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch(PDOException $e) {
    echo $e->getMessage("faild to connect");
}