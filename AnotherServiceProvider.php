<?php namespace App\Modules\Admin;

class AnotherServiceProvider extends \Illuminate\Support\ServiceProvider {

	public function register()
	{
		\Log::debug("AnotherServiceProvider registered");
	}

}
