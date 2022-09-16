@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row" style="margin-bottom: 1rem;">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4" style="height: 100%;">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark">
                        <i class="fa-solid fa-clipboard"></i>
                        รายการเคลมรอดำเนินการ
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
                                <th class="text-center">
                                    <i class="fa-solid fa-bars"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $cost = 0; @endphp
                            @foreach ($list as $res)
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
                                    <a href="#" class="btn btn-success btn-sm" data-id="{{ $res->id }}"
                                        onclick="
                                            var id = $(this).attr('data-id');
                                                event.preventDefault();
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'ยืนยันการดำเนินการ ?',
                                                    text: '{{ 'HN : '.$res->visit_hn }}',
                                                    showCancelButton: true,
                                                    confirmButtonText: `ยืนยัน`,
                                                    cancelButtonText: `ยกเลิก`,
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        $.ajax({
                                                            url: '{{ route('claim.confirm',$res->id) }}',
                                                            success: function (data) {
                                                                Swal.fire({
                                                                    icon: 'success',
                                                                    title: 'ดำเนินการเสร็จสิ้น',
                                                                    showConfirmButton: false,
                                                                    timer: 3000
                                                                })
                                                                window.setTimeout(function () {
                                                                    location.reload()
                                                                }, 1500);
                                                            }
                                                        });
                                                    }
                                                });">
                                        <i class="fa-solid fa-circle-check"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-sm" data-id="{{ $res->id }}"
                                        onclick="
                                        var id = $(this).attr('data-id');
                                            event.preventDefault();
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'ยืนยันการดำเนินการ ?',
                                                showCancelButton: true,
                                                confirmButtonText: `ยืนยัน`,
                                                cancelButtonText: `ยกเลิก`,
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    $.ajax({
                                                        url: '{{ route('claim.decline',$res->id) }}',
                                                        success: function (data) {
                                                            Swal.fire({
                                                                icon: 'error',
                                                                title: 'ดำเนินการเสร็จสิ้น',
                                                                showConfirmButton: false,
                                                                timer: 3000
                                                            })
                                                            window.setTimeout(function () {
                                                                location.reload()
                                                            }, 1500);
                                                        }
                                                    });
                                                }
                                            });">
                                        <i class="fa-solid fa-circle-xmark"></i>
                                    </a>
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
