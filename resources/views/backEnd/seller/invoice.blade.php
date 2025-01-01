@extends('backEnd.layouts.master')
@section('title', 'seller Invoice')
@section('content')
 <style>
        .customer-invoice {
            margin: 25px 0;
        }

        .invoice_btn {
            margin-bottom: 15px;
        }

        p {
            margin: 0;
        }

        td {
            font-size: 16px;
        }

        @page {
            margin: 0px;
        }

        @media print {
            .invoice-innter {
                margin-left: -120px !important;
            }

            .invoice_btn {
                margin-bottom: 0 !important;
            }

            td {
                font-size: 18px;
            }

            p {
                margin: 0;
            }

            header,
            footer,
            .no-print,
            .left-side-menu,
            .navbar-custom {
                display: none !important;
            }
        }
    </style>
<section class="customer-invoice ">
    <div class="container">
        <div class="row my-3 justify-content-center">
            <div class="col-sm-5">
                <a href=""><strong><i class="fa fa-angle-left"></i> Back</strong></a>
            </div>
            <div class="col-sm-5 text-end">
                <div class="button-list">
                    <button onclick="printFunction()" class="no-print btn btn-primary btn-sm"><i class="fa fa-print"></i></button>
                    @if($withdraw->status == 'paid')
                    <a class="btn rounded-pill btn-danger"><i class="fe-check"></i> Already Paid</a>
                    @else
                    <a data-bs-toggle="modal" data-bs-target="#payment_status" class="btn rounded-pill btn-info"><i class="fe-plus"></i> Change Status</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="invoice-innter" style="width: 900px;margin: 0 auto;background: #fff;overflow: hidden;padding: 30px;padding-top: 0;">
                    <table style="width:100%">
                        <tr>
                            <td style="width: 40%; float: left; padding-top: 15px;">
                                <img src="{{asset($generalsetting->white_logo)}}" style="margin-top:25px !important;width:150px" alt="">
                                <p style="font-size: 14px; color: #222;margin-top: 10px;"><strong>Payment Method:</strong> <span style="text-transform: uppercase;">{{$withdraw->payment_method}}</span></p>
                                @if($withdraw->trx_id)
                                <p style="font-size: 14px; color: #222;"><strong>Trx Id:</strong> <span style="text-transform: uppercase;">{{$withdraw->trx_id}}</span></p>
                                @endif
                                <div class="invoice_form" style="margin-top:10px">
                                    <p style="font-size:16px;line-height:1.8;color:#222"><strong>Invoice From:</strong></p>
                                    <p style="font-size:16px;line-height:1.8;color:#222">{{$generalsetting->name}}</p>
                                    <p style="font-size:16px;line-height:1.8;color:#222">{{$contact->phone}}</p>
                                    <p style="font-size:16px;line-height:1.8;color:#222">{{$contact->address}}</p>
                                </div>
                            </td>
                            <td  style="width:60%;float: left;">
                                <div class="invoice-bar" style=" background: #3F9669; transform: skew(38deg); width: 100%; margin-left: 65px; padding: 15px 60px; ">
                                    <p style="font-size: 25px; color: #fff; transform: skew(-38deg); text-transform: uppercase; text-align: right; font-weight: bold;">Invoice</p>
                                </div>
                                <div class="invoice-bar" style="background:#fff; transform: skew(36deg); width: 75%; margin-left: 182px; padding: 8px 42px; margin-top: 4px;text-align:right">
                                   <p style="transform: skew(-36deg);display:inline-block">Invoice Date: <strong>{{$withdraw->created_at->format('d-m-y')}}</strong></p>
                                   <p style="transform: skew(-36deg);display:inline-block;margin-right: 18px;">Invoice No: <strong>{{$withdraw->invoice_id}}</p>
                                    </p>
                                </div>
                                <div class="invoice_to" style="padding-top: 0px;">
                                    <p style="font-size:16px;line-height:1.8;color:#222;text-align: right;"><strong>Invoice To:</strong></p>
                                    <p style="font-size:16px;line-height:1.8;color:#222;text-align: right;font-weight:normal">{{$withdraw->seller?$withdraw->seller->name:''}}</p>
                                    <p style="font-size:16px;line-height:1.8;color:#222;text-align: right;font-weight:normal">{{$withdraw->seller?$withdraw->seller->phone:''}}</p>
                                    <p style="font-size:16px;line-height:1.8;color:#222;text-align: right;font-weight:normal">{{$withdraw->seller?$withdraw->seller->address:''}}</p>
                                   <p style="text-align:right;text-transform:capitalize;"><span class="@if($withdraw->status == 'paid') success @else warning @endif">{{$withdraw->status}}</span></p>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <table class="table" style="margin-top: 20px">
                        <thead style="background: #3F9669; color: #fff;">
                            <tr>
                                <th>Order</th>
                                <th>Amount</th>
                                <th>S. Charge</th>
                                <th>Commision</th>
                                <th>Payable</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($withdraw->withdrawdetails as $value)
                            <tr>
                                <td>{{$value->order?$value->order->invoice_id:''}}</td>
                                <td>৳{{$value->amount}}</td>
                                <td>৳{{$value->shipping_charge}}</td>
                                <td>৳{{$value->commision}}</td>
                                <td>৳{{$value->payable_amount}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="invoice-bottom">
                        <table class="table" style="width: 300px; float: right;    margin-bottom: 30px;">
                            <tbody style="background:#3F9669">
                                <tr style="color:#fff">
                                    <td style="font-weight: 600;font-size:15px">Amount</td>
                                    <td style="font-weight: 600;font-size:15px">৳{{$withdraw->withdrawdetails->sum('amount')}}</td>
                                </tr>
                                <tr style="color:#fff">
                                    <td style="font-weight: 600;font-size:15px">Delivery Charge(-)</td>
                                    <td style="font-weight: 600;font-size:15px">৳{{$withdraw->withdrawdetails->sum('shipping_charge')}}</td>
                                </tr>
                                <tr style="color:#fff">
                                    <td style="font-weight: 600;font-size:15px">Commisions(-)</td>
                                    <td style="font-weight: 600;font-size:15px">৳{{$withdraw->withdrawdetails->sum('seller_commisions')}}</td>
                                </tr>
                                <tr style="color:#fff">
                                    <td style="font-weight: 600;font-size:15px">Payable</td>
                                    <td style="font-weight: 600;font-size:15px">৳{{$withdraw->amount}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="terms-condition" style="overflow: hidden; width: 100%; text-align: center; padding: 20px 0; border-top: 1px solid #ddd;">
                            <h5 style="font-style: italic;"><a href="{{route('page',['slug'=>'terms-condition'])}}">Terms & Conditions</a></h5>
                            <p style="text-align: center; font-style: italic; font-size: 15px; margin-top: 10px;">* This is a computer generated invoice, does not require any signature.</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>
<!-- Modal start -->
<div class="modal fade" id="payment_status" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Payment Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="payment-info">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>Payment Method</td>
                        <td>{{$withdraw->payment_method}}</td>
                    </tr>
                    @if($withdraw->payment_method == 'bank')
                    <tr>
                        <td>Bank Name</td>
                        <td>{{$withdraw->bank_name}}</td>
                    </tr>
                    <tr>
                        <td>Account Number</td>
                        <td>{{$withdraw->account_number}}</td>
                    </tr>
                    <tr>
                        <td>Routing</td>
                        <td>{{$withdraw->routing}}</td>
                    </tr>
                    @else
                    <tr>
                        <td>Receive</td>
                        <td>{{$withdraw->receive_number}}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <form action="{{route('sellers.withdraw.status')}}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{$withdraw->id}}">
            <div class="form-group">
                <label for="payment_status" class="mb-2">Delivery Status</label>
                <select name="payment_status" id="payment_status" class="form-control">
                    <option value="">Select..</option>
                    <option value="paid">Paid</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div class="form-group mt-2">
                <label for="admin_note" class="mb-2">Sender Info & Note</label>
                <textarea name="admin_note" class="form-control" id="admin_note" required></textarea>
            </div>
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Assign User End-->
<script>
    function printFunction() {
        window.print();
    }
</script>
@endsection
