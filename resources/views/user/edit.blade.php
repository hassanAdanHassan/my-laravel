@extends('../master')
@section('content')
<div class="col-md-10">
    <h3>User </h3>
    <div class="card card-primary">
        <div class="card-header">
            <h4 class="card-title">Edit user</h4>
        </div>

        <form id="userForm" action="{{ route('user.update') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $user->id }}">
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
@push('scripts')
<script>
    $(document).ready(function() {
        $('#userForm').on('submit', function(e) {
            e.preventDefault();

            // const data = $(this).serialize();
            // console.log(data);
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response) {
                    alert('User updated successfully!');
                    window.location.href = "{{ route('user.index') }}";
                },
                error: function(xhr) {
                    alert('An error occurred while updating the user.');
                }
            });
        });
    });
</script>
@endpush