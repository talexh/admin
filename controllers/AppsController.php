<?php
/**
 *
 * @author Alex
 *
 */
namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Models\Apps;
use App\Modules\Admin\Services\Uploads\UploadService;
use App\Modules\Admin\Utilities\Utility;

class AppsController extends BaseController {

	/*
	* |--------------------------------------------------------------------------
	* | Default Apps Controller
	* |--------------------------------------------------------------------------
	* |
	* | You may wish to use controllers instead of, or in addition to, Closure
	* | based routes. That's great! Here is an example controller method to
	* | get you started. To route to this controller, just add the route:
	* |
	* |	Route::get('/', 'AppsController@index');
	* |
	*/

	public $_name = 'apps';

	/**
	 *@return content of view
	 */
	public function index() {


		$appsList = Apps::ofAvailable()->get();
		$params = array();
		$params['apps'] = $appsList;
		$params['title'] = \Lang::get('admin::apps.title-page');
		$params['ctrl'] = $this->_name;
		return \View::make('admin::admin/apps/list', $params);
	}

	public function add() {

		$params['title'] = \Lang::get('admin::apps.title-page');
		$params['ctrl'] = $this->_name;

		return \View::make('admin::admin/apps/add', $params);
	}
	public function create() {

		$data = \Input::get('data');
		$appDataForm = $data['Apps'];

		$image = \Input::file('filename');
		$file = \Input::file('musics');

		$valid = Apps::validate($appDataForm);

		if(!$valid->passes()) {
			foreach ($valid->messages()->getMessages() as $field_name => $messages) {
				echo json_encode(array('status'=>'NOK','msg'=>$messages[0],'field'=>$field_name));
				break;
			}

			die;

		} else {
			$appObject = new Apps();

			$appDataForm['status'] = isset($appDataForm['status']) ? $appDataForm['status'] : 0;

			$appDataForm['folder'] = Utility::makeNiceName($appDataForm['folder'], false);
			$folder = public_path('uploads/'.$appDataForm['folder']);
			if (!file_exists($folder)) {
				\File::makeDirectory($folder, 0777);
			}

			$appObject->bind($appDataForm);

			$appObject->save();

			if(isset($data['redirectTo'])) {
				$result = array('status'=>'OK', 'msg'=>'Success', 'url'=>'/admin/'. $this->_name);
			} else if(isset($data['addNew'])) {
				$result = array('status'=>'OK', 'msg'=>'Success', 'url'=>'/admin/'.$this->_name.'/add');
			} else {
				$result = array('status'=>'OK', 'msg'=>'Success', 'url'=>'/admin/'.$this->_name.'/edit/'.$appObject->id);
			}
			
			echo json_encode($result);
		}

		die;
	}

	public function edit($uid) {

		$params['title'] = \Lang::get('admin::apps.title-page');
		$params['ctrl'] = $this->_name;
		$appObject = Apps::find($uid);

		$params['appObject'] = $appObject;
		$params['id'] = $uid;

		return \View::make('admin::admin/apps/edit', $params);
	}
	public function update() {
		$data = \Input::get('data');
		$appDataForm = $data['Apps'];

		$valid = Apps::validate($appDataForm, false);

		if(!$valid->passes()) {
			foreach ($valid->messages()->getMessages() as $field_name => $messages) {
				echo json_encode(array('status'=>'NOK','msg'=>$messages[0],'field'=>$field_name));
				break;
			}

			die;

		} else {
			$appObject = Apps::find($appDataForm['id']);
			
			$oldFolder = $appObject->folder;
			
			$appDataForm['status'] = isset($appDataForm['status'])? $appDataForm['status'] : 0;
			$appDataForm['updated_at'] = date('Y-m-d H:i:s', time());

			$appDataForm['folder'] = Utility::makeNiceName($appDataForm['folder'], false);

			$folder = public_path('uploads/'. $appDataForm['folder']);
			if (!file_exists($folder)) {
				\File::makeDirectory($folder, 0777);
				Utility::moveFiles(public_path('uploads/'. $oldFolder),$folder);
			}

			$appObject->bind($appDataForm);
			$appObject->save();

			if(isset($data['redirectTo'])) {
				$result = array('status'=>'OK', 'msg'=>'Success', 'url'=>'/admin/'. $this->_name);
			} else if(isset($data['addNew'])) {
				$result = array('status'=>'OK', 'msg'=>'Success', 'url'=>'/admin/'.$this->_name.'/add');
			} else {
				$result = array('status'=>'OK', 'msg'=>'Success', 'url'=>'/admin/'.$this->_name.'/edit/'.$appObject->id);
			}
			
			echo json_encode($result);
		}

		die;
	}

	public function delete($id) {
		$app = Apps::find($id);
		$success = \File::deleteDirectory(public_path('uploads/'.$app->folder));
		$app->delete();
		//$app->deleted = 1;
		//$app->save();
		return \Redirect::to('/admin/apps');
	}
	public function deleteforever($id) {
		$app = Apps::find($id);
		$app->delete();
		return \Redirect::to('/admin/apps');
	}
}
