<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class opd extends Controller
{

    public function opdRefer()
    {
        $opd = DB::select(DB::raw("SELECT 
            count(b_visit_office.b_visit_office_id) as total,
            b_visit_office.b_visit_office_id as hcode,
            b_visit_office.visit_office_name as hname
            from 
                t_visit
                inner join t_patient            on t_visit.t_patient_id = t_patient.t_patient_id
                inner join t_visit_payment      on t_visit.t_visit_id = t_visit_payment.t_visit_id
                inner join t_visit_refer_in_out on t_visit.t_visit_id = t_visit_refer_in_out.t_visit_id
                inner join b_visit_office       on t_visit_refer_in_out.visit_refer_in_out_refer_hospital = b_visit_office.b_visit_office_id
                inner join f_visit_type         on t_visit.f_visit_type_id = f_visit_type.f_visit_type_id
                
            where 
                t_visit.f_visit_status_id <> '4'
                and t_visit_payment.visit_payment_priority = '0'
                and t_visit_payment.visit_payment_active = '1'
                and t_visit.f_visit_type_id = '0'
                and t_visit_refer_in_out.visit_refer_in_out_active ='1'
                and t_visit_payment.visit_payment_active = '1'
                and SUBSTRING(t_visit.visit_financial_discharge_time,1,10) between substring('2564-10-01',1,10) and substring('2565-09-31',1,10)
            group by b_visit_office.visit_office_name,b_visit_office.b_visit_office_id
            order by total desc
            limit 10"));

        // dd($opd);
        return view('opd.refer',['opd'=>$opd]);
    }

    public function n10diag()
    {
        $diag = DB::select(DB::raw("SELECT 
            t_diag_icd10.diag_icd10_number AS icdname,
            b_icd10.icd10_description AS icdtext,
            COUNT(DISTINCT t_visit.visit_vn) AS total
            FROM t_visit
            LEFT JOIN t_diag_icd10 ON t_visit.t_visit_id = t_diag_icd10.diag_icd10_vn
            LEFT JOIN b_icd10 ON b_icd10.icd10_number = t_diag_icd10.diag_icd10_number
            WHERE 
            t_diag_icd10.f_diag_icd10_type_id = '1' 
            AND t_visit.f_visit_status_id <> '4'
            AND t_visit.f_visit_type_id = '0'
            AND SUBSTRING(t_visit.visit_financial_discharge_time,1,10) BETWEEN SUBSTRING('2564-10-01',1,10) AND SUBSTRING('2565-09-31',1,10)
            AND t_diag_icd10.diag_icd10_number NOT IN ('U11.9','Z11.5','U07.1')
            GROUP BY t_diag_icd10.diag_icd10_number,b_icd10.icd10_description
            ORDER BY total DESC
            LIMIT 10"));

        // dd($diag);
        return view('opd.diag',['diag'=>$diag]);
    }

    public function searchRefer(Request $request)
    {
        $start = substr($request->start,4);
        $sYear = date("Y",strtotime($request->start))+543;
        $sNew = $sYear.$start;

        $end = substr($request->end,4);
        $eYear = date("Y",strtotime($request->end))+543;
        $eNew = $eYear.$end;

        $opd = DB::select(DB::raw("SELECT 
            count(b_visit_office.b_visit_office_id) as total,
            b_visit_office.b_visit_office_id as hcode,
            b_visit_office.visit_office_name as hname
            from 
                t_visit
                inner join t_patient            on t_visit.t_patient_id = t_patient.t_patient_id
                inner join t_visit_payment      on t_visit.t_visit_id = t_visit_payment.t_visit_id
                inner join t_visit_refer_in_out on t_visit.t_visit_id = t_visit_refer_in_out.t_visit_id
                inner join b_visit_office       on t_visit_refer_in_out.visit_refer_in_out_refer_hospital = b_visit_office.b_visit_office_id
                inner join f_visit_type         on t_visit.f_visit_type_id = f_visit_type.f_visit_type_id
                
            where 
                t_visit.f_visit_status_id <> '4'
                and t_visit_payment.visit_payment_priority = '0'
                and t_visit_payment.visit_payment_active = '1'
                and t_visit.f_visit_type_id = '0'
                and t_visit_refer_in_out.visit_refer_in_out_active ='1'
                and t_visit_payment.visit_payment_active = '1'
                and SUBSTRING(t_visit.visit_financial_discharge_time,1,10) between '$sNew' and '$eNew'
            group by b_visit_office.visit_office_name,b_visit_office.b_visit_office_id
            order by total desc
            limit 10"));

        // dd($opd);
        return view('opd.refer_search',['opd'=>$opd]);
    }

    public function searchDiag(Request $request)
    {
        $start = substr($request->start,4);
        $sYear = date("Y",strtotime($request->start))+543;
        $sNew = $sYear.$start;

        $end = substr($request->end,4);
        $eYear = date("Y",strtotime($request->end))+543;
        $eNew = $eYear.$end;

        $diag = DB::select(DB::raw("SELECT 
            t_diag_icd10.diag_icd10_number AS icdname,
            b_icd10.icd10_description AS icdtext,
            COUNT(DISTINCT t_visit.visit_vn) AS total
            FROM t_visit
            LEFT JOIN t_diag_icd10 ON t_visit.t_visit_id = t_diag_icd10.diag_icd10_vn
            LEFT JOIN b_icd10 ON b_icd10.icd10_number = t_diag_icd10.diag_icd10_number
            WHERE 
            t_diag_icd10.f_diag_icd10_type_id = '1' 
            AND t_visit.f_visit_status_id <> '4'
            AND t_visit.f_visit_type_id = '0'
            AND SUBSTRING(t_visit.visit_financial_discharge_time,1,10) BETWEEN '$sNew' AND '$eNew'
            AND t_diag_icd10.diag_icd10_number NOT IN ('U11.9','Z11.5','U07.1')
            GROUP BY t_diag_icd10.diag_icd10_number,b_icd10.icd10_description
            ORDER BY total DESC
            LIMIT 10"));

        // dd($diag);
        return view('opd.diag_search',['diag'=>$diag]);
    }

}
