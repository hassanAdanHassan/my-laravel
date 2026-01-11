@extends("../master")
@section('content')
    <div class="col-md-10">
        <h3>product </h3>
        <div class="card card-primary">
            <div class="card-header">
                <h4 class="card-title">Edit product</h4>
            </div>
           <form action="{{ route('products.update', $product->id) }}" method="POST">
                        @csrf
                        @method('post')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">name</label>
                                <input type="text" class="form-control" name="name" value="{{ $product->name }}" id="name"
                                    placeholder="Enter name">
                            </div>


                            <div class="form-group">
                                <label for="description">description</label>
                                <input type="text" class="form-control" name="description" value="{{ $product->description }}" id="description"
                                    placeholder="enter description">
                            </div>
                            <div class="form-group">
                                <label for="price">price</label>
                                <input type="number" class="form-control" name="price" value="{{ $product->price }}" id="price"
                                    placeholder="enter price">
                            </div>
                            <div class="form-group">
                                <label for="stock">stock</label>
                                <input type="number" class="form-control" name="stock" value="{{ $product->stock }}" id="stock"
                                    placeholder="enter stock">
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

    </div>
@endsection