<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class dashboard extends Controller
{
    public function index()
    {
        $result = DB::select(DB::raw("SELECT r_plan_group.plan_group_description as plan
            ,SUM(query1.budget) as budget
            FROM r_plan_group  
            LEFT JOIN  
            (SELECT 
                b_contract_plans.contract_plans_description as plan_description
                ,SUM(CASE WHEN (t_visit.f_visit_type_id = '0')
                        THEN t_billing.billing_total
                        ELSE NULL
                end) AS budget
            ,CASE WHEN (r_plan_group_map_pttype.r_plan_group_id IS NULL OR  
            r_plan_group_map_pttype.r_plan_group_id = '' OR  
            r_plan_group_map_pttype.r_plan_group_id = 'null' ) 
                        THEN '8030000000006'  
                        ELSE r_plan_group_map_pttype.r_plan_group_id  
                        END AS r_plan_group_id 
            ,r_plan_group_map_pttype.r_plan_group_id as r_p
            
            FROM
                t_visit 
            INNER JOIN t_billing ON t_visit.t_visit_id = t_billing.t_visit_id
            INNER JOIN t_visit_payment ON t_visit.t_visit_id = t_visit_payment.t_visit_id
            INNER JOIN b_contract_plans ON t_visit_payment.b_contract_plans_id = b_contract_plans.b_contract_plans_id
            LEFT JOIN r_plan_group_map_pttype ON b_contract_plans.contract_plans_pttype = r_plan_group_map_pttype.plan_group_map_pttype_pttype 
            
            WHERE t_visit.f_visit_status_id <> '4'
            AND t_billing.billing_active = '1'
            AND t_visit_payment.visit_payment_active = '1'
            AND t_visit_payment.visit_payment_priority = '0'
            AND SUBSTRING(t_visit.visit_financial_discharge_time,1,10) BETWEEN SUBSTRING('2564-10-01',1,10) AND SUBSTRING('2565-09-31',1,10) 
            
            GROUP BY
                b_contract_plans.contract_plans_description,r_plan_group_map_pttype.r_plan_group_id ) as query1
                ON r_plan_group.r_plan_group_id = query1.r_plan_group_id
            
            GROUP BY query1.r_p,r_plan_group.plan_group_description"));
            
            $opd = DB::select(DB::raw("SELECT
                b_contract_plans.contract_plans_description AS plan
                ,sum(t_billing.billing_patient_share) AS total
                ,sum(t_billing.billing_paid) AS paid
                ,sum(t_billing.billing_remain) AS stuck
            FROM
                t_patient INNER JOIN t_visit
                ON t_patient.t_patient_id = t_visit.t_patient_id
                INNER JOIN t_visit_payment
                ON t_visit.t_visit_id = t_visit_payment.t_visit_id
                INNER JOIN b_contract_plans
                ON t_visit_payment.b_contract_plans_id = 
            b_contract_plans.b_contract_plans_id
                INNER JOIN t_billing
                ON t_visit.t_visit_id = t_billing.t_visit_id
            WHERE
                t_visit.f_visit_type_id = '0'
                AND t_visit.f_visit_status_id <> '4'
                AND t_billing.billing_active = '1'
                AND SUBSTRING(t_visit.visit_financial_discharge_time,1,10) BETWEEN SUBSTRING('2564-10-01',1,10) AND SUBSTRING('2565-09-31',1,10)
            GROUP BY
                b_contract_plans.contract_plans_description
            ORDER BY total DESC LIMIT 10"));

        $sDay = date("d");
        $sMonth = date("m");
        $sYear = date("Y")+543;
        $sNew = $sYear."-".$sMonth."-".$sDay;
        
        $daily = DB::table('t_visit')
                ->where('f_visit_type_id', 0)
                ->where('f_visit_status_id','!=', 4)
                ->whereRaw("SUBSTRING(t_visit.visit_financial_discharge_time,1,10)= '$sNew'")
                ->count();

        $ward = DB::table('t_visit')
                ->where('f_visit_type_id', 1)
                ->where('f_visit_status_id', 1)
                ->where('visit_bed','!=','IPD Discharge')
                ->count();

        $dent = DB::table('t_visit')
                ->join('t_order','t_visit.t_visit_id','t_order.t_visit_id')
                ->join('b_item_subgroup','t_order.b_item_subgroup_id','b_item_subgroup.b_item_subgroup_id')
                ->join('t_visit_payment','t_visit.t_visit_id','t_visit_payment.t_visit_id')
                ->where('b_item_subgroup.f_item_group_id', 6)
                ->where('t_visit.f_visit_type_id', 0)
                ->where('t_visit.f_visit_status_id','!=', 4)
                ->where('t_order.f_order_status_id','!=', 3)
                ->where('t_visit_payment.visit_payment_priority', 0)
                ->where('t_visit_payment.visit_payment_active', 1)
                ->whereRaw("SUBSTRING(t_visit.visit_financial_discharge_time,1,10)= '$sNew'")
                ->count();

        $pipd = DB::select(DB::raw("SELECT SUM(q1.val) AS total
            FROM
            (SELECT SUM(order_price * order_qty) as val
            FROM t_patient
            INNER JOIN t_visit ON t_patient.t_patient_id = t_visit.t_patient_id
            INNER JOIN t_order ON t_visit.t_visit_id = t_order.t_visit_id
            INNER JOIN f_visit_type ON f_visit_type.f_visit_type_id = t_visit.f_visit_type_id
            
            WHERE
            f_visit_type.f_visit_type_id = '1' AND 
            t_order.f_item_group_id = '1' AND
            t_order.f_order_status_id <> '3'
            AND SUBSTRING(t_visit.visit_financial_discharge_time,1,10) BETWEEN SUBSTRING('2564-10-01',1,10) AND SUBSTRING('2565-09-31',1,10)

            GROUP BY t_order.order_common_name ,order_qty ,order_date_time) as q1"));

        $popd = DB::select(DB::raw("SELECT SUM(q1.val) AS total
            FROM
            (SELECT SUM(order_price * order_qty) as val
            FROM t_patient
            INNER JOIN t_visit ON t_patient.t_patient_id = t_visit.t_patient_id
            INNER JOIN t_order ON t_visit.t_visit_id = t_order.t_visit_id
            INNER JOIN f_visit_type ON f_visit_type.f_visit_type_id = t_visit.f_visit_type_id

            WHERE
            f_visit_type.f_visit_type_id = '0' AND 
            t_order.f_item_group_id = '1' AND
            t_order.f_order_status_id <> '3'
            AND SUBSTRING(t_visit.visit_financial_discharge_time,1,10) BETWEEN SUBSTRING('2564-10-01',1,10) AND SUBSTRING('2565-09-31',1,10)

            GROUP BY t_order.order_common_name ,order_qty ,order_date_time) as q1"));

        $er = DB::table('t_visit')
                ->join('t_patient','t_visit.t_patient_id','t_patient.t_patient_id')
                ->join('t_diag_icd10','t_visit.t_visit_id','t_diag_icd10.diag_icd10_vn')
                ->join('t_visit_service','t_visit.t_visit_id','t_visit_service.t_visit_id')
                ->where('t_visit.f_visit_status_id','!=',4)
                ->where('t_diag_icd10.diag_icd10_active',1)
                ->whereRaw("t_visit_service.b_service_point_id in ('2409144269314')")
                ->whereRaw("t_visit.f_visit_status_id in ('2','3')")
                ->whereRaw("SUBSTRING(t_visit.visit_financial_discharge_time,1,10)= '$sNew'")
                ->count();

        return view('index',['result'=>$result,'opd'=>$opd,'daily'=>$daily,'ward'=>$ward,'dent'=>$dent,'pipd'=>$pipd,'popd'=>$popd,'er'=>$er]);
    }
}
