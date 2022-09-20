@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4" style="height: 100%;">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark">
                        <i class="fa-solid fa-clipboard-check"></i>
                        รายงานข้อมูลการเข้ารับบริการ
                    </h6>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card-body" style="font-size: 14px;">
                            <div class="alert alert-success" role="alert">
                                <div class="row">
                                    <div class="col-md-4">
                                        <span class="font-weight-bold">
                                            <i class="fa-regular fa-calendar-check"></i>
                                            วันที่
                                        </span>
                                        <ul>
                                            <li>
                                                {{ DateThai($_REQUEST['start']) ." ถึง ".DateThai($_REQUEST['end']) }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-2">
                                        <span class="font-weight-bold">
                                            <i class="fa-regular fa-square-check"></i>
                                            สิทธิ์ที่เลือก
                                        </span>
                                        <ul>
                                            @foreach ($splan as $plan)
                                                <li>{{ $plan->contract_plans_description }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-md-2">
                                        <i class="fa-regular fa-rectangle-xmark"></i>
                                        <span class="font-weight-bold">ICD10 ที่คัดออก</span>
                                        @php $icd = explode(",",$icds); @endphp
                                        <ul>
                                            @foreach ($icd as $res)
                                                <li>{{ $res }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-md-2">
                                        <i class="fa-regular fa-check-square"></i>
                                        <span class="font-weight-bold">ICD10 ที่ระบุ</span>
                                        @php $gicd = explode(",",$gicds); @endphp
                                        <ul>
                                            @foreach ($gicd as $res)
                                                <li>{{ $res }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-md-2">
                                        <i class="fa-regular fa-hospital"></i>
                                        <span class="font-weight-bold">ประเภทผู้ป่วย</span>
                                        <ul>
                                            @if ($_REQUEST['vtype'] == 0)
                                            <li>ผู้ป่วยนอก</li>
                                            @else
                                            <li>ผู้ป่วยใน</li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12">
                        <div class="card-body">
                            <table class="table table-borderless table-striped tableExport" style="font-size: 14px;">
                                <thead class="thead-dark">
                                    <tr class="text-center">
                                        <th>วันที่เข้ารับบริการ</th>
                                        <th>หมายเลข 13 หลัก</th>
                                        <th>HN</th>
                                        <th>สิทธิ์รักษา</th>
                                        <th class="text-left">ผู้ป่วย</th>
                                        <th>อายุ</th>
                                        <th>ICD10</th>
                                        <th>ค่ารักษา</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $cost = 0; @endphp
                                    @foreach ($data as $res)
                                    @php $cost += $res->visit_cost @endphp
                                    <tr class="text-center">
                                        <td>{{ $res->visit_date }}</td>
                                        <td>{{ $res->visit_pid }}</td>
                                        <td>{{ $res->visit_hn }}</td>
                                        <td>{{ $res->visit_plan }}</td>
                                        <td class="text-left">{{ $res->visit_patient }}</td>
                                        <td>{{ $res->visit_age }}</td>
                                        <td>{{ $res->visit_icd10 }}</td>
                                        <td class="text-right">
                                            {{ number_format($res->visit_cost,2) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="font-weight-bold">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-center">
                                            รวมค่ารักษาพยาบาล
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($cost,2)." ฿" }}
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="card-body">
                            <button id="sendData" class="btn btn-success">
                                <i class="fa-solid fa-paper-plane"></i>
                                ส่งข้อมูล
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
        $(document).ready(function() {
        var table = $('.tableExport').DataTable();
        $('.tableExport tbody').on( 'click', 'tr', function () {
            $(this).toggleClass('selected');

        });
    
        $('#sendData').click( function () {
            var token = "{{ csrf_token() }}";
            var array = [];

            table.rows('.selected').every(function(rowIdx) {
                array.push(table.row(rowIdx).data())
            })
            var formData = array;
        Swal.fire({
            icon: 'warning',
            title: 'ยืนยันการส่งข้อมูล ?',
            text: 'จำนวนข้อมูลที่เลือก '+ table.rows('.selected').data().length +' รายการ',
            showCancelButton: true,
            confirmButtonText: `ส่งข้อมูล`,
            cancelButtonText: `ยกเลิก`,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'กำลังส่งชุดข้อมูล',
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading()
                            const b = Swal.getHtmlContainer().querySelector('b')
                        },
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {}
                    })
                    $.ajax({
                        url: "{{ route('sendData') }}",
                        method:'POST',
                        data:{formData: formData,_token: token},
                        success: function (result) {
                            Swal.fire({
                                icon: 'success',
                                title: 'สำเร็จ',
                                text: 'จำนวนข้อมูลที่ถูกส่ง '+ table.rows('.selected').data().length +' รายการ',
                                showConfirmButton: false,
                                // timer: 3000
                            })
                        },
                         error: function (jqXHR, textStatus, errorThrown) {
                            Swal.fire({
                                icon: 'error',
                                title: 'พบข้อผิดพลาด',
                                text: 'Error: ' + textStatus + ' - ' + errorThrown,
                            })
                        }
                    });
                }
            })
        });
    });
</script>
@endsection
