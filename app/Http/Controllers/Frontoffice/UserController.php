<?php
namespace App\Http\Controllers\Frontoffice;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

    public function details(Request $request) 
    { 
        $user = Auth::user();
        return response()->json($user, 200); 
    }
}