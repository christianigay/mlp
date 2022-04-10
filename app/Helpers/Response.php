<?php namespace App\Helpers;

abstract class Response {
    
    public static function responseJSON($data)
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: *');
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        echo json_encode($data, true);
        exit();
    }
}