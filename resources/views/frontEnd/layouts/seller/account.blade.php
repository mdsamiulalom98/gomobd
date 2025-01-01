@extends('frontEnd.layouts.seller.master')
@section('title', 'Seller Account')
@section('css')
    <!-- Plugins css -->
    <link href="{{ asset('public/backEnd/') }}/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backEnd/') }}/assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet"
        type="text/css" />
@endsection
@section('content')
    <style>
        a.canvasjs-chart-credit {
            display: none !important;
        }

        .graph-pie {
            background: #fff;
            margin-bottom: 20px;
        }

        .des-item h5 {
            color: #979797;
        }

        .des-item h2 {
            font-weight: 800;
            color: #6a6a6a;
        }

        .chart-des {
            padding-top: 50px;
        }

        .inner-chart {
            position: absolute;
            top: 25%;
            left: 34%;
            opacity: 1;
            z-index: 9;
            text-align: center;
        }

        .inner-chart h5 {
            text-transform: capitalize;
        }

        .main-Pie {
            position: relative;
        }

        .ex-pro {
            margin-top: 14px;
            margin-left: 8px;
        }
    </style>
    <section class="seller-des">
        <h5 class="account-title">Dashboard</h5>

        <!-- graph pie section start -->
        <div class="row">
            <div class="col-sm-9 text-start">
                <form class="no-print mb-2">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" value="{{ request()->get('start_date') }}"
                                    class="form-control flatdate" name="start_date">
                            </div>
                        </div>
                        <!--col-sm-3-->
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" value="{{ request()->get('end_date') }}" class="form-control flatdate"
                                    name="end_date">
                            </div>
                        </div>
                        <!--col-sm-3-->
                        <div class="col-sm-2 text-start">
                            <div class="form-group mt-3">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        <!-- col end -->
                    </div>
                </form>
            </div>
            <!-- comission and condition start -->
            <div class="col-sm-3">
                <!-- modal-start -->
                <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
                    tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Commission & Conditions Rules</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                আপনার প্রতি প্রোডাক্ট এর লাভ এর উপর {{ Auth::guard('seller')->user()->commision }} পার্সেন্ট
                                টাকা কাটা হবে
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" data-bs-target="#exampleModalToggle2"
                                    data-bs-toggle="modal">I Agree</button>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-success mt-3" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Commission
                    & Conditions</button>
                <!-- modal-end -->
            </div>
            <!-- comission and condition end -->
        </div>
        <!--graph chart start -->
        <div class="graph-pie">
            <div class="row">
                <div class="col-sm-3 main-Pie">
                    <div id="chartContainer" style="height: 200px; width: 100%;"></div>
                    <a href="{{ route('seller.orders', ['slug' => 'all']) }}">
                        <div class="inner-chart">
                            <h5>total value</h5>
                            <h3> ৳ {{ number_format($total_amount) }}</h3>
                            <p>{{ $total_order }} Orders</p>
                        </div>
                    </a>
                </div>
                <!--end-col-->
                <div class="col-sm-9">
                    <div class="chart-des">
                        <!--new-row-start-->
                        <div class="row">
                            <div class="col-sm-4">
                                <a href="{{ route('seller.orders', ['slug' => 'completed']) }}">
                                    <div class="des-item" style="border-left:6px solid #21c624; padding-left:20px;">
                                        <h5>Delivered</h5>
                                        <h2>
                                            @if ($total_complete > 0)
                                                {{ number_format(($total_complete * 100) / $total_order, 2) }}
                                            @else
                                                0
                                            @endif%
                                        </h2>
                                        <h5>{{ $total_complete }} orders | ৳ {{ $delivery_amount }}</h5>
                                    </div>
                                </a>
                            </div>
                            <!--end-col-->
                            <div class="col-sm-4">
                                <a href="{{ route('seller.orders', ['slug' => 'in-courier']) }}">
                                    <div class="des-item" style="border-left:6px solid #ffcd00; padding-left:20px;">
                                        <h5>Delivery Processing</h5>
                                        <h2>
                                            @if ($total_process > 0)
                                                {{ number_format(($total_process * 100) / $total_order, 2) }}
                                            @else
                                                0
                                            @endif%
                                        </h2>
                                        <h5>{{ $total_process }} orders | ৳ {{ $process_amount }}</h5>
                                    </div>
                                </a>
                            </div>
                            <!--end-col-->
                            <div class="col-sm-4">
                                <a href="{{ route('seller.orders', ['slug' => 'returned']) }}">
                                    <div class="des-item" style="border-left:6px solid #ff4c49;padding-left:20px;">
                                        <h5>Returned</h5>
                                        <h2>
                                            @if ($total_return > 0)
                                                {{ number_format(($total_return * 100) / $total_order, 2) }}
                                            @else
                                                0
                                            @endif%
                                        </h2>
                                        <h5>{{ $total_return }} orders | ৳ {{ $return_amount }}</h5>
                                    </div>
                                </a>
                            </div>
                            <!--end-col-->
                        </div>
                        <!--new-row-end-->
                    </div>
                </div>
                <!--end-col-->
            </div>
            <!--end-row-->
        </div>

        <!--graph chart end -->

        <!--dashboard-short-view-start-->
        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="short-dashboard card">
                    <div class="card-body">
                        <a href="{{route('seller.payable.order')}}">
                            <div class="row">
                                <div class="col-6">
                                    <div
                                        class="avatar-lg dash-round front-dash bg-success bg-gradient bg-opacity-25 border-success border">
                                        <i class="fa-solid fa-coins text-success"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span
                                                data-plugin="counterup">{{ $payable_amount }}</span>
                                        </h3>
                                        <p class="text-end mb-1 dashborad-text">Balance</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </a>
                    </div>
                </div> <!-- end short-dashboard-->
            </div>
            <!-- end col-->
            <div class="col-md-6 col-xl-3">
                <div class="short-dashboard card">
                    <div class="card-body">
                        <a href="{{ route('seller.withdraw') }}">
                            <div class="row">
                                <div class="col-6">
                                    <div
                                        class="avatar-lg dash-round front-dash bg-warning bg-secondary bg-gradient bg-opacity-25 border-bg-secondary">
                                        <i class="fa-solid fa-list text-warning"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span
                                                data-plugin="counterup">{{ Auth::guard('seller')->user()->withdraw }}</span>
                                        </h3>
                                        <p class="text-end mb-1 dashborad-text">Withdraw</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </a>
                    </div>
                </div> <!-- end short-dashboard-->
            </div>
            <!-- end col-->
            <div class="col-md-6 col-xl-3">
                <div class="short-dashboard card">
                    <div class="card-body">
                        <a href="{{ route('seller.orders', ['slug' => 'completed']) }}">
                            <div class="row">
                                <div class="col-6">
                                    <div
                                        class="avatar-lg dash-round front-dash bg-danger  bg-danger  bg-gradient bg-opacity-25 border-bg-danger">
                                        <i class="fa-brands fa-sellcast text-danger "></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span
                                                data-plugin="counterup">{{ $delivery_amount }}</span></h3>
                                        <p class="text-end mb-1 dashborad-text">Total sell</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </a>
                    </div>
                </div> <!-- end short-dashboard-->
            </div>
            <!-- end col-->

            <div class="col-md-6 col-xl-3">
                <div class="short-dashboard card">
                    <div class="card-body">
                        <a href="{{route('seller.commission')}}">
                            <div class="row">
                                <div class="col-6">
                                    <div
                                        class="avatar-lg dash-round front-dash bg-primary bg-gradient bg-opacity-25 border-primary border">
                                        <i class="fa-solid fa-arrow-up-wide-short text-primary"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span
                                                data-plugin="counterup">{{ $total_comision }}</span></h3>
                                        <p class="text-end mb-1 dashborad-text">Commissions</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </a>
                    </div>
                </div> <!-- end short-dashboard-->
            </div>
            <!-- end col-->
        </div>
        <!-- end row-->
        <!--dashboard-short-view-end-->
    </section>

@endsection

@push('script')
    <script src="{{ asset('public/frontEnd/') }}/js/parsley.min.js"></script>
    <script src="{{ asset('public/frontEnd/') }}/js/form-validation.init.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/libs/selectize/js/standalone/selectize.min.js"></script>
    <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script src="https://cdn.canvasjs.com/jquery.canvasjs.min.js"></script>
    <script>
        window.onload = function() {

            var options = {
                animationEnabled: true,
                title: {
                    text: ""
                },
                data: [{
                    type: "doughnut",
                    innerRadius: "80%",
                    dataPoints: [{
                            label: "",
                            y: {{ $delivery_amount }},
                            color: "#21c624"
                        },
                        {
                            label: "",
                            y: {{ $process_amount }},
                            color: "#ffcd00"
                        },
                        {
                            label: "",
                            y: {{ $return_amount }},
                            color: "#ff4c49"
                        },

                    ]
                }]
            };
            $("#chartContainer").CanvasJSChart(options);

        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            flatpickr(".flatdate", {});
        });
    </script>
@endpush
