<?php
namespace App\Helpers;

class FileHelper {

    public function writeFile($directory, $filename, $log)
    {
        if(!file_exists($directory)){
            mkdir($directory, 0755, true);
        }
        $fp = fopen($directory.$filename, 'a');
        fwrite($fp, $log);
        fclose($fp);
    }

    public function readFile($logFolder, $logFile)
    {
        $logFullPath = $logFolder . $logFile;
        $logFileLines = [];
        $fp = fopen($logFullPath, 'rb');
        while ( ($line = fgets($fp)) !== false) {
            $logFileLines[] = "$line";
        }
        return $logFileLines;
    }
}