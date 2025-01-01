@extends('frontEnd.layouts.master')
@section('title', 'Customer Account')
@section('content')
    <section class="customer-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="customer-sidebar">
                        @include('frontEnd.layouts.customer.sidebar')
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="customer-content">
                        <h5 class="account-title">EMEI Information</h5>


                        <div class="emei-box table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Paid Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @php
                                    $totalAmount = $order->emi_amount;
                                    $remainingAmount = $totalAmount - $order->down_payment;
                                    $startDate = $order->created_at;
                                    $currentDate = new DateTime($startDate);
                                    $today = new DateTime();
                                @endphp

                                <tbody>
                                    @foreach ($order->installments as $key => $value)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $value->due_date }}
                                            </td>
                                            <td>৳{{ $value->amount }}</td>
                                            <td>{{ $value->paid_amount }}</td>
                                            <td>
                                                @php
                                                    $dueDate = new DateTime($value->due_date);
                                                @endphp
                                                @if ($dueDate < $today)
                                                    <span class="text-danger">Date Passed</span>
                                                @else
                                                    <span class="text-success">Upcoming</span>
                                                @endif
                                                <span class="badge bg-warning btn text-capitalize">
                                                    {{ $value->status }}
                                                </span>
                                            </td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
