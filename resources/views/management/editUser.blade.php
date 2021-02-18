@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('management.inc.sidebar')
            <div class="col-md-8">
                <i class="fas fa-align-justify"></i> Edit User
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
                <form action="/management/user/{{$user->id}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" value="{{$user->name}}" {{$user->role == 'admin' && $user->id != Auth::id() ? 'disabled' : ''}}>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" {{$user->role == 'admin' && $user->id != Auth::id() ? 'disabled' : ''}}>
                    </div>
                    <div class="form-group">
                        <label for="name">Email</label>
                        <input type="email" name="email" class="form-control" value="{{$user->email}}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select name="role" class="form-control" {{$user->role == 'admin' && $user->id != Auth::id() ? 'disabled' : ''}}>
                            <option value="admin" {{$user->role == 'admin' ? 'selected' : ''}}>Admin</option>
                            <option value="cashier" {{$user->role == 'cashier' ? 'selected' : ''}}>Cashier</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-outline-danger" >Update</button>
                </form>

            </div>
        </div>

    </div>
@endsection
