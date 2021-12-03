<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Protocol;

class ProtocolorController extends Controller
{
    public function getProtols(){
        $protocols = Protocol::all();
        
        return response()->json(
            $protocols,
        200);
    }


}