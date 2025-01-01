@extends('backEnd.layouts.master')
@section('title', 'Dashboard')
@section('css')
    <!-- Plugins css -->
    <link href="{{ asset('public/backEnd/') }}/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backEnd/') }}/assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet"
        type="text/css" />

@endsection
@section('content')
    <!-- Start Content-->
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">

                    </div>
                    <h4 class="page-title">Dashboard</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                
                                    <h3 class="text-dark my-1 taka-sign"><span data-plugin="counterup">{{ $total_sale }}</span></h3>
                                    <p class="text-muted mb-1 text-truncate">Total Sales</p>
                                
                            </div>
                            <div class="col-6">
                                <div class="float-right">
                                    <div class="avatar-sm bg-blue rounded">
                                        <i class="fe-pie-chart avatar-title font-22 text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end widget-rounded-circle-->
            </div> <!-- end col-->
            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h3 class="text-dark my-1 taka-sign"><span data-plugin="counterup">{{ $current_month_sale }}</span></h3>
                                <p class="text-muted mb-1 text-truncate">This Month Sales</p>
                            </div>
                            <div class="col-6">
                                <div class="float-right">
                                    <div class="avatar-sm bg-blue rounded">
                                        <i class="fe-bar-chart-2 avatar-title font-22 text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col-->
            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h3 class="text-dark my-1 taka-sign"><span data-plugin="counterup">{{ $today_sales }}</span></h3>
                                <p class="text-muted mb-1 text-truncate">Today Sales</p>
                            </div>
                            <div class="col-6">
                                <div class="float-right">
                                    <div class="avatar-sm bg-blue rounded">
                                        <i class="fe-activity avatar-title font-22 text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col-->
            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h3 class="text-dark my-1"><span data-plugin="counterup">{{ $total_order }}</span></h3>
                                <p class="text-muted mb-1 text-truncate">Total Order</p>
                            </div>
                            <div class="col-6">
                                <div class="float-right">
                                    <div class="avatar-sm bg-blue rounded">
                                        <i class="fe-shopping-cart avatar-title font-22 text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col-->
            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h3 class="text-dark my-1"><span data-plugin="counterup">{{ $current_month_order }}</span></h3>
                                <p class="text-muted mb-1 text-truncate">This Month Orders</p>
                            </div>
                            <div class="col-6">
                                <div class="float-right">
                                    <div class="avatar-sm bg-blue rounded">
                                        <i class="fe-database avatar-title font-22 text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col-->
            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h3 class="text-dark my-1"><span data-plugin="counterup">{{ $total_customer }}</span></h3>
                                <p class="text-muted mb-1 text-truncate">Customers</p>
                            </div>
                            <div class="col-6">
                                <div class="float-right">
                                    <div class="avatar-sm bg-blue rounded">
                                        <i class="fe-users avatar-title font-22 text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col-->
        </div>
        <!-- end row-->

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-0">Last 30 days sales reports</h4>
                        <canvas id="paymentsChart" width="600" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="widget-rounded-circle card bg-primary">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-12">
                                <div class="text-start">
                                    <h3 class="text-dark mt-1 text-white"><span
                                            data-plugin="counterup">{{ $total_order }}</span></h3>
                                    <p class="text-dark mb-1 text-truncate text-white">Total</p>
                                </div>
                            </div>
                        </div> <!-- end row-->
                    </div>
                </div> <!-- end widget-rounded-circle-->
            </div> <!-- end col-->
            @foreach ($order_statuses as $key => $status)
                <div class="col-md-6 col-xl-3">
                    <div class="widget-rounded-circle card {{$status->color}}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="text-start">
                                        <h3 class="text-dark mt-1 text-white"><span
                                                data-plugin="counterup">{{ $status->orders_count }}</span></h3>
                                        <p class="text-dark mb-1 text-truncate text-white">{{ $status->name }}</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div>
                    </div> <!-- end widget-rounded-circle-->
                </div> <!-- end col-->
            @endforeach

        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                             <h4 class="header-title mt-1">Stock Alert Products</h4>
                         </div>
                            <div class="col-sm-6 text-end">
                                 <a href="{{route('products.stock_alert')}}" class="btn btn-success rounded-pill"><i class="fe-danger"></i> View All</a>
                            </div>
                        </div>
                       
                        <div class="table-responsive">
                            <table class="table table-borderless table-hover table-nowrap table-centered m-0">

                                <thead class="table-light">
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Size</th>
                                        <th>Color</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td><img src="{{ asset($product->image?$product->image->image:'')}}" class="rounded-circle avatar-sm" />
                                            </td>
                                            <td>{{ $product->name}}</td>
                                            <td>N/A</td>
                                            <td>N/A</td>
                                            <td>{{$product->new_price}}</td>
                                            <td>{{$product->stock}}</td>
                                            <td><a href="{{route('products.purchase_create')}}"><i class="fe-shopping-bag"></i></a></td>
                                        </tr>
                                    @endforeach
                                    @foreach ($variables as $variable)
                                        <tr>
                                            <td><img src="{{ asset($variable->image?$variable->image:'')}}" class="rounded-circle avatar-sm" />
                                            </td>
                                            <td>{{ Str::limit($variable->product->name,50)}}</td>
                                            <td>{{$variable->size ?? 'N/A'}}</td>
                                            <td>{{$variable->color ??  'N/A'}}</td>
                                            <td>{{$variable->product->new_price}}</td>
                                            <td>{{$variable->stock}}</td>
                                            <td><a href="{{route('products.purchase_create')}}"><i class="fe-shopping-bag"></i></a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container -->
@endsection
@section('script')
    <!-- Plugins js-->
    <script src="{{ asset('public/backEnd/') }}/assets/libs/flatpickr/flatpickr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('paymentsChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! $dates_json !!}, // X-axis labels (dates)
                datasets: [{
                    label: 'Last 30 days sales reports',
                    data: {!! $totals_json !!}, // Y-axis data (payments)
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: {
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection

