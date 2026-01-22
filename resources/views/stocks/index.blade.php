@extends('master')
@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        create stock
    </button>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">new stock</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="{{ route('products.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                      <label for="name" class="form-label">Product Name</label>
                      <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                      <label for="description" class="form-label">Description</label>
                      <input type="text" class="form-control" id="description" name="description">
                    </div>
                    <div class="mb-3">
                      <label for="price" class="form-label">Price</label>
                      <input type="number" class="form-control" id="price" name="price">
                    </div>
                    <div class="mb-3">
                      <label for="amount" class="form-label">Amount</label>
                      <input type="number" class="form-control" id="amount" name="amount">
                    </div>
                    <div class="mb-3">
                      <label for="color" class="form-label">Color</label>
                      <input type="text" class="form-control" id="color" name="color">
                    </div>
                    <div class="mb-3">
                      <label for="stock_id" class="form-label">Stock ID</label>
                      <input type="number" class="form-control" id="stock_id" name="stock_id">
                    </div>
                       <div class="mb-3">
                      <label for="creater_id" class="form-label">creater_id</label>
                      <input type="number" class="form-control" id="creater_id" name="creater_id">
                    </div>
                    <div class="mb-3">
                      <label for="group_category_id" class="form-label">Group Category ID</label>
                      <input type="number" class="form-control" id="group_category_id" name="group_category_id">
                    </div>
                    <button type="submit" class="btn btn-primary">Create Product</button>
                  </form>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Categories</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="category" class="table table-bordered table-hover">
                        <thead>
                               <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>description</th>
                                <th>price</th>
                                <th>amount</th>
                                <th>color</th>
                                <th>group_category</th>
                                <th>stock</th>
                                <th>create-at</th>
                                <th>Actions</th>

                            </tr>
                        </thead>


                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
@endsection
