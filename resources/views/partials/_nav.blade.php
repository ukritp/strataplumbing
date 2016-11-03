<!-- Default Bootstrap navbar -->
<nav id="main-navbar" class="navbar navbar-default">
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
          <li class="{{Request::is('/') ? "active" : ""}}"><a href="{{route('home')}}">Dashboard</a></li>
          <li class="{{Request::is('clients*') ? "active" : ""}}"><a href="{{url('clients')}}">Clients</a></li>
          {{-- <li class="{{Request::is('sites/*') ? "active" : ""}}"><a href="{{url('sites/index/0')}}">Sites</a></li> --}}
          <li class="{{Request::is('jobs/*') ? "active" : ""}}"><a href="{{url('jobs/index/0')}}">Open Jobs</a></li>
          <li class="{{Request::is('technicians/*') ? "active" : ""}}"><a href="{{url('technicians/index/0')}}">Technician Details</a></li>
          {{-- <li class="{{Request::is('invoices/*') ? "active" : ""}}"><a href="{{url('invoices/index/0')}}">Completed Invoices</a></li> --}}
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Invoices <span class="caret"></span></a>
            <ul class="dropdown-menu">
              @set('approved_invoice',count(\Auth::user()->invoiceApprovedOrDeclined('approved')))
              @set('declined_invoice',count(\Auth::user()->invoiceApprovedOrDeclined('declined')))
              <li>
                <a href="{{url('/invoices/approved/all')}}">All Approved Invoices</a>
                @if($approved_invoice)
                <span class="badge notification-bubble bubble-green">{{$approved_invoice}}</span>
                @endif
              </li>
              <li>
                <a href="{{url('/invoices/declined/all')}}">All Declined Invoices</a>
                @if($declined_invoice)
                <span class="badge notification-bubble bubble-red">{{$declined_invoice}}</span>
                @endif
              </li>
              <li role="separator" class="divider"></li>
              @set('pending_invoice_pc',count(\Auth::user()->pendingInvoiceGroupByPM('PC')))
              @set('pending_invoice_jg',count(\Auth::user()->pendingInvoiceGroupByPM('JG')))
              @set('pending_invoice_jb',count(\Auth::user()->pendingInvoiceGroupByPM('jb')))
              @set('pending_invoice_all',$pending_invoice_pc + $pending_invoice_jg + $pending_invoice_jb)
              <li>
                <a href="{{url('/invoices/pending/all')}}">All Pending Invoices</a>
                @if($pending_invoice_all)
                <span class="badge notification-bubble bubble-yellow">{{$pending_invoice_all}}</span>
                @endif
              </li>
              <li>
                <a href="{{url('/invoices/pending/PC')}}">Pending Approval - Peter Campa</a>
                @if($pending_invoice_pc)
                <span class="badge notification-bubble bubble-yellow">{{$pending_invoice_pc}}</span>
                @endif
              </li>
              <li>
                <a href="{{url('/invoices/pending/JG')}}">Pending Approval - Jess Gunther</a>
                @if($pending_invoice_jg)
                <span class="badge notification-bubble bubble-yellow">{{$pending_invoice_jg}}</span>
                @endif
              </li>
              <li>
                <a href="{{url('/invoices/pending/JB')}}">Pending Approval - Johan Becker</a>
                @if($pending_invoice_jb)
                <span class="badge notification-bubble bubble-yellow">{{$pending_invoice_jb}}</span>
                @endif
              </li>
              <li role="separator" class="divider"></li>
              <li><a href="{{url('invoices/index/1' )}}">Issued / QB Invoices</a></li>
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


      {!! Form::open(array('route' => 'pages.search','method'=>'get', 'data-parsley-validate'=>'', 'class'=>'navbar-form navbar-right navbar-search-form')) !!}
        <div class="input-group">
            <input type="text" name="keyword" id="keyword" class="form-control " placeholder="Search all...." maxlegnth="255" required>
            <span class="input-group-btn">
                <button class="btn btn-primary " type="submit"><i class="glyphicon glyphicon-search"></i></button>
            </span>
        </div>
      {!! Form::close() !!}

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>