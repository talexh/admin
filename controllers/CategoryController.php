<?php
/**
 *
 * @author Alex
 *
 */
namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Models\Category;
use App\Modules\Admin\Models\Apps;
use App\Modules\Admin\Services\Uploads\UploadService;
use App\Modules\Admin\Utilities\Utility;

class CategoryController extends BaseController {

	/*
	* |--------------------------------------------------------------------------
	* | Default category Controller
	* |--------------------------------------------------------------------------
	* |
	* | You may wish to use controllers instead of, or in addition to, Closure
	* | based routes. That's great! Here is an example controller method to
	* | get you started. To route to this controller, just add the route:
	* |
	* |	Route::get('/', 'categoryController@index');
	* |
	*/

	public $_name = 'category';

	/**
	 *@return content of view
	 */
	public function index() {


		$categories = Category::ofAvailable()->get();
		$params = array();
		$params['categories'] = $categories;
		$params['title'] = \Lang::get('admin::category.title-page');
		$params['ctrl'] = $this->_name;
		return \View::make('admin::admin/category/list', $params);
	}

	public function add() {

		$params['title'] = \Lang::get('admin::category.title-page');
		$params['ctrl'] = $this->_name;
		$params['apps'] = Apps::getList();
		return \View::make('admin::admin/category/add', $params);
	}
	public function create() {

		$data = \Input::get('data');
		$categoryDataForm = $data['Category'];

		$image = \Input::file('filename');

		$valid = Category::validate($categoryDataForm);

		if(!$valid->passes()) {
			foreach ($valid->messages()->getMessages() as $field_name => $messages) {
				echo json_encode(array('status'=>'NOK','msg'=>$messages[0],'field'=>$field_name));
				break;
			}

			die;

		} else {
			$categoryObject = new Category();

			$service = new UploadService();

			$uploader = $service->createUploadService();
			if(!empty($image)) {
				$imageData = $uploader->uploadImage($image, true, false);
				unset($imageData['abspath']);
				$categoryObject->bind($imageData);
			} else {
				$categoryObject->allowed_resize = 'unresized';
			}

			$categoryDataForm = array_merge($categoryDataForm, $imageData);

			$categoryObject->bind($categoryDataForm);

			$categoryObject->save();
			if(isset($data['redirectTo'])) {
				$result = array('status'=>'OK', 'msg'=>'Success', 'url'=>'/admin/'. $this->_name .'/');
			} else {
				$result = array('status'=>'OK', 'msg'=>'Success', 'url'=>'/admin/'. $this->_name .'/edit/'.$categoryObject->id);
			}

			echo json_encode($result);
		}

		die;
	}

	public function edit($uid) {

		$params['title'] = \Lang::get('admin::category.title-page');
		$params['ctrl'] = $this->_name;
		$categoryObject = Category::find($uid);

		$params['categoryObject'] = $categoryObject;
		$params['id'] = $uid;
		$params['apps'] = Apps::getList();

		return \View::make('admin::admin/category/edit', $params);
	}
	public function update() {
		$data = \Input::get('data');
		$categoryDataForm = $data['Category'];

		$image = \Input::file('filename');

		$valid = Category::validate($categoryDataForm, false);

		if(!$valid->passes()) {
			foreach ($valid->messages()->getMessages() as $field_name => $messages) {
				echo json_encode(array('status'=>'NOK','msg'=>$messages[0],'field'=>$field_name));
				break;
			}
			die;
		} else {
			$categoryObject = Category::find($categoryDataForm['id']);

			$service = new UploadService();

			$uploader = $service->createUploadService();
			$imageData = array();
			if(!empty($image)) {
				$imageData = $uploader->uploadImage($image, true, false);

				if(is_string($imageData)) {
					echo json_encode(array('status'=>'NOK','msg'=>$imageData,'field'=>'image_ext'));
					die;
				}

				unset($imageData['abspath']);

			}
			if(!empty($categoryObject->image_path) && !empty($imageData)) {
				Utility::deleteFile($categoryObject->image_path);
			}

			$categoryDataForm = array_merge($categoryDataForm, $imageData);

			$categoryObject->bind($categoryDataForm, false);

			$categoryObject->save();

			if(isset($data['redirectTo'])) {
				$result = array('status'=>'OK', 'msg'=>'Success', 'url'=>'/admin/'. $this->_name .'/');
			} else {
				$result = array('status'=>'OK', 'msg'=>'Success', 'url'=>'/admin/'. $this->_name .'/edit/'.$categoryObject->id);
			}

			echo json_encode($result);
		}

		die;
	}

	public function delete($id) {
		$category = Category::find($id);
		$category->deleted = 1;
		$category->save();
		return \Redirect::to('/admin/' . $this->_name);
	}
	public function deleteforever($id) {
		$category = Category::find($id);
		if(!empty($category->image_path)) {
			Utility::deleteFile($category->image_path);
		}
		$category->delete();
		return \Redirect::to('/admin/' . $this->_name);
	}
}
