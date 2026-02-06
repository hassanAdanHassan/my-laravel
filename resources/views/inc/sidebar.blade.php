  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link">
          <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
              style="opacity: .8">
          <span class="brand-text font-weight-light">gaalid</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">

              </div>
              <div class="info">
                  <a href="#" class="d-block">
                      <i class="fas fa-user"></i>

                      {{ auth()->user()->name ?? '' }}</a>
              </div>
          </div>

          <!-- SidebarSearch Form -->
          <div class="form-inline">
              <div class="input-group" data-widget="sidebar-search">
                  <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                      aria-label="Search">
                  <div class="input-group-append">
                      <button class="btn btn-sidebar">
                          <i class="fas fa-search fa-fw"></i>
                      </button>
                  </div>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  @can('admin-only')
                      <li class="nav-item menu-open">
                          <a href="#" class="nav-link active">
                              <i class="nav-icon fas fa-tachometer-alt"></i>
                              <p>
                                  Categorys
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>

                          <ul class="nav nav-treeview">

                              <li class="nav-item">
                                  <a href="{{ route('category.index') }}" class="nav-link active">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p> Category</p>
                                  </a>
                              </li>

                              <li class="nav-item">
                                  <a href="{{ route('groupCategory.index') }}" class="nav-link ">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>groups Category</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('products.index') }}" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>products</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('supplier.index') }}" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>suppliers</p>
                                  </a>
                              </li>
                          </ul>

                      </li>
                  @endcan
                  <li class="nav-item menu-open">
                      <a href="#" class="nav-link active">
                          <i class="nav-icon fas fa-boxes"></i>
                          <p>
                              Inventory
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>

                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('location.index') }}" class="nav-link active">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p> location</p>
                              </a>
                          </li>
                      </ul>

                  </li>
                  @can('admin-only')
                      <li class="nav-item">
                          <a href="#" class="nav-link">
                              <i class="nav-icon fas fa-chart-pie"></i>
                              <p>
                                  USERS
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ url('/user') }}" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Users</p>
                                  </a>
                              </li>

                          </ul>
                      </li>
                  @endcan
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
