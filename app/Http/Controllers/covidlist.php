<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class covidlist extends Controller
{
    public function index()
    {
        return view('covid.index');
    }

    public function process(Request $request)
    {
        $start = substr($request->start,4);
        $sYear = date("Y",strtotime($request->start))+543;
        $sNew = $sYear.$start;

        $end = substr($request->end,4);
        $eYear = date("Y",strtotime($request->end))+543;
        $eNew = $eYear.$end;

        $data = DB::select("SELECT query1.dateVisit AS visit_date,query1.patient_pid AS visit_pid,
                query1.visit_hn AS visit_hn,query1.contract_plans_description as visit_plan,
                query1.patient_prefix_description || ' ' || query1.patient_firstname || ' ' || query1.patient_lastname AS visit_patient,
                query1.sex_description AS visit_gender,query1.visit_patient_age AS visit_age,
                query1.totalPrice AS visit_cost,query1.lab_name,query1.lab_result
            FROM 
            (SELECT t_visit.t_visit_id,t_visit.visit_hn,t_visit.visit_vn,t_visit.visit_patient_age
                ,f_patient_prefix.patient_prefix_description,t_patient.patient_firstname,t_patient.patient_lastname
                ,f_sex.sex_description,t_patient.patient_pid,t_patient.patient_birthday
                ,t_visit_payment.visit_payment_main_hospital
                ,SUM(t_billing.billing_total) AS totalPrice,b_contract_plans.contract_plans_description AS contract_plans_description
                ,t_visit.visit_begin_visit_time AS dateVisit,t_order.order_common_name AS lab_name,t_result_lab.result_lab_value AS lab_result
            FROM 
            t_visit 
            INNER JOIN t_patient ON t_visit.t_patient_id = t_patient.t_patient_id 
            LEFT JOIN f_patient_prefix ON t_patient.f_patient_prefix_id = f_patient_prefix.f_patient_prefix_id
            INNER JOIN t_visit_payment ON t_visit.t_visit_id = t_visit_payment.t_visit_id 
            LEFT JOIN b_contract_plans ON t_visit_payment.b_contract_plans_id = b_contract_plans.b_contract_plans_id	
            INNER JOIN t_billing ON t_visit.t_visit_id = t_billing.t_visit_id 
            LEFT JOIN f_sex ON t_patient.f_sex_id = f_sex.f_sex_id
            LEFT JOIN t_order ON t_order.t_visit_id = t_visit.t_visit_id
            LEFT JOIN t_result_lab on t_result_lab.t_order_id = t_order.t_order_id
            WHERE
                t_visit.f_visit_status_id <>'4'
                -- AND t_visit.f_visit_type_id = '0'
                -- AND t_visit_payment.visit_payment_active ='1'
                -- AND t_visit_payment.visit_payment_priority = '0'
                -- AND t_billing.billing_active ='1'
                AND (SUBSTRING(t_visit.visit_begin_visit_time,1,10) BETWEEN ('$sNew') AND ('$eNew'))
                AND b_contract_plans.b_contract_plans_id NOT IN ('2120000000044','2120000000039','0000000000000')
                AND t_order.b_item_id IN ('174237368279260568')
                AND t_result_lab.result_lab_value IN ('Negative','negative','nagative')
            GROUP BY 
                t_visit.t_visit_id,f_patient_prefix.patient_prefix_description,t_patient.patient_firstname
                ,t_patient.patient_lastname,t_patient.patient_pid,t_patient.patient_birthday,f_sex.sex_description
                ,t_visit_payment.visit_payment_main_hospital,b_contract_plans.contract_plans_description
                ,t_order.order_common_name,t_result_lab.result_lab_value) AS query1 
            GROUP BY
                query1.dateVisit,query1.visit_hn,query1.visit_vn,query1.patient_prefix_description,query1.patient_firstname
                ,query1.patient_lastname ,query1.patient_pid,query1.patient_birthday
                ,query1.visit_payment_main_hospital	,query1.sex_description,query1.visit_patient_age,query1.contract_plans_description
                ,query1.totalPrice,query1.lab_name,query1.lab_result
            ORDER BY
                query1.dateVisit,query1.visit_hn");
        // dd($data);
        return view('covid.result',['data'=>$data]);
    }
}
