@extends('frontEnd.layouts.seller.master')
@section('title','Profile')
@section('content')
<div class="container-fluid">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{route('seller.profile_edit')}}" class="btn btn-primary rounded-pill">Update</a>
                </div>
                <h4 class="page-title">My Profile</h4>
            </div>
        </div>
    </div>       
    <!-- end page title --> 
   <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                    <tbody>
                    	<tr>
                            <td>Owner Name</td>
                            <td>{{$seller->owner_name}}</td>
                        </tr>
                        <tr>
                            <td>Shop Name</td>
                            <td>{{$seller->name}}</td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>{{$seller->phone}}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{$seller->email}}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>{{$seller->address}}</td>
                        </tr>
                        <tr>
                            <td>Disctrict</td>
                            <td>{{$seller->district}}</td>
                        </tr>
                        <tr>
                            <td>Area</td>
                            <td>{{ $seller->seller_area ? $seller->seller_area->area_name : '' }}</td>
                        </tr>
                        <tr>
                            <td>Image</td>
                            <td><img src="{{asset($seller->image)}}" alt="" height="80" class="circle-5"></td>
                        </tr>
                        <tr>
                            <td>NID Number</td>
                            <td>{{$seller->nidnum}}</td>
                        </tr>
                        <tr>
                            <td>Nid Images</td>
                            <td><img src="{{asset($seller->nid1)}}" alt="" height="220" width="350" class="circle-5" style="margin-right: 20px; border-radius:10px;"><img src="{{asset($seller->nid2)}}" alt="" height="220" width="350" class="circle-5" style="border-radius:10px;"></td>
                        </tr>
                    </tbody>
                </table>
 
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
   </div>
</div>
@endsection
