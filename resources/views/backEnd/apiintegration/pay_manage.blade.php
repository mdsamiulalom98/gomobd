@extends('backEnd.layouts.master')
@section('title', 'Payment Gateway')
@section('css')
    <link href="{{ asset('public/backEnd') }}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backEnd') }}/assets/libs/summernote/summernote-lite.min.css" rel="stylesheet"
        type="text/css" />
    @endsection @section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Payment Gateway</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="payment_gateway">
                          <div class="row">
                              <div class="col-sm-2">
                                  <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        <button class="nav-link active" id="v-pills-bkash-tab" data-bs-toggle="pill" data-bs-target="#v-pills-bkash" type="button" role="tab" aria-controls="v-pills-bkash" aria-selected="true">Bkash</button>
                                        <button class="nav-link" id="v-pills-shurjopay-tab" data-bs-toggle="pill" data-bs-target="#v-pills-shurjopay" type="button" role="tab" aria-controls="v-pills-shurjopay" aria-selected="false">Shurjopay</button>
                                  </div>
                              </div>
                              <div class="col-sm-10">
                                  <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="v-pills-bkash" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
                                        <h4 class="page-title">Bkash Gateway</h4>
                                        <form action="{{ route('paymentgeteway.update') }}" method="POST" class="row" data-parsley-validate="" enctype="multipart/form-data">
                                         @csrf
                                        <input type="hidden" name="id" value="{{ $bkash->id }}">
                                        <div class="col-sm-4">
                                            <div class="form-group mb-3">
                                                <label for="username" class="form-label">User Name *</label>
                                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                                    name="username" value="{{ $bkash->username }}" id="username" required="" />
                                                @error('username')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- col-end -->
                                        <div class="col-sm-4">
                                            <div class="form-group mb-3">
                                                <label for="app_key" class="form-label">App Key *</label>
                                                <input type="text" class="form-control @error('app_key') is-invalid @enderror"
                                                    name="app_key" value="{{ $bkash->app_key }}" id="app_key" required="" />
                                                @error('app_key')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- col-end -->

                                        <div class="col-sm-4">
                                            <div class="form-group mb-3">
                                                <label for="app_secret" class="form-label">App Secret *</label>
                                                <input type="text" class="form-control @error('app_secret') is-invalid @enderror"
                                                    name="app_secret" value="{{ $bkash->app_secret }}" id="app_secret" required="" />
                                                @error('app_secret')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- col-end -->
                                        <div class="col-sm-4">
                                            <div class="form-group mb-3">
                                                <label for="base_url" class="form-label">Base Url *</label>
                                                <input type="text" class="form-control @error('base_url') is-invalid @enderror"
                                                    name="base_url" value="{{ $bkash->base_url }}" id="base_url" required="" />
                                                @error('base_url')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- col-end -->
                                        <div class="col-sm-4">
                                            <div class="form-group mb-3">
                                                <label for="password" class="form-label">Password *</label>
                                                <input type="text" class="form-control @error('password') is-invalid @enderror"
                                                    name="password" value="{{ $bkash->password }}" id="password" required="" />
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- col-end -->
                                        <div class="col-sm-3 mb-3">
                                            <div class="form-group">
                                                <label for="status" class="d-block">Status</label>
                                                <label class="switch">
                                                    <input type="checkbox" value="1"
                                                        @if ($bkash->status == 1) checked @endif name="status" />
                                                    <span class="slider round"></span>
                                                </label>
                                                @error('status')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- col end -->

                                        <div>
                                            <input type="submit" class="btn btn-success" value="Submit" />
                                        </div>
                                    </form>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-shurjopay" role="tabpanel" aria-labelledby="v-pills-shurjopay-tab" tabindex="0">
                                       <h4 class="page-title">Shurjopay Gateway</h4>
                                        <form action="{{route('paymentgeteway.update')}}" method="POST" class="row" data-parsley-validate="" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $shurjopay->id}}">
                                        <div class="col-sm-4">
                                          <div class="form-group mb-3">
                                            <label for="username" class="form-label">User Name *</label>
                                            <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $shurjopay->username}}" id="username" required="" />
                                            @error('username')
                                            <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                          </div>
                                        </div>
                                        <!-- col-end -->
                                        <div class="col-sm-4">
                                          <div class="form-group mb-3">
                                            <label for="prefix" class="form-label">Prefix *</label>
                                            <input type="text" class="form-control @error('prefix') is-invalid @enderror" name="prefix" value="{{ $shurjopay->prefix}}" id="prefix" required="" />
                                            @error('prefix')
                                            <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                          </div>
                                        </div>
                                        <!-- col-end -->
                                        
                                        <div class="col-sm-4">
                                          <div class="form-group mb-3">
                                            <label for="success_url" class="form-label">Success Url *</label>
                                            <input type="text" class="form-control @error('success_url') is-invalid @enderror" name="success_url" value="{{ $shurjopay->success_url}}" id="success_url" required="" />
                                            @error('success_url')
                                            <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                          </div>
                                        </div>
                                        <!-- col-end -->
                                        <div class="col-sm-4">
                                          <div class="form-group mb-3">
                                            <label for="return_url" class="form-label">Return Url *</label>
                                            <input type="text" class="form-control @error('return_url') is-invalid @enderror" name="return_url" value="{{ $shurjopay->return_url}}" id="return_url" required="" />
                                            @error('return_url')
                                            <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                          </div>
                                        </div>
                                        <!-- col-end -->
                                        <div class="col-sm-4">
                                          <div class="form-group mb-3">
                                            <label for="base_url" class="form-label">Base Url *</label>
                                            <input type="text" class="form-control @error('base_url') is-invalid @enderror" name="base_url" value="{{ $shurjopay->base_url}}" id="base_url" required="" />
                                            @error('base_url')
                                            <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                          </div>
                                        </div>
                                        <!-- col-end -->
                                        <div class="col-sm-4">
                                          <div class="form-group mb-3">
                                            <label for="password" class="form-label">Password *</label>
                                            <input type="text" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ $shurjopay->password}}" id="password" required="" />
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                          </div>
                                        </div>
                                        <!-- col-end -->
                                        <div class="col-sm-3 mb-3">
                                          <div class="form-group">
                                            <label for="status" class="d-block">Status</label>
                                            <label class="switch">
                                              <input type="checkbox" value="1" @if($shurjopay->status==1)checked @endif name="status" />
                                              <span class="slider round"></span>
                                            </label>
                                            @error('status')
                                            <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                          </div>
                                        </div>
                                        <!-- col end -->

                                        <div>
                                          <input type="submit" class="btn btn-primary" value="Submit" />
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                              </div>
                          </div>
                        </div>
                    </div>
                    <!-- end card-body-->
                </div>
                <!-- end card-->
            </div>
            <!-- end col-->
        </div>
        <!-- end page title -->


    </div>
    @endsection @section('script')
    <script src="{{ asset('public/backEnd/') }}/assets/libs/parsleyjs/parsley.min.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/js/pages/form-validation.init.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/libs/select2/js/select2.min.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/js/pages/form-advanced.init.js"></script>
@endsection
