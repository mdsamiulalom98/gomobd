<div class="menu-area">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="main-menu">
                    <ul>
                        @foreach ($categories as $category)
                        <li>
                            <a href="{{route('category',$category->slug)}}">
                                {{$category->name}}   
                                @if ($category->subcategories->count() > 0)
                                    <i class="fa-solid fa-angle-down cat_down"></i>
                                @endif
                            </a>
                            @if($category->subcategories->count() > 0)
                            <div class="mega_menu">
                                @foreach ($category->subcategories as $subcat)
                                <ul>
                                    <li>
                                        <a href="{{ route('subcategory',$subcat->slug) }}" class="cat-title">
                                           {{ Str::limit($subcat->name, 25) }}
                                        </a>
                                    </li>
                                    @foreach($subcat->childcategories as $childcat)
                                    <li>
                                        <a href="{{ route('products',$childcat->slug) }}">{{ $childcat->name }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endforeach
                            </div>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>