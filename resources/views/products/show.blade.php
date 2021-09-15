<x-dashboard-layout>

    <html>

    <head>
        <style>
            /* .content {
  max-width: 500px;
  margin: auto;
} */
        </style>
    </head>

    <body class="content">
        <div class="container">
            <h2>{{$product->name}}</h2>
            <div class="d-flex container">
                {{--
            @if($product->image_path)
            <!-- upslute path -->
             <img src="/storage/{{$product->image_path}}" alt="">
                <!-- بتدخل جوا ملف الببلك ومابهمني احط السلاش او لا بشكل صحيح -->
                <img src="{{ asset ('storage/'.$product->image_path) }}" alt="">

                @else
                <img src="https://via.placeholder.com/250C/O https://placeholder.com/" alt="">
                @endif
                --}}


                <dl style="width: 50%; float:right">
                    <img src="{{ $product->image_path }}" alt="" width="500px" height="500px">
                </dl>

                <dl class="row" style="width: 50%; float:left" class="list-group">
                    <dt class="col-md-3"></dt>
                    <dd class="col-md-9"></dd>
                    <dt class="col-md-3"></dt>
                    <dd class="col-md-9"></dd>
                    <dt class="col-md-3"></dt>
                    <div class="container">
                        <ul class="list-group">
                            <li class="list-group-item"><b>Name :</b> {{ $product->name }}</li>
                            <li class="list-group-item"><b>Catigory:</b> {{ $product->category->name }}</li>
                            <li class="list-group-item"><b>Price:</b> {{ $product->price }}</li>
                            <li class="list-group-item"><b>Quantity:</b> {{ $product->quantity }}</li>
                            <li class="list-group-item"><b>Slug :</b> {{ $product->slug }}</li>
                            <li class="list-group-item"><b>Description :</b> {{ $product->description }}</li>
                            <li class="list-group-item"><b>Status :</b> {{ $product->status }}</li>
                            <li class="list-group-item"><b>Created At: :</b> {{ $product->created_at }}</li>
                            <li class="list-group-item"><b>Update At: :</b> {{ $product->updated_at  }}</li>


                        </ul>
                    </div>

                </dl>

            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
        </div>
    </body>

    </html>


</x-dashboard-layout>