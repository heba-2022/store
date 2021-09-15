@php
$total = 0;
$i =0;
@endphp

<div class="ps-cart"><a class="ps-cart__toggle" href="#"><span><i>{{$i}}</i></span><i class="ps-icon-shopping-cart"></i></a>
    <div class="ps-cart__listing">
        <div class="ps-cart__content">


            @foreach($cart as $item)
            @php
            $total += $item->quantity * $item->product->price ;
            $i++;
            @endphp
            <div class="ps-cart-item"><a class="ps-cart-item__close" href="#"></a>
                <div class="ps-cart-item__thumbnail"><a href="{{route('show',$item->product->slug)}}"></a><img src="{{$item->product->image_path}}" alt=""></div>
                <div class="ps-cart-item__content"><a class="ps-cart-item__title" href="{{ route('show', $item->product->slug) }}">{{$item->product->name}}</a>
                    <p><span>Quantity:<i>{{$item->quantity}}</i></span><span>Total:<i>{{$item->quantity * $item->product->purchase_price }}</i></span></p>
                </div>
            </div>
            @endforeach

        </div>
        <div class="ps-cart__total">
            <p>Number of items:<span>{{$i}}</span></p>
            <p>Item Total:<span>£{{$total}}</span></p>
        </div>
        <div class="ps-cart__footer"><a class="ps-btn" href="{{route('checkout')}}">Check out<i class="ps-icon-arrow-left"></i></a></div>
    </div>
</div>