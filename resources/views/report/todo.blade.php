@extends('layouts.app')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-dismissible fade show" role="alert" style="background-color: gray">
                <span class="font-weight-bold">
                    <i class="fa-solid fa-list-check"></i>
                    Todo List : รายการที่ต้องเคลมวันนี้ {{ count($result) }} ราย
                </span>
            </div>
            <div class="card">
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
                            </tr>
                        </thead>
                        <tbody>
                            @php $cost = 0; @endphp
                            @foreach ($result as $res)
                            @php $cost += $res->visit_cost @endphp
                            <tr class="text-center">
                                <td>{{ $res->visit_date }}</td>
                                <td>{{ $res->visit_pid }}</td>
                                <td>{{ $res->visit_hn }}</td>
                                <td>{{ $res->visit_plan }}</td>
                                <td class="text-left">{{ $res->visit_patient }}</td>
                                <td>{{ $res->visit_age }}</td>
                                <td>{{ $res->visit_icd10 }}</td>
                                <td class="text-right">{{ number_format($res->visit_cost,2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="font-weight-bold">
                                <td class="text-right" colspan="4">
                                    รวมค่ารักษาพยาบาล
                                </td>
                                <td class="text-left" colspan="5">
                                    {{ number_format($cost,2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div style="margin-top: -1rem;">
                <button id="sendData" class="btn btn-info">
                    <i class="fa-solid fa-send"></i>
                    ส่งข้อมูล
                </button>
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
                                timer: 3000
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
