<?php

class Bank{
    private $conn;
    protected  $conf;
    protected  $DBHost;
	protected  $DBPassword;
	protected  $DBUser;
	protected  $DBName;

    public function __construct(){
        $this->conf=json_decode(file_get_contents("env.json"));
		$this->DBHost=$this->conf->DBHOST;
		$this->DBPassword=$this->conf->DBPASSWORD;
		$this->DBUser=$this->conf->DBUSER;
		$this->DBName=$this->conf->DBNAME;
        $this->conn = new PDO("mysql:host=".$this->DBHost.";dbname=".$this->DBName, $this->DBUser, $this->DBPassword);
    }
    
    public function getCards(){
        $sql="SELECT * FROM cards;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function transact($summ, $card1, $card2){
        if (empty($summ) || empty($card1) || empty($card2)){
            echo "введите все данные";
            return "";
        }
        try{
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn->beginTransaction();
        $sql="UPDATE cards SET balance = balance + :summ WHERE number = :card2;";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindValue(":summ", $summ);
        $stmt->bindValue(":card2", $card2);
        $stmt->execute();

        $sql="UPDATE cards SET balance = balance - :summ WHERE number = :card1;";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindValue(":summ", $summ);
        $stmt->bindValue(":card1", $card1);
        $stmt->execute(); 

        $a = date('d.m.Y H:i:s');
        $sql="INSERT INTO operations (card_append,descreption,card_pop,date) VALUES(:card2,:summ,:card1,:a);";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindValue(":summ", $summ);
        $stmt->bindValue(":card1", $card1);
        $stmt->bindValue(":card2", $card2);
        $stmt->bindValue(":a", $a);
        $stmt->execute(); 

        $this->conn->commit();
    }
    catch (Exception $e){
        $this->conn->rollBack();
        echo "ERRoR:" . $e->getMessage();
    }
    }

    public function getAllTransactions(){
        $sql="SELECT * FROM operations;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function createNewCard($number, $balance){
        $sql="INSERT INTO cards (number, balance) VALUES(:card_number, :balance);";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindValue(":card_number", $number);
        $stmt->bindValue(":balance", $balance);
        $stmt->execute();
    }

    public function deleteCard($number, $balance){
        $sql="DELETE FROM cards WHERE number = :card_number and balance = :balance;";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindValue(":card_number", $number);
        $stmt->bindValue(":balance", $balance);
        $stmt->execute();
    }
}

    


?>