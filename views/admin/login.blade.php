<!doctype html>
<html>
<head>
	<title>Look at me Login</title>
	{{ HTML::style('css/backend/app.css') }}
	{{ HTML::style('css/backend/main.css') }}
	{{ HTML::script('js/jquery-2.1.0.min.js') }}
</head>
<body>
	<div id="login-page" class="login-form">
	{{ Form::open(array('url' => '/admin/signIn')) }}
		<h1>Login</h1>

		<!-- if there are login errors, show them here -->
		<p>
			{{ $errors->first('email') }}
			{{ $errors->first('password') }}
		</p>

		<p>
			{{ Form::label('email', 'Email Address') }}
			{{ Form::text('email', Input::old('email'), array('placeholder' => 'awesome@awesome.com')) }}
		</p>

		<p>
			{{ Form::label('password', 'Password') }}
			{{ Form::password('password') }}
		</p>
		<p class="submit-area clear">{{ Form::submit('Sign In') }}</p>
	{{ Form::close() }}
	</div>
</body>
</html>
