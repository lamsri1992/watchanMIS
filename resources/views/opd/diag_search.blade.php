@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row" style="margin-bottom: 1rem;">
        <div class="col-xl-9 col-lg-9">
            <div class="card shadow" style="height: 100%;">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark">
                        <i class="fa-regular fa-calendar-check"></i>
                        10 อันดับโรคผู้ป่วยนอก :
                        {{ DateThai(request('start'))." ถึง ".DateThai(request('end')) }}
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="myChart"></canvas>
                    <br>
                    <div class="alert alert-success">
                        @php $sum = 0; @endphp
                        @foreach ($diag as $res)
                            @php $sum += $res->total @endphp
                        @endforeach
                       <div class="text-center font-weight-bold">
                           <i class="fa-solid fa-clipboard-check"></i>
                           รวมทั้งหมด : 
                           {{ number_format($sum) }}
                           ครั้ง
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3">
            <div class="card shadow" style="height: 100%;">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark">
                        <i class="fa-solid fa-search"></i>
                        ค้นหาข้อมูล
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('searchDiag') }}">
                        <div class="form-group">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa-regular fa-calendar"></i>
                                    </div>
                                </div>
                                <input type="text" class="form-control basicDate" name="start" placeholder="วันที่เริ่มต้น" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa-regular fa-calendar"></i>
                                    </div>
                                </div>
                                <input type="text" class="form-control basicDate" name="end" placeholder="วันที่สิ้นสุด" readonly>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-secondary btn-sm">
                                <i class="fa-solid fa-search"></i>
                                ค้นหา
                            </button>
                            <button type="reset" class="btn btn-danger btn-sm">
                                <i class="fa-solid fa-times-circle"></i>
                                ล้างค่า
                            </button>
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
    const labels = [
        @foreach ($diag as $res)
        [ "{{ $res->icdname }}"],
        @endforeach
    ];
  
    const config = {
      type: 'bar',
      data: {
        datasets: [{
            label: 'จำนวน/ครั้ง',
            data: [
                @foreach ($diag as $res)
                "{{ $res->total }}",
                @endforeach
            ],
            backgroundColor: [
                'rgba(255, 205, 86)',
            ],
            borderColor: [
                'rgba(255, 205, 86)',
            ],
        }],
        labels: labels
    },
      options: {}
    };

    $(document).ready(function () {
        Chart.defaults.font.family = 'Prompt';
    });

    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
</script>
@endsection
