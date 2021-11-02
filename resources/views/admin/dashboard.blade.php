@extends('layouts.admin')
@section('admin-content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">لوحة المدير</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fab fa-creative-commons-zero fa-sm text-white-50"></i> تصفير الخزنة</a>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-s font-weight-bold text-primary text-uppercase mb-1" style="color: #577AE1 !important;">
                                    مبيعات هذا الشهر
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$monthly_sells}} جنيه</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-money-bill-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-s font-weight-bold text-success text-uppercase mb-1">
                                    مبيعات هذا العام
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$yearly_sells}} جنيه</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- spent (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-x font-weight-bold text-danger text-uppercase mb-1">مصروفات هذا الشهر
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{__('2000')}}جنيه
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-list-ol fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- spent (yearly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-s font-weight-bold text-warning text-uppercase mb-1">
                                    مصروفات هذا العام
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{__('30000')}} جنيه</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->

        <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">نظرة عامة على الارباح</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="myAreaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
    @push('bottom-script')
        <script>
            // Area Chart Example
            var ctx = document.getElementById("myAreaChart");
            var myLineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ["يناير", "فبراير", "مارس", "ابريل", "مايو", "يونيو", "يوليو", "اغسطس", "سبنمبر", "اكتوبر", "نوفمبر", "ديسمبر"],
                    datasets: [{
                        label: "الارباح",
                        lineTension: 0.3,
                        backgroundColor: "rgba(78,115,223,0.3)",
                        borderColor: "#157B9A",
                        pointRadius: 3,
                        pointBackgroundColor: "#4aa9c6",
                        pointBorderColor: "#4aa9c6",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "#084658",
                        pointHoverBorderColor: "#084658",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: [{{$arr[0]}}, {{$arr[1]}}, {{$arr[2]}}, {{$arr[3]}}, {{$arr[4]}}, {{$arr[5]}}, {{$arr[6]}}, {{$arr[7]}}, {{$arr[8]}}, {{$arr[9]}}, {{$arr[10]}}, {{$arr[11]}}],
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            left: 10,
                            right: 25,
                            top: 25,
                            bottom: 0
                        }
                    },
                    scales: {
                        xAxes: [{
                            time: {
                                unit: 'date'
                            },
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                maxTicksLimit: 7
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                maxTicksLimit: 6,
                                padding: 10,
                                // Include a dollar sign in the ticks
                                callback: function (value, index, values) {
                                    return number_format(value) + ' جنيه';
                                }
                            },
                            gridLines: {
                                color: "rgb(234, 236, 244)",
                                zeroLineColor: "rgb(234, 236, 244)",
                                drawBorder: false,
                                borderDash: [2],
                                zeroLineBorderDash: [2]
                            }
                        }],
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        titleMarginBottom: 10,
                        titleFontColor: '#6e707e',
                        titleFontSize: 14,
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        intersect: false,
                        mode: 'index',
                        caretPadding: 10,
                        callbacks: {
                            label: function (tooltipItem, chart) {
                                var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                                return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
@endsection
