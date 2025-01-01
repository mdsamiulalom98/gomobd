@extends('backEnd.layouts.master')
@section('title','Product Stock Alert')
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <a href="{{route('products.purchase_create')}}" class="btn btn-primary rounded-pill"> Stock Add </a>
            </div>
            <h4 class="page-title">Product Stock Alert</h4>
        </div>
    </div>
</div>      
    <!-- end page title --> 
   <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table nowrap w-100">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Size</th>
                            <th>Color</th>
                            <th>Price</th>
                            <th>Stock</th>
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
                        </tr>
                        @endforeach
                        @foreach ($variables as $variable)
                        <tr>
                            <td><img src="{{ asset($variable->image?$variable->image:'')}}" class="rounded-circle avatar-sm" />
                            </td>
                            <td>{{ $variable->product->name}}</td>
                            <td>{{$variable->size ?? 'N/A'}}</td>
                            <td>{{$variable->color ??  'N/A'}}</td>
                            <td>{{$variable->product->new_price}}</td>
                            <td>{{$variable->stock}}</td>
                        </tr>
                        @endforeach
                     </tbody>
                    </table>
                </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
   </div>
</div>

@endsection