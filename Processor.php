<?php

include_once('Database.php');

class Processor 
{

    private $database;

    function __construct()
    {
   
    }

    function initDatabase(array $credentials)
    {
        $dbUser = $credentials['u'];
        $dbPass = $credentials['p'];
        $dbHost = $credentials['h'];
        $dbDatabase = $credentials['d'] ?? 'assignment' ;
        $dbPort = $credentials['p'] ?? 3306 ;

        $this->database = new Database($dbHost,$dbUser,$dbPass,$dbDatabase,$dbPort);
        
        return $this; 
    }

    function printHelp()
    {
        $output = "• --file [csv file name] – this is the name of the CSV to be parsed\n";
        $output .= "• --create_table – this will cause the MySQL users table to be built (and no further";
        $output .= " action will be taken)\n";
        $output .= "• --dry_run – this will be used with the --file directive in the instance that we want";
        $output .= " to run the script but not insert into the DB. All other functions will be executed,";
        $output .= " but the database won't be altered.\n";
        $output .= "• -u – MySQL username\n";
        $output .= "• -p – MySQL password\n";
        $output .= "• -h – MySQL host\n";
        $output .= "• -d – MySQL database\n";
        $output .= "• -o – MySQL port\n";
    
        echo $output;exit;
    }

    function createTable(){

    }
}
