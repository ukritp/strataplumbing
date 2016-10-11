<!-- Default Bootstrap navbar -->
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      @if(Auth::check())
        @set('user', \Auth::user()->roles()->first()->name)
        @if($user === 'Admin' || $user === 'Owner')
          <li class="{{Request::is('/') ? "active" : ""}}"><a href="{{route('home')}}">Home</a></li>
          <li class="{{Request::is('clients*') ? "active" : ""}}"><a href="{{url('clients')}}">Clients</a></li>
          <li class="{{Request::is('sites/*') ? "active" : ""}}"><a href="{{url('sites/index/0')}}">Sites</a></li>
          <li class="{{Request::is('jobs/*') ? "active" : ""}}"><a href="{{url('jobs/index/0')}}">Open Jobs</a></li>
          <li class="{{Request::is('technicians/*') ? "active" : ""}}"><a href="{{url('technicians/index/0')}}">Technician Details</a></li>
          <li class="{{Request::is('invoices/*') ? "active" : ""}}"><a href="{{url('invoices/index/0')}}">Completed Invoices</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Invoices <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#">All Invoices</a></li>
              <li><a href="{{url('/invoices/pending/PC')}}">Pending Approval - Peter Campa</a></li>
              <li><a href="{{url('/invoices/pending/JG')}}">Pending Approval - Jess Gunther</a></li>
              <li><a href="{{url('/invoices/pending/JB')}}">Pending Approval - Johan Becker</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="{{url('invoices/index/0' )}}">Issued / QB Invoices</a></li>
            </ul>
          </li>
        @else
          <li class="{{Request::is('technicians/*') ? "active" : ""}}"><a href="{{url('technicians/index/0')}}">Technician Details</a></li>
        @endif
        @if($user === 'Owner')
          {{-- <li class="{{Request::is('activitylogs*') ? "active" : ""}}"><a href="{{route('activitylogs.index')}}">Activity Logs</a></li> --}}
        @endif
      @endif

      </ul>

      <ul class="nav navbar-nav navbar-right">
        @if(Auth::check())
        <li class="dropdown">
          <li><a href="#">Logged In as: <strong>{{Auth::user()->name}}</strong></a></li>
          <li><a href="{{route('logout')}}">Logout</a></li>
        </li>
        @else
          <li><a href="{{route('login')}}" class="btn btn-link">Login</a></li>
          <li><a href="{{route('register')}}" class="btn btn-link">Register</a></li>
        @endif
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>