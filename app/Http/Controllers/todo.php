<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class todo extends Controller
{
    public function index()
    {
        $ckDay = date('w');
        $sDay = date("d");
        $sMonth = date("m");
        $sYear = date("Y")+543;
        $sNew = $sYear."-".$sMonth."-".$sDay;
        if($ckDay == 1){
            $sQry = date("Y-m-d",strtotime("-3 days",strtotime($sNew)));
            $eQry = date("Y-m-d",strtotime("-1 days",strtotime($sNew)));
        }else{
            $sQry = date("Y-m-d",strtotime("-1 days",strtotime($sNew)));
            $eQry = date("Y-m-d",strtotime("-1 days",strtotime($sNew)));
        }

        $result = DB::select("SELECT query1.dateVisit AS visit_date,query1.patient_pid AS visit_pid,
                query1.visit_hn AS visit_hn,query1.contract_plans_description as visit_plan,
                query1.patient_prefix_description || query1.patient_firstname || ' ' || query1.patient_lastname AS visit_patient,
                query1.sex_description AS visit_gender,query1.visit_patient_age AS visit_age,query1.diag_icd10_number AS visit_icd10,
                query1.diag_icd9_icd9_number AS visit_icd9,query1.totalPrice AS visit_cost,query1.f_visit_type_id AS p_type
            FROM 
            (SELECT t_visit.t_visit_id,t_visit.visit_hn,t_visit.visit_vn,t_visit.visit_patient_age
                ,f_patient_prefix.patient_prefix_description,t_patient.patient_firstname,t_patient.patient_lastname
                ,f_sex.sex_description,t_patient.patient_pid,t_patient.patient_birthday,b_employee.employee_number
                ,t_diag_icd10.diag_icd10_number,t_diag_icd9.diag_icd9_icd9_number ,t_visit_payment.visit_payment_main_hospital
                ,SUM(t_billing.billing_total) AS totalPrice,b_contract_plans.contract_plans_description AS contract_plans_description
                ,t_visit.visit_begin_visit_time AS dateVisit,t_visit.f_visit_type_id
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
            WHERE
                t_visit.f_visit_status_id <>'4'
                AND t_visit_payment.visit_payment_active ='1'
                AND t_visit_payment.visit_payment_priority = '0'
                AND t_billing.billing_active ='1'
                AND (SUBSTRING(t_visit.visit_begin_visit_time,1,10) BETWEEN ('$sQry') AND ('$eQry'))
                AND b_contract_plans.b_contract_plans_id IN ('212237369210884755','212237367483846128')
                AND t_diag_icd10.diag_icd10_number NOT IN ('Z11.5','U11.9','U07.2','U07.2','Z29.0')
            GROUP BY 
                t_visit.t_visit_id,f_patient_prefix.patient_prefix_description,t_patient.patient_firstname
                ,t_patient.patient_lastname,t_patient.patient_pid,t_patient.patient_birthday,b_employee.employee_number
                ,t_diag_icd10.diag_icd10_number,f_sex.sex_description,t_diag_icd9.diag_icd9_icd9_number
                ,t_visit_payment.visit_payment_main_hospital,b_contract_plans.contract_plans_description) AS query1 
            GROUP BY
                query1.dateVisit,query1.visit_hn,query1.visit_vn,query1.patient_prefix_description,query1.patient_firstname
                ,query1.patient_lastname ,query1.patient_pid,query1.patient_birthday,query1.employee_number,query1.diag_icd10_number
                ,query1.visit_payment_main_hospital	,query1.sex_description,query1.visit_patient_age,query1.contract_plans_description
                ,query1.diag_icd9_icd9_number,query1.totalPrice,query1.f_visit_type_id
            ORDER BY
                query1.dateVisit,query1.f_visit_type_id");

        return view('report.todo',['result'=>$result]);
    }

    public function sendline()
    {
        $ckDay = date('w');
        $sDay = date("d");
        $sMonth = date("m");
        $sYear = date("Y")+543;
        $sNew = $sYear."-".$sMonth."-".$sDay;
        if($ckDay == 1){
            $sQry = date("Y-m-d",strtotime("-3 days",strtotime($sNew)));
            $eQry = date("Y-m-d",strtotime("-1 days",strtotime($sNew)));
        }else{
            $sQry = date("Y-m-d",strtotime("-1 days",strtotime($sNew)));
            $eQry = date("Y-m-d",strtotime("-1 days",strtotime($sNew)));
        }

        $data = DB::select("SELECT query1.dateVisit AS visit_date,query1.patient_pid AS visit_pid,
                query1.visit_hn AS visit_hn,query1.contract_plans_description as visit_plan,
                query1.patient_prefix_description || query1.patient_firstname || ' ' || query1.patient_lastname AS visit_patient,
                query1.sex_description AS visit_gender,query1.visit_patient_age AS visit_age,query1.diag_icd10_number AS visit_icd10,
                query1.diag_icd9_icd9_number AS visit_icd9,query1.totalPrice AS visit_cost,query1.f_visit_type_id AS p_type
            FROM 
            (SELECT t_visit.t_visit_id,t_visit.visit_hn,t_visit.visit_vn,t_visit.visit_patient_age
                ,f_patient_prefix.patient_prefix_description,t_patient.patient_firstname,t_patient.patient_lastname
                ,f_sex.sex_description,t_patient.patient_pid,t_patient.patient_birthday,b_employee.employee_number
                ,t_diag_icd10.diag_icd10_number,t_diag_icd9.diag_icd9_icd9_number ,t_visit_payment.visit_payment_main_hospital
                ,SUM(t_billing.billing_total) AS totalPrice,b_contract_plans.contract_plans_description AS contract_plans_description
                ,t_visit.visit_begin_visit_time AS dateVisit,t_visit.f_visit_type_id
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
            WHERE
                t_visit.f_visit_status_id <>'4'
                AND t_visit_payment.visit_payment_active ='1'
                AND t_visit_payment.visit_payment_priority = '0'
                AND t_billing.billing_active ='1'
                AND (SUBSTRING(t_visit.visit_begin_visit_time,1,10) BETWEEN ('$sQry') AND ('$eQry'))
                AND b_contract_plans.b_contract_plans_id IN ('212237369210884755','212237367483846128')
                AND t_diag_icd10.diag_icd10_number NOT IN ('Z11.5','U11.9','U07.2','U07.2','Z29.0')
            GROUP BY 
                t_visit.t_visit_id,f_patient_prefix.patient_prefix_description,t_patient.patient_firstname
                ,t_patient.patient_lastname,t_patient.patient_pid,t_patient.patient_birthday,b_employee.employee_number
                ,t_diag_icd10.diag_icd10_number,f_sex.sex_description,t_diag_icd9.diag_icd9_icd9_number
                ,t_visit_payment.visit_payment_main_hospital,b_contract_plans.contract_plans_description) AS query1 
            GROUP BY
                query1.dateVisit,query1.visit_hn,query1.visit_vn,query1.patient_prefix_description,query1.patient_firstname
                ,query1.patient_lastname ,query1.patient_pid,query1.patient_birthday,query1.employee_number,query1.diag_icd10_number
                ,query1.visit_payment_main_hospital	,query1.sex_description,query1.visit_patient_age,query1.contract_plans_description
                ,query1.diag_icd9_icd9_number,query1.totalPrice,query1.f_visit_type_id
            ORDER BY
                query1.dateVisit,query1.f_visit_type_id");
        $count = count($data);
        $text = "";
        $i=0;
        foreach ($data as $res){
            $i ++;
            $text .=  "\n".$i.". HN".$res->visit_hn."\n".$res->visit_patient."\nสิทธิ์".$res->visit_plan."\n";
        }
        $text2 = "รายการที่รอตรวจสอบวันนี้\n จำนวน ".$count." ราย\n";
        $Token = "zpaiMIDk67ZD1peP2oDNyojmhOBQgXUE0qC5z1AADBu";
        $message = $text2.$text;
        line_notify($Token, $message);
        return back()->with('success','ส่ง LINE NOTIFY แล้ว');
        // dd($count,$data);
    }

    function sendData(Request $request)
    {
        $data = $request->get('formData');
        $count = count($data);
        // dd($data);
        foreach ($data as $res){
            $cost = str_replace(",", "", $res['7']);
            DB::connection('mysql')->table('claim_list')->insert([
                "visit_date" => $res['0'],
                // "visit_type" => $res['1'],
                "visit_pid" => $res['1'],
                "visit_hn" => $res['2'],
                "visit_plan" => $res['3'],
                "visit_patient" => $res['4'],
                "visit_age" => $res['5'],
                "visit_icd10" => $res['6'],
                "visit_cost" => $cost,
            ]);
        }

        $Token = "ARuAsomfKbOZlFsueudj8ShjdzZJJKNzvrbfNuDsQ7v";
        $message = "รายการที่ต้องเคลมวันนี้\n จำนวน ".$count." ราย\n ตรวจสอบได้ที่ระบบ Watchan Claim Report";
        line_notify($Token, $message);
    }
}
