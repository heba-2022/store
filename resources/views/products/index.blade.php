<x-dashboard-layout>

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left text-center">
            <h3>Products</h3>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('products.create') }}"> Create product</a>
        </div><br>
    </div>
</div>
@if ($message = Session::get('success'))
<div class="alert alert-success">
    <span>{{ $message }}</span>
</div>
@endif
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <!-- <th>Product Image</th> -->
            <th>{{ __('Name') }}</th>
            <th>Price</th>
            <th>quantity</th>
            <th>@lang('Slug')</th>
            <th>{{ __('Status') }}</th>
      
        </tr>
    </thead>




    <tbody>

        @if (count($products) > 0)
        @foreach ($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <!-- <td><img src="{{ $product->image_path }}" width="250" alt=""></td> -->
            <td><a  href="{{ route('products.show',$product->id) }}" > {{ $product->name }} </a> </td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->quantity}}</td>
            <td>{{ $product->slug }}</td>
            <td>{{ $product->status }}</td>

            <td>
                <form action="{{ route('products.destroy',$product->id) }}" method="POST">
                    <a class="btn btn-primary" href="{{ route('products.edit',$product->id) }}">Edit</a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Do you really want to delete product!')" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="6">No products</td>
        </tr>
        @endif
    </tbody>



</table>


{!! $products->links() !!}
</x-dashboard-layout>
