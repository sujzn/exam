<?php 

if('PHP_SAPI' != 'cli') exit ('Access Denied!');

try{

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
    exit($e->getCode());
}