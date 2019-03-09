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
        if(!$dbCredentials['u'] || !$dbCredentials['p'] || !$dbCredentials['h']){
            throw new Exception('Database Username, Password and Host must be provided!!');
        } 
        
        $processor->initDatabase($dbCredentials)->createTable();

        //var_dump(getopt("u:p:h:"));exit;
    }
    




	$files = getopt("f:");
	if(empty($files)){
		throw new Exception('Please pass csv files as argument.', 1);
	}
	//print_r($files);exit;
	include_once 'process.php';
    $csv = new csv($files);


    //print_r($csv);exit;
    fwrite(STDOUT, $csv->import());
    exit(0);

} catch (Exception $e) {
    $error = "---------------\nError: {$e->getMessage()}\n---------------";
    fwrite(STDERR, $error);
    exit($e->getMessage());
}


