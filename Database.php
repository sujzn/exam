<?php

class Database {
    private $host = '';
    private $user = '';
    private $pass = '';
    private $dbname = '';
    private $port = '';
    

    private $dbh;
    private $error;
    private $stmt;
    
    // Constructor
    public function __construct($host,$user,$pass,$dbname,$port){
        
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->dbname = $dbname;
        $this->port = $port;
        // Set DSN
        


        $dsn = 'mysql:host=' . $this->host . ':'.$this->port.';dbname=' . $this->dbname;
        
        // Set options
        $options = array(
            PDO::ATTR_PERSISTENT => true, 
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        
        // Create a new PDO instanace
        try{
           //echo $this->pass;exit;
            $this->dbh = new PDO($dsn, $this->user, $this->pass);
            //var_dump($this->dbh);exit;
            $this->dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling
            //echo 'tedr';
        }
        // Catch any errors
        catch(PDOException $e){
            echo 'error';
            $this->error = $e->getMessage();
            var_dump($this->error);exit;
        }
    }

    public function statement(string $sql)
    {
        $this->dhb->query($sql);

        return $this;
    }
    
    // Prepare
    public function query($query){
        $this->stmt = $this->dbh->prepare($query);
        
        return $this;
    }
    
    // Bind
    public function bind($param, $value, $type = null){
        if (is_null($type)) {
          switch (true) {
            case is_int($value):
              $type = PDO::PARAM_INT;
              break;
            case is_bool($value):
              $type = PDO::PARAM_BOOL;
              break;
            case is_null($value):
              $type = PDO::PARAM_NULL;
              break;
            default:
              $type = PDO::PARAM_STR;
          }
        }
        $this->stmt->bindValue($param, $value, $type);
    }
    
    // Execute
    public function execute(){
        return $this->stmt->execute();
    }
    
    // Result Set
    public function resultset(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Single
    public function single(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Row Count
    public function rowCount(){
        return $this->stmt->rowCount();
    }
    
    // Last Insert Id
    public function lastInsertId(){
        return $this->dbh->lastInsertId();
    }
    
    /* TRANSACTIONS */
    // To begin a transaction
    public function beginTransaction(){
        return $this->dbh->beginTransaction();
    }
    // To end a transaction and commit your changes
    public function endTransaction(){
        return $this->dbh->commit();
    }
    // To cancel a transaction and roll back your changes
    public function cancelTransaction(){
        return $this->dbh->rollBack();
    }
    
    
    // Debug Dump Parameters
    public function debugDumpParams(){
        return $this->stmt->debugDumpParams();
    }
  
}
// /* Example: Using your PDO class */
// // Instantiate database.
// $database = new PDO_Database();
// /* [To Insert a new record] */
// $database->query('INSERT INTO mytable (FName, LName, Age, Gender) VALUES (:fname, :lname, :age, :gender)');
// // bind data
// $database->bind(':fname', 'John');
// $database->bind(':lname', 'Smith');
// $database->bind(':age', '24');
// $database->bind(':gender', 'male');
// // execute
// $database->execute();
// //fetch last insert id
// echo $database->lastInsertId();
// /* [To Select a single row] */
// $database->query('SELECT FName, LName, Age, Gender FROM mytable WHERE FName = :fname');
// $database->bind(':fname', 'Jenny');
// $row = $database->single();
// /* [To Select multiple rows] */
// $database->query('SELECT FName, LName, Age, Gender FROM mytable WHERE LName = :lname');
// $database->bind(':lname', 'Smith');
// $rows = $database->resultset();
// // display the number of records returned.
// echo $database->rowCount();