<x-store-layout>
<form action="{{ URL::current() }}" method="get">
    <div class="ps-products-wrap pt-80 pb-80">
        <div class="ps-products" data-mh="product-listing">
            <div class="ps-product-action">
                <div class="ps-product__filter">
                    <select class="ps-select selectpicker" name="sort">
                        <option value="">Shortby</option>
                        <option value="name">Name</option>
                        <option value="price-low">Price (Low to High)</option>
                        <option value="price-high">Price (High to Low)</option>
                    </select>
                </div>
                <div class="ps-pagination">
                    <ul class="pagination">
                        <li><a href="#"><i class="fa fa-angle-left"></i></a></li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">...</a></li>
                        <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="ps-product__columns">
                @foreach ($products as $product)
                <div class="ps-product__column">
                    <div class="ps-shoe mb-30">
                        <div class="ps-shoe__thumbnail">
                            <a class="ps-shoe__favorite" href="#"><i class="ps-icon-heart"></i></a>
                            <img src="{{ $product->image_path }}" alt="">
                            <a class="ps-shoe__overlay" href="{{ route('show', $product->slug) }}"></a>
                        </div>
                        <div class="ps-shoe__content">
                            <div class="ps-shoe__variants">
                                <div class="ps-shoe__variant normal">
                                    @foreach ($product->images as $image)
                                    <img src="{{ $image->image_path }}" alt="">
                                    @endforeach
                                </div>
                                <select class="ps-rating ps-shoe__rating">
                                    <option value="1">1</option>
                                    <option value="1">2</option>
                                    <option value="1">3</option>
                                    <option value="1">4</option>
                                    <option value="2">5</option>
                                </select>
                            </div>
                            <div class="ps-shoe__detail">
                                <a class="ps-shoe__name" href="{{ route('show', $product->slug) }}">{{ $product->name }}</a>
                                <p class="ps-shoe__categories"><a href="#">{{ $product->category->name }}</a></p>
                                <span class="ps-shoe__price"> £ {{ $product->price }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="ps-product-action">
                <div class="ps-product__filter">
                    <select class="ps-select selectpicker">
                        <option value="1">Shortby</option>
                        <option value="2">Name</option>
                        <option value="3">Price (Low to High)</option>
                        <option value="3">Price (High to Low)</option>
                    </select>
                </div>
                <div class="ps-pagination">
                    <ul class="pagination">
                        <li><a href="#"><i class="fa fa-angle-left"></i></a></li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">...</a></li>
                        <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>

        
        <div class="ps-sidebar" data-mh="product-listing">
            <aside class="ps-widget--sidebar ps-widget--category">
                <div class="ps-widget__header">
                    <h3>Category</h3>
                </div>
                <div class="ps-widget__content">
                    <ul class="ps-list--checked">
                        @foreach ($categories as $category)
                        <li><input type="checkbox" name="category[]" value="{{ $category->id }}"> {{ $category->name }} ({{ $category->products_count }})</li>
                        @endforeach
                    </ul>
                </div>
            </aside>
            <aside class="ps-widget--sidebar ps-widget--filter">
                <div class="ps-widget__header">
                    <h3>Category</h3>
                </div>
                <div class="ps-widget__content">
                    <div class="ac-slider" data-default-min="300" data-default-max="2000" data-max="3450" data-step="50" data-unit="$"></div>
                    <p class="ac-slider__meta">Price:<span class="ac-slider__value ac-slider__min"></span>-<span class="ac-slider__value ac-slider__max"></span></p>
                    <input type="text" name="min_price" value="">
                    <input type="text" name="max_price" value="">
                    <button type="submit" class="ac-slider__filter ps-btn" href="#">Filter</button>

                </div>
      
     
        </div>
    </div>
</form>
{{ $products->links() }}
</x-store-layout>