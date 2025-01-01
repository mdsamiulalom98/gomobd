@extends('backEnd.layouts.master')
@section('title', 'Barcode Print')
@section('css')
    <link href="{{ asset('public/backEnd') }}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <style>
        @page {
            margin: 0mm;
        }

        @media print {

            header,
            footer,
            .no-print,
            .left-side-menu,
            .navbar-custom {
                display: none !important;
            }

            body {
                font-size: 10px !important;
                margin: 0 !important;
                line-height: 1.5 !important;
            }

            p {
                margin: 0 !important;
            }

            .main-items,
            .barcode img,
            .name {
                width: 100% !important;
            }

            .site_name {
                font-size: 11px !important;
                font-weight: 600 !important;
                padding-top: 0px !important;
                margin-bottom: 0px !important;
            }

            .main-items {
                margin-top: -52px !important;
            }

            .barcode {
                padding-top: 0px !important;
                padding-bottom: 0px !important;
            }

            .name,
            .size,
            .size strong,
            .serial,
            .bold-price {
                font-size: 8px !important;
            }

            .bold-price {
                font-size: 8px !important;
            }

            .barcode {
                justify-content: center !important;
                display: flex !important;
            }
        }

        .site_name {
            font-size: 24px;
            font-weight: 800;
            padding-top: 10px;
            margin-bottom: 2px;
        }

        .name {
            text-align: center;
            font-size: 17px;
            font-weight: 700;
            color: #000;
        }

        .main-items {
            display: grid;
            grid-gap: 15px;
            padding-top: 14px;
            width: 60%;
            margin: 0 auto;
        }


        .barcode {
            padding-top: 10px;
            padding-bottom: 5px;
            justify-content: center;
            display: flex;
        }

        .variant-product {
            display: flex;
            justify-content: center;
            gap: 5px;
        }
        
        .variant-product .size {
            font-size: 16px;
            color: #000;
        }
        
        .serial {
            color: #000;
            font-size: 16px;
            font-weight: 700;
        }

        .bold-price {
            font-size: 15px;
            font-weight: 800;
            color: #222;
        }

        .card {
            margin-bottom: 0px;
            text-transform: uppercase;
            color: #222;
        }

        .barcode-item {
            border-radius: 3px;
            background: #fff;
            padding: 0 10px;
        }
    </style>
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-6">
                <div class="page-title-box">
                    <h4 class="page-title no-print">Product Barcode</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="cards">
                    <div class="card-bodys">
                        <div class="row justify-content-center">
                            <div class="col-sm-12 no-print">
                                <form action="" class="row justify-content-center">
                                    <div class="col-sm-8">
                                        <div class="form-group mb-3">
                                            <label for="product_id" class="form-label">Products *</label>
                                            <select class="form-control select2 @error('product_id') is-invalid @enderror"
                                                name="product_id" value="{{ old('product_id') }}" id="product_id" required>
                                                <option value="">Select Product..</option>
                                                @foreach ($data as $key => $value)
                                                    @if ($value->type == 1)
                                                        <option value="{{ $value->id }}" data-type="1"
                                                            @if (request()->type == 1 && $value->id == request()->product_id) selected @endif>
                                                            {{ $value->name }} - {{ $value->new_price }}</option>
                                                    @else
                                                        @foreach ($value->variables as $index => $variable)
                                                            <option value="{{ $variable->id }}" data-type="0"
                                                                @if (request()->type == 0 && $variable->id == request()->product_id) selected @endif>
                                                                {{ $value->name }} @if ($variable->color)
                                                                    - {{ $variable->color }}
                                                                    @endif @if ($variable->size)
                                                                        - {{ $variable->size }}
                                                                    @endif - {{ $variable->new_price }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('product_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <input type="hidden" name="type" id="type-input" value="">
                                    <!--col end-->
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <button class="btn btn-success d-block" style="margin:0 auto">Submit</button>
                                        </div>
                                    </div>
                                    <!--col end-->
                                </form>
                            </div>
                            <!--col end-->
                            @if ($barcode != null)
                                <div class="col-sm-6">
                                    <div class="row invoic4-inner">
                                        <div class="col-sm-12 my-3 text-center">
                                            <button style="margin-top: 27px;" onclick="printFunction()" class="no-print btn btn-xs btn-success waves-effect waves-light">
                                                <i class="fa fa-print"></i>
                                            </button>
                                        </div>
                                        <div class="main-items">

                                            @if (request()->type == 1)
                                                <div class="barcode-item">
                                                    <div class="cards">
                                                        <div class="card-bodys text-center">
                                                            <p class="site_name"> {{ $generalsetting->name }}</p>
                                                            <div class="name">{{ $product->name }}</div>
                                                            <div class="size bold-price"><strong>Price:
                                                                </strong>{{ $barcode->new_price }} Tk</div>
                                                            <div class="barcode">
                                                                <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($barcode->pro_barcode, 'C39') }}" />
                                                            </div>
                                                            <div class="serial">
                                                                {{ $barcode->pro_barcode }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="barcode-item">
                                                    <div class="cards">
                                                        <div class="card-bodys text-center">
                                                            <p class="site_name">{{ $generalsetting->name }}</p>
                                                            <div class="name">{{ $product->name }}</div>
                                                            <div class="size bold-price"><strong>Price:
                                                                </strong>{{ $barcode->new_price }} Tk</div>
                                                            <div class="variant-product">
                                                                <div class="size"><strong>Size:
                                                                    </strong>{{ $barcode->size }}</div>
                                                                <div class="size"><strong>Color:
                                                                    </strong>{{ $barcode->color }}</div>
                                                            </div>
                                                            <div class="barcode">
                                                                <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($barcode->pro_barcode, 'C39') }}" />
                                                            </div>
                                                            <div class="serial">{{ $barcode->pro_barcode }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            @endif
                            <!--barcode col end-->
                        </div>

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
    </div>
    <script>
        function printFunction() {
            window.print();
        }
    </script>
@endsection
@section('script')
    <script src="{{ asset('public/backEnd/') }}/assets/libs/select2/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".select2").select2();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('select').change(function() {
                var selectedOption = $(this).find(':selected');
                var type = selectedOption.data('type');
                $('#type-input').val(type);
            });
        });
    </script>
@endsection
