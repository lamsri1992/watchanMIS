@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row" style="margin-bottom: 1rem;">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4" style="height: 100%;">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark">
                        <i class="fa-solid fa-clipboard"></i>
                        รายการจัดซื้อ/จัดจ้าง
                    </h6>
                </div>
                <div class="card-body">
                    <table id="tableExport" class="table table-borderless table-striped display nowrap" style="font-size: 13px;">
                        <thead class="thead-dark">
                            <tr class="">
                                <th class="text-center">วันที่</th>
                                <th>กลุ่มงาน</th>
                                <th>รายละเอียด</th>
                                <th>ผู้ดำเนินการ</th>
                                <th class="text-center">สถานะ</th>
                            </tr>
                        </thead>
                        <tbody class="text-dark">
                            @php $cost = 0; @endphp
                            @foreach ($result as $res)
                            <tr class="">
                                <td class="text-center">{{ DateThai($res->DATE_REGIS) }}</td>
                                <td>{{ $res->DEP_REQUEST_NAME }}</td>
                                <td>{{ $res->CON_DETAIL }}</td>
                                <td>{{ $res->PERSON_REQUEST_NAME }}</td>
                                <td class="text-center">{{ $res->REGIS_STATUS_NAME }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

@endsection
