@extends('frontEnd.layouts.seller.master')
@section('title','Payment Withdraw')
@push('css')
<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />
@endpush

@section('content')
<div class="container-fluid">
   <!-- start page title -->
    <div class="row">
        <div class="col-6">
            <div class="page-title-box">
                <h4 class="page-title text-capitalize">Payment Withdraw </h4>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="payment-btns mt-3 text-end">
                <ul>
                    <li><a data-bs-toggle="modal" data-bs-target="#payment_modal" class="btn btn-primary">Payment Request</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- end page title -->
   <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                
                
                    <tbody>
                        @foreach($withdraw as $key=>$value)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$value->created_at->format('d-d-Y H:m a')}}</td>
                            <td>{{$value->amount}}</td>
                            <td>{{$value->payment_method}}</td>
                            <td>@if($value->status=='pending')<span class="badge bg-soft-danger text-danger">{{$value->status}}</span> @else <span class="badge bg-soft-success text-success">{{$value->status}}</span> @endif</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
 
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
   </div>
</div>

<!-- Modal -->
    <div class="modal fade" id="payment_modal" tabindex="-1" aria-labelledby="payment_modalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="payment_modalLabel">Payment Request</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{route('seller.withdraw_request')}}" method="POST"
                enctype="multipart/form-data" data-parsley-validate="">
                @csrf
                <div class="row">
                    <div class="col-sm-12 mb-3">
                        <div class="form-group">
                            <label for="payment_method" class="mb-2">Select Payment Method</label>
                            <select class="form-control payment_method" name="payment_method"  required>
                                <option value="">Select..</option>
                                <option value="bank">Bank</option>
                                <option value="bkash">Bkash</option>
                                <option value="nagad">Nagad</option>
                                <option value="rocket">Rocket</option>
                                <option value="cash">Cash</option>
                            </select>
                        </div>
                        <div class="form-group mt-2 others_method">
                            <label for="receive_number" class="mb-2">Receive Number</label>
                            <input class="form-control" name="receive_number" required>
                        </div>
                        <div class="bank_method" style="display:none">
                            <div class="form-group mt-2">
                                <label for="bank_name" class="mb-2">Bank Name</label>
                                <input class="form-control" name="bank_name" id="bank_name">
                            </div>
                            <div class="form-group mt-2">
                                <label for="account_number" class="mb-2">Account Number</label>
                                <input class="form-control" name="account_number" id="account_number">
                            </div>
                            <div class="form-group mt-2">
                                <label for="routing" class="mb-2">Routing Number</label>
                                <input class="form-control" name="routing" id="routing">
                            </div>
                            </div>
                        <div class="form-group mt-3">
                            <button class="btn btn-primary" id="submitBtn">Submit</button>
                        </div>
                    </div>
                    <!-- col end -->
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
<!-- withdraw modal-end -->
@endsection


@push('script')
<!-- third party js -->
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/js/pages/datatables.init.js"></script>
<!-- third party js ends -->
<script>
    $('.payment_method').on('change',function(){
        var method = $(this).val();
        if(method == 'bank'){
            $('.bank_method').show();
            $('.others_method').hide();
        }else{
            $('.bank_method').hide();
            $('.others_method').show();
        }
    })
</script>
@endpush