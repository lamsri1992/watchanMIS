@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row" style="margin-bottom: 1rem;">
        <div class="col-xl-12 col-lg-12">
            <div  style="margin-bottom: 1rem;">
                <h6 class="m-0 font-weight-bold text-dark">
                    <i class="fa-solid fa-clipboard-check"></i>
                    สรุปยอดรายการเคลมค่ารักษาพยาบาล
                </h6>
            </div>
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-bottom-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                        ทั้งหมด
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <a href="#">
                                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                    {{ count($all) }} รายการ
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-clipboard fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-bottom-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                        รอดำเนินการ
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <a href="{{ url('/claim/list') }}">
                                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                    {{ count($list) }} รายการ
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-spinner fa-spin fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-bottom-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                        ดำเนินการแล้ว
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <a href="#">
                                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                    {{ count($res) }} รายการ
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-clipboard-check fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-bottom-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                        ค้างชำระ
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <a href="#">
                                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                    {{ count($lost) }} รายการ
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-circle-exclamation fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4" style="height: 100%;">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark">
                        <i class="fa-solid fa-clipboard-check"></i>
                        รายการเคลมทั้งหมด
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-striped tableExport">
                        <thead class="thead-dark">
                            <tr class="text-center">
                                <th>วันที่</th>
                                <th>CID</th>
                                <th>HN</th>
                                <th>สิทธิ์รักษา</th>
                                <th class="text-left">ผู้ป่วย</th>
                                <th>อายุ</th>
                                <th>ICD10</th>
                                <th>ค่ารักษา</th>
                                <th class="text-center">สถานะ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $cost = 0; @endphp
                            @foreach ($all as $res)
                            @php $cost += $res->visit_cost @endphp
                            <tr class="text-center">
                                <td>{{ $res->visit_date }}</td>
                                <td>{{ $res->visit_pid }}</td>
                                <td>{{ $res->visit_hn }}</td>
                                <td>{{ $res->visit_plan }}</td>
                                <td class="text-left">{{ $res->visit_patient }}</td>
                                <td>{{ $res->visit_age }}</td>
                                <td>{{ $res->visit_icd10 }}</td>
                                <td class="text-right">{{ number_format($res->visit_cost,2) }} ฿</td>
                                <td class="text-center">
                                    {!! $res->sta_icon !!}
                                    {{ $res->sta_name }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="font-weight-bold">
                                <td class="text-right" colspan="5">
                                    รวมค่ารักษาพยาบาล
                                </td>
                                <td class="text-left" colspan="4">
                                    {{ number_format($cost,2) }} ฿
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
<script>

</script>
@endsection