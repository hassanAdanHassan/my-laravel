@extends("../master")
@section('content')
    <div class="col-md-10">
        <h3>Category Edit Page</h3>
        <div class="card card-primary">
            <div class="card-header">
                <h4 class="card-title">Edit Category</h4>
            </div>
            <form action="{{ route('category.update', $category->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}">
                    </div>
                   
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </div>
            </form>

    </div>
@endsection