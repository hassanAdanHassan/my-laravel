@extends('master')
@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
   
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
 create suppliers
</button>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">suppliers</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <form  action="{{ route('supplier.store') }}" method="POST">
                @csrf
                @method('post')
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        <label for="email">email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="enter email">
                    </div>

                    <div class="form-group">
                        <label for="phone">phone</label>
                        <input type="number" class="form-control" name="phone" id="phone" placeholder="enter phone">
                    </div>
                    <div class="form-group">
                        <label for="address">address</label>
                        <input type="number" class="form-control" name="address" id="address" placeholder="enter address">
                    </div>


                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
      </div>
      
    </div>
  </div>
</div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">suppliers</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>email</th>
                                <th>phone</th>
                                <th>address</th>
                                <Th>create-at</Th>
                                <th>Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                           
                           @foreach ($suppliers as $supplier)
                           <tr></tr>
                            <td>{{ $supplier->id }}</td>
                            <td>{{ $supplier->name }}</td>
                            <td>{{ $supplier->email }}</td>
                            <td>{{ $supplier->phone }}</td>
                            <td>{{ $supplier->address }}</td>
                            <td>{{ $supplier->created_at }}</td>
                             <td>
                             <a href="{{ route("supplier.edit", $supplier->id) }}" class="btn btn-info">Edit</a>
                             <form action="{{ route('supplier.destroy', $supplier->id) }}"
                                         method="POST" class="btn btn-danger btn-sm">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this supplier {{ $supplier->name }}?')">
                                                Delete
                                                </button>
                                        </form>
                             </td>
                               </tr>
                           @endforeach
                           
                        
                        
                        </tbody>

                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
@endsection
