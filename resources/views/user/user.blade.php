@extends("master")
@section('content' )
  <div class="col-md-6>
          
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">create example</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">name</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter name">
                  </div>
                  <div class="form-group">
                    <label for="second-name">second name</label>
                    <input type="text" class="form-control" id="second-name" placeholder="enter second name">
                  </div>
                  
                   <div class="form-group">
                    <label for="email">email</label>
                    <input type="email" class="form-control" id="email" placeholder="email">
                  </div>
                   <div class="form-group">
                    <label for="password">password</label>
                    <input type="password" class="form-control" id="password" placeholder="password">
                  </div>
                   <div class="form-group">
                    <label for="confirm-password">confirm-password</label>
                    <input type="password" class="form-control" id="confirm-password" placeholder="enter confirm-password">
                  </div>
                  
                </div>
                
              </form>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            @endsection