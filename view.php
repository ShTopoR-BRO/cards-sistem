<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="view.php" method="POST">
        <input type="number" name="summ" placeholder="сумма"></br>
        <input type="text" name="card1" placeholder="карта списания"></br>
        <input type="text" name="card2" placeholder="карта зачисления"></br>
        <input type="submit" name="transact" value="TRANSACT">
        <input type="submit" name="show_all_transactions" value="Show ALL Transactions">
    </form>
    <form action="view2.php" method="POST">
        <input type="submit" name="create_new_card" value="Create/Delete Card">
    </form>
</body>
</html>

<?php

include "connection.php";

$res = new Bank();
$data = $res->getCards();
foreach ($data as $row) {
    echo $row["number"] . " ";
    echo $row["balance"] . " ";
    echo "рублей" . "</br>";        
}

if(isset($_POST["transact"])){
    $summ = $_POST["summ"];
    $card1 = $_POST["card1"];
    $card2 = $_POST["card2"];
    $res->transact($summ, $card1, $card2);
    header("Location:http://localhost/php_files/Bank/view.php");
}

if(isset($_POST["show_all_transactions"])){
    $data = $res->getAllTransactions();
    foreach ($data as $row){
        echo "ПЕРЕВОД" . " ";
        echo "отправитель:" . $row["card_append"] . " ";
        echo "сумма:" . $row["descreption"] . " ";
        echo "получатель:" . $row["card_pop"] . " ";
        echo "дата:" . $row["date"] . " " . "</br>";
    }
}
?>