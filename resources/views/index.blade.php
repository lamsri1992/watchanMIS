@extends('layouts.app')
@section('content')
@foreach ($popd as $resOpd)  @endforeach
@foreach ($pipd as $resIpd)  @endforeach
<div class="container-fluid">
    @php $sum = 0; @endphp
    @foreach ($result as $res)
    @php $sum += $res->budget @endphp
    @endforeach
    <div class="row">
        <div class="col-xl-12">
            <h6 class="m-0 font-weight-bold text-dark mb-2">
                <i class="fa-solid fa-calendar-day"></i>
                ข้อมูลการรับบริการประจำวันที่ {{ DateThai(date('Y-m-d')) }}
            </h6>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="font-weight-bold text-success mb-1">
                                จำนวนผู้ป่วยนอก
                            </div>
                            <div class="h2 mb-0 font-weight-bold text-gray-800">
                                {{ $daily ." คน"}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-hospital-user fa-3x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="font-weight-bold text-warning mb-1">
                                จำนวนผู้ป่วยใน
                            </div>
                            <div class="h2 mb-0 font-weight-bold text-gray-800">
                                {{ $ward }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-bed fa-3x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="font-weight-bold text-info mb-1">
                                จำนวนผู้ป่วยทันตกรรม
                            </div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">
                                {{ $dent }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-tooth fa-3x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="font-weight-bold text-danger mb-1">
                                จำนวนผู้ป่วยฉุกเฉิน
                            </div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">
                                {{ $er }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-truck-medical fa-3x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow mb-3">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-dark">
                <i class="fa-regular fa-clipboard"></i>
                รายงานค่าใช้จ่ายตามสิทธิ์ ประจำปีงบประมาณ 2565
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach ($result as $res)            
                <div class="col-xl-4 col-md-6 mb-3">
                    <div class="card shadow h-100 py-2 bg-secondary">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-white mb-1">
                                        <span style="font-size: 13px;">
                                            {{ $res->plan }}
                                        </span>
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-white">
                                        {{ "฿ ".number_format($res->budget,2) }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-comment-dollar fa-3x text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="alert alert-secondary text-center" role="alert">
                <h5 class="font-weight-bold" style="margin-top: 0.5rem;">
                    ยอดรวมทั้งหมด : 
                    <span class="text-primary">
                        {{ "฿ ".number_format($sum,2) }}
                    </span>
                </h5>
            </div>
        </div>
    </div>
    <div class="row" style="margin-bottom: 1rem;">
        <div class="col-xl-8 col-lg-8">
            <div class="card shadow mb-3" style="height: 100%;">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark">
                        <i class="fa-solid fa-chart-line"></i>
                        แผนภูมิแสดงค่ารักษาพยาบาลผู้ป่วยนอก ประจำปีงบประมาณ 2565 : 10 อันดับ
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4">
            <div class="card shadow mb-3" style="height: 100%;">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark">
                        <i class="fa-solid fa-chart-line"></i>
                        แผนภูมิแสดงมูลค่ายารักษาผู้ป่วย
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="drugChart"></canvas><br>
                    <div class="alert alert-secondary text-center" role="alert">
                        <span class="font-weight-bold" style="margin-top: 0.5rem;">
                            ยอดรวมทั้งหมด : 
                            <span class="text-primary">
                                {{ "฿ ".number_format($resOpd->total + $resIpd->total,2) }}
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    const labels = [
        @foreach ($opd as $res)
        [ "{{ $res->plan }}"],
        @endforeach         
    ];
  
    const config = {
      type: 'bar',
      data: {
        datasets: [{
            label: 'ค่ารักษาพยาบาล',
            data: [
                @foreach ($opd as $res)
                "{{ $res->total }}",
                @endforeach
            ],
            backgroundColor: [
                'rgb(75, 192, 192)',
            ],
            borderColor: [
                'rgb(75, 192, 192)',
            ],
        },{
            label: 'ผู้ป่วยชำระ',
            data: [
                @foreach ($opd as $res)
                "{{ $res->paid }}",
                @endforeach
            ],
            backgroundColor: [
                'rgba(255, 205, 86)',
            ],
            borderColor: [
                'rgba(255, 205, 86)',
            ],
        },{
            label: 'ค้างชำระ',
            data: [
                @foreach ($opd as $res)
                "{{ $res->stuck }}",
                @endforeach
            ],
            backgroundColor: [
                'rgb(255, 99, 132)',
            ],
            borderColor: [
                'rgb(255, 99, 132)',
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
<script>
    const dataDrug = {
    labels: [
        'ผู้ป่วยนอก',
        'ผู้ป่วยใน'
    ],
    datasets: [{
        label: 'มูลค่ายารักษาผู้ป่วย',
        data: ["{{ $resOpd->total }}", "{{ $resIpd->total }}"],
        backgroundColor: [
            'rgb(75, 192, 192)',
            'rgb(255, 205, 86)'
        ],
            hoverOffset: 4
        }]
    };

    const configDrug = {
        type: 'doughnut',
        data: dataDrug,
    };

    const drugChart = new Chart(
        document.getElementById('drugChart'),
        configDrug
    );
</script>
@endsection
