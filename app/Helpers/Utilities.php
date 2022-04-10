<?php
namespace App\Helpers;

abstract class Utilities 
{

    public static function splitByLine(string $string): array {
        return explode("\n", $string);
    }

    public static function splitBySpace(int $space_number, string $string): array {
        return preg_split('/ {'.$space_number.',}/', $string);
    }

    public static function removeEmptyLines($lines)
    {
        $output = [];
        foreach($lines as $line){
            if( ! empty(trim($line)) ){
                array_push($output, trim($line));
            }
        }
        return $output;
    }

    public static function mergeArray($item)
    {
        return call_user_func_array('array_merge', $item);
    }
}