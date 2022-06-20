<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class person extends Controller
{
    public function gender()
    {
        $person = DB::select(DB::raw("SELECT
            case when length(t_health_village.village_moo) = 1 then '0' || t_health_village.village_moo else t_health_village.village_moo  end AS moo,
            public.t_health_village.village_name AS mname,
            count(t_health_family.t_health_family_id) AS total,
            sum(case when t_health_family.f_sex_id = '1' then 1 else 0 end) AS male,
            sum(case when t_health_family.f_sex_id = '2' then 1 else 0 end) AS female
        FROM
          t_health_family
            INNER JOIN t_health_home ON (t_health_family.t_health_home_id = t_health_home.t_health_home_id)
            INNER JOIN public.t_health_village ON (t_health_home.t_health_village_id = t_health_village.t_health_village_id ) 
            WHERE t_health_family.patient_birthday <> '' and t_health_village.village_moo <> '0'
        GROUP BY mname,moo"));

        $gender = DB::select(DB::raw("SELECT
            sum(case when t_health_family.f_sex_id = '1' then 1 else 0 end) AS male,
            sum(case when t_health_family.f_sex_id = '2' then 1 else 0 end) AS female
        FROM
        t_health_family
            INNER JOIN t_health_home ON (t_health_family.t_health_home_id = t_health_home.t_health_home_id)
            INNER JOIN public.t_health_village ON (t_health_home.t_health_village_id = t_health_village.t_health_village_id ) 
            WHERE t_health_family.patient_birthday <> '' and t_health_village.village_moo <> '0'"));
            
        return view('person.people',['person'=>$person,'gender'=>$gender]);
    }
}
