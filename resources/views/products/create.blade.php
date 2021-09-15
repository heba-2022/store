@extends('Categories.layout')
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Create Categories</h2>
        </div>
    </div>
</div>
@if ($errors->any())
<div class="alert alert-danger">
    <strong>Whoops!</strong> something we are problems with your input.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif





<form action="{{ route('categories.store') }}" method="POST" >
    @csrf

    <!-- ألحقل في الفور نفس اسم الحقل في الداتا بيس -->
    <label for="name">Name</label>
    <div>
        <input type="text" id="name" name="name" value="{{ old('name',$category->name)}}" class="form-control @error('name') is-invalid @enderror">
        @error('name')
        <p class="invalid-feedback">{{$message}}</p>
        @enderror
    </div>


    <label for="parent_id">Parent</label>
    <div>
        <select id="parent_id" name="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
            <option value="">No Parent</option>
            @foreach ($parents as $parent)
            <option value="{{ $parent->id }}" @if($parent->id == old('parent_id', $category->parent_id)) selected @endif>{{ $parent->name }}</option>
            @endforeach
        </select>
        @error('parent_id')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>


    <div class="form-group mb-3">
        <label for="description">Description</label>
        <div>
            <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $category->description) }}</textarea>
            @error('description')
            <p class="invalid-feedback">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="form-group mb-3">
        <label for="image">Image</label>
        <div>
            <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror">
            @error('image')
            <p class="invalid-feedback">{{ $message }}</p>
            @enderror
        </div>
    </div>


    <div class="form-group mb-3">
        <label for="status">Status</label>
        <div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" value="active" id="status_active" @if(old('status', $category->status) == 'active') checked @endif>
                <label class="form-check-label" for="status_active">
                    Active
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" value="inactive" id="status_inactive" @if(old('status', $category->status) == 'inactive') checked @endif>
                <label class="form-check-label" for="status_inactive">
                    Inactive
                </label>
            </div>
            @error('status')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <a class="btn btn-primary" href="{{ route('categories.index') }}"> Back</a>
        <button type="submit" class="btn btn-success">Submit</button>
    </div>
</form>



@endsection