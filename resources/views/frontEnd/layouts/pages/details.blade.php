@extends('frontEnd.layouts.master')
@section('title', $details->name)

@push('seo')
    <meta name="app-url" content="{{ route('product', $details->slug) }}" />
    <meta name="robots" content="index, follow" />
    <meta name="description" content="{{ $details->meta_description }}" />
    <meta name="keywords" content="{{ $details->slug }}" />

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product" />
    <meta name="twitter:site" content="{{ $details->name }}" />
    <meta name="twitter:title" content="{{ $details->name }}" />
    <meta name="twitter:description" content="{{ $details->meta_description }}" />
    <meta name="twitter:creator" content="{{ $generalsetting->name }}" />
    <meta property="og:url" content="{{ route('product', $details->slug) }}" />
    <meta name="twitter:image" content="{{ asset($details->image->image ?? '') }}" />

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $details->name }}" />
    <meta property="og:type" content="product" />
    <meta property="og:url" content="{{ route('product', $details->slug) }}" />
    <meta property="og:image" content="{{ asset($details->image->image ?? '') }}" />
    <meta property="og:description" content="{{ $details->meta_description }}" />
    <meta property="og:site_name" content="{{ $details->name }}" />
@endpush

@section('content')
    <div class="homeproduct main-details-page">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="details-product">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="position-relative">
                                    @if ($details->old_price)
                                        <div class="discount">
                                            <p> @php $discount=(((($details->old_price)-($details->new_price))*100) / ($details->old_price)) @endphp {{ number_format($discount, 0) }}% Discount</p>
                                        </div>
                                    @endif
                                    {{-- @if ($details->variableimages->count() > 0) --}}
                                        {{-- <div class="details_slider owl-carousel">
                                            @foreach ($details->variableimages as $value)
                                                <div class="dimage_item">
                                                    <img src="{{ asset($value->image) }}" class="block__pic" />
                                                </div>
                                            @endforeach
                                        </div>
                                        <div
                                            class="indicator_thumb @if ($details->variableimages->count() > 4) thumb_slider owl-carousel @endif">
                                            @foreach ($details->variableimages as $key => $value)
                                                <div class="indicator-item" data-id="{{ $key }}">
                                                    <p>{{ $value->name }}</p>
                                                    <img src="{{ asset($value->image) }}" />
                                                </div>
                                            @endforeach
                                        </div> --}}

                                        <!-- normal product image -->
                                    {{-- @else --}}
                                        <div class="details_slider owl-carousel">
                                            @foreach ($sliderimages as $key => $value)
                                                <div class="dimage_item">
                                                    <img src="{{ asset($value['image'] ?? '') }}" class="block__pic" />
                                                </div>
                                            @endforeach
                                        </div>
                                        <div
                                            class="indicator_thumb @if ($sliderimages > 4) thumb_slider owl-carousel @endif">
                                            @foreach ($sliderimages as $key => $value)
                                                <div class="indicator-item" data-id="{{ $key }}">
                                                    <img src="{{ asset($value['image'] ?? '') }}" />
                                                </div>
                                            @endforeach
                                        </div>
                                    {{-- @endif --}}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="details_right">
                                    <div class="breadcrumb">
                                        <ul>
                                            <li><a href="{{ url('/') }}">Home</a></li>
                                            <li><span>/</span></li>
                                            <li><a
                                                    href="{{ url('category/' . $details->category->slug) }}">{{ $details->category->name }}</a>
                                            </li>
                                            @if ($details->subcategory)
                                                <li><span>/</span></li>
                                                <li><a
                                                        href="#">{{ $details->subcategory ? $details->subcategory->name : '' }}</a>
                                                </li>
                                                @endif @if ($details->childcategory)
                                                    <li><span>/</span></li>
                                                    <li> <a href="#">{{ $details->childcategory->name }}</a>
                                                    </li>
                                                @endif
                                        </ul>
                                    </div>

                                    <div class="product">
                                        <div class="product-cart">
                                            <p class="name">{{ $details->name }}</p>
                                            @if ($details->variable_count > 0 && $details->type == 0)
                                                <p class="details-price">
                                                    @if ($details->variable->old_price)
                                                        <del>৳ <span
                                                                class="old_price">{{ $details->variable->old_price }}</span></del>
                                                    @endif ৳ <span
                                                        class="new_price">{{ $details->variable->new_price }}</span>
                                                </p>
                                            @else
                                                <p class="details-price">
                                                    @if ($details->old_price)
                                                        <del>৳ <span
                                                                class="old_price">{{ $details->old_price }}</span></del>
                                                    @endif ৳ <span
                                                        class="new_price">{{ $details->new_price }}</span>
                                                </p>
                                            @endif
                                            <form action="{{ route('cart.store') }}" method="POST" name="formName">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $details->id }}" />
                                                <input type="hidden" name="category_id"
                                                    value="{{ $details->category_id }}" />
                                                @if ($productcolors->count() > 0)
                                                    <div class="pro-color">
                                                        <p class="color-title">Select Color </p>
                                                        <div class="color_inner">
                                                            <div class="size-container">
                                                                <div class="selector">
                                                                    @foreach ($productcolors as $key => $procolor)
                                                                        <div class="selector-item color-item"
                                                                            data-id="{{ $key }}">
                                                                            {{ $procolor->image }}
                                                                            <input type="radio"
                                                                                id="fc-option{{ $procolor->color->name ?? '' }}"
                                                                                value="{{ $procolor->color->name ?? '' }}"
                                                                                name="product_color"
                                                                                class="selector-item_radio emptyalert stock_color"
                                                                                required
                                                                                data-color="{{ $procolor->color->name ?? '' }}" />
                                                                            <label
                                                                                for="fc-option{{ $procolor->color->name ?? '' }}"
                                                                                class="selector-item_label">{{ $procolor->color->name ?? '' }}
                                                                            </label>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if ($productsizes->count() > 0)
                                                    <div class="pro-size">
                                                        <p class="color-title">Select Size</p>
                                                        <div class="size_inner">

                                                            <div class="size-container">
                                                                <div class="selector">
                                                                    @foreach ($productsizes as $prosize)
                                                                        <div class="selector-item">
                                                                            <input type="radio"
                                                                                id="f-option{{ $prosize->size }}"
                                                                                value="{{ $prosize->size }}"
                                                                                name="product_size"
                                                                                class="selector-item_radio emptyalert stock_size stock_check"
                                                                                data-size="{{ $prosize->size }}"
                                                                                required />
                                                                            <label for="f-option{{ $prosize->size }}"
                                                                                class="selector-item_label">{{ $prosize->size }}</label>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="pro_brand">
                                                    <p>Brand :
                                                        {{ $details->brand ? $details->brand->name : 'N/A' }}
                                                    </p>
                                                </div>

                                                @if ($productregions->count() > 0)
                                                    <div class="pro-size">
                                                        <p class="color-title">Select Region</p>
                                                        <div class="size_inner">

                                                            <div class="size-container">
                                                                <div class="selector">
                                                                    @foreach ($productregions as $proregion)
                                                                        <div class="selector-item">
                                                                            <input type="radio"
                                                                                id="f-option{{ $proregion->region }}"
                                                                                value="{{ $proregion->region }}"
                                                                                name="product_region"
                                                                                class="selector-item_radio emptyalert stock_region stock_check"
                                                                                data-region="{{ $proregion->region }}"
                                                                                required />
                                                                            <label for="f-option{{ $proregion->region }}"
                                                                                class="selector-item_label">{{ $proregion->region }}</label>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                <h2>Payment Options</h2>
                                                <div class="product-price-options">
                                                    <label class="p-wrap cash active">
                                                        <input type="radio" name="enable_emi" checked=""
                                                            value="0">
                                                        <span
                                                            class="price new_price taka-sign-before">{{ $details->new_price }}</span>
                                                        <div class="p-tag">Cash Discount Price</div>
                                                        <div class="p-tag fade show">Online / Cash Payment</div>
                                                    </label>
                                                    @php
                                                        $new_price = $details->new_price;
                                                        $emi_amount = ($new_price * 12) / 100 + ($new_price * 10) / 100 + $new_price;
                                                        $down_payment = ($emi_amount * 35) / 100;
                                                        $monthly_installment = ($emi_amount - $down_payment) / 10;
                                                    @endphp
                                                    <label class="p-wrap emi">
                                                        <input type="radio" name="enable_emi" value="1">
                                                        <span
                                                            class="price down_payment taka-sign-before">{{ round($monthly_installment, 0) }}</span>
                                                        <div class="p-tag regular">Down Payment: <span
                                                                class="taka-sign-before emi_amount">{{ round($down_payment, 0) }}</span>
                                                        </div>
                                                        <div class="p-tag fade show"><span
                                                                class="taka-sign-before monthly_installment">{{ round($monthly_installment, 0) }}</span>
                                                            EMI for up to 10 Months***</div>
                                                    </label>
                                                </div>
                                                <div class="row">
                                                    <div class="qty-cart col-sm-6">
                                                        <div class="quantity">
                                                            <span class="minus">-</span>
                                                            <input type="text" name="qty" value="1" />
                                                            <span class="plus">+</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="pro_brand stock"></div>
                                                    </div>
                                                </div>
                                                <div class="d-flex single_product col-sm-12">
                                                    <input type="submit" class="btn px-4 add_cart_btn"
                                                        onclick="return sendSuccess();" name="add_cart"
                                                        value="Add To Cart " />

                                                    <input type="submit" class="btn px-4 order_now_btn order_now_btn_m"
                                                        onclick="return sendSuccess();" name="order_now"
                                                        value="Order Now" />
                                                </div>
                                                <div class="mt-md-2 mt-2">
                                                    <h4 class="font-weight-bold">
                                                        <a class="btn btn-success w-100 call_now_btn"
                                                            href="https://api.whatsapp.com/send?phone={{ $contact->whatsapp }}">
                                                            <i class="fa-brands fa-whatsapp"></i>
                                                            {{ $contact->hotline }}
                                                        </a>
                                                    </h4>
                                                </div>
                                                {{--
                                                <div class="mt-3">
                                                    <div class="del_charge_area">
                                                        <table class="table table-bordered">
                                                            <tbody>
                                                                @foreach ($shippingcharge as $key => $value)
                                                                    <tr>
                                                                        <td>Delivery Charge</td>
                                                                        <td>{{ $value->name }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                --}}
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="pro_details_area">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="details-tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="video-tab" data-bs-toggle="tab"
                                    data-bs-target="#video-tab-pane" type="button" role="tab">Video</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link " id="description-tab" data-bs-toggle="tab"
                                    data-bs-target="#description-tab-pane" type="button"
                                    role="tab">Description</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="review-tab" data-bs-toggle="tab"
                                    data-bs-target="#review-tab-pane" type="button" role="tab">Review</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="seller-tab" data-bs-toggle="tab"
                                    data-bs-target="#seller-tab-pane" type="button" role="tab">Seller Info</button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade " id="description-tab-pane" role="tabpanel"
                                aria-labelledby="description-tab" tabindex="0">
                                <div class="description">
                                    {!! $details->description !!}
                                </div>
                            </div>
                            <div class="tab-pane fade" id="review-tab-pane" role="tabpanel" aria-labelledby="review-tab"
                                tabindex="0">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="review-inner">
                                            <div class="review-head">
                                                <div class="review-title">
                                                    <h4>Reviews ({{ $reviews->count() }})</h4>
                                                    <p>Get specific details about this product from customers who own it.
                                                    </p>
                                                </div>
                                                <div class="review-btn">
                                                    <button type="button" data-bs-toggle="modal"
                                                        data-bs-target="#review_modal">
                                                        Give a review
                                                    </button>
                                                </div>
                                            </div>
                                            @if ($reviews->count() > 0)
                                                <div class="customer-review">
                                                    <div class="row">
                                                        @foreach ($reviews as $key => $review)
                                                            <div class="col-sm-12 col-12">
                                                                <div class="review-card">
                                                                    <p class="reviewer_name"><i
                                                                            data-feather="message-square"></i>
                                                                        {{ $review->name }}</p>
                                                                    <p class="review_data">
                                                                        {{ $review->created_at->format('d-m-Y') }}</p>
                                                                    <p class="review_star">{!! str_repeat('<i class="fa-solid fa-star"></i>', $review->ratting) !!}</p>
                                                                    <p class="review_content">{{ $review->review }}</p>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @else
                                                <div class="empty-review">
                                                    <i class="fa fa-clipboard-list"></i>
                                                    <p class="empty-text">This product has no reviews yet. Be the first one
                                                        to Give a review.</p>
                                                </div>
                                            @endif
                                            <div class="modal fade" id="review_modal" tabindex="-1"
                                                aria-labelledby="review_modalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="review_modalLabel">Give your
                                                                review</h1>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="insert-review">
                                                                @if (Auth::guard('customer')->user())
                                                                    <form action="{{ route('customer.review') }}"
                                                                        id="review-form" method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="product_id"
                                                                            value="{{ $details->id }}">
                                                                        <div class="fz-12 mb-2">
                                                                            <div class="rating">
                                                                                <label title="Excelent">
                                                                                    ☆
                                                                                    <input required type="radio"
                                                                                        name="ratting" value="5" />
                                                                                </label>
                                                                                <label title="Best">
                                                                                    ☆
                                                                                    <input required type="radio"
                                                                                        name="ratting" value="4" />
                                                                                </label>
                                                                                <label title="Better">
                                                                                    ☆
                                                                                    <input required type="radio"
                                                                                        name="ratting" value="3" />
                                                                                </label>
                                                                                <label title="Very Good">
                                                                                    ☆
                                                                                    <input required type="radio"
                                                                                        name="ratting" value="2" />
                                                                                </label>
                                                                                <label title="Good">
                                                                                    ☆
                                                                                    <input required type="radio"
                                                                                        name="ratting" value="1" />
                                                                                </label>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="message-text"
                                                                                class="col-form-label">Message:</label>
                                                                            <textarea required class="form-control radius-lg" name="review" id="message-text"></textarea>
                                                                            <span id="validation-message"
                                                                                style="color: red;"></span>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <button class="details-review-button"
                                                                                type="submit">Submit
                                                                                Review</button>
                                                                        </div>

                                                                    </form>
                                                                @else
                                                                    <form action="{{ route('customer.signin') }}"
                                                                        method="POST" data-parsley-validate="">
                                                                        @csrf
                                                                        <input type="hidden" name="review"
                                                                            value="1">
                                                                        <h6 class="mb-3">Please login first</h6>
                                                                        <div class="form-group mb-3">
                                                                            <label for="phone" class="mb-3">Mobile
                                                                                Number *</label>
                                                                            <input type="number" id="phone"
                                                                                class="form-control @error('phone') is-invalid @enderror"
                                                                                placeholder="Enter your mobile number"
                                                                                name="phone"
                                                                                value="{{ old('phone') }}" required>
                                                                            @error('phone')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                        <!-- col-end -->
                                                                        <div class="form-group mb-3">
                                                                            <label for="password" class="mb-3">Password
                                                                                *</label>
                                                                            <input type="password" id="password"
                                                                                class="form-control @error('password') is-invalid @enderror"
                                                                                placeholder="Enter your password"
                                                                                name="password"
                                                                                value="{{ old('password') }}" required>
                                                                            @error('password')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                        <!-- col-end -->
                                                                        <div class="form-group mb-3">
                                                                            <button class="submit-btn"> Login </button>
                                                                        </div>
                                                                        <!-- col-end -->
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade show active" id="video-tab-pane" role="tabpanel" aria-labelledby="video-tab"
                                tabindex="0">
                                <div class="pro_vide">
                                    <iframe width="100%" height="315"
                                        src="https://www.youtube.com/embed/{{ $details->pro_video }}"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen></iframe>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="seller-tab-pane" role="tabpanel" aria-labelledby="seller-tab"
                                tabindex="0">
                                <div class="seller_card">
                                    <a href="{{ route('seller.shop', ['shop_id' => $seller_info->id]) }}">
                                        <div class="seller_img">
                                            <img src="{{ asset($seller_info->image) }}" alt="">
                                        </div>
                                        <div class="seller_info">
                                            <h3>
                                                <a
                                                    href="{{ route('seller.shop', ['shop_id' => $seller_info->id]) }}">{{ $seller_info->name }}</a>
                                            </h3>
                                            <p>{{ $seller_info->address }}</p>
                                            <a href="{{ route('seller.shop', ['shop_id' => $seller_info->id]) }}"
                                                class="seller_shop">Visit Shop</a>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="related-product-section">
        <div class="container">
            <div class="row">
                <div class="related-title">
                    <h5>Related Product</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="product-inner owl-carousel related_slider">
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

@endsection

@push('script')
    <script src="{{ asset('public/frontEnd/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('public/frontEnd/js/zoomsl.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".details_slider").owlCarousel({
                margin: 15,
                items: 1,
                loop: true,
                dots: false,
                nav: false,
                autoplay: false,
            });
            $(".indicator-item,.color-item").on("click", function() {
                var slideIndex = $(this).data('id');
                $('.details_slider').trigger('to.owl.carousel', slideIndex);
            });
            $(".p-wrap").on("click", function() {
                $(".p-wrap").removeClass('active');
                $(this).addClass('active');
                $('.details_slider').trigger('to.owl.carousel', slideIndex);
            });
        });
    </script>
    <!--Data Layer Start-->
    <script type="text/javascript">
        window.dataLayer = window.dataLayer || [];
        dataLayer.push({
            ecommerce: null
        });
        dataLayer.push({
            event: "view_item",
            ecommerce: {
                items: [{
                    item_name: "{{ $details->name }}",
                    item_id: "{{ $details->id }}",
                    @if ($details->variable_count > 0 && $details->type == 0)
                        price: "{{ $details->variable->new_price }}",
                    @else
                        price: "{{ $details->new_price }}",
                    @endif
                    item_brand: "{{ $details->brand ? $details->brand->name : '' }}",
                    item_category: "{{ $details->category->name }}",
                    item_variant: "{{ $details->pro_unit }}",
                    currency: "BDT",
                    quantity: {{ $details->stock ?? 0 }}
                }],

            }
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#add_to_cart').click(function() {
                gtag("event", "add_to_cart", {
                    currency: "BDT",
                    value: "1.5",
                    items: [
                        @foreach (Cart::instance('shopping')->content() as $cartInfo)
                            {
                                item_id: "{{ $details->id }}",
                                item_name: "{{ $details->name }}",
                                price: "{{ $details->new_price }}",
                                currency: "BDT",
                                quantity: {{ $cartInfo->qty ?? 0 }}
                            },
                        @endforeach
                    ]
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#order_now').click(function() {
                gtag("event", "add_to_cart", {
                    currency: "BDT",
                    value: "1.5",
                    items: [
                        @foreach (Cart::instance('shopping')->content() as $cartInfo)
                            {
                                item_id: "{{ $details->id }}",
                                item_name: "{{ $details->name }}",
                                price: "{{ $details->new_price }}",
                                currency: "BDT",
                                quantity: {{ $cartInfo->qty ?? 0 }}
                            },
                        @endforeach
                    ]
                });
            });
        });
    </script>

    <!-- Data Layer End-->
    <script>
        $(document).ready(function() {
            $(".related_slider").owlCarousel({
                margin: 10,
                items: 5,
                loop: true,
                dots: true,
                nav: false,
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
                        items: 3,
                        nav: false,
                    },
                    1000: {
                        items: 5,
                    },
                },
            });
            // $('.owl-nav').remove();
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".minus").click(function() {
                var $input = $(this).parent().find("input");
                var count = parseInt($input.val()) - 1;
                count = count < 1 ? 1 : count;
                $input.val(count);
                $input.change();
                return false;
            });
            $(".plus").click(function() {
                var $input = $(this).parent().find("input");
                $input.val(parseInt($input.val()) + 1);
                $input.change();
                return false;
            });
        });
    </script>

    <script>
        function sendSuccess() {
            // size validation
            // if (document.forms["formName"]["product_size"]) {
            //     size = document.forms["formName"]["product_size"].value;
            //     if (size != "") {} else {
            //         toastr.warning("Please select any size");
            //         return false;
            //     }
            // }
            // if (document.forms["formName"]["product_color"]) {
            //     color = document.forms["formName"]["product_color"].value;
            //     if (color != "") {} else {
            //         toastr.error("Please select any color");
            //         return false;
            //     }
            // }
        }
    </script>
    <script>
        $(document).ready(function() {
            $(".rating label").click(function() {
                $(".rating label").removeClass("active");
                $(this).addClass("active");
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".thumb_slider").owlCarousel({
                margin: 15,
                items: 4,
                loop: true,
                dots: false,
                nav: true,
                autoplayTimeout: 6000,
                autoplayHoverPause: true,
            });
        });
    </script>

    <script type="text/javascript">
        $(".block__pic").imagezoomsl({
            zoomrange: [3, 3]
        });
    </script>
    <script>
        @if ($details->type == 1)
            $(".stock").html('<p><span>Stock : </span>' + {{ $details->stock }} + '</p>');
        @endif
        $(document).on('click', '.stock_size', function () {
            // Uncheck all inputs with the class `size_input`
            // $('.stock_check').prop('checked', false);

            // Optionally, check the input corresponding to the button's value
            // const value = $(this).val();
            // $('.size_input[value="' + value + '"]').prop('checked', true);
        });
        $(".stock_check").on("click", function() {
            var region = $(".stock_region:checked").data('region');
            var size = $(".stock_size:checked").data('size');
            var id = {{ $details->id }};
            console.log(region);
            if (id) {
                $.ajax({
                    type: "GET",
                    data: {
                        id: id,
                        region: region,
                        size: size
                    },
                    url: "{{ route('stock_check') }}",
                    dataType: "json",
                    success: function(response) {
                        if (response.status) {
                            console.log('true' + response.status);
                            $(".stock").html('<p><span>Stock : </span>' + response.product.stock +
                                '</p>');

                            $(".old_price").text(response.product.old_price);
                            $(".new_price").text(response.product.new_price);
                            $(".emi_amount").text(response.emi_amount);
                            $(".down_payment").text(response.down_payment);
                            $(".monthly_installment").text(response.monthly_installment);
                            // cart button enable
                            $('.add_cart_btn').prop('disabled', false);
                            $('.order_now_btn').prop('disabled', false);
                        } else {
                            console.log('false: ' + response.status);
                            toastr.warning("Please select another region or size");
                            $(".old_price").text('0');
                            $(".new_price").text('0');
                            $(".emi_amount").text('0');
                            $(".down_payment").text('0');
                            $(".monthly_installment").text('0');
                            $(".stock").empty();
                            // cart button disabled
                            $('.add_cart_btn').prop('disabled', true);
                            $('.order_now_btn').prop('disabled', true);
                        }
                    }
                });
            }
        });
    </script>

    <!--Microdata -->
    <script type="application/ld+json">
{
  "@context":"https://schema.org",
  "@type":"Product",
  "productID":"{{$details->id}}",
  "name":"{{$details->name}}",
  "description":"{!!$details->description!!}",
  "url":"{{Request::fullUrl()}}",
  "image":"{{asset($details->image->image ?? '')}}",
  "brand":"@if($details->brand_id !=NULL) {{$details->brand->brandName}} @endif",
  "offers": [
    {
      "@type": "Offer",
     @if ($details->variable_count > 0 && $details->type == 0)
      "price": "{{$details->variable->new_price}}",
      @else
      "price": "{{$details->new_price}}",
      @endif
      "priceCurrency": "BDT",
      "itemCondition": "https://schema.org/NewCondition",
      "availability": "https://schema.org/InStock"
    }
  ],
  "additionalProperty": [{
    "@type": "PropertyValue",
    "propertyID": "item_group_id",
    "value": "{{$details->name}}"
  }]
}
</script>
@endpush
