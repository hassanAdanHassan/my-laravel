@extends('master')
@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form method="POST" action="{{ route('profile.update', $user->id) }}">
    @csrf
    @method('POST')
        <div class="card-body">
            <div class="form-group">
                <label for="">user name</label>
                <input type="text" class="form-control" name="name" value="{{ $user->name }}">
            </div>
            <div class="form-group">
                <label>email</label>
                <input type="email" value="{{ $user->email }}" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">change Password</label>
                <input type="password" class="form-control" name="password" placeholder="Password">
            </div>
         
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">change</button>
        </div>
    </form>
@endsection
