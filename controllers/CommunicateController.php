<?php
namespace App\Modules\Admin\Controllers;
use Input;
use Hash;
use Lang;
use Config;
use Request;
use App\Modules\Admin\Utilities\Utility;
use App\Modules\Admin\Services\Scaners\ScanerService;
class CommunicateController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'CommunicateController@showWelcome');
	|
	*/

	public function checkAndReqUpdate() {
		if (\Request::isMethod('post') && \Request::ajax()) {
		    //TODO
			$imageConfigs = \Config::get('admin::image');
			$content = Utility::readFile($imageConfigs['appfolder'] . 'logger.json');
			echo $content;
			die;
		}

	}


}
