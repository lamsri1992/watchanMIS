@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row" style="margin-bottom: 1rem;">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4" style="height: 100%;">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark">
                        <i class="fa-solid fa-clipboard"></i>
                        รายงานลูกหนี้ {{ (request('fi_type') == 1) ? 'IPD':'OPD' }} : 
                        {{ DateThai(request('start'))." ถึง ".DateThai(request('end')) }}
                    </h6>
                </div>
                <div class="card-body">
                    <table id="tableExport" class="table table-borderless table-striped display nowrap" style="font-size: 13px;">
                        <thead class="thead-dark">
                            <tr class="text-center">
                                <th>วันที่</th>
                                <th>HN</th>
                                <th>VN</th>
                                <th class="text-left">ผู้ป่วย</th>
                                <th class="text-left">สิทธิ์รักษา</th>
                                <th class="">กลุ่มสิทธิ์</th>
                                <th>อายุ</th>
                                <th>ICD10</th>
                                <th class="text-right">ค่ารักษา</th>
                            </tr>
                        </thead>
                        <tbody class="text-dark">
                            @php $cost = 0; @endphp
                            @foreach ($data as $res)
                            @php $cost += $res->visit_cost @endphp
                            <tr class="text-center">
                                <td>{{ $res->visit_date }}</td>
                                <td>{{ $res->visit_vn }}</td>
                                <td>{{ $res->visit_hn }}</td>
                                <td class="font-weight-bold text-left">{{ $res->visit_patient }}</td>
                                <td class="text-left">{{ $res->visit_plan }}</td>
                                <td class="">{{ $res->visit_plan_main }}</td>
                                <td>{{ $res->visit_age }}</td>
                                <td class="font-weight-bold text-primary">
                                    {{ $res->visit_icd10 }}
                                </td>
                                <td class="text-right font-weight-bold text-danger">
                                    {{ number_format($res->visit_cost,2)." ฿" }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="font-weight-bolder">
                                <td class="text-center" colspan="9" style="font-size: 16px;">
                                    รวมค่ารักษาพยาบาล 
                                    {{ number_format($cost,2)." ฿" }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

@endsection
