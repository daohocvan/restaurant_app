@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('management.inc.sidebar')
            <div class="col-md-8">
                <i class="fas fa-align-justify"></i> Edit Menu
                <hr>
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="/management/menu/{{$menu->id}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Menu Name</label>
                        <input type="text" name="name" class="form-control" value="{{$menu->name}}">

                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" name="price" class="form-control" value="{{$menu->price}}">
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input class="form-control" type="file" name="image">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input class="form-control" type="text" name="description" rows="4" value="{{$menu->description}}">
                
                    </div>
                    <div class="form-group">
                        <label for="category_id">Category Name</label>
                        <select name="category_id" class="form-control">
                            @foreach($categories as $category)
                            <option value="{{$category->id}}" {{$menu->category_id === $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-outline-danger">Edit</button>
                </form>
            </div>
        </div>

    </div>
@endsection
