 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
     <!-- Left navbar links -->
     <ul class="navbar-nav">
         <li class="nav-item">
             <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
         </li>

     </ul>

     <!-- Right navbar links -->
     <ul class="navbar-nav ml-auto">
         <li class="nav-item dropdown user-menu">
             <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                 <img src="{{ asset('public/dist/img/user2-160x160.jpg') }}" class="user-image img-circle elevation-2"
                     alt="User Image">
                 <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
             </a>
             <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                 <!-- User image -->
                 <li class="user-header bg-primary">
                     <img src="{{ asset('public/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                         alt="User Image">

                     <p>
                         {{ auth()->user()->name }}
                         {{-- <small>Member since Nov. 2012</small> --}}
                     </p>
                 </li>
                 <!-- Menu Body -->
                 <li class="user-body">

                     <form method="POST" action="{{ route('logout') }}">
                         @csrf

                         <a href="route('logout')" class="btn btn-default btn-flat float-right"
                             onclick="event.preventDefault();
                                                this.closest('form').submit();">
                             {{ __('Log Out') }}
                         </a>
                     </form>
                     @if (auth()->user()->hasPermission('profile.edit'))
                         <a href="{{ route('profile.edit') }}" class="btn btn-default btn-flat">Profile</a>
                     @endif
                     <!-- /.row -->
                 </li>

             </ul>
         </li>
     </ul>
 </nav>
 <!-- /.navbar -->
