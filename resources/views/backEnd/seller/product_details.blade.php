@extends('backEnd.layouts.master')
@section('title','Product Details')
@section('css')
<link href="{{asset('public/backEnd')}}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('public/backEnd')}}/assets/libs/summernote/summernote-lite.min.css" rel="stylesheet" type="text/css" />

@endsection
@section('content')
<div class="container-fluid">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{route('sellers.pending_product')}}" class="btn btn-primary rounded-pill">Manage</a>
                </div>
                <h4 class="page-title">Product Details</h4>
            </div>
        </div>
    </div>       
    <!-- end page title --> 
   <div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered" style="width:100%">
                            <tbody>
                                <tr>
                                    <td>Name</td>
                                    <td>{{$details->name}}</td>
                                </tr>
                                <tr>
                                    <td>Category</td>
                                    <td>{{$details->category?$details->category->name:''}}</td>
                                </tr>
                                <tr>
                                    <td>Brand</td>
                                    <td>{{$details->brand?$details->brand->name:'N/A'}}</td>
                                </tr>
                                <tr>
                                    <td>Purchase Price</td>
                                    <td>{{$details->purchase_price}} Tk</td>
                                </tr>
                                <tr>
                                    <td>Old Price</td>
                                    <td>{{$details->old_price}} Tk</td>
                                </tr>
                                <tr>
                                    <td>New Price</td>
                                    <td>{{$details->new_price}} Tk</td>
                                </tr>
                                <tr>
                                    <td>Stock</td>
                                    <td>{{$details->stock}}</td>
                                </tr>
                                <tr>
                                    <td>Images</td>
                                    
                                    <td>
                                        @foreach($details->images as $value)
                                            <img src="{{asset($value->image)}}" class="backend-image" alt="">
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td>Description</td>
                                    <td>{!!$details->description!!}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-12">
                        <h4>Product Approval</h4>
                        <form action="{{route('sellers.product_status')}}" method="POST" data-parsley-validate=""  enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{$details->id}}" name="id">
                            <div class="form-group mb-3">
                                <select name="status"  class="form-control">
                                    <option value="">Select Status..</option>
                                    <option value="1">Approved</option>
                                    <option value="2">Reject</option>
                                </select>
                            </div>
                            <div>
                                <input type="submit" class="btn btn-success" value="Submit">
                            </div>

                        </form>
                    </div>
                </div>

            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col-->
   </div>
</div>
@endsection


@section('script')
<script src="{{asset('public/backEnd/')}}/assets/libs/parsleyjs/parsley.min.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/js/pages/form-validation.init.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/libs/select2/js/select2.min.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/js/pages/form-advanced.init.js"></script>
<!-- Plugins js -->
<script src="{{asset('public/backEnd/')}}/assets/libs//summernote/summernote-lite.min.js"></script>
<script>
  $(".summernote").summernote({
    placeholder: "Enter Your Text Here",
    
  });
</script>


@endsection