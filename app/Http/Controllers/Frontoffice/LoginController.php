<?php
namespace App\Http\Controllers\Frontoffice;

use App\Http\Controllers\Controller;

class LoginController extends Controller
{

    public function login()
    {
        return response('test', 200);
    }
}