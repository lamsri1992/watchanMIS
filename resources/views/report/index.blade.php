@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row" style="margin-bottom: 1rem;">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4" style="height: 100%;">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark">
                        <i class="fa-solid fa-clipboard-check"></i>
                        รายงานข้อมูลการเข้ารับบริการ
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ url('report/process') }}">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="">
                                    <i class="fa-solid fa-file-medical text-secondary"></i>
                                    เลือกสิทธิ์การรักษา 
                                    <small class="text-danger">** สามารถเลือกได้มากกว่า 1 สิทธิ์ **</small>
                                </label>
                                <select name="plan[]" class="basic-multiple" multiple="multiple">
                                    <optgroup label="สิทธิ์การรักษา HospitalOS">
                                        @foreach ($plan as $res)
                                        <option value="{{ $res->b_contract_plans_id }}">
                                            {{ "• ".$res->contract_plans_description }}
                                        </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="">
                                    <i class="fa-solid fa-times-square text-danger"></i>
                                    เลือกรหัสโรคที่ไม่ต้องการ : ICD10
                                    <small class="text-danger">** หากต้องการกรองจากรหัสโรคทั้งหมดให้เว้นว่างไว้ **</small>
                                </label>
                                <select name='icd10[]' class="icd10" multiple="multiple"></select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="">
                                    <i class="fa-solid fa-check-square text-success"></i>
                                    เลือกรหัสโรคที่ต้องการ : ICD10
                                    <small class="text-danger">** หากต้องการกรองจากรหัสโรคทั้งหมดให้เว้นว่างไว้ **</small>
                                </label>
                                <select name='gicd10[]' class="icd10" multiple="multiple"></select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="">
                                    <i class="fa-regular fa-calendar"></i>
                                    เลือกวันที่
                                </label>
                                <div class="form-row">
                                    <div class="col-md-6">
                                      <input type="text" name="start" class="form-control basicDate" placeholder="วันที่เริ่มต้น" readonly>
                                    </div>
                                    <div class="col-md-6">
                                      <input type="text" name="end" class="form-control basicDate" placeholder="วันที่สิ้นสุด" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label for="">
                                    <i class="fa-regular fa-hospital"></i>
                                    เลือกประเภทผู้ป่วย
                                </label>
                                <label class="form-control">
                                    <input type="radio" name="vtype" value="0"> ผู้ป่วยนอก
                                </label>
                                <label class="form-control">
                                    <input type="radio" name="vtype" value="1"> ผู้ป่วยใน
                                </label>
                            </div>
                            <div class="form-group col-12">
                                <button type="submit" class="btn btn-success"
                                onclick="
                                    let timerInterval
                                    Swal.fire({
                                        title: 'กำลังสร้างรายงานข้อมูล',
                                        html: 'Query Loading...',
                                        timerProgressBar: true,
                                        didOpen: () => {
                                            Swal.showLoading()
                                            const b = Swal.getHtmlContainer().querySelector('b')
                                            timerInterval = setInterval(() => {
                                            b.textContent = Swal.getTimerLeft()
                                            }, 100)
                                        },
                                        willClose: () => {
                                            clearInterval(timerInterval)
                                        }
                                        }).then((result) => {
                                        /* Read more about handling dismissals below */
                                        if (result.dismiss === Swal.DismissReason.timer) {
                                            // console.log('I was closed by the timer')
                                        }
                                    })">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    เขียนรายงาน
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    // CSRF Token
    var token = "{{ csrf_token() }}";
    $(document).ready(function(){
        $( ".icd10" ).select2({
            ajax: { 
                url: "{{ route('report.getIcd10') }}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: token,
                        search: params.term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            },
            width: '100%',
        });
    });
</script>
@endsection
