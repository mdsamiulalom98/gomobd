@extends('frontEnd.layouts.seller.master')
@section('title','Profile Edit')
@section('css')
<link rel="stylesheet" href="{{asset('public/frontEnd/css/select2.min.css')}}">
<style>
.product_img img {
    height: 60px !important;
    width: 60px !important;
    border-radius: 50%;
}

</style>
@endsection
@section('content')
<div class="container-fluid">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{route('seller.profile')}}" class="btn btn-primary rounded-pill">Manage</a>
                </div>
                <h4 class="page-title">Profile Edit</h4>
            </div>
        </div>
    </div>       
    <!-- end page title --> 
   <div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="{{route('seller.profile_update')}}" method="POST" class=row data-parsley-validate=""  enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{$profile_edit->id}}" name="id">
                    <div class="col-sm-4">
                        <div class="form-group mb-3">
                            <label for="owner_name" class="form-label">Owner Name *</label>
                            <input type="text" class="form-control @error('owner_name') is-invalid @enderror" name="owner_name" value="{{$profile_edit->owner_name }}" id="owner_name" required="">
                            @error('owner_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->
                    <div class="col-sm-4">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Shop Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$profile_edit->name }}" id="name" required="">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->
                    <div class="col-sm-4">
                        <div class="form-group mb-3">
                            <label for="phone" class="form-label">Phone Number *</label>
                            <input type="text" readonly class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{$profile_edit->phone }}" id="name" required="">
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->
                    <div class="col-sm-4">
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="text" readonly class="form-control @error('email') is-invalid @enderror" name="email" value="{{$profile_edit->email }}" id="name" required="">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->
                    <div class="col-sm-4">
                        <div class="form-group mb-3">
                            <label for="address" class="form-label">Address *</label>
                            <input type="text" id="address" class="form-control @error('address') is-invalid @enderror" name="address" value="{{$profile_edit->address}}"  required>
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->
                    <div class="col-sm-4">
                        <div class="form-group mb-3">
                            <label for="nidnum" class="form-label">NID Number *</label>
                            <input type="number" class="form-control @error('nidnum') is-invalid @enderror" name="nidnum" value="{{$profile_edit->nidnum }}" id="name" required="">
                            @error('nidnum')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->
                        <div class="col-sm-6">
                        <div class="form-group mb-3">
                            <label for="district" class="form-label">District *</label>
                            <select  id="district" class="form-control select2 district @error('district') is-invalid @enderror" name="district" value="{{ old('district') }}"  required>
                                <option value="">Select...</option>
                                @foreach($districts as $key=>$district)
                                <option value="{{$district->district}}" @if($profile_edit->district==$district->district) selected @endif>{{$district->district}}</option>
                                @endforeach
                            </select>
                            @error('district')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->
                    <div class="col-sm-6">
                        <div class="form-group mb-3">
                            <label for="area" class="form-label">Area *</label>
                            <select  id="area" class="form-control area select2 @error('area') is-invalid @enderror" name="area" value="{{ old('area') }}"  required>
                                <option value="">Select...</option>
                                @foreach($areas as $key=>$area)
                                <option value="{{$area->id}}" @if($profile_edit->area == $area->id) selected @endif>{{$area->area_name}}</option>
                                @endforeach
                            </select>
                            @error('area')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->
                    <div class="col-sm-4 mb-3">
                        <label for="image" class="form-label">Image *</label>
                        <div class="input-group control-group increment">
                            <input type="file" name="image[]" class="form-control @error('image') is-invalid @enderror" />
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="product_img">
                            <img src="{{asset($profile_edit->image)}}" class="edit-image border" alt="">
                        </div>
                    </div>
                    <!-- col end -->
                    <div class="col-sm-4 mb-3">
                        <label for="nid1" class="form-label">Nid Front Image *</label>
                        <div class="input-group control-group increment">
                            <input type="file" name="nid1" class="form-control @error('nid1') is-invalid @enderror"/>
                            @error('nid1')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="product_img">
                            <img src="{{asset($profile_edit->nid1)}}" class="edit-nid1 border"  style="height: 100px; width:150px;" alt="">
                        </div>
                    </div>
                    <!-- col end -->
                    <div class="col-sm-4 mb-3">
                        <label for="nid2" class="form-label">Nid Back Image *</label>
                        <div class="input-group control-group increment">
                            <input type="file" name="nid2" class="form-control @error('nid2') is-invalid @enderror"/>
                            @error('nid2')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="product_img">
                            <img src="{{asset($profile_edit->nid2)}}" class="edit-nid2 border"  style="height: 100px; width:150px;" alt="">
                        </div>
                    </div>
                    <!-- col end -->
                    <div>
                        <input type="submit" class="btn btn-success" value="Submit">
                    </div>

                </form>

            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col-->
   </div>
</div>
@endsection


@section('script')
<script src="{{asset('public/frontEnd/')}}/js/parsley.min.js"></script>
<script src="{{asset('public/frontEnd/')}}/js/form-validation.init.js"></script>
<script src="{{asset('public/frontEnd/')}}/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
<script>
    $('.district').on('change',function(){
    var id = $(this).val();
        $.ajax({
           type:"GET",
           data:{'id':id},
           url:"{{route('districts')}}",
           success:function(res){               
            if(res){
                $(".area").empty();
                $(".area").append('<option value="">Select..</option>');
                $.each(res,function(key,value){
                    $(".area").append('<option value="'+key+'" >'+value+'</option>');
                });
           
            }else{
               $(".area").empty();
            }
           }
        });  
   });
</script>
@endsection