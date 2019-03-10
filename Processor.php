<?php

include_once('Database.php');

class Processor 
{

    private $database;

    public function __construct()
    {
   
    }

    public function initDatabase(array $credentials)
    {
        $dbUser = $credentials['u'];
        $dbPass = $credentials['p'];
        $dbHost = $credentials['h'];
        $dbDatabase = $credentials['d'] ?? 'assignment';
        $dbPort = $credentials['o'] ?? 3306 ;

        //echo $this->database;exit;

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

        echo $sql;exit;    
        
        $this->database->statement($sql);

        echo 'TABLE created';
    }

    public function readFile($file){

        $handle = fopen($file, "r");
        $i = 1;
        while (($data = fgetcsv($handle, 5000, ",")) !== FALSE) {
            $num = count($data);    
            $row++;
            $mycsvfile[] = $data;
            
            $firstColumn = $mycsvfile[0][0];
            $secondColumn = $mycsvfile[0][1];
            $thirdColumn =  $mycsvfile[0][2];

            if (trim($firstColumn) !== "name" || trim($secondColumn) !== "surname" || trim($thirdColumn) !== "email") {
                echo 'Invalid Header';   exit;                
                fclose($handle);                
            } else {
                if ($i > 0) {
                    //echo 'here';exit;
                    $patternName = UCfirst($firstColumn);
                    var_dump($patternName);
                    $patternSurname = UCfirst($secondColumn);

                   

                    // Check if the row has the correct format
                    //if (preg_match($data[2], $patternPhone)) {

                        // Format is OK, let's insert

                        // $import = "INSERT into upload (techDate, techEmail, techPhone)values('$data[0]','$data[1]','$data[2]')";

                        // $db->query($import);
                        // $qstring = '?status=succ';

                } else {
                         // The row doesn't have the right format
                        //echo 'there';exit; 
                         echo "The row ".$row." doesn't have the right format";
                }
            }
        }
        $i++; 
        fclose($handle);
    }      

}

?>
