<!DOCTYPE html>
<html lang="en">

  <head>
    @include('partials._head')
  </head>
  <body>

  @if(Auth::check())
    @set('user', \Auth::user()->roles()->first()->name)
    @if($user === 'Admin' || $user === 'Owner')
      <a href="{{route('home')}}" class="thumbnail thumbnail-logo">
        {{-- <img src="/images/logo.jpg" class="img-responsive" alt="strataplumbing"> --}}
        {{ Html::image('images/logo.jpg')}}
      </a>
    @else
      <a href="/technicians/index/0" class="thumbnail thumbnail-logo">
        {{ Html::image('images/logo.jpg')}}
      </a>
    @endif
  @else
    <div class="thumbnail thumbnail-logo">
      {{ Html::image('images/logo.jpg')}}
    </div>
  @endif

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
