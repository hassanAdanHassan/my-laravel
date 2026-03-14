@extends("../master")
@section('content')
    <div class="col-md-10">
        <h3>Customer</h3>
        <div class="card card-primary">
            <div class="card-header">
                <h4 class="card-title">Edit Customer</h4>
            </div>
            <form  action="{{ route( 'customer.update', $customer->id) }}" method="POST">
                @csrf
                @method('post')
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $customer->name }}" placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ $customer->email }}" placeholder="Enter email">
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="number" class="form-control" name="phone" value="{{ $customer->phone }}" id="phone" placeholder="Enter phone">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" name="address" value="{{ $customer->address }}" placeholder="Enter address">
                    </div>

                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>

    </div>
@endsection
