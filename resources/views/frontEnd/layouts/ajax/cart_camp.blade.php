@php
    $subtotal = Cart::instance('shopping')->subtotal();
    $subtotal = str_replace(',', '', $subtotal);
    $subtotal = str_replace('.00', '', $subtotal);
    $shipping = Session::get('shipping') ? Session::get('shipping') : 0;
    $discount = Session::get('discount') ? Session::get('discount') : 0;
@endphp
<table class="cart_table table table-bordered table-striped text-center mb-0">
    <thead>
        <tr>
            <th style="width: 50%;">Product</th>
            <th style="width: 25%;">Amount</th>
            <th style="width: 25%;">Price</th>
        </tr>
    </thead>

    <tbody>
        @foreach (Cart::instance('shopping')->content() as $value)
            <tr>
                <td class="text-left">
                    <div>
                        <img src="{{ asset($value->options->image) }}"  style="height: 30px; width: 30px;">
                       <p> {{ Str::limit($value->name, 20) }}</p>
                       @if($value->options->product_size)
                       <p> Size : {{ $value->options->product_size}}</p>
                       @endif
                        @if($value->options->product_color)
                       <p> Color : {{ $value->options->product_color}}</p>
                       @endif
                    </div>
                </td>
                <td width="15%" class="cart_qty">
                    <div class="qty-cart vcart-qty">
                        <div class="quantity">
                            <button class="minus cart_decrement" data-id="{{ $value->rowId }}">-</button>
                            <input type="text" value="{{ $value->qty }}" readonly />
                            <button class="plus  cart_increment" data-id="{{ $value->rowId }}">+</button>
                        </div>
                    </div>
                </td>
                <td>৳{{ $value->price * $value->qty }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="2" class="text-end px-4">Total</th>
            <td>
                <span id="net_total"><span class="alinur">৳ </span><strong>{{ $subtotal }}</strong></span>
            </td>
        </tr>
        <tr>
            <th colspan="2" class="text-end px-4">Delivery Charge</th>
            <td>
                <span id="cart_shipping_cost"><span class="alinur">৳ </span><strong>{{ $shipping }}</strong></span>
            </td>
        </tr>
        <tr>
            <th colspan="2" class="text-end px-4">TOTAL</th>
            <td>
                <span id="grand_total"><span class="alinur">৳
                    </span><strong>{{ $subtotal + $shipping }}</strong></span>
            </td>
        </tr>
    </tfoot>
</table>

<script src="{{ asset('public/frontEnd/js/jquery-3.6.3.min.js') }}"></script>
<!-- cart js start -->
<script>
            $(".cart_increment").on("click", function () {
                var id = $(this).data("id");
                if (id) {
                    $.ajax({
                        type: "GET",
                        data: { id: id },
                        url: "{{route('cart.increment_camp')}}",
                        success: function (data) {
                            if (data) {
                                $(".cartlist").html(data);
                            }
                        },
                    });
                }
            });

            $(".cart_decrement").on("click", function () {
                var id = $(this).data("id");
                if (id) {
                    $.ajax({
                        type: "GET",
                        data: { id: id },
                        url: "{{route('cart.decrement_camp')}}",
                        success: function (data) {
                            if (data) {
                                $(".cartlist").html(data);
                            }
                        },
                    });
                }
            });
            $(".stock_check").on("click", function () {
                var color = $(".stock_color:checked").data('color');
                var size = $(".stock_size:checked").data('size');
                if(id){
                    $.ajax({
                        type: "GET",
                        data: { id:id,color: color ,size:size},
                        url: "{{route('campaign.stock_check')}}",
                        dataType: "json",
                        success: function(status){
                            if(status == true){
                                $('.confirm_order').prop('disabled', false);
                                return cart_content();
                            }else{
                                $('.confirm_order').prop('disabled', true);
                                toastr.error('Stock Out',"Please select another color or size");
                            }
                            console.log(status);
                            // return cart_content();
                        }
                    });
                }
            });
            function cart_content() {
                $.ajax({
                    type: "GET",
                    url: "{{route('cart.content_camp')}}",
                    success: function (data) {
                        if (data) {
                           $(".cartlist").html(data);
                        } else {
                           $(".cartlist").html(data);
                        }
                    },
                });
            }
        </script>
<!-- cart js end -->
