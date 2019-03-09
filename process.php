<?php 

// Define configuration
// May Include this in database configuration file
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "database");
/*
 PDO Database Class
 */
class csv {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    
    private $dbh;

    
    // Constructor
    public function __construct(){
        // Set DSN
        $dsn = 'mysqli:host=' . $this->host . ';dbname=' . $this->dbname;
        

        try{
            $this->dbh = new PDO($dsn, $this->user, $this->pass);
        }
        // Catch any errors
        catch(PDOException $e){
            $this->error = $e->getMessage();
        }
    }

    public function import($file){

    	print_r($file);exit;

    	$file = fopen($file, 'r');
    	while($rows = fgetcsv($file)){
    		print "<pre>".print_r($rows)."</pre>";
    	}

    		
    }
}

?>