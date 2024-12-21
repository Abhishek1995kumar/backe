<?php

function errorLog($errorOnLineNumberIs='', $fileNameWhereGettingError='', $getErrorMessage='', $whichQueryIsGenerateError='', $getBindingErrorWithQuery='', $getErrorCode='') {
    ini_set('memory_limit', '64M');
    $file = base_path('app/Http/Logs');
    if(!file_exists($file)) {
        mkdir($file, 0777, true);
    }
    date_default_timezone_set('Asia/Kolkata');
    $logFileName = $file.'/Log_'.date('d-m-Y').'.log';
    $timestamp = date('[Y-m-d H:i:s] ');
    $logData1 = "======================================================================================================\n";
    $logData2 = "Start log message:\n";
    $logData = is_array($getErrorMessage) || is_object($getErrorMessage) ? print_r($getErrorMessage, true) : "Error : Getting on your query : ".$getErrorMessage;
    $logData3 = "Error : Line number where getting error is : " . $fileNameWhereGettingError;
    $logData4 = "Error : File name where getting error is : " . $errorOnLineNumberIs;
    $logData5 = "Error : Your query value is : " . $whichQueryIsGenerateError;
    $logData6 = "Error : Your query binding with error : " . $getBindingErrorWithQuery;
    $logData7 = "Error : Code : " . $getErrorCode;
    $logData8 = "End log message\n";
    $logData9 = "======================================================================================================\n";
    file_put_contents($logFileName, 
        $timestamp . $logData1 . 
        $timestamp . $logData2 . 
        $timestamp . $logData3 . "\n" 
        . $timestamp . $logData4. "\n" 
        . $timestamp . $logData . "\n" 
        . $timestamp . $logData5 . "\n" 
        . $timestamp . $logData6 . "\n" 
        . $timestamp . $logData7 . "\n" 
        . $timestamp. $logData8 
        . $timestamp. $logData9 . "\n", FILE_APPEND);
    // file_put_contents($logFileName, implode("\n", $logContent) . "\n", FILE_APPEND);
};


