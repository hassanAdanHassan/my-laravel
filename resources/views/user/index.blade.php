@extends('master')
@section('content')
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
    Add user
</button>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="userForm" action="{{ route('user.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">name</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Enter name">
                        </div>
                        <div class="form-group">
                            <label for="email">email</label>
                            <input type="email" class="form-control" name="email" placeholder="enter email">
                        </div>

                        <div class="form-group">
                            <label for="password">password</label>
                            <input type="password" class="form-control" name="password">
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
                <h3 class="card-title">Users</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="userTable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Created At</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>


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

@push('scripts')
<script>
    $(function() {
        $('#userTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('user.getUsers') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'roles',
                    name: 'roles'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                }

                // add action column for edit and delete buttons static
                , {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {

                        let editUrl = "{{ url('user/edit') }}/" + row.id;
                        let deleteUrl = "{{ url('user/delete') }}/" + row.id;

                        return `
                            <a href="${editUrl}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="${deleteUrl}" method="POST" style="display:inline;">    
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        `;
                    }
                }
            ]
        });
    });

    // Handle form submission
    $('#userForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),

            data: $(this).serialize(),

            success: function(response) {
                $('#staticBackdrop').modal('hide');
                $('#userTable').DataTable().ajax.reload();
                alert('User created successfully!');
                form.reset();
            },
            error: function(xhr) {
                alert('An error occurred while creating the user.');
            }
        });
    });
</script>
@endpush