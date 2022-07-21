<?php

class Donation{
    // database connection and table name
    private $conn;
    private $table_name = "donation";
  
    // object properties
    public $donation_id;
    public $donation_amount;
    public $donation_datetime;
    public $cust_id;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read donation
    function read(){
    
        // select all query
        $query = "SELECT * FROM $this->table_name ORDER BY donation_id asc";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }
    // create donation
    function create(){
    
        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " 
                SET donation_amount=:donation_amount, donation_datetime=:donation_datetime, cust_id=:cust_id";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        // $this->donation_id=htmlspecialchars(strip_tags($this->donation_id));
        $this->donation_amount=htmlspecialchars(strip_tags($this->donation_amount));
        $this->donation_datetime=htmlspecialchars(strip_tags($this->donation_datetime));
        $this->cust_id=htmlspecialchars(strip_tags($this->cust_id));

        // bind values
        // $stmt->bindParam(":donation_id", $this->donation_id);
        $stmt->bindParam(":donation_amount", $this->donation_amount);
        $stmt->bindParam(":donation_datetime", $this->donation_datetime);
        $stmt->bindParam(":cust_id", $this->cust_id);

        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }
    // used when filling up the update donation form
    function readOne(){
    
        // query to read single record
        $query = "SELECT * FROM $this->table_name Where donation_id=?";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind id of donation to be updated
        $stmt->bindParam(1, $this->donation_id);
    
        // execute query
        $stmt->execute();
    
        // get retrieved row
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // set values to object properties
            $this->donation_id = $row['donation_id'];
            $this->donation_amount = $row['donation_amount'];
            return true;
        }
        else {
            return false;
        }
        
    }
    // update the donation
    function update(){
    
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    donation_amount = :donation_amount
                WHERE
                    donation_id = :donation_id";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->donation_amount=htmlspecialchars(strip_tags($this->donation_amount));
        $this->donation_id=htmlspecialchars(strip_tags($this->donation_id));

        $isIdExist = $this->isIdExist($this->donation_id);
    
        if ($isIdExist) {
            $stmt->bindParam(':donation_amount', $this->donation_amount);
            $stmt->bindParam(':donation_id', $this->donation_id); 

            if ($stmt->execute())
                return true;
            else 
                return false;
        }
        return false;
    }

    // delete the donation
    function delete(){

        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE donation_id = ?";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->donation_id=htmlspecialchars(strip_tags($this->donation_id));
    
        $isIdExist = $this->isIdExist($this->donation_id);
    
        if ($isIdExist) {
            $stmt->bindParam(1, $this->donation_id);

            if ($stmt->execute())
                return true;
            else 
                return false;
        }
        return false;
    }

    // used for paging donation
    public function count(){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
  
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
    return $row['total_rows'];
}

    function isIdExist($donation_id) {
        $query = "SELECT donation_id FROM " . $this->table_name . " WHERE donation_id = " . $donation_id;
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // execute query
        $stmt->execute();
    
        // get retrieved row
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return true;
        }

        return false;
    }
    
     // search products
     function search($keywords){
  
        // select all query
        $query = "SELECT * FROM
                    " . $this->table_name . "
                WHERE
                    donation_amount LIKE ? 
                ORDER BY
                    donation_id DESC";
      
        // prepare query statement
        $stmt = $this->conn->prepare($query);
      
        // sanitize
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";
      
        // bind
        $stmt->bindParam(1, $keywords);
      
        // execute query
        $stmt->execute();
      
        return $stmt;
    }

}

?>