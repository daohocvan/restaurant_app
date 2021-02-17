@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('management.inc.sidebar')
            <div class="col-md-8">
                <i class="fas fa-align-justify"></i> Edit Table
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
                <form action="/management/table/{{$table->id}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Table</label>
                        <input type="text" name="name" class="form-control" value="{{$table->name}}">
                    </div>
                    <button type="submit" class="btn btn-outline-danger">Update</button>
                </form>

            </div>
        </div>

    </div>
@endsection
