@extends('frontEnd.layouts.seller.master')
@section('title', 'Product Create')
@push('css')
    <style>
        .increment_btn,
        .remove_btn {
            margin-top: -17px;
            margin-bottom: 10px;
        }
    </style>
    <link href="{{ asset('public/backEnd') }}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backEnd') }}/assets/libs/summernote/summernote-lite.min.css" rel="stylesheet"
        type="text/css" />
@endpush
@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ route('seller.products.index') }}" class="btn btn-primary rounded-pill">Manage</a>
                    </div>
                    <h4 class="page-title">Product Create</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('seller.products.store') }}" method="POST" class="row"
                            data-parsley-validate="" enctype="multipart/form-data">
                            @csrf

                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Product Name *</label>
                                    @if (request()->has('product'))
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" value="{{ $product->name ?? old('name') }}" id="name"
                                            required />
                                        <input type="hidden" name="product" value="{{ request()->get('product') }}">
                                    @else
                                        <select class="form-control select2 @error('product') is-invalid @enderror"
                                            name="product" value="{{ old('product') }}" id="product" required>
                                            <option value="">Select..</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                    @error('product')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->
                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label for="category_id" class="form-label">Categories *</label>
                                    <select class="form-control select2 @error('category_id') is-invalid @enderror"
                                        name="category_id" value="{{ old('category_id') }}" id="category_id" required>
                                        <option value="">Select..</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col end -->



                            <div class="col-sm-4 mb-3">
                                <label for="image" class="form-label">Product Image (ctrl to multiple) *</label>
                                <div class="input-group control-group">
                                    <input type="file" name="image[]" multiple
                                        class="form-control @error('image') is-invalid @enderror" />
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="product_img">
                                    @foreach ($product->images as $image)
                                        <img src="{{ asset($image->image) }}" class="edit-image border"
                                            alt="" />

                                    @endforeach
                                </div>

                            </div>
                            <!-- col end -->

                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label for="type" class="form-label">Product Type</label>
                                    <select class="form-control select2 @error('type') is-invalid @enderror"
                                        value="{{ old('type') }}" id="product_type" name="type" >
                                        <option value="1" {{ $product->type == 1 ? 'selected' : '' }} >Normal Product</option>
                                        <option value="0" {{ $product->type == 0 ? 'selected' : '' }} >Variable Product</option>
                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->

                            @if ($product->type == 0)
                                <div class="variable_product ">
                                    <!-- variable edit part -->
                                    @foreach ($variables as $variable)
                                    <div class="border p-2 mb-2">

                                        <div class="row mb-2 ">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="sizes" class="form-label">Size/Weight</label>
                                                    <select class="form-control" name="sizes[]">
                                                        <option value="">Select</option>
                                                        @foreach ($sizes as $size)
                                                            <option value="{{ $size->name }}"
                                                                @if ($variable->size == $size->name) selected @endif>
                                                                {{ $size->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('sizes')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!--col end -->
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="up_color" class="form-label">Color </label>
                                                    <select class="form-control" name="colors[]">
                                                        <option value="">Select</option>
                                                        @foreach ($colors as $color)
                                                            <option value="{{ $color->name }}"
                                                                @if ($variable->color == $color->name) selected @endif>
                                                                {{ $color->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('up_color')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!--col end -->


                                            <!-- col-end -->
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="old_prices" class="form-label">Old Price</label>
                                                    <input type="text"
                                                        class="form-control @error('old_prices') is-invalid @enderror"
                                                        name="old_prices[]"
                                                        value="{{ $variable->old_price }}"
                                                        id="old_prices" />
                                                    @error('old_prices')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!-- col-end -->
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="new_prices" class="form-label">New Price *</label>
                                                    <input type="text"
                                                        class="form-control @error('new_prices') is-invalid @enderror"
                                                         name="new_prices[]"
                                                         value="{{ $variable->new_price }}"
                                                        id="new_prices" />
                                                    @error('new_prices')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!-- col-end -->
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="stocks" class="form-label">Stock *</label>
                                                    <input type="text" class="form-control" name="stocks[]"
                                                        value="{{ $variable->stock }}">
                                                    @error('stocks')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="up_images">Color Image </label>
                                                    <div class="input-group control-group">

                                                        <div class="input-group-btn">
                                                        </div>
                                                        @error('images[]')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                @if($variable->image)
                                                <img src="{{ asset($variable->image) }}" class="edit-image border mt-1">
                                                @endif
                                            </div>


                                            <!-- col end -->

                                        </div>
                                    </div>
                                    @endforeach
                                    <!--edit variable product  end-->

                                    <!-- new variable add-->
                                    <div class="row mt-3">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="roles" class="form-label">Size/Weight *</label>
                                                <select class="form-control" name="sizes[]">
                                                    <option value="">Select</option>
                                                    @foreach ($sizes as $size)
                                                        <option value="{{ $size->name }}">{{ $size->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('sizes')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!--col end -->
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="color" class="form-label">Color </label>
                                                <select class="form-control" name="colors[]">
                                                    <option value="">Select</option>
                                                    @foreach ($colors as $color)
                                                        <option value="{{ $color->name }}">{{ $color->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('color')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!--col end -->

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="purchase_prices" class="form-label">Purchase Price *</label>
                                                <input type="text"
                                                    class="form-control @error('purchase_prices') is-invalid @enderror"
                                                    name="purchase_prices[]" value="{{ old('purchase_prices') }}"
                                                    id="purchase_prices" />
                                                @error('purchase_price')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- col-end -->
                                        <!-- col-end -->
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="old_prices" class="form-label">Old Price</label>
                                                <input type="text"
                                                    class="form-control @error('old_prices') is-invalid @enderror"
                                                    name="old_prices[]" value="{{ old('old_prices') }}"
                                                    id="old_prices" />
                                                @error('old_prices')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- col-end -->
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="new_prices" class="form-label">New Price *</label>
                                                <input type="text"
                                                    class="form-control @error('new_prices') is-invalid @enderror"
                                                    name="new_prices[]" value="{{ old('new_prices') }}"
                                                    id="new_prices" />
                                                @error('new_prices')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- col-end -->
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="stocks" class="form-label">Stock *</label>
                                                <input type="text" class="form-control" name="stocks[]">
                                                @error('stocks')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-8 mt-2">
                                            <div class="form-group">
                                                <label for="images" class="form-label">Color Image </label>
                                                <div class="input-group control-group">
                                                    <input type="file" name="images[]"
                                                        class="form-control @error('images') is-invalid @enderror" />
                                                    <div class="input-group-btn">
                                                    </div>
                                                    @error('images[]')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <!-- col end -->


                                        <!-- col end -->
                                        <div class="input-group-btn mt-2">
                                            <button class="btn btn-success increment_btn  btn-xs text-white"
                                                type="button"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <div class="clone_variable" style="display:none">
                                        <div class="row increment_control">
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="roles" class="form-label">Size/Weight</label>
                                                    <select class="form-control" name="sizes[]">
                                                        <option value="">Select</option>
                                                        @foreach ($sizes as $size)
                                                            <option value="{{ $size->name }}">{{ $size->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('size')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!--col end -->
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="color" class="form-label">Color </label>
                                                    <select class="form-control " name="colors[]">
                                                        <option value="">Select</option>
                                                        @foreach ($colors as $color)
                                                            <option value="{{ $color->name }}">
                                                                {{ $color->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('size')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!--col end -->
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="purchase_prices" class="form-label">Purchase Price
                                                        *</label>
                                                    <input type="text"
                                                        class="form-control @error('purchase_prices') is-invalid @enderror"
                                                        name="purchase_prices[]" value="{{ old('purchase_prices') }}"
                                                        id="purchase_prices" />
                                                    @error('purchase_prices')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!-- col-end -->
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="old_prices" class="form-label">Old Price</label>
                                                    <input type="text"
                                                        class="form-control @error('old_prices') is-invalid @enderror"
                                                        name="old_prices[]" value="{{ old('old_prices') }}"
                                                        id="old_prices" />
                                                    @error('old_prices')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!-- col-end -->
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="new_prices" class="form-label">New Price *</label>
                                                    <input type="text"
                                                        class="form-control @error('new_prices') is-invalid @enderror"
                                                        name="new_prices[]" value="{{ old('new_prices') }}"
                                                        id="new_prices" />
                                                    @error('new_prices')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!-- col-end -->
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="stocks" class="form-label">Stock *</label>
                                                    <input type="text"
                                                        class="form-control @error('stock') is-invalid @enderror"
                                                        name="stocks[]" value="{{ old('stocks') }}" id="stocks">
                                                    @error('stocks[]')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                        <div class="col-sm-8 mt-2">
                                            <div class="form-group">
                                                <label for="images" class="form-label">Color Image </label>
                                                <div class="input-group control-group">
                                                    <input type="file" name="images[]"
                                                        class="form-control @error('images') is-invalid @enderror" />
                                                    <div class="input-group-btn">
                                                    </div>
                                                    @error('images[]')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <!-- col end -->

                                            <div class="input-group-btn mt-2">
                                                <button class="btn btn-danger remove_btn  btn-xs text-white"
                                                    type="button"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="normal_product">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group mb-3">
                                                <label for="purchase_price" class="form-label">Purchase Price *</label>
                                                <input type="text"
                                                    class="form-control @error('purchase_price') is-invalid @enderror"
                                                    name="purchase_price" value="{{ $edit_data->purchase_price }}"
                                                    id="purchase_price" />
                                                @error('purchase_price')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- col-end -->
                                        <!-- col-end -->
                                        <div class="col-sm-3">
                                            <div class="form-group mb-3">
                                                <label for="old_price" class="form-label">Old Price</label>
                                                <input type="text"
                                                    class="form-control @error('old_price') is-invalid @enderror"
                                                    name="old_price" value="{{ $edit_data->old_price }}"
                                                    id="old_price" />
                                                @error('old_price')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- col-end -->
                                        <div class="col-sm-3">
                                            <div class="form-group mb-3">
                                                <label for="new_price" class="form-label">New Price *</label>
                                                <input type="text"
                                                    class="form-control @error('new_price') is-invalid @enderror"
                                                    name="new_price" value="{{ $edit_data->new_price }}"
                                                    id="new_price" />
                                                @error('new_price')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- col-end -->

                                        <div class="col-sm-3">
                                            <div class="form-group mb-3">
                                                <label for="stock" class="form-label">Stock *</label>
                                                <input type="text"
                                                    class="form-control @error('stock') is-invalid @enderror"
                                                    name="stock" value="{{ $edit_data->stock }}" id="stock" />
                                                @error('stock')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- col-end -->
                                    </div>
                                </div>
                                <!-- normal product end -->
                            @endif

                            @if(request()->has('product'))
                            <div class="normal_product">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group mb-3">
                                            <label for="purchase_price" class="form-label">Purchase Price *</label>
                                            <input type="text"
                                                class="nrequired form-control @error('purchase_price') is-invalid @enderror"
                                                name="purchase_price" value="{{ $product->purchase_price ?? old('purchase_price') }}"
                                                id="purchase_price" />
                                            @error('purchase_price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- col-end -->
                                    <!-- col-end -->
                                    <div class="col-sm-3">
                                        <div class="form-group mb-3">
                                            <label for="old_price" class="form-label">Old Price</label>
                                            <input type="text"
                                                class="form-control @error('old_price') is-invalid @enderror"
                                                name="old_price" value="{{ $product->old_price ?? old('old_price') }}" id="old_price" />
                                            @error('old_price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- col-end -->
                                    <div class="col-sm-3">
                                        <div class="form-group mb-3">
                                            <label for="new_price" class="form-label">New Price *</label>
                                            <input type="text"
                                                class="nrequired form-control @error('new_price') is-invalid @enderror"
                                                name="new_price" value="{{ $product->new_price ?? old('new_price') }}" id="new_price" />
                                            @error('new_price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- col-end -->

                                    <div class="col-sm-3">
                                        <div class="form-group mb-3">
                                            <label for="stock" class="form-label">Stock *</label>
                                            <input type="text"
                                                class="nrequired form-control @error('stock') is-invalid @enderror"
                                                name="stock" value="{{ $product->stock ?? old('stock') }}" id="stock" />
                                            @error('stock')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- col-end -->
                                </div>
                            </div>
                            @endif
                            <!-- normal product end -->
                            <div class="variable_product" style="display:none">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="roles" class="form-label">Size/Weight</label>
                                            <select class="form-control" name="sizes[]">
                                                <option value="">Select</option>
                                                @foreach ($sizes as $size)
                                                    <option value="{{ $size->name }}">{{ $size->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('sizes')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!--col end -->
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="color" class="form-label">Color</label>
                                            <select class="form-control" name="colors[]">
                                                <option value="">Select</option>
                                                @foreach ($colors as $color)
                                                    <option value="{{ $color->name }}">{{ $color->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('color')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!--col end -->

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="purchase_prices" class="form-label">Purchase Price *</label>
                                            <input type="text"
                                                class="form-control @error('purchase_prices') is-invalid @enderror"
                                                name="purchase_prices[]" value="{{ old('purchase_prices') }}"
                                                id="purchase_prices" />
                                            @error('purchase_price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- col-end -->
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="old_prices" class="form-label">Old Price </label>
                                            <input type="text"
                                                class="form-control @error('old_prices') is-invalid @enderror"
                                                name="old_prices[]" value="{{ old('old_prices') }}" id="old_prices" />
                                            @error('old_prices')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- col-end -->
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="new_prices" class="form-label">New Price *</label>
                                            <input type="text"
                                                class="form-control @error('new_prices') is-invalid @enderror"
                                                name="new_prices[]" value="{{ old('new_prices') }}" id="new_prices" />
                                            @error('new_prices')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- col-end -->
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="stocks" class="form-label">Stock *</label>
                                            <input type="text" class="form-control" name="stocks[]">
                                            @error('stocks')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="images" class="form-label">Color Image </label>
                                            <div class="input-group control-group">
                                                <input type="file" name="images[]"
                                                    class="form-control @error('images') is-invalid @enderror" />
                                                <div class="input-group-btn">
                                                </div>
                                                @error('images[]')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- col end -->
                                    <div class="input-group-btn mt-3">
                                        <button class="btn btn-success increment_btn  btn-xs text-white" type="button"><i
                                                class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                                <div class="clone_variable" style="display:none">
                                    <div class="row increment_control">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="roles" class="form-label">Size/Weight</label>
                                                <select class="form-control" name="sizes[]">
                                                    <option value="">Select</option>
                                                    @foreach ($sizes as $size)
                                                        <option value="{{ $size->name }}">{{ $size->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('size')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!--col end -->
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="color" class="form-label">Color </label>
                                                <select class="form-control " name="colors[]">
                                                    <option value="">Select</option>
                                                    @foreach ($colors as $color)
                                                        <option value="{{ $color->name }}">{{ $color->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('size')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!--col end -->
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="purchase_prices" class="form-label">Purchase Price *</label>
                                                <input type="text"
                                                    class="form-control @error('purchase_prices') is-invalid @enderror"
                                                    name="purchase_prices[]" value="{{ old('purchase_prices') }}"
                                                    id="purchase_prices" />
                                                @error('purchase_prices')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- col-end -->
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="old_prices" class="form-label">Old Price </label>
                                                <input type="text"
                                                    class="form-control @error('old_prices') is-invalid @enderror"
                                                    name="old_prices[]" value="{{ old('old_prices') }}"
                                                    id="old_prices" />
                                                @error('old_prices')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- col-end -->
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="new_prices" class="form-label">New Price *</label>
                                                <input type="text"
                                                    class="form-control @error('new_prices') is-invalid @enderror"
                                                    name="new_prices[]" value="{{ old('new_prices') }}"
                                                    id="new_prices" />
                                                @error('new_prices')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- col-end -->
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="stocks" class="form-label">Stock *</label>
                                                <input type="text"
                                                    class="form-control @error('stock') is-invalid @enderror"
                                                    name="stocks[]" value="{{ old('stocks') }}" id="stocks">
                                                @error('stocks[]')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="images" class="form-label">Color Image </label>
                                                <div class="input-group control-group">
                                                    <input type="file" name="images[]"
                                                        class="form-control @error('images') is-invalid @enderror" />
                                                    <div class="input-group-btn">
                                                    </div>
                                                    @error('images[]')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <!-- col end -->
                                        <div class="input-group-btn mt-3">
                                            <button class="btn btn-danger remove_btn  btn-xs text-white" type="button"><i
                                                    class="fa fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--variable product  end-->

                            <div class="col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="description" class="form-label">Description *</label>
                                    <textarea name="description" rows="6"
                                        class="summernote form-control @error('description') is-invalid @enderror" required>{{ $product->description ?? '' }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col end -->
                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label for="stock_alert" class="form-label">Stock Alert </label>
                                    <input type="text" class="form-control @error('stock_alert') is-invalid @enderror"
                                        name="stock_alert" value="{{ $product->stock_alert ?? old('stock_alert') }}" id="stock_alert" />
                                    @error('stock_alert')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col end -->
                            <div class="col-sm-8 ">
                                <div class="form-group mb-3">
                                    <label for="meta_title" class="form-label">Meta Title</label>
                                    <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                                        name="meta_title" value="{{ $product->meta_title ?? old('meta_title') }}" id="meta_title" />
                                    @error('meta_title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col end -->
                            <div class="col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="meta_description" class="form-label">Meta Description </label>
                                    <textarea name="meta_description" rows="6"
                                        class="summernote form-control @error('meta_description') is-invalid @enderror">{{ $product->meta_description ?? '' }}</textarea>
                                    @error('meta_description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col end -->
                            <div class="col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="meta_keyword" class="form-label">Meta Keyword </label>
                                    <textarea name="meta_keyword" rows="6"
                                        class="summernote form-control @error('meta_keyword') is-invalid @enderror">{{ $product->meta_keyword ?? '' }}</textarea>
                                    @error('meta_keyword')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col end -->

                            <!-- col end -->
                            <div class="col-sm-3 mb-3">
                                <div class="form-group">
                                    <label for="status" class="d-block">Status</label>
                                    <label class="switch">
                                        <input type="checkbox" value="1" name="status" {{ $product->topsale == 1 ? 'checked' : '' }} />
                                        <span class="slider round"></span>
                                    </label>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col end -->
                            <div class="col-sm-3 mb-3">
                                <div class="form-group">
                                    <label for="topsale" class="d-block">Best Deals</label>
                                    <label class="switch">
                                        <input type="checkbox" value="1" name="topsale" {{ $product->topsale == 1 ? 'checked' : '' }} />
                                        <span class="slider round"></span>
                                    </label>
                                    @error('topsale')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col end -->
                            <div>
                                <input type="submit" class="btn btn-success" value="Submit" />
                            </div>
                        </form>
                    </div>
                    <!-- end card-body-->
                </div>
                <!-- end card-->
            </div>
            <!-- end col-->
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('public/backEnd/') }}/assets/libs/parsleyjs/parsley.min.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/js/pages/form-validation.init.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/libs/select2/js/select2.min.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/js/pages/form-advanced.init.js"></script>
    <!-- Plugins js -->
    <script src="{{ asset('public/backEnd/') }}/assets/libs//summernote/summernote-lite.min.js"></script>
    <script>
        $(".summernote").summernote({
            placeholder: "Enter Your Text Here",
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.nrequired').attr('required', true);
            $('#product_type').change(function() {
                var id = $(this).val();
                if (id == 1) {
                    $('.nrequired').attr('required', true);
                    $('.barcode').removeAttr('disabled');
                    $('.normal_product').show();
                    $('.variable_product').hide();
                } else {
                    $('.nrequired').removeAttr('required');
                    $('.barcode').attr('disabled', true);
                    $('.variable_product').show();
                    $('.normal_product').hide();
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var serialNumber = 1;
            $(".increment_btn").click(function() {
                var html = $(".clone_variable").html();
                var newHtml = html.replace(/stock\[\]/g, "stock[" + serialNumber + "]");
                $(".variable_product").after(newHtml);
                serialNumber++;
            });
            $("body").on("click", ".remove_btn", function() {
                $(this).parents(".increment_control").remove();
                serialNumber--;
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(".select2").select2();
        });

        // category to sub
        $("#category_id").on("change", function() {
            var ajaxId = $(this).val();
            if (ajaxId) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('ajax-product-subcategory') }}?category_id=" + ajaxId,
                    success: function(res) {
                        if (res) {
                            $("#subcategory_id").empty();
                            $("#subcategory_id").append('<option value="0">Choose...</option>');
                            $.each(res, function(key, value) {
                                $("#subcategory_id").append('<option value="' + key + '">' +
                                    value + "</option>");
                            });
                        } else {
                            $("#subcategory_id").empty();
                        }
                    },
                });
            } else {
                $("#subcategory_id").empty();
            }
        });

        // subcategory to childcategory
        $("#subcategory_id").on("change", function() {
            var ajaxId = $(this).val();
            if (ajaxId) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('ajax-product-childcategory') }}?subcategory_id=" + ajaxId,
                    success: function(res) {
                        if (res) {
                            $("#childcategory_id").empty();
                            $("#childcategory_id").append('<option value="0">Choose...</option>');
                            $.each(res, function(key, value) {
                                $("#childcategory_id").append('<option value="' + key + '">' +
                                    value + "</option>");
                            });
                        } else {
                            $("#childcategory_id").empty();
                        }
                    },
                });
            } else {
                $("#childcategory_id").empty();
            }
        });

        $(document).ready(function() {
            $('#product').change(function() {
                const selectedValue = $(this).val();
                if (selectedValue) {
                    // Redirect to the URL with the selected value as an optional parameter
                    const currentUrl = window.location.origin + window.location.pathname;
                    window.location.href = `${currentUrl}?product=${encodeURIComponent(selectedValue)}`;
                }
            });
        });
    </script>
@endpush
