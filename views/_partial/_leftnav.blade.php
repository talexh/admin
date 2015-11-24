
<div class="col-sm-3 col-md-2 sidebar dynamic">
	<div class="icon-leftbar"><i class="glyphicon glyphicon-hand-left"></i></div>
	<ul class="nav nav-sidebar">
		<li class="{{{ (($ctrl=='apps') ?'active':'') }}}">
			<a href="/admin/apps" title="{{Lang::get('admin::common.apps')}} {{Lang::get('admin::common.management')}}"><i class="glyphicon glyphicon-list-alt"></i> {{Lang::get('admin::common.apps')}}</a>
		</li>
		<li class="{{{ (($ctrl=='category') ?'active':'') }}}">
			<a href="/admin/category" title="{{Lang::get('admin::common.categories')}} {{Lang::get('admin::common.management')}}"><i class="glyphicon glyphicon-list-alt"></i> {{Lang::get('admin::common.categories')}}</a>
		</li>
		<li class="{{{ (($ctrl=='news') ?'active':'') }}}">
			<a href="/admin/news/list" title="{{Lang::get('admin::common.contents')}} {{Lang::get('admin::common.management')}}"><i class="glyphicon glyphicon-list-alt"></i> {{Lang::get('admin::common.contents')}}</a>
		</li>
	</ul>

</div>
