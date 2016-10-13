<!DOCTYPE html>
<html lang="en">

  <head>
    @include('partials._head')
  </head>
  <body>

    @if(Auth::check())
      @set('user', \Auth::user()->roles()->first()->name)
      @if($user === 'Admin' || $user === 'Owner')
        @set('logo_route', route('home'))
      @else
        @set('logo_route', route('technicians.index',0))
      @endif
    @else
        @set('logo_route', '#')
    @endif

    <a href="{{$logo_route}}" class="thumbnail thumbnail-logo">
      {{ Html::image('images/logo-new.png', 'strataplumbing', ['width'=>'400px'])}}
    </a>

    @include('partials._nav')

    <div class="container">
        <div class="main-row">
          @include('partials._messages')
          @yield('content')
        </div>

        @include('partials._footer')

    </div> <!-- /.container -->


    @include('partials._javascript')
    <!-- extra script for each page to save the load time -->
    @yield('scripts')

  </body>
</html>
