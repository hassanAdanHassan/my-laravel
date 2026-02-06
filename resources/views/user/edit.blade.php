@extends('../master')
@section('content')
    <div class="col-md-10">
        <h3>User </h3>
        <div class="card card-primary">
            <div class="card-header">
                <h4 class="card-title">Edit user</h4>
            </div>

            <form action="{{ route('user.update', $user->id) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">name</label>
                        <input type="text" class="form-control" name="name" value="{{ $user->name }}"
                            placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        <label for="email">email</label>
                        <input type="email" class="form-control" name="email" value="{{ $user->email }}"
                            placeholder="enter email">
                    </div>

                </div>
                <button type="submit" class="btn btn-primary">update</button>
            </form>

        </div>

    </div>
@endsection
