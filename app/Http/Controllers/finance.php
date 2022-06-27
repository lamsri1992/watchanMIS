<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class finance extends Controller
{
    public function report(Request $request)
    {
        $start = substr($request->start,4);
        $sYear = date("Y",strtotime($request->start))+543;
        $sNew = $sYear.$start;

        $end = substr($request->end,4);
        $eYear = date("Y",strtotime($request->end))+543;
        $eNew = $eYear.$end;

        if($request->fi_type == 0 || $request->fi_type == 1)
        {
            $data = DB::select("SELECT query1.dateVisit AS visit_date,query1.patient_pid AS visit_pid,
                query1.visit_hn AS visit_hn,query1.contract_plans_description as visit_plan,
                query1.plan_main as visit_plan_main,
                query1.patient_prefix_description || '' || query1.patient_firstname || ' ' || query1.patient_lastname AS visit_patient,
                query1.sex_description AS visit_gender,query1.visit_patient_age AS visit_age,query1.diag_icd10_number AS visit_icd10,
                query1.diag_icd9_icd9_number AS visit_icd9,query1.totalPrice AS visit_cost,query1.p_type AS p_type
            FROM 
            (SELECT t_visit.t_visit_id,t_visit.visit_hn,t_visit.visit_vn,t_visit.visit_patient_age
                ,f_patient_prefix.patient_prefix_description,t_patient.patient_firstname,t_patient.patient_lastname
                ,f_sex.sex_description,t_patient.patient_pid,t_patient.patient_birthday,b_employee.employee_number
                ,t_diag_icd10.diag_icd10_number,t_diag_icd9.diag_icd9_icd9_number ,t_visit_payment.visit_payment_main_hospital
                ,SUM(t_billing.billing_total) AS totalPrice,b_contract_plans.contract_plans_description AS contract_plans_description
                ,t_visit.visit_begin_visit_time AS dateVisit ,t_visit.f_visit_type_id AS p_type
                ,r_plan_group.plan_group_description AS plan_main
            FROM 
            t_visit INNER JOIN t_patient  ON t_visit.t_patient_id = t_patient.t_patient_id 
            LEFT JOIN f_patient_prefix ON t_patient.f_patient_prefix_id = f_patient_prefix.f_patient_prefix_id
            INNER JOIN t_visit_payment ON t_visit.t_visit_id = t_visit_payment.t_visit_id 
            LEFT JOIN b_contract_plans ON t_visit_payment.b_contract_plans_id = b_contract_plans.b_contract_plans_id	
            LEFT JOIN t_diag_icd10 
                ON (t_visit.t_visit_id = t_diag_icd10.diag_icd10_vn AND t_diag_icd10.f_diag_icd10_type_id = '1' AND  t_diag_icd10.diag_icd10_active = '1' )
            LEFT JOIN  t_diag_icd9 
                ON (t_visit.t_visit_id = t_diag_icd9.diag_icd9_vn AND t_diag_icd9.diag_icd9_active ='1' AND t_diag_icd9.f_diagnosis_operation_type_id = '1')
            LEFT JOIN b_employee ON b_employee.b_employee_id = t_diag_icd10.diag_icd10_staff_doctor
            INNER JOIN t_billing ON t_visit.t_visit_id = t_billing.t_visit_id 
            LEFT JOIN f_sex ON t_patient.f_sex_id = f_sex.f_sex_id
            LEFT JOIN r_plan_group_map_pttype ON b_contract_plans.contract_plans_pttype = r_plan_group_map_pttype.plan_group_map_pttype_pttype
			LEFT JOIN r_plan_group on r_plan_group.r_plan_group_id = r_plan_group_map_pttype.r_plan_group_id
            WHERE
                t_visit.f_visit_status_id <> '4'
                AND t_visit.f_visit_type_id = '$request->fi_type'
                AND t_visit_payment.visit_payment_active = '1'
                AND t_visit_payment.visit_payment_priority = '0'
                AND t_billing.billing_active = '1'
                AND r_plan_group.r_plan_group_id = '$request->fi_group'
                AND (SUBSTRING(t_visit.visit_begin_visit_time,1,10) BETWEEN ('$sNew') AND ('$eNew'))
            GROUP BY 
                t_visit.t_visit_id,f_patient_prefix.patient_prefix_description,t_patient.patient_firstname
                ,t_patient.patient_lastname,t_patient.patient_pid,t_patient.patient_birthday,b_employee.employee_number
                ,t_diag_icd10.diag_icd10_number,f_sex.sex_description,t_diag_icd9.diag_icd9_icd9_number
                ,t_visit_payment.visit_payment_main_hospital,b_contract_plans.contract_plans_description
                ,r_plan_group.plan_group_description) AS query1 
            GROUP BY
                query1.dateVisit,query1.visit_hn,query1.visit_vn,query1.patient_prefix_description,query1.patient_firstname
                ,query1.patient_lastname ,query1.patient_pid,query1.patient_birthday,query1.employee_number,query1.diag_icd10_number
                ,query1.visit_payment_main_hospital	,query1.sex_description,query1.visit_patient_age,query1.contract_plans_description
                ,query1.diag_icd9_icd9_number,query1.totalPrice,query1.p_type,query1.plan_main
            ORDER BY
                query1.dateVisit");
        }

        // dd($data);
        return view('finance.report',['data'=>$data]);
    }

    public function statement(Request $request,$id)
    {
        dd($id);
    }
}
