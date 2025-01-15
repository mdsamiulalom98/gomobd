@extends('frontEnd.layouts.master')
@section('title', $details->title)
@section('content')
    <section class="homeproduct product-section">
        <div class="container">
            <div class="sorting-section">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="category-breadcrumb d-flex align-items-center">
                            <a href="{{ route('home') }}">Home</a>
                            <span>/</span>
                            <span>Blog</span>
                            <span>/</span>
                            <strong>{{$details->title}}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-8">
                    <div class="blog-details">
                            <div class="bdetails-img">
                                <img src="{{asset($details->image)}}" alt="">
                            </div>
                            <div class="blog-article">
                                <h5>{{$details->title}}</h5>
                                <div class="blog-description">
                                    {!! $details->description !!}
                                </div>
                                <div class="blog-description">
                                    {!! $details->description1 !!}
                                </div>
                                <div class="blog-description">
                                    {!! $details->description2 !!}
                                </div>
                                <div class="blog-description">
                                    {!! $details->description3 !!}
                                </div>
                                <div class="blog-description">
                                    {!! $details->description4 !!}
                                </div>
                            </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="blog-sidebar">
                        <h6>Latest Blog</h6>
                        @foreach($blogs as $key=>$value)
                        <div class="sblog-item">
                           <a href="{{route('blog.details',$value->slug)}}">
                                <div class="sblog-image">
                                    <img src="{{asset($value->image)}}" alt="">
                                </div>
                                <div class="sblog-text">
                                    <h6>{{$value->title}}</h6>
                                    <a href="">Read More</a>
                                </div>
                           </a>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
