<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Protocolo;

class ProtocolorController extends Controller
{
    public function getProtols(){
        $protocols = DB::table('protocols')->get();
        
        return response()->json(
            $protocols,
        200);
    }
}