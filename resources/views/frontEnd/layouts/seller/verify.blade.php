<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>Seller Verify | {{$generalsetting->name}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset($generalsetting->favicon)}}">
		<!-- Bootstrap css -->
		<link href="{{asset('public/backEnd/')}}/assets/css/bootstrap.min.css" rel="stylesheet"/>
		<!-- App css -->
		<link href="{{asset('public/backEnd/')}}/assets/css/app.min.css" rel="stylesheet" id="app-style"/>
		<!-- icons -->
		<link href="{{asset('public/backEnd/')}}/assets/css/icons.min.css" rel="stylesheet" />
		<!-- toastr js -->
        <link rel="stylesheet" href="{{asset('public/backEnd/')}}/assets/css/toastr.min.css">
        <!-- Head js -->

		<script src="{{asset('public/backEnd/')}}/assets/js/head.js"></script>
        <style>
            .auth-fluid-right.text-center {
                background-image: url(../public/frontEnd/images/seller-verify.jpg);
                background-size: cover;
                background-repeat: no-repeat;
                background-position: top center;
            }
            .invalid-feedback {
                display: block;
            }
        </style>

    </head>

    <body class="auth-fluid-pages pb-0">

        <div class="auth-fluid">
            <!--Auth fluid left content -->
            <div class="auth-fluid-form-box">
                <div class="align-items-center  h-100">
                    <div class="p-3">

                        <!-- Logo -->
                        <div class="auth-brand text-left text-lg-start">
                            <div class="auth-logo">
                                <a href="{{route('seller.register')}}">
                                    <span class="dripicons-arrow-thin-left"></span> <strong>Back To Register</strong>
                                </a>
                            </div>
                        </div>

                        <!-- title-->
                        <h4 class="mt-4 mb-3">Seller Verify</h4>

                        <!-- form -->
                        <form action="{{route('seller.account.verify')}}" method="POST" data-parsley-validate="">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="otp" class="form-label">OTP</label>
                                <input class="form-control  @error('otp') is-invalid @enderror" type="number" name="otp" id="otp" value="{{ old('otp') }}" placeholder="Enter OTP" required>
                                @error('otp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- form group end -->
                            <div class="text-center d-grid">
                                <button class="btn btn-primary waves-effect waves-light" type="submit"> Submit </button>
                            </div>
                            <!-- social-->
                        </form>
                        <!-- end form-->
                        <div class="mt-4">
                        <form action="{{route('seller.resendotp')}}" method="POST">
                            @csrf
                            <button class="btn btn-outline-warning rounded-pill waves-effect waves-light"><i data-feather="rotate-cw"></i> Resend OTP</button>
                        </form>
                    </div>

                    </div> <!-- end .card-body -->
                </div> <!-- end .align-items-center.d-flex.h-100-->
            </div>
            <!-- end auth-fluid-form-box-->

            <!-- Auth fluid right content -->
            <div class="auth-fluid-right text-center">
                <div class="auth-user-testimonial">
                    
                </div> <!-- end auth-user-testimonial-->
            </div>
            <!-- end Auth fluid right content -->
        </div>
        <!-- end auth-fluid-->

        <!-- Vendor js -->
        <script src="{{asset('public/backEnd/')}}/assets/js/vendor.min.js"></script>
        <script src="{{asset('public/frontEnd/')}}/js/parsley.min.js"></script>
        <script src="{{asset('public/frontEnd/')}}/js/form-validation.init.js"></script>
        <!-- App js -->
        <script src="{{asset('public/backEnd/')}}/assets/js/app.min.js"></script>
        <script src="{{asset('public/backEnd/')}}/assets/js/toastr.min.js"></script>
        {!! Toastr::message() !!}
        
    </body>
    </html>