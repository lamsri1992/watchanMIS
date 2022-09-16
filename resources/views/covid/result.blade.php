@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fa-solid fa-virus-covid"></i>
                        รายงานข้อมูลเคลม Covid-19
                    </h5>
                    <p class="text-muted">
                        {{ DateThai($_REQUEST['start']) ." ถึง ".DateThai($_REQUEST['end']) }}
                    </p>
                    <p class="text-danger">
                        LAB : SARS coronavirus 2, Ag [+/-] in Respiratory specimen by Chromatography ที่มีผลเป็น Negative
                    </p>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-striped tableExport">
                        <thead class="thead-dark">
                            <tr class="text-center">
                                <th>วันที่เข้ารับบริการ</th>
                                <th>13 หลัก</th>
                                <th>HN</th>
                                <th>สิทธิ์รักษา</th>
                                <th class="text-left">ผู้ป่วย</th>
                                <th>ผล</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $res)
                            <tr class="text-center">
                                <td>{{ $res->visit_date }}</td>
                                <td>{{ $res->visit_pid }}</td>
                                <td>{{ $res->visit_hn }}</td>
                                <td>{{ $res->visit_plan }}</td>
                                <td class="text-left">{{ $res->visit_patient }}</td>
                                <td>{{ $res->lab_result }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="stats"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

@endsection
