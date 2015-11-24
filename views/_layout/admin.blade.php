<!doctype html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	@section('title')
	<title>{{{$title}}}</title>
	@show
	{{ HTML::style('css/bootstrap.min.css') }}
	{{ HTML::style('css/bootstrap-theme.min.css') }}
	{{ HTML::style('css/backend/app.css') }}
	{{ HTML::style('css/backend/main.css') }}

</head>
<body>
	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
		  <a class="navbar-brand" href="/admin/dash-board">Dashboard</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="/admin/profile">Profile</a></li>
					<li><a href="/admin/users">Users</a></li>
					<li><a href="/admin/export">Export Data For Apps</a></li>
				</ul>
			</li>
            <li><a href="/admin/logout">Logout</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        @yield('leftnav')
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        @yield('main')
        </div>
      </div>
    </div>
	{{ HTML::script('js/jquery-2.1.0.min.js') }}
	{{ HTML::script('js/bootstrap.min.js') }}
	{{ HTML::script('js/docs.min.js') }}
	{{ HTML::script('js/ie10-viewport-bug-workaround.js') }}
	{{ HTML::script('js/admin/app.min.js') }}
</body>
</html>
