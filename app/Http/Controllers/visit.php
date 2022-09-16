<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class visit extends Controller
{
    public function report(Request $request)
    {
        dd($request->m_visit,$request->y_visit);
    }
}
