<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class claim extends Controller
{
    public function dashboard()
    {
        $opd = DB::select("SELECT query1.totalPrice AS visit_cost
                FROM 
                (SELECT t_visit.t_visit_id,t_visit.visit_hn,t_visit.visit_vn,t_visit.visit_patient_age
                    ,f_patient_prefix.patient_prefix_description,t_patient.patient_firstname,t_patient.patient_lastname
                    ,f_sex.sex_description,t_patient.patient_pid,t_patient.patient_birthday,b_employee.employee_number
                    ,t_diag_icd10.diag_icd10_number,t_diag_icd9.diag_icd9_icd9_number ,t_visit_payment.visit_payment_main_hospital
                    ,SUM(t_billing.billing_total) AS totalPrice,b_contract_plans.contract_plans_description AS contract_plans_description
                    ,SUBSTRING(t_visit.visit_begin_visit_time,0,11) AS dateVisit 
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
                    AND t_visit.f_visit_type_id = '0'
                    AND t_visit_payment.visit_payment_active ='1'
                    AND t_visit_payment.visit_payment_priority = '0'
                    AND t_billing.billing_active ='1'
                    AND (SUBSTRING(t_visit.visit_begin_visit_time,1,10) BETWEEN SUBSTRING('2564-10-01',1,10) AND SUBSTRING('2565-09-30',1,10))
                GROUP BY 
                    t_visit.t_visit_id,f_patient_prefix.patient_prefix_description,t_patient.patient_firstname
                    ,t_patient.patient_lastname,t_patient.patient_pid,t_patient.patient_birthday,b_employee.employee_number
                    ,t_diag_icd10.diag_icd10_number,f_sex.sex_description,t_diag_icd9.diag_icd9_icd9_number
                    ,t_visit_payment.visit_payment_main_hospital,b_contract_plans.contract_plans_description) AS query1 
                GROUP BY
                    query1.dateVisit,query1.visit_hn,query1.visit_vn,query1.patient_prefix_description,query1.patient_firstname
                    ,query1.patient_lastname ,query1.patient_pid,query1.patient_birthday,query1.employee_number,query1.diag_icd10_number
                    ,query1.visit_payment_main_hospital	,query1.sex_description,query1.visit_patient_age,query1.contract_plans_description
                    ,query1.diag_icd9_icd9_number,query1.totalPrice
                ORDER BY
                    query1.dateVisit,query1.visit_hn");
         
        $ipd = DB::select("SELECT query1.totalPrice AS visit_cost
                FROM 
                (SELECT t_visit.t_visit_id,t_visit.visit_hn,t_visit.visit_vn,t_visit.visit_patient_age
                    ,f_patient_prefix.patient_prefix_description,t_patient.patient_firstname,t_patient.patient_lastname
                    ,f_sex.sex_description,t_patient.patient_pid,t_patient.patient_birthday,b_employee.employee_number
                    ,t_diag_icd10.diag_icd10_number,t_diag_icd9.diag_icd9_icd9_number ,t_visit_payment.visit_payment_main_hospital
                    ,SUM(t_billing.billing_total) AS totalPrice,b_contract_plans.contract_plans_description AS contract_plans_description
                    ,SUBSTRING(t_visit.visit_begin_visit_time,0,11) AS dateVisit 
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
                    AND t_visit.f_visit_type_id = '1'
                    AND t_visit_payment.visit_payment_active ='1'
                    AND t_visit_payment.visit_payment_priority = '0'
                    AND t_billing.billing_active ='1'
                    AND (SUBSTRING(t_visit.visit_begin_visit_time,1,10) BETWEEN SUBSTRING('2564-10-01',1,10) AND SUBSTRING('2565-09-30',1,10))
                GROUP BY 
                    t_visit.t_visit_id,f_patient_prefix.patient_prefix_description,t_patient.patient_firstname
                    ,t_patient.patient_lastname,t_patient.patient_pid,t_patient.patient_birthday,b_employee.employee_number
                    ,t_diag_icd10.diag_icd10_number,f_sex.sex_description,t_diag_icd9.diag_icd9_icd9_number
                    ,t_visit_payment.visit_payment_main_hospital,b_contract_plans.contract_plans_description) AS query1 
                GROUP BY
                    query1.dateVisit,query1.visit_hn,query1.visit_vn,query1.patient_prefix_description,query1.patient_firstname
                    ,query1.patient_lastname ,query1.patient_pid,query1.patient_birthday,query1.employee_number,query1.diag_icd10_number
                    ,query1.visit_payment_main_hospital	,query1.sex_description,query1.visit_patient_age,query1.contract_plans_description
                    ,query1.diag_icd9_icd9_number,query1.totalPrice
                ORDER BY
                    query1.dateVisit,query1.visit_hn");

        $phopd = DB::select("SELECT SUM(q1.val) AS cost FROM
                (SELECT t_order.order_common_name AS item,order_qty AS qty
                ,SUM(order_price*order_qty) AS val
                FROM t_patient
                    INNER JOIN t_visit ON t_patient.t_patient_id = t_visit.t_patient_id
                    INNER JOIN t_order ON t_visit.t_visit_id = t_order.t_visit_id
                    INNER JOIN f_visit_type ON f_visit_type.f_visit_type_id = t_visit.f_visit_type_id
                WHERE f_visit_type.f_visit_type_id = '0'
                AND t_order.f_item_group_id = '1'
                AND t_order.f_order_status_id <> '3'
                AND substring(visit_financial_discharge_time,1,10) BETWEEN SUBSTRING('2564-10-01',1,10) AND SUBSTRING('2565-09-30',1,10)
                GROUP BY  t_order.order_common_name ,order_qty ,order_date_time) as q1 ");
        $phipd = DB::select("SELECT SUM(q1.val) AS cost FROM
                (SELECT t_order.order_common_name AS item,order_qty AS qty
                ,SUM(order_price*order_qty) AS val
                FROM t_patient
                    INNER JOIN t_visit ON t_patient.t_patient_id = t_visit.t_patient_id
                    INNER JOIN t_order ON t_visit.t_visit_id = t_order.t_visit_id
                    INNER JOIN f_visit_type ON f_visit_type.f_visit_type_id = t_visit.f_visit_type_id
                WHERE f_visit_type.f_visit_type_id = '1'
                AND t_order.f_item_group_id = '1'
                AND t_order.f_order_status_id <> '3'
                AND substring(visit_financial_discharge_time,1,10) BETWEEN SUBSTRING('2564-10-01',1,10) AND SUBSTRING('2565-09-30',1,10)
                GROUP BY  t_order.order_common_name ,order_qty ,order_date_time) as q1 ");
                
        $list = DB::connection('mysql')->table('claim_list')->where('visit_status',0)->get();
        $all = DB::connection('mysql')->table('claim_list')->leftjoin('claim_status','sta_no','visit_status')->get();
        $res = DB::connection('mysql')->table('claim_list')->where('visit_status',1)->count();
        $wait = DB::connection('mysql')->table('claim_list')->where('visit_status',9)->count();

        $report = DB::select(DB::raw("SELECT b_contract_plans.contract_plans_description
                ,count(DISTINCT CASE WHEN t_visit.f_visit_type_id='1'
                            THEN t_visit.visit_vn
                            ELSE NULL END) as count_visit_ipd
                ,count(distinct CASE WHEN t_visit.f_visit_type_id='0'
                                THEN t_visit.visit_vn
                                ELSE NULL END) as count_visit_opd
                ,count(distinct CASE WHEN t_visit.f_visit_type_id='1'
                                THEN t_patient.patient_hn
                                ELSE NULL END) as count_patient_ipd
                ,count(distinct CASE WHEN t_visit.f_visit_type_id='0'
                                THEN  t_patient.patient_hn
                                ELSE NULL END) as count_patient_opd
                FROM t_visit
                JOIN t_patient ON t_patient.t_patient_id = t_visit.t_patient_id
                LEFT JOIN t_visit_payment ON t_visit.t_visit_id = t_visit_payment.t_visit_id
                    AND t_visit_payment.visit_payment_active='1'
                    AND t_visit_payment.visit_payment_priority='0'
                LEFT JOIN b_contract_plans ON t_visit_payment.b_contract_plans_id = b_contract_plans.b_contract_plans_id
                WHERE t_visit.f_visit_status_id NOT IN ('4')
                    AND substr(visit_begin_visit_time,1,10) BETWEEN substr('2565-06-01',1,10) AND substr('2565-06-30',1,10)
                GROUP BY b_contract_plans.contract_plans_description"));
        // dd($report);
        return view('dashboard',['opd'=>$opd,'ipd'=>$ipd,'phopd'=>$phopd,'phipd'=>$phipd,'list'=>$list,'wait'=>$wait,'all'=>$all,'res'=>$res,'report'=>$report]);
    }
}
