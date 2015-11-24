<?php
/**
 *
 * @author Alex
 *
 */
namespace App\Modules\Admin\Controllers;
date_default_timezone_set('Asia/Ho_Chi_Minh');
class BaseController extends \Controller {

	/**
	 * layout to use
	 * @var View
	 */
	protected $layout = 'admin::_layout.admin';

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout() {
		if ( ! is_null($this->layout)) {
			$this->layout = \View::make($this->layout);
		}
	}

	public function logout() {
		\Session::forget('User');
		\Auth::logout(); // log the user out of our application
		return \Redirect::to('/admin/login'); // redirect the user to the login screen
	}

}
