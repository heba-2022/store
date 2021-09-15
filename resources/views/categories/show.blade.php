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
            <h2>{{$category->name}}</h2>

            <div class="d-flex container">

                <div>
                    <dl style="width: 50%; float:right">
                        <img src="{{ $category->image_url }}" alt="" width="500px" height="500px">
                    </dl>

                    <dl class="row" style="width: 50%; float:left" class="list-group">
                        <dt class="col-md-3"></dt>
                        <dd class="col-md-9"></dd>
                        <dt class="col-md-3"></dt>
                        <dd class="col-md-9"></dd>
                        <dt class="col-md-3"></dt>
                        <div class="container">
                            <ul class="list-group">
                                <li class="list-group-item"><b>Name :</b> {{ $category->name }}</li>
                                <li class="list-group-item"><b>Slug :</b> {{ $category->slug }}</li>
                                <li class="list-group-item"><b>Parent :</b> {{ $category->parent->name }}</li>
                                <li class="list-group-item"><b>Description :</b> {{ $category->description }}</li>
                                <li class="list-group-item"><b>Status :</b> {{ $category->status }}</li>
                                <li class="list-group-item"><b>Created At: :</b> {{ $category->created_at }}</li>
                                <li class="list-group-item"><b>Update At: :</b> {{ $category->updated_at  }}</li>


                            </ul>
                        </div>

                    </dl>

                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <a class="btn btn-primary" href="{{ route('categories.index') }}"> Back</a>
        </div>




    </body>

    </html>
</x-dashboard-layout>