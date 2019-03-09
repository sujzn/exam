<?php 

include_once('Processor.php');

//if('PHP_SAPI' != 'cli') exit ('Access Denied!');

try{

    $processor = new Processor();

    $help = getopt(null,['help::']);
    if(count($help)){
        $processor->printHelp();
    }

    $createTable = getopt(null,['create_table::']);
    
    if(count($createTable)){
        $dbCredentials = getopt("u:p:h:d:o:");
        if(!$dbCredentials['u'] || !$dbCredentials['h']){
            throw new Exception('Database Username, Password and Host must be provided!!');
        } 
        //echo 'hi';
        $processor->initDatabase($dbCredentials)->createTable();

        //var_dump(getopt("u:p:h:"));exit;
    }

    $csvFile = getopt('f:');
    //print_r($csvFile);exit;
    if(empty($csvFile)){
        throw new Exception('Please pass CSV file as an argument!');
    }
    $processor->readFile($csvFile);
 
	
	//print_r($csv);exit;
    fwrite(STDOUT, $csv->import());
    exit(0);

} catch (Exception $e) {
    $error = "---------------\nError: {$e->getMessage()}\n---------------";
    fwrite(STDERR, $error);
    exit($e->getMessage());
}


