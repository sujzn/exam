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

    // public function readFile($file){
        
    //     $files = implode(",",$file);
    //     $handle = fopen($files, "r");
    //     while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

    //         $num = count($data);    
    //         $row++;

    //         $mycsvfile[] = $data; //add the row to the main array.

    //         $firstRow = $mycsvfile[0][0];
    //         $secondRow = $mycsvfile[0][1];
    //         $thirdRow =  $mycsvfile[0][2];

    //         $patternEmail = '(?:[a-z0-9!#$%&*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])';

    //         if (preg_match($data[2], $thirdRow)) {
                
    //             $import = "INSERT into suppliers ('name', 'surname', 'email')values('$data[0]','$data[1]','$data[2]')";

    //                         $this->database->statement($import);
    //                         //$qstring = '?status=succ'; 
    //             } else {
    //                 // The row doesn't have the right format
    //                 echo "The row $row doesn't have the right format";
    //             }
    //     }   
    //     fclose($handle);  
    // }
}
?>
