<?php 
error_reporting(E_STRICT);
include_once('Processor.php');

function dd(...$var)
{
    var_dump($var);exit;
}


try{
    
    $inputs = getopt('u:p:h:d:o:', ['create_table', 'file:', 'dry_run', 'help']);
    
    $processor = new Processor();
    
    if(isset($inputs['help'])){
        $processor->printHelp();
    }
    
    
    $dbCredentials = [
        'u' => $inputs['u'] ?? NULL,
        'p' => $inputs['p'] ?? '',
        'h' => $inputs['h'] ?? NULL,
        'd' => $inputs['d'] ?? 'assignment',
        'o' => $inputs['o'] ?? 3306
    ];
    
    if(isset($inputs['create_table'])){
        
        if(!$dbCredentials['u'] || !$dbCredentials['h']){
            throw new Exception('Database Username, Password and Host must be provided!!');
        } 
        
        $processor->initDatabase($dbCredentials)->createTable();
        
    }
    
    
    
    if(isset($inputs['file'])){
        $isDryRun = isset($inputs['dry_run']);
        $fileName = $inputs['file'] ?? null;
        
        
        
        if(!$fileName) {
            throw new Exception('File name should be provided');
        }
        
        if(!$isDryRun){
            if(!$dbCredentials['u'] || !$dbCredentials['h']){
                throw new Exception('Database Username, Password and Host must be provided!!');
            }
            
            $processor->initDatabase($dbCredentials);
        }
        
        
        $processor->processFile($fileName, $isDryRun);
        
        
    }
    
} catch (Exception $e) {
    $error = "\n---------------\nError: {$e->getMessage()}\n---------------\n\n";
    fwrite(STDERR, $error);
    exit;
}   



