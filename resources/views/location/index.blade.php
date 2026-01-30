@extends('master')
@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        create groupcategory
    </button>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">new groupCategory</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('location.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="country">country</label>
                                <input type="text" class="form-control" name="country" id="country"
                                    placeholder="Enter country">
                            </div>
                            <div class="form-group">
                                <label for="province">province</label>
                                <input type="text" class="form-control" name="province" id="province"
                                    placeholder="Enter province">
                            </div>
                            <div class="form-group">
                                <label for="district">district</label>
                                <input type="text" class="form-control" name="district" id="district"
                                    placeholder="Enter district">
                            </div>
                            <div class="form-group">
                                <label for="village">village</label>
                                <input type="text" class="form-control" name="village" id="village"
                                    placeholder="Enter village">
                            </div>
                            <div class="form-group">
                                <label for="zoon">zoon</label>
                                <input type="text" class="form-control" name="zoon" id="zoon"
                                    placeholder="Enter zoon">
                            </div>
                            <div class="form-group">
                                <label for="state">state</label>
                                <input type="text" class="form-control" name="state" id="state"
                                    placeholder="Enter state">
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
                    <h3 class="card-title">groupCategory</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="location" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>country</th>
                                <th>province</th>
                                <th>district</th>
                                <th>village</th>
                                <th>zoon</th>
                                <th>state</th>
                                <th>action</th>
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
@push('scripts')
    <script>
        $(function() {
            $('#location').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('location.index') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'country',
                        name: 'country'
                    },
                    {
                        data: 'province',
                        name: 'province'
                    },
                    {
                        data: 'district',
                        name: 'district'
                    },
                    {
                        data: 'village',
                        name: 'village'
                    },
                    {
                        data: 'zoon',
                        name: 'zoon'
                    },
                    {
                        data: 'state',
                        name: 'state'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }

                ]
            });
        });
    </script>
@endpush
