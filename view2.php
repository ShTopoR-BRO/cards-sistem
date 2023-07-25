<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="view2.php" method="POST">
        <input type="text" name="card_number" placeholder="create card number">
        <input type="text" name="balance" placeholder="input balance">
        <input type="submit" name="create_card" value="Create Card"> 
        <input type="submit" name="delete_card" value="Delete Card">
    </form>
</body>
</html>

<?php
include "connection.php";


if(isset($_POST["create_card"])){
    if (empty($_POST["card_number"])){
        echo "введите номер карты";
    }
    else{
    $res = new Bank();
    echo $_POST["card_number"];
    echo $_POST["balance"];
    $number = $_POST["card_number"];
    $balance = $_POST["balance"];
    $res->createNewCard($number, (int) $balance);
    header("Location:http://localhost/php_files/Bank/view.php");
}   
}

if(isset($_POST["delete_card"])){
    if (empty($_POST["card_number"])){
        echo "введите номер карты";
    }
    else{
    $res = new Bank();
    $number = $_POST["card_number"];
    $balance = $_POST["balance"];
    $res->deleteCard($number, (int) $balance);
    header("Location:http://localhost/php_files/Bank/view.php");
}   
}


?>