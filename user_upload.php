<?php 

include_once('Processor.php');

//if('PHP_SAPI' != 'cli') exit ('Access Denied!');

try{

    $processor = new Processor();

    /* Print help script  */
    $help = getopt(null,['help::']);
    if(count($help)){
        $processor->printHelp();
    }


    /* create table script */

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
    
    /* File name print script */

    $file = getopt(null,['file::']);
    if(count($file)){
        $processor->printFileName();
    }

    /* Read and insert csv file to database script */

    $csvFile = getopt('c:');
    $files = implode(",",$csvFile);
    //print_r($files);exit;
    if(empty($csvFile)){
        throw new Exception('Please pass CSV file as an argument!');
    }
    $processor->readFile($files);
 
	
	//print_r($csv);exit;
    // fwrite(STDOUT, $csv->import());
    // exit(0);


} catch (Exception $e) {
    $error = "---------------\nError: {$e->getMessage()}\n---------------";
    fwrite(STDERR, $error);
    exit($e->getMessage());
}


