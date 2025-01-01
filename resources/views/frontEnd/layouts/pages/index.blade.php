@extends('frontEnd.layouts.master') 
@section('title', $generalsetting->meta_title) 
@push('seo')
<meta name="app-url" content="" />
<meta name="robots" content="index, follow" />
<meta name="description" content="{{$generalsetting->meta_description}}" />
<meta name="keywords" content="{{$generalsetting->meta_keyword}}" />
<!-- Open Graph data -->
<meta property="og:title" content="{{$generalsetting->meta_title}}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="" />
<meta property="og:image" content="{{ asset($generalsetting->white_logo) }}" />
<meta property="og:description" content="{{$generalsetting->meta_description}}" />
@endpush 
@push('css')
<link rel="stylesheet" href="{{ asset('public/frontEnd/css/owl.carousel.min.css') }}" />
<link rel="stylesheet" href="{{ asset('public/frontEnd/css/owl.theme.default.min.css') }}" />
@endpush 
@section('content')
<section class="slider-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="home-slider-container">
                    <div class="main_slider owl-carousel">
                        @foreach ($sliders as $key => $value)
                            <div class="slider-item">
                               <a href="{{$value->link}}">
                                    <img src="{{ asset($value->image) }}" alt="" />
                               </a>
                            </div>
                            <!-- slider item -->
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- col-end -->
        </div>
    </div>
</section>
<!-- slider end -->
<section class="homeproduct">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="section-title">
                    <h3> <a href="{{route('bestdeals')}}">Best Deals</a></h3>
                    <a href="{{route('bestdeals')}}" class="view_all">View All</a>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="product_slider owl-carousel">
                    @foreach ($hotdeal_top as $key => $value)
                        <div class="product_item wist_item">
                            @include('frontEnd.layouts.partials.product')
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- section banners -->
<section class="section__banner">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="banner__items">
                    @foreach($sliderrightads as $key=>$value)
                    <div class="banner__item">
                        <a href=""><img src="{{asset($value->image)}}" alt="{{$value->name}}"></a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@foreach ($homecategory as $homecat)
    <section class="homeproduct">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="section-title">
                        <h3><a href="{{route('category',$homecat->slug)}}">{{$homecat->name}} </a></h3>
                        <a href="{{route('category',$homecat->slug)}}" class="view_all">View All</a>
                    </div>
                </div>
                @php
                    $products = App\Models\Product::where(['status' => 1,'approval'=>1, 'category_id' => $homecat->id])
                        ->orderBy('id', 'DESC')
                        ->select('id', 'name', 'slug','status','approval', 'new_price', 'old_price', 'type','category_id')
                        ->withCount('variable')
                        ->limit(12)
                        ->get();
                @endphp
                <div class="col-sm-12">
                    <div class="product_slider owl-carousel">
                        @foreach ($products as $key => $value)
                            <div class="product_item wist_item">
                               @include('frontEnd.layouts.partials.product')
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endforeach

    <div class="home-category mt-4">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="category-title">
                        <h3>Featured Brands</h3>
                    </div>
                    <div class="category-sliders owl-carousel">
                        @foreach($brands as $key=>$value)
                        <div class="brand-item">
                            <a href="{{route('brand',$value->slug)}}">
                                <img src="{{asset($value->image)}}" alt="">
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-gap"></div>
@endsection 
@push('script')
<script src="{{ asset('public/frontEnd/js/owl.carousel.min.js') }}"></script>
<script>
    $(document).ready(function() {
        
        // main slider 
        $(".main_slider").owlCarousel({
            items: 1,
            loop: true,
            dots: false,
            autoplay: true,
            nav: true,
            autoplayHoverPause: false,
            margin: 0,
            mouseDrag: true,
            smartSpeed: 8000,
            autoplayTimeout: 3000,

            navText: ["<i class='fa-solid fa-angle-left'></i>",
                "<i class='fa-solid fa-angle-right'></i>"
            ],
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: false,
                },
                600: {
                    items: 1,
                },
                1000: {
                    items: 1,
                },
            },
        });

         $(".category-slider").owlCarousel({
            margin: 15,
            loop: true,
            dots: false,
            nav: false,
            autoplay: true,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 3,
                },
                600: {
                    items: 3,
                },
                1000: {
                    items: 6,
                },
            },
        });
  
        $(".product_slider").owlCarousel({
            margin: 10,
            items: 7,
            loop: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 2,
                    nav: false,
                },
                600: {
                    items: 5,
                    nav: false,
                },
                1000: {
                    items: 6,
                    nav: false,
                },
            },
        });
    });
</script>
@endpush
