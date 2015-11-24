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
		  <a class="navbar-brand" href="/admin/dash-board">{{Lang::get('admin::common.dashboard')}}</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-cog"></i> {{Lang::get('admin::common.setting')}} <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li class="{{{ (($ctrl=='admin/profile') ?'active':'') }}}"><a href="/admin/profile"><i class="glyphicon glyphicon-folder-open"></i> {{Lang::get('admin::common.profile')}}</a></li>
					<li class="{{{ (($ctrl=='users') ?'active':'') }}}"><a href="/admin/users"><i class="glyphicon glyphicon-user"></i> {{Lang::get('admin::common.user.label')}}</a></li>
					<li class="{{{ (($ctrl=='admin/export') ?'active':'') }}}"><a href="/admin/export"><i class="glyphicon glyphicon-export"></i> {{Lang::get('admin::common.export')}}</a></li>
				</ul>
			</li>
            <li><a href="/admin/logout"><i class="glyphicon glyphicon-log-out"></i> {{Lang::get('admin::common.logout')}}</a></li>
          </ul>
          <form class="navbar-form navbar-right" method="post" action="/admin/{{$ctrl . '/search'}}">
          	<input type="hidden" name="_token" value="{{Session::token()}}">
            <input type="text" name="searchKeyword" value="" class="form-control" placeholder="{{Lang::get('admin::common.search')}}...">
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
