@extends('backEnd.layouts.master')
@section('title', 'Courier API Manage')
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
                    <h4 class="page-title">Courier API Manage</h4>
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
                                        <button class="nav-link active" id="v-pills-steadfast-tab" data-bs-toggle="pill" data-bs-target="#v-pills-steadfast" type="button" role="tab" aria-controls="v-pills-steadfast" aria-selected="true">Steadfast</button>
                                        <button class="nav-link" id="v-pills-pathao-tab" data-bs-toggle="pill" data-bs-target="#v-pills-pathao" type="button" role="tab" aria-controls="v-pills-pathao" aria-selected="false">Pathao</button>
                                  </div>
                              </div>
                              <div class="col-sm-10">
                                  <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="v-pills-steadfast" role="tabpanel" aria-labelledby="v-pills-steadfast-tab" tabindex="0">
                                        <h4 class="page-title">SteadFast Courier API</h4>
                                        <form action="{{route('courierapi.update')}}" method="POST" class="row" data-parsley-validate="" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$steadfast->id}}">
                                            <div class="col-sm-6">
                                              <div class="form-group mb-3">
                                                <label for="api_key" class="form-label">API key *</label>
                                                <input type="text" class="form-control @error('api_key') is-invalid @enderror" name="api_key" value="{{ $steadfast->api_key}}" id="api_key" required="" />
                                                @error('api_key')
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                              </div>
                                            </div>
                                            <!-- col-end -->
                                            <div class="col-sm-6">
                                              <div class="form-group mb-3">
                                                <label for="secret_key" class="form-label">Secret key *</label>
                                                <input type="text" class="form-control @error('secret_key') is-invalid @enderror" name="secret_key" value="{{ $steadfast->secret_key }}" id="secret_key" required="" />
                                                @error('secret_key')
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                              </div>
                                            </div>
                                            <!-- col-end -->
                                            
                                            <div class="col-sm-6">
                                              <div class="form-group mb-3">
                                                <label for="url" class="form-label">URL *</label>
                                                <input type="text" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ $steadfast->url }}" id="url" required="" />
                                                @error('url')
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
                                                  <input type="checkbox" value="1" @if($steadfast->status==1)checked @endif name="status" />
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
                                    <div class="tab-pane fade" id="v-pills-pathao" role="tabpanel" aria-labelledby="v-pills-pathao-tab" tabindex="0">
                                       <h4 class="page-title">Pathao Courier API</h4>
                                        <form action="{{route('courierapi.update')}}" method="POST" class="row" data-parsley-validate="" enctype="multipart/form-data">
                                          @csrf
                                          <input type="hidden" name="id" value="{{ $pathao->id}}">
                                          <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                              <label for="url" class="form-label">URL *</label>
                                              <input type="text" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ $pathao->url}}" id="url" required="" />
                                              @error('url')
                                              <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                              </span>
                                              @enderror
                                            </div>
                                          </div>
                                          <!-- col-end -->
                                          <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                              <label for="token" class="form-label">Token *</label>
                                              <input type="text" class="form-control @error('token') is-invalid @enderror" name="token" value="{{ $pathao->token}}" id="token" required="" />
                                              @error('token')
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
                                                <input type="checkbox" value="1" @if($pathao->status==1)checked @endif name="status" />
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
