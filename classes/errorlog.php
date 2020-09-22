<?php


/**
 * Class error_log
 *
 * Quick class to log errors
 */
class errorlog{
    /**
    *
    */
    function Log($Content){
        $time = date("Y-m-d H:i:s",time());

        $fp = fopen(__DIR__.'/../logs/log.txt', 'a');//opens file in append mode
        fwrite($fp, $time . ": " . $Content . "\r\n");
        fclose($fp);
    }
}