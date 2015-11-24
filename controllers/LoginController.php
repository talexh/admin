<?php
namespace App\Modules\Admin\Controllers;

class LoginController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'LoginController@showWelcome');
	|
	*/

	public function login() {
		if (\Auth::viaRemember()) {
			return \Redirect::to('/admin/dashboard');
		} else {
			return \View::make('admin::admin/login');
		}

	}

	public function signIn() {
		// validate the info, create rules for the inputs
		$rules = array(
			'email'    => 'required|email', // make sure the email is an actual email
			'password' => 'required|min:6' // password can only be alphanumeric and has to be greater than 3 characters
		);

		// run the validation rules on the inputs from the form
		$validator = \Validator::make(\Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
			return \Redirect::to('/admin/login')
				->withErrors($validator) // send back all errors to the login form
				->withInput(\Input::except('password')); // send back the input (not the password) so that we can repopulate the form
		} else {

			// create our user data for the authentication
			$userdata = array(
				'email' 	=> \Input::get('email'),
				'password' 	=> \Input::get('password')
			);

			// attempt to do the login
			if (\Auth::attempt($userdata)) {

				// validation successful!
				// redirect them to the secure section or whatever
				// return Redirect::to('secure');
				// for now we'll just echo success (even though echoing in a controller is bad)
				//echo 'SUCCESS!';
				if (\Auth::check()) {
					\Auth::user()->password = '';
					$user = \Auth::user();
					\Session::put('User', $user);
					return \Redirect::intended('/admin/dash-board')->with('success', 'SUCCESS!');
				} else {
					return \Redirect::to('/admin/login');
				}

			} else {

				// validation not successful, send back to form
				return \Redirect::to('/admin/login');

			}

		}
		return \View::make('admin::admin/login');
	}
}
