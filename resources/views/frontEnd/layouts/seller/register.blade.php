<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>Seller Register | {{$generalsetting->name}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset($generalsetting->favicon)}}">
		<!-- Bootstrap css -->
		<link href="{{asset('public/backEnd/')}}/assets/css/bootstrap.min.css" rel="stylesheet" />
		<!-- App css -->
		<link href="{{asset('public/backEnd/')}}/assets/css/app.min.css" rel="stylesheet" id="app-style"/>
		<!-- icons -->
		<link href="{{asset('public/backEnd/')}}/assets/css/icons.min.css" rel="stylesheet" />
		<!-- Head js -->
		<script src="{{asset('public/backEnd/')}}/assets/js/head.js"></script>
        <style>
            .auth-fluid-right.text-center {
                background-image: url(../public/frontEnd/images/seller-register.jpg);
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
                                <a href="{{route('home')}}">
                                    <span class="dripicons-arrow-thin-left"></span> <strong>Back To Home</strong>
                                </a>
                            </div>
                        </div>

                        <!-- title-->
                        <h4 class="mt-4 mb-2">Seller Register</h4>

                        <!-- form -->
                        <form action="{{route('seller.store')}}" method="POST" data-parsley-validate="">
                            @csrf
                            <div class="form-group mb-2">
                                <label for="name" class="form-label">Shop Name</label>
                                <input class="form-control  @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Enter shop name" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- form group end -->
                            <div class="form-group mb-2">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input class="form-control  @error('phone') is-invalid @enderror" type="text" name="phone" id="phone" value="{{ old('phone') }}" placeholder="Enter phone number" required>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- form group end -->
                            <div class="form-group mb-2">
                                <label for="email" class="form-label">Email Address</label>
                                <input class="form-control  @error('email') is-invalid @enderror" type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Enter email address" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- form group end -->
                            <div class="form-group mb-2">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" name="password" id="password" class="form-control  @error('password') is-invalid @enderror" value="{{old('password')}}" placeholder="Enter your password" required>
                                    <div class="input-group-text" data-password="false">
                                        <span class="password-eye"></span>
                                    </div>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- form group end -->
                            <div class="form-group mb-2">
                                <label for="confirm-password" class="form-label">Cconfirm Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" name="confirm-password" id="confirm-password" class="form-control  @error('confirm-password') is-invalid @enderror" value="{{old('confirm-password')}}" placeholder="Confirm password" required>
                                    <div class="input-group-text" data-password="false">
                                        <span class="password-eye"></span>
                                    </div>
                                </div>
                                @error('confirm-password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- form group end -->
                            <div class="mb-2">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="checkbox-signup">
                                    <label class="form-check-label" for="checkbox-signup">I accept <a href="{{route('page',['slug'=>'conditions'])}}">Conditions</a> & <a href="{{route('page',['slug'=>'privacy-policy'])}}">Privacy Policy</a></label>
                                </div>
                            </div>
                            <div class="text-center d-grid">
                                <button class="btn btn-primary waves-effect waves-light" type="submit"> Sign Up </button>
                            </div>
                            <!-- social-->
                        </form>
                        <!-- end form-->

                        <!-- Footer-->
                        <footer class="footer footer-alt">
                            <p class="text-muted">Already have account? <a href="{{route('seller.login')}}" class="text-muted ms-1"><b>Log In</b></a></p>
                        </footer>

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
        
    </body>
    </html>