@extends('frontEnd.layouts.master')
@section('title', 'Blogs')
@section('content')
    <section class="homeproduct product-section">
        <div class="container">
            <div class="sorting-section">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="category-breadcrumb d-flex align-items-center">
                            <a href="{{ route('home') }}">Home</a>
                            <span>/</span>
                            <strong>Blogs</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach($blogs as $key=>$value)
                <div class="col-sm-4">
                    <div class="blog-item">
                         <a href="{{route('blog.details',$value->slug)}}">
                            <div class="blog-img">
                                <img src="{{asset($value->image)}}" alt="">
                            </div>
                            <div class="blog-text">
                                <h5>{{$value->title}}</h5>
                                <a href="{{route('blog.details',$value->slug)}}" class="blog-btn">Read More</a>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="custom_paginate">
                        {{ $blogs->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
