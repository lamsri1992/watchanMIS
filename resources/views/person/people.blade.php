@extends('layouts.app')
@section('content')
@foreach ($gender as $resGender) @endforeach
<div class="container-fluid">
    <div class="row" style="margin-bottom: 1rem;">
        <div class="col-xl-8 col-lg-8">
            <div class="card shadow mb-4" style="height: 100%;">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark">
                        <i class="fa-solid fa-house-user"></i>
                        แผนภูมิข้อมูลประชากรในเขตรับผิดชอบ
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4">
            <div class="card shadow mb-4" style="height: 100%;">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark">
                        <i class="fa-solid fa-venus-mars"></i>
                        แผนภูมิข้อมูลประชากรแยกตามเพศ
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="genderChart"></canvas><br>
                </div>
            </div>
        </div>
    </div>
    <div class="alert alert-success">
        @php $sum = 0; @endphp
        @foreach ($person as $res)
            @php $sum += $res->total @endphp
        @endforeach
        <div class="text-center font-weight-bold">
            <i class="fa-solid fa-address-book"></i>
            รวมทั้งหมด : 
            {{ number_format($sum) }}
            ราย
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    const labels = [
        @foreach ($person as $res)
        [ "{{ $res->mname }}"],
        @endforeach         
    ];
  
    const config = {
      type: 'bar',
      data: {
        datasets: [{
            label: 'จำนวนประชากร',
            data: [
                @foreach ($person as $res)
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
            label: 'เพศชาย',
            data: [
                @foreach ($person as $res)
                "{{ $res->male }}",
                @endforeach
            ],
            backgroundColor: [
                'rgba(255, 205, 86)',
            ],
            borderColor: [
                'rgba(255, 205, 86)',
            ],
        },{
            label: 'เพศหญิง',
            data: [
                @foreach ($person as $res)
                "{{ $res->female }}",
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
    const dataGender = {
    labels: [
        'เพศชาย',
        'เพศหญิง'
    ],
    datasets: [{
        data: ["{{ $resGender->male }}", "{{ $resGender->female }}"],
        backgroundColor: [
            'rgb(255, 205, 86)',
            'rgb(255, 99, 132)',
        ],
            hoverOffset: 4
        }]
    };

    const configGender = {
        type: 'doughnut',
        data: dataGender,
    };

    const genderChart = new Chart(
        document.getElementById('genderChart'),
        configGender
    );
</script>
@endsection
