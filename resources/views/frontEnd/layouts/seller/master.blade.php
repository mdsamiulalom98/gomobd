<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />

        <title>@yield('title') - {{$generalsetting->name}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset($generalsetting->favicon)}}">

		<!-- Bootstrap css -->
		<link href="{{asset('public/backEnd/')}}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<!-- App css -->

        <link rel="stylesheet" href="{{ asset('public/frontEnd/css/all.min.css') }}" />
		<link href="{{asset('public/backEnd/')}}/assets/css/app.min.css" rel="stylesheet" type="text/css"/>
		<!-- icons -->
		<link href="{{asset('public/backEnd/')}}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- toastr css -->
        <link rel="stylesheet" href="{{asset('public/backEnd/')}}/assets/css/toastr.min.css">
        <!-- custom css -->
        <link href="{{ asset('public/frontEnd/') }}/css/seller.css" rel="stylesheet" type="text/css" />
		<!-- Head js -->
        <style>
            .front-dash i {
                font-size: 30px;
                line-height: 70px;
            }
            .dash-round {
                height: 70px;
                border-radius: 50% !important;
                width: 70px;
                margin: 0 auto;
                text-align: center;
            }
            div#sidebar-menu ul.nav-second-level svg {
                font-size: 14px !important;
                width: 16px;
            }
            .edit-image{
                width: 50px;
                height: 50px;
                border-radius: 50px;
                margin-top: 5px;
                background: #f1f1f1;
            }
            .select2-container--default .select2-selection--multiple .select2-selection__choice {
                background-color: #0f52cd !important;
                border: 1px solid #0f52cd !important;
            }
            .select2-selection__rendered,.select2-selection--single{
                height: 38px !important;
                line-height: 29px !important;
            }
            .select2-selection--multiple {
                max-height: auto !important;
                line-height: 29px !important;
            }
            .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
                color: #fff !important;
            }
            .backend-image{
                height: 50px;
                width: 50px;
                border-radius: 50px;
            }
            .custom-btn-list button {
                background: transparent;
                border: 0;
            }

            .custom-btn-list button i, .custom-btn-list a i {
                color: #444;
                font-size: 16px;
            }
            .button-list.custom-btn-list a, .button-list.custom-btn-list button {
                margin: 3px 5px;
                padding: 0;
            }
            .action2-btn {
                margin: 0;
                padding: 0;
                margin-bottom: 20px;
            }
            .action2-btn li {
                display: inline-block;
                list-style: none;
                margin: 2px 0;
            }
            body[data-leftbar-size=condensed] .left-side-menu #sidebar-menu>ul ul,body[data-leftbar-size=condensed] .left-side-menu #sidebar-menu>ul>li:hover>a{
                background: #fff !important;
            }
        </style>
        @stack('css')
		<script src="{{asset('public/backEnd/')}}/assets/js/head.js"></script>

    </head>

    <!-- body start -->
    <body data-layout-mode="default" data-theme="light" data-layout-width="fluid" data-topbar-color="dark" data-menu-position="fixed" data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='false'>

        <!-- Begin page -->
        <div id="wrapper">


            <!-- Topbar Start -->
            @php


            $sellerorder = \App\Models\Order::where('order_status', '1')->latest()->where('seller_id',Auth::guard('seller')->user()->id)->get();


            @endphp
            <div class="navbar-custom">
                <div class="container-fluid">
                    <ul class="list-unstyled topnav-menu float-end mb-0">
                        <li class="dropdown notification-list topbar-dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown"
                                href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="fe-bell noti-icon"></i>
                                <span class="badge bg-danger rounded-circle noti-icon-badge">{{ $sellerorder->count() }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-lg">
                                <!-- item-->
                                <div class="dropdown-item noti-title">
                                    <h5 class="m-0">
                                        <span class="float-end">
                                            <a href="{{ route('seller.orders', ['slug' => 'pending']) }}" class="text-dark">
                                                <small>View All</small>
                                            </a>
                                        </span>
                                        Orders
                                    </h5>
                                </div>

                                <div class="noti-scroll" data-simplebar>
                                    @foreach ($sellerorder as $value)
                                        <!-- item-->
                                        <a href="{{ route('seller.orders', ['slug' => 'pending']) }}"
                                            class="dropdown-item notify-item active">
                                            <div class="notify-icon">

                                            </div>
                                            <p class="notify-details">{{ $value->customer ? $value->customer->name : '' }}
                                            </p>
                                            <p class="text-muted mb-0 user-msg">
                                                <small>Invoice : {{ $value->invoice_id }}</small>
                                            </p>
                                        </a>
                                    @endforeach

                                    <!-- item-->
                                </div>

                                <!-- All-->
                                <a href="{{ route('seller.orders', ['slug' => 'pending']) }}"
                                    class="dropdown-item text-center text-primary notify-item notify-all">
                                    View all
                                    <i class="fe-arrow-right"></i>
                                </a>
                            </div>
                        </li>
                        <!-- order-notification end -->

                        <li class="dropdown d-none d-lg-inline-block">
                            <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="fullscreen" href="#">
                                <i class="fe-maximize noti-icon"></i>
                            </a>
                        </li>
                            <li class="dropdown notification-list topbar-dropdown">
                            <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <img src="{{asset(Auth::guard('seller')->user()->image)}}" alt="user-image" class="rounded-circle">
                                <span class="pro-user-name ms-1">
                                    {{Auth::guard('seller')->user()->name}} <i class="mdi mdi-chevron-down"></i>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                                <!-- item-->
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome !</h6>
                                </div>

                                <!-- item-->
                                <a href="{{route('seller.account')}}" class="dropdown-item notify-item">
                                    <i class="fe-user"></i>
                                    <span>Dashboard</span>
                                </a>

                                <!-- item-->
                                <a href="{{route('seller.change_pass')}}" class="dropdown-item notify-item">
                                    <i class="fe-settings"></i>
                                    <span>Change Password</span>
                                </a>

                                <div class="dropdown-divider"></div>

                                <!-- item-->
                                <a  href="{{ route('seller.logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="dropdown-item notify-item">
                                    <i class="fe-log-out me-1"></i>
                                    <span>Logout</span>
                                </a>
                                <form id="logout-form" action="{{ route('seller.logout') }}" method="POST" style="display: none;">
                                        @csrf
                                </form>

                            </div>
                        </li>
                    </ul>

                    <!-- LOGO -->
                    <div class="logo-box">
                        <a href="{{url('seller/account')}}" class="logo logo-dark text-center">
                            <span class="logo-sm">
                                <img src="{{asset($generalsetting->white_logo)}}" alt="" height="22">
                                <!-- <span class="logo-lg-text-light">UBold</span> -->
                            </span>
                            <span class="logo-lg">
                                <img src="{{asset($generalsetting->dark_logo)}}" alt="" height="20">
                                <!-- <span class="logo-lg-text-light">U</span> -->
                            </span>
                        </a>

                        <a href="{{url('seller/account')}}" class="logo logo-light text-center">
                            <span class="logo-sm">
                                <img src="{{asset($generalsetting->white_logo)}}" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="{{asset($generalsetting->white_logo)}}" alt="" height="20">
                            </span>
                        </a>
                    </div>

                    <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                        <li>
                            <button class="button-menu-mobile waves-effect waves-light">
                                <i class="fe-menu"></i>
                            </button>
                        </li>

                        <li>
                            <!-- Mobile menu toggle (Horizontal Layout)-->
                            <a class="navbar-toggle nav-link" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                                <div class="lines">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </a>
                            <!-- End mobile menu toggle-->
                        </li>

                        <li class="dropdown d-none d-xl-block">
                            <a class="nav-link dropdown-toggle waves-effect waves-light" href="{{route('home')}}" target="_blank">
                               <i data-feather="globe"></i> Visit My shop
                            </a>
                        </li>
                        <li class="visit-shop dropdown d-block d-xl-none">
                            <a class="nav-link dropdown-toggle waves-effect waves-light" href="{{route('home')}}" target="_blank">
                               <i data-feather="globe"></i> Visit
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
            <div class="left-side-menu">

                <div class="h-100" data-simplebar>

                    <!-- User box -->
                    <div class="user-box text-center">
                        <img src="{{asset(Auth::guard('seller')->user()->image)}}" alt="user-img" title="Mat Helme"
                            class="rounded-circle avatar-md">
                        <div class="dropdown">
                            <a href="javascript: void(0);" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block"
                                data-bs-toggle="dropdown">{{Auth::guard('seller')->user()->name}}</a>
                            <div class="dropdown-menu user-pro-dropdown">

                                <!-- item-->
                                <a href="{{route('seller.account')}}" class="dropdown-item notify-item">
                                    <i class="fe-user me-1"></i>
                                    <span>My Account</span>
                                </a>
                                <!-- item-->
                                <a  href="{{ route('seller.logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="dropdown-item notify-item">
                                    <i class="fe-log-out me-1"></i>
                                    <span>Logout</span>
                                </a>
                                <form id="logout-form" action="{{ route('seller.logout') }}" method="POST" style="display: none;">
                                        @csrf
                                </form>

                            </div>
                        </div>
                        <p class="text-muted">Admin Head</p>
                    </div>

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">

                        <ul id="side-menu">


                            <li>
                                <a href="{{route('seller.account')}}">
                                    <i data-feather="airplay"></i>
                                    <span> Dashboards </span>
                                </a>
                            </li>
                            <li class="menu-title mt-2">Sales</li>
                            <!-- nav items -->
                            <li>
                                <a href="#sidebar-orders" data-bs-toggle="collapse">
                                    <i data-feather="shopping-cart"></i>
                                    <span> Orders </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebar-orders">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{route('seller.orders',['slug'=>'all'])}}"><i
                                                data-feather="minus"></i> All Order</a>
                                        </li>
                                        @foreach($orderstatus as $ordertype)
                                        <li>
                                            <a href="{{route('seller.orders',['slug'=>$ordertype->slug])}}"><i data-feather="minus"></i> {{$ordertype->name}}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                            <!-- nav items -->
                            <li class="menu-title mt-2">Shop Setting</li>
                            <li>
                                <a href="#siebar-product" data-bs-toggle="collapse">
                                    <i data-feather="database"></i>
                                    <span> Product Manage </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="siebar-product">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{route('seller.products.index')}}"><i data-feather="minus"></i> Products Manage</a>
                                        </li>
                                        <li>
                                            <a href="{{route('seller.products.create')}}"><i data-feather="minus"></i> New Products</a>
                                        </li>
                                        <li>
                                            <a href="{{route('seller.products.price_edit')}}"><i data-feather="minus"></i> Price Edit</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- nav items end -->
                            <li class="menu-title mt-2">Setting</li>
                            <li>
                                <a href="#setting-product" data-bs-toggle="collapse">
                                    <i data-feather="edit"></i>
                                    <span> Profile Manage </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="setting-product">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{route('seller.profile')}}">My Profile</a>
                                        </li>
                                        <li>
                                            <a href="{{route('seller.profile_edit')}}">Profile Update</a>
                                        </li>
                                        <li>
                                            <a href="{{route('seller.change_pass')}}">Change Password</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- nav items end -->
                            <li class="menu-title mt-2">Accounts</li>
                            <li>
                                <a href="{{route('seller.payable.order')}}">
                                    <i data-feather="credit-card"></i>
                                    <span> Payable order </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('seller.withdraw')}}">
                                    <i data-feather="credit-card"></i>
                                    <span> Withdraws </span>
                                </a>
                            </li>
                        </ul>

                    </div>
                    <!-- End Sidebar -->

                    <div class="clearfix"></div>

                </div>
                <!-- Sidebar -left -->

            </div>
            <!-- Left Sidebar End -->

            <div class="content-page">
                <div class="content">

                    @yield('content');

                </div> <!-- content -->

                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 text-end">
                                 &copy; {{$generalsetting->name}} <a href="https://websolutionit.com" target="_blank">Websolution IT</a>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>



        </div>
        <!-- END wrapper -->

        <!-- Right Sidebar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="{{asset('public/backEnd/')}}/assets/js/vendor.min.js"></script>


        <!-- App js -->
        <script src="{{asset('public/backEnd/')}}/assets/js/app.min.js"></script>
        <script src="{{asset('public/backEnd/')}}/assets/js/toastr.min.js"></script>
        {!! Toastr::message() !!}
        <script src="{{asset('public/backEnd/')}}/assets/js/sweetalert.min.js"></script>
        @stack('script')
        <script type="text/javascript">
             $('.delete-confirm').click(function(event) {
                  var form =  $(this).closest("form");
                  event.preventDefault();
                  swal({
                      title: `Are you sure you want to delete this record?`,
                      text: "If you delete this, it will be gone forever.",
                      icon: "warning",
                      buttons: true,
                      dangerMode: true,
                  })
                  .then((willDelete) => {
                    if (willDelete) {
                      form.submit();
                    }
                  });
              });
             $('.change-confirm').click(function(event) {
                  var form =  $(this).closest("form");
                  event.preventDefault();
                  swal({
                      title: `Are you sure you want to change this record?`,
                      icon: "warning",
                      buttons: true,
                      dangerMode: true,
                  })
                  .then((willDelete) => {
                    if (willDelete) {
                      form.submit();
                    }
                  });
              });
        </script>
        <script>
            $(".district").on("change", function() {
                var id = $(this).val();
                $.ajax({
                    type: "GET",
                    data: {
                        id: id
                    },
                    url: "{{ route('districts') }}",
                    success: function(res) {
                        if (res) {
                            $(".area").empty();
                            $(".area").append('<option value="">Select..</option>');
                            $.each(res, function(key, value) {
                                $(".area").append('<option value="' + key + '" >' + value +
                                    "</option>");
                            });
                        } else {
                            $(".area").empty();
                        }
                    },
                });
            });
        </script>



    </body>
</html>
