<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class supplies extends Controller
{
    public function index()
    {
        $result = DB::connection('mysql')->table('claim_list')->get();
        dd($result);
    }
}
