@extends('backEnd.layouts.master')
@section('title', request('status'))
@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title text-capitalize">{{request('status')}} Payment History</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive ">
                            <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Invoice</th>
                                        <th>Seller</th>
                                        <th>Amount</th>
                                        <th>Method</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($withdraws as $key => $value)
                                        <tr>
                                            <td>{{$value->created_at->format('d m, Y h:m A')}}</td>
                                            <td>{{$value->invoice_id}}</td>
                                            <td>{{$value->seller?$value->seller->name:''}} <br> {{$value->seller?$value->seller->phone:''}}<br>{{$value->seller?$value->seller->address:''}}</td>
                                            <td>৳ {{$value->amount}}</td>
                                            <td>{{$value->payment_method}}</td>
                                            <td><span class="@if($value->status == 'paid') success @else warning @endif">{{$value->status}}</span></td>
                                            <td><a href="{{route('sellers.invoice',$value->id)}}" class="btn btn-xs btn-primary waves-effect waves-light"><i class="fe-eye"></i></a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="custom-paginate">
                            {{ $withdraws->links('pagination::bootstrap-4') }}
                        </div>
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
    </div>
@endsection
