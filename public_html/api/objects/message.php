<?php

class Message{
    // database connection and table name
    private $conn;
    private $table_name = "message";
  
    // object properties
    // public $message_id;
    public $m_name;
    public $m_email;
    public $m_phone;
    public $m_comment;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read message
    function read(){
    
        // select all query
        $query = "SELECT * FROM $this->table_name ORDER BY message_id asc";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }
    // create message
    function create(){
    
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    m_name=:m_name, m_email=:m_email, m_phone=:m_phone, m_comment=:m_comment";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->m_name=htmlspecialchars(strip_tags($this->m_name));
        $this->m_email=htmlspecialchars(strip_tags($this->m_email));
        $this->m_phone=htmlspecialchars(strip_tags($this->m_phone));
        $this->m_comment=htmlspecialchars(strip_tags($this->m_comment));

    
        // bind values
        $stmt->bindParam(":m_name", $this->m_name);
        $stmt->bindParam(":m_email", $this->m_email);
        $stmt->bindParam(":m_phone", $this->m_phone);
        $stmt->bindParam(":m_comment", $this->m_comment);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }
    // used when filling up the update message form
    function readOne(){
    
        // query to read single record
        $query = "SELECT * FROM $this->table_name Where message_id=?";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind id of message to be updated
        $stmt->bindParam(1, $this->message_id);
    
        // execute query
        $stmt->execute();
    
        // get retrieved row
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // set values to object properties
            $this->m_name = $row['m_name'];
            $this->m_email = $row['m_email'];
            $this->m_phone = $row['m_phone'];
            $this->m_comment = $row['m_comment'];
            return true;
        }
        else {
            return false;
        }
        
    }
    // update the message
    function update(){
    
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    m_name = :m_name,
                    m_email = :m_email,
                    m_phone = :m_phone,
                    m_comment = :m_comment
                WHERE
                    message_id = :message_id";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->m_name=htmlspecialchars(strip_tags($this->m_name));
        $this->m_email=htmlspecialchars(strip_tags($this->m_email));
        $this->m_phone=htmlspecialchars(strip_tags($this->m_phone));
        $this->m_comment=htmlspecialchars(strip_tags($this->m_comment));
        $this->message_id=htmlspecialchars(strip_tags($this->message_id));

        $isIdExist = $this->isIdExist($this->message_id);
    
        if ($isIdExist) {
            $stmt->bindParam(':m_name', $this->m_name);
            $stmt->bindParam(':m_email', $this->m_email);
            $stmt->bindParam(':m_phone', $this->m_phone);
            $stmt->bindParam(':m_comment', $this->m_comment);
            $stmt->bindParam(':message_id', $this->message_id); 

            if ($stmt->execute())
                return true;
            else 
                return false;
        }
        return false;
    }

    // delete the message
    function delete(){

        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE message_id = ?";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->message_id=htmlspecialchars(strip_tags($this->message_id));
    
        $isIdExist = $this->isIdExist($this->message_id);
    
        if ($isIdExist) {
            $stmt->bindParam(1, $this->message_id);

            if ($stmt->execute())
                return true;
            else 
                return false;
        }
        return false;
    }

    // used for paging message
public function count(){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
  
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
    return $row['total_rows'];
}

    function isIdExist($message_id) {
        $query = "SELECT message_id FROM " . $this->table_name . " WHERE message_id = " . $message_id;
    
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
                m_name LIKE ? OR m_email LIKE ? OR m_phone LIKE ? OR m_comment LIKE ?
            ORDER BY
                message_id DESC";
  
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