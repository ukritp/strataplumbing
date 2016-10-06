@if(Session::has('success'))

	<!-- // http://getbootstrap.com/components/ -->
	<div class="alert alert-success" role="alert">
		<strong>{{ Session::get('success')}}</strong>
	</div>

@endif

@if(Session::has('error'))

	<!-- // http://getbootstrap.com/components/ -->
	<div class="alert alert-danger" role="alert">
		<strong>{{ Session::get('error')}}</strong>
	</div>

@endif

@if(count($errors)>0)

	<div class="alert alert-danger" role="alert">
		<strong>Error:</strong>
		<ul>
		@foreach($errors->all() as $error)
			<li>{{ $error}}</li>
		@endforeach
		</ul>
	</div>

@endif