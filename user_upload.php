<?php 

//if('PHP_SAPI' != 'cli') exit ('Access Denied!');

try{

	$files = getopt("f:");
	if(empty($files)){
		throw new Exception('Please pass csv files as argument.', 1);
	}
	include_once 'process.php';
    $csv = new csv($files);
    fwrite(STDOUT, $csv->import($csv));
    exit(0);

} catch (Exception $e) {
    $error = "---------------\nError: {$e->getMessage()}\n---------------";
    fwrite(STDERR, $error);
    exit($e->getCode());
}

?>