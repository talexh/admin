<?php
namespace App\Modules\Admin\Controllers;
use User;

class UserController extends BaseController {

	/*
	 * |--------------------------------------------------------------------------
	 * | Default Admin Controller
	 * |--------------------------------------------------------------------------
	 * |
	 * | You may wish to use controllers instead of, or in addition to, Closure
	 * | based routes. That's great! Here is an example controller method to
	 * | get you started. To route to this controller, just add the route:
	 * |
	 * |	Route::get('/', 'UserController@showWelcome');
	 * |
	 */

	public $_name = 'users';

	/**
	 *
	 * @return $layout
	 */
	public function index() {
		/* $layout = View::make ( 'master' );
		$layout->title = Lang::get('language.user-list');
		$users = User::all();
		$layout->main = View::make ( 'admin/users/list' )->with ( 'users', $users );
		return $layout; */
		$title = \Lang::get('admin::user.user-list');
		$users = User::all();
		return \View::make ( 'admin::admin/users/list', array('users'=>$users,'title'=> $title,'ctrl'=>$this->_name));
	}

	/**
	 *
	 * @return $layout
	 */
	public function add() {
		/* $layout = View::make ( 'master' );
		$layout->title = 'Add User';
		$user = new User();
		$layout->main = View::make ( 'admin::admin/users/add' )->with ( 'user', $user );
		return $layout; */
		$user = new User();
		$title = \Lang::get('admin::user.add-user');
		return \View::make ( 'admin::admin/users/add', array('title'=>$title,'user'=>$user,'ctrl'=>$this->_name));
	}

	public function create() {
		$data = \Input::get('data');
		$title = \Lang::get('add-user');
		$valid = User::validate ( $data['User'] );
		$user = new User();
		if ($valid->passes ()) {
			$pwd = $data['User']['password'];
			$data['User']['password'] = \Hash::make($pwd);

			unset($data['User']['password_confirmation']);
			$user->bind($data['User']);
			try {
				$user->save ();
				//return \Redirect::to ( '/admin/users/' );
				echo json_encode(array('status'=>'OK','url'=>'/admin/users/'));
				die;
			} catch(\Illuminate\Database\QueryException $e) {
				$messages = $valid->messages()->getMessages();
				foreach ($messages as $field_name => $message) {
					echo json_encode(array('status'=>'NOK','msg'=>$message[0],'field'=>$field_name));
					break;
				}
				//return \View::make ( 'admin::admin/users/add', array('title'=>$title,'user'=>$user,'ctrl'=>$this->_name));
				die;
				//return \Redirect::to ( 'admin/users/add/')->with('user',$user)->withErrors($valid);
			}
		} else {
			//unset($data['User']['password_confirmation']);
			$user->bind($data['User']);
			//
			// print_r($data['User']);
			foreach ($valid->messages()->getMessages() as $field_name => $messages) {
				echo json_encode(array('status'=>'NOK','msg'=>$messages[0],'field'=>$field_name));
				break;
			}
			//return \View::make ( 'admin::admin/users/add', array('title'=>$title,'user'=>$user,'ctrl'=>$this->_name));
			die;
			//return \Redirect::to ( '/admin/users/add/')->with('user',$user)->withErrors($valid);
		}
	}

	/**
	 *
	 * @return $layout
	 */
	public function edit($id) {
		try {
			if(!is_numeric($id) || $id == 0) {
				return \Redirect::to ( '/admin/users/' );
			}
			/* $layout = View::make ( 'master' );
			$layout->title = Lang::get('language.edit-user');
			$user = User::find ( $id ); */
			$user = User::find ( $id );
			if(!$user) {
				return \Redirect::to ( '/admin/users/' );
			}
// 			$layout->main = View::make ( '/admin/users/edit' )->with ( 'user', $user );
// 			return $layout;
			$title = \Lang::get('admin::user.edit-user');
			return \View::make ( 'admin::admin/users/edit', array('user'=>$user,'title'=>$title,'ctrl'=>$this->_name));
		} catch (\Exception $e) {
			return \Redirect::to ( '/admin/users' );
		}

	}

	/**
	 *
	 */
	public function update() {

		$data = \Input::get('data');

		$valid = User::validate ( $data['User'], false );

		if ($valid->passes ()) {
			unset($data['User']['password_confirmation']);
			$user = User::find ( $data['User']['id'] );
			$pwd = $data['User']['password'];
			$data['User']['password'] = \Hash::make($pwd);

			$user->bind($data['User']);

			$user->save ();
			echo json_encode(array('status'=>'OK','url'=>'/admin/users/'));
			// return \Redirect::to ( '/admin/users' );
		} else {
			foreach ($valid->messages()->getMessages() as $field_name => $messages) {
				echo json_encode(array('status'=>'NOK','msg'=>$messages[0],'field'=>$field_name));
				break;
			}
			// return \Redirect::to ( '/admin/users/edit/'.$data['User']['id'])->withErrors($valid);
		}
		die;
	}

	/**
	 *
	 */
	public function delete($id) {
		$user = User::find($id);
		if($user) {
			$user->delete();
		}
		return \Redirect::to ( '/admin/users' );
	}
}
