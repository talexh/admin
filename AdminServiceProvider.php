<?php

namespace App\Modules\Admin;

class AdminServiceProvider extends \App\Modules\ServiceProvider {

	/* public function register() {
		\Log::debug("AnotherServiceProvider registered");

		// Register facades
		$this->app->booting(function() {
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();
			$loader->alias('Entry', 'App\Modules\Content\Facades\EntryFacade');
		});
	} */

	public function register() {
		parent::register('admin');
	}

	public function boot() {
		parent::boot('admin');
	}

}
