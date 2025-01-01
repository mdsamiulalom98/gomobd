@extends('frontEnd.layouts.master')
@section('title', 'Order Success')
@section('content')
    <section class="customer-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-8 my-5">
                    <div class="text-center">
                        <i class="bg-success fa fa-check rounded-5 text-white" style="width: 40px; height: 40px; line-height: 40px"></i>
                    </div>
                    <p class="hind-siliguri text-lg text-center my-2">"{{ $generalsetting->name }}" এ অর্ডার করার জন্য আপনাকে ধন্যবাদ।</p>
                    <p class="hind-siliguri text-base text-center my-2">আসসালামু আলাইকুম, আপনার অর্ডার টি কনফার্ম করা হয়েছে।  আপনার  অর্ডার নাম্বার হল - {{$order->invoice_id}} ।<br> যে কোন প্রয়োজনে - {{ $contact->hotline }}</p>
                    <p class="text-center my-2">
                        <b class="hind-siliguri text-lg">দয়া করে প্রোডাক্ট টি রিসিভ করার সময় চেক করে নিবেন।</b>
                    </p>
                    <p class="text-center">
                        <b class="hind-siliguri text-lg">প্রোডাক্ট বুঝে নিয়ে টাকা পরিশোধ করুন। ডেলিভারিম্যান চলে যাওয়ার পর কোনো অভিযোগ নেওয়া হবে না।</b>
                    </p>
                    <div class="text-center">
                        <a href="{{ route('home') }}" class="btn btn-success d-inline-block my-3 p-2 text-white px-5 ">Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
