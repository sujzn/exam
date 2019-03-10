<?php

include_once('Database.php');

class Processor 
{
    
    private $database;
    
    public function __construct()
    {
        
    }

    function validateemail($email) {
        $v = "/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/";
        
        return (bool)preg_match($v, $email);
        }
    
    public function initDatabase(array $credentials)
    {
        $dbUser = $credentials['u'];
        $dbPass = $credentials['p'];
        $dbHost = $credentials['h'];
        $dbDatabase = $credentials['d'] ?? 'assignment';
        $dbPort = $credentials['o'] ?? 3306 ;
        
        
        $this->database = new Database($dbHost,$dbUser,$dbPass,$dbDatabase,$dbPort);
        
        return $this; 
    }
    
    public function printHelp()
    {
        $output = "• --file                [csv file name] – this is the name of the CSV to be parsed\n";
        $output .= "• --create_table        this will cause the MySQL users table to be built (and no further action will be taken)\n";
        $output .= "• --dry_run             this will be used with the --file directive in the instance that we want to run the script \n";
        $output .= "                        but not insert into the DB. All other functions will be executed,but the database won't be altered.\n";
        $output .= "• -u                    MySQL username\n";
        $output .= "• -p                    MySQL password\n";
        $output .= "• -h                    MySQL host\n";
        $output .= "• -d                    MySQL database\n";
        $output .= "• -o                    MySQL port\n";
        
        echo $output;exit;
    }
    
    public function printFileName()
    {
        $output = 'users.csv – this is the name of the CSV to be parsed';
        echo $output;exit;
    }
    
    
    public function createTable(){
        $table = 'users';
        $sql = "CREATE TABLE IF NOT EXISTS {$table} (
            id INT PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            surname VARCHAR(12) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            CONSTRAINT uc_email UNIQUE (email)
        );";
           
        
        $this->database->query($sql);
        
        echo 'Table Created.';
    }
    
    protected function getUsersFromCSV(string $file) : array
    {
        
        if (!file_exists($file)) {
            throw new Exception('File not found.');
        }
        $fp = fopen($file, 'r');
        if ($fp === false) {
            throw new Exception('Cannon open file/');
        }
        $users = [];
        while (($user = fgetcsv($fp)) !== false) {
            $users[] = $user;
        }
        fclose($fp);
        return empty($users) ? [] : $users;
    }
    
    public function processFile(string $file, bool $isDryRun)
    {

        $users = $this->getUsersFromCSV($file);

        unset($users[0]);
        

        $users = array_map(function(array $user) use($isDryRun) {

            $name = $user[0];
            $surname = $user[1];
            $email = $user[2];
            
            // validate name 
            $name = addslashes(ucfirst(strtolower(trim($name))));
            $surname = addslashes(ucfirst(strtolower(trim($surname))));
            $email = addslashes(strtolower(trim($email)));
            
            $user = ['name' => $name, 'surname' => $surname, 'email' => $email];
            
            if($this->validateemail($email)) {
                if(!$isDryRun && !email === FALSE ) {
                    try {
                        $this->saveInDB($user);
                    } catch(Exception $exception) {
                        echo $exception->getMessage()."\n";
                    }
                    
                }
            } else {
                echo 'Email is not valid: '.$email."\n";
            }
            
            if($isDryRun) {
                print_r($user);
            }
            
            return $user;            
        }, $users);
    }
    
    public function saveInDB(array $row)
    {
        $sql = "INSERT INTO users (name,surname,email) VALUES ('{$row['name']}','{$row['surname']}','{$row['email']}')";
        $this->database->query($sql);
    }
    
    
}


