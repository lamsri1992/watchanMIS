<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class supplies extends Controller
{
    public function index()
    {
        $result = DB::connection('mysql')
                ->table('sup_con')
                ->select('DATE_REGIS','PERSON_REQUEST_NAME','DEP_REQUEST_NAME','CON_DETAIL','REGIS_STATUS_NAME')
                ->join('sup_status_regis','sup_status_regis.REGIS_STATUS_ID','sup_con.REGIS_STATUS_ID')
                ->get();
        // dd($result);
        return view('supplies.index',['result'=>$result]);
    }
}
