<x-dashboard-layout>

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left text-center">
                <h3>Categories</h3>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('categories.create') }}"> Create category</a>
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
                <th>{{ __('Name') }}</th>
                <th>@lang('Slug')</th>
                <th>{{ trans('Parent') }}</th>
                <th>{{ Lang::get('Products #') }}</th>
                <th>{{ __('Created At') }}</th>
                <th>{{ __('Status') }}</th>
                <th></th>
            </tr>
        </thead>




        <tbody>

            @if (count($categories) > 0)
            @foreach ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td><a href="{{ route('categories.show',$category->id) }}"> {{ $category->name }} <a></td>
                <td>{{ $category->slug }}</td>
                <td>{{ $category->parent->name }}</td>
                <td>{{ $category->products_count }}</td>
                <td>{{ $category->created_at }}</td>
                <td>{{ $category->status }}</td>

                <td colspan="3">
                    <form action="{{ route('categories.destroy',$category->id) }}" method="POST">
                        <!-- <a class="btn btn-info" href="{{ route('categories.show',$category->id) }}">Show</a> -->
                        <a class="btn btn-primary" href="{{ route('categories.edit',$category->id) }}">Edit</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Do you really want to delete category!')" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="6">No categories</td>
            </tr>
            @endif
        </tbody>



    </table>

    {!! $categories->links() !!}
</x-dashboard-layout>