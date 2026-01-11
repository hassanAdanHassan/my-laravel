@extends("../master")
@section('content')
    <div class="col-md-10">
        <h3>supplier </h3>
        <div class="card card-primary">
            <div class="card-header">
                <h4 class="card-title">Edit suplier</h4>
            </div>
            <form  action="{{ route( 'supplier.update', $supplier->id) }}" method="POST">
                @csrf
                @method('post')
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">name</label>
                        <input type="text" class="form-control" name="name" value="{{ $supplier->name }}" placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        <label for="email">email</label>
                        <input type="email" class="form-control" name="email" value="{{ $supplier->email }}" placeholder="enter email">
                    </div>

                    <div class="form-group">
                        <label for="phone">phone</label>
                        <input type="number" class="form-control" name="phone" value="{{ $supplier->phone }}" id="phone" placeholder="enter phone">
                    </div>
                    <div class="form-group">
                        <label for="address">address</label>
                        <input type="text" class="form-control" name="address" value="{{ $supplier->address }}" placeholder="enter address">
                    </div>


                </div>
                <button type="submit" class="btn btn-primary">update</button>
            </form>
                </div>

    </div>
@endsection