@extends('backEnd.layouts.master')
@section('title', 'Product Purchase')
@section('css')
    <link href="{{ asset('public/backEnd') }}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-6">
                <div class="page-title-box">
                    <h4 class="page-title no-print">Product Purchase</h4>
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
                                <form action="{{route('products.purchase_store')}}" method="POST" class="row justify-content-center">
                                    @csrf
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
                                                            {{ $value->name }} - {{ $value->new_price }} Tk</option>
                                                    @else
                                                        @foreach ($value->variables as $index => $variable)
                                                            <option value="{{ $variable->id }}" data-type="0"
                                                                @if (request()->type == 0 && $variable->id == request()->product_id) selected @endif>
                                                                {{ $value->name }} @if ($variable->color)
                                                                    - {{ $variable->color }}
                                                                    @endif @if ($variable->size)
                                                                        - {{ $variable->size }}
                                                                    @endif - {{ $variable->new_price }} Tk
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
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <label for="qty" class="form-label">Quantity *</label>
                                            <input type="text" name="qty" value="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 mt-3">
                                        <div class="form-group">
                                            <button class="btn btn-success d-block" style="margin:0 auto">Submit</button>
                                        </div>
                                    </div>
                                    <!--col end-->
                                </form>
                            </div>
                            <!--col end-->
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
