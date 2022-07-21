<?php

class Customer{
    // database connection and table name
    private $conn;
    private $table_name = "customer";
  
    // object properties
    // public $cust_id;
    public $cust_id;
    public $cust_fname;
    public $cust_lname;
    public $cust_phone;
    public $cust_email;
    public $cust_password;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read customer
    function read(){
    
        // select all query
        $query = "SELECT * FROM $this->table_name ORDER BY cust_id asc";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }
    // create customer
    function create(){
    
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                cust_fname=:cust_fname, cust_lname=:cust_lname, cust_phone=:cust_phone, cust_email=:cust_email, cust_password=:cust_password";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->cust_fname=htmlspecialchars(strip_tags($this->cust_fname));
        $this->cust_lname=htmlspecialchars(strip_tags($this->cust_lname));
        $this->cust_phone=htmlspecialchars(strip_tags($this->cust_phone));
        $this->cust_email=htmlspecialchars(strip_tags($this->cust_email));
        $this->cust_password=htmlspecialchars(strip_tags($this->cust_password));
    
        // bind values
        $stmt->bindParam(":cust_fname", $this->cust_fname);
        $stmt->bindParam(":cust_lname", $this->cust_lname);
        $stmt->bindParam(":cust_phone", $this->cust_phone);
        $stmt->bindParam(":cust_email", $this->cust_email);
        $stmt->bindParam(":cust_password", $this->cust_password);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }
    // used when filling up the update customer form
    function readOne(){
    
        // query to read single record
        $query = "SELECT * FROM $this->table_name Where cust_id=?";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind id of customer to be updated
        $stmt->bindParam(1, $this->cust_id);
    
        // execute query
        $stmt->execute();
    
        // get retrieved row
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // set values to object properties
            $this->cust_fname = $row['cust_fname'];
            $this->cust_lname = $row['cust_lname'];
            $this->cust_phone = $row['cust_phone'];
            $this->cust_email = $row['cust_email'];
            $this->cust_password = $row['cust_password'];
            return true;
        }
        else {
            return false;
        }
        
    }
    // update the customer
    function update(){
    
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                cust_fname = :cust_fname,
                cust_lname = :cust_lname,
                cust_phone = :cust_phone,
                cust_email = :cust_email,
                cust_password = :cust_password
                WHERE
                cust_id = :cust_id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->cust_fname=htmlspecialchars(strip_tags($this->cust_fname));
        $this->cust_lname=htmlspecialchars(strip_tags($this->cust_lname));
        $this->cust_phone=htmlspecialchars(strip_tags($this->cust_phone));
        $this->cust_email=htmlspecialchars(strip_tags($this->cust_email));
        $this->cust_password=htmlspecialchars(strip_tags($this->cust_password));
        $this->cust_id=htmlspecialchars(strip_tags($this->cust_id));

        $isIdExist = $this->isIdExist($this->cust_id);
        
        if ($isIdExist) {
            $stmt->bindParam(':cust_fname', $this->cust_fname);
            $stmt->bindParam(':cust_lname', $this->cust_lname);
            $stmt->bindParam(':cust_phone', $this->cust_phone);
            $stmt->bindParam(':cust_email', $this->cust_email);
            $stmt->bindParam(':cust_password', $this->cust_password);
            $stmt->bindParam(':cust_id', $this->cust_id); 

            if ($stmt->execute())
                return true;
            else 
                return false;
        }
        return false;
    }

    // delete the customer
    function delete(){

        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE cust_id = ?";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->cust_id=htmlspecialchars(strip_tags($this->cust_id));
    
        $isIdExist = $this->isIdExist($this->cust_id);
    
        if ($isIdExist) {
            $stmt->bindParam(1, $this->cust_id);

            if ($stmt->execute())
                return true;
            else 
                return false;
        }
        return false;
    }

    // used for paging customer
    public function count(){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
  
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
    return $row['total_rows'];
}

    function isIdExist($cust_id) {
        $query = "SELECT cust_id FROM " . $this->table_name . " WHERE cust_id = " . $cust_id;
    
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
                    cust_fname LIKE ? OR cust_lname LIKE ? OR cust_phone LIKE ? OR cust_email LIKE ? 
                ORDER BY
                    cust_id DESC";
      
        // prepare query statement
        $stmt = $this->conn->prepare($query);
      
        // sanitize
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";
      
        // bind
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);
        $stmt->bindParam(4, $keywords);
      
        // execute query
        $stmt->execute();
      
        return $stmt;
    }
    

}

?>