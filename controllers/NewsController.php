<?php
/**
 *
 * @author Alex
 *
 */
namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Models\News;
use App\Modules\Admin\Models\Apps;
use App\Modules\Admin\Models\Category;
use App\Modules\Admin\Services\Uploads\UploadService;
use App\Modules\Admin\Utilities\Utility;

class NewsController extends BaseController {

	/*
	* |--------------------------------------------------------------------------
	* | Default News Controller
	* |--------------------------------------------------------------------------
	* |
	* | You may wish to use controllers instead of, or in addition to, Closure
	* | based routes. That's great! Here is an example controller method to
	* | get you started. To route to this controller, just add the route:
	* |
	* |	Route::get('/', 'NewsController@index');
	* |
	*/

	public $_name = 'news';

	/**
	 *@return content of view
	 */
	public function index($categoryId = '', $appId = '') {

		$news = News::ofReadyFilter($categoryId, $appId)->paginate(15);

		// get list of categories to show in select box
		$categories = Category::getList();

		// get list of apps to show in select box
		$apps = Apps::getList();

		$params = array();
		$params['newss'] = $news;
		$params['categories'] = $categories;
		$params['apps'] = $apps;
		$params['title'] = \Lang::get('admin::news.title-page');
		$params['ctrl'] = $this->_name;
		$params['appId'] = $appId;
		$params['categoryId'] = $categoryId;
		return \View::make('admin::admin/'. $this->_name .'/list', $params);
	}

	/**
	 *@return content of view
	 */
	public function search() {
		$categories = Category::getList();

		$keyword = \Input::get('searchKeyword');

		$news = News::ofKeyword($keyword)->paginate(1000);

		$apps = Apps::getList();

		$params = array();
		$params['newss'] = $news;
		$params['categories'] = $categories;
		$params['apps'] = $apps;
		$params['title'] = \Lang::get('admin::news.title-page');
		$params['ctrl'] = $this->_name;
		$params['keyword'] = $keyword;
		$params['appId'] = 'all';
		$params['categoryId'] = 'all';
		return \View::make('admin::admin/'. $this->_name .'/list', $params);
	}

	public function add() {

		$params['title'] = \Lang::get('admin::news.title-page');
		$params['ctrl'] = $this->_name .'/list';
		$params['apps'] = Apps::getList();
		$params['categories'] = Category::getList();
		return \View::make('admin::admin/'. $this->_name .'/add', $params);
	}
	public function create() {

		$data = \Input::get('data');
		$newsDataForm = $data['News'];

		$image = \Input::file('filename');
		$file = \Input::file('musics');

		$valid = News::validate($newsDataForm);

		if(!$valid->passes()) {
			foreach ($valid->messages()->getMessages() as $field_name => $messages) {
				echo json_encode(array('status'=>'NOK','msg'=>$messages[0],'field'=>$field_name));
				break;
			}

			die;

		} else {
			$newsObject = new News();
			$service = new UploadService();

			$uploader = $service->createService();
			if(!empty($image)) {
				$imageData = $uploader->uploadImage($image, true, false);
				unset($imageData['abspath']);
				$newsObject->bind($imageData);
			} else {
				$newsObject->allowed_resize = 'unresized';
			}
			if(!empty($file)) {
				$filename = $uploader->uploadFile($file);
				$newsDataForm['sound'] = $filename;
			}

			$newsObject->bind($newsDataForm);

			$newsObject->save();
			if(isset($data['redirectTo'])) {
				$result = array('status'=>'OK', 'msg'=>'Success', 'url'=>'/admin/news/list');
			} else if(isset($data['addNew'])) {
				$result = array('status'=>'OK', 'msg'=>'Success', 'url'=>'/admin/news/add');
			} else {
				$result = array('status'=>'OK', 'msg'=>'Success', 'url'=>'/admin/news/edit/'.$newsObject->id);
			}

			//copy image for app update
			$source = public_path($newsObject->image_path. '/'. $newsObject->image_name.'.'.$newsObject->image_ext);
			$target = $newsObject->image_name.'.'.$newsObject->image_ext;
			$targetPath = public_path('uploads/'.$newsObject->Apps->folder).'/';
			Utility::copy($source, $target, $targetPath);
			
			// Copy sound
			$source = public_path( 'uploads/media/'. $newsObject->sound);
			$target = $newsObject->sound;
			Utility::copy($source, $target, $targetPath);
			
			echo json_encode($result);
		}

		die;
	}

	public function edit($uid) {

		$params['title'] = \Lang::get('admin::news.title-page');
		$params['ctrl'] = $this->_name .'/list';
		$newsObject = News::find($uid);

		$params['newsObject'] = $newsObject;
		$params['id'] = $uid;
		$params['apps'] = Apps::getList();
		$params['categories'] = Category::getList();

		return \View::make('admin::admin/'. $this->_name .'/edit', $params);
	}
	public function update() {
		$data = \Input::get('data');
		$newsDataForm = $data['News'];

		$image = \Input::file('filename');
		$file = \Input::file('musics');

		$valid = News::validate($newsDataForm, false);

		if(!$valid->passes()) {
			foreach ($valid->messages()->getMessages() as $field_name => $messages) {
				echo json_encode(array('status'=>'NOK','msg'=>$messages[0],'field'=>$field_name));
				break;
			}
			die;
		} else {
			$newsObject = News::find($newsDataForm['id']);
			$oldImage = $newsObject->image_name.'.'.$newsObject->image_ext;
			$oldSound = basename($newsObject->sound);
			
			$service = new UploadService();

			$uploader = $service->createService();
			$imageData = array();
			if(!empty($image)) {
				$imageData = $uploader->uploadImage($image, true, false);

				if(is_string($imageData)) {
					echo json_encode(array('status'=>'NOK','msg'=>$imageData,'field'=>'image_ext'));
					die;
				}

				unset($imageData['abspath']);

			}

			if(!empty($file)) {
				$filename = $uploader->uploadFile($file);

				if(!is_string($filename)) {
					// if upload media fail then delete image that uploaded before
					if(!empty($imageData)) {
						Utility::deleteFile($newsObject->image_path);
					}

					echo json_encode(array('status'=>'NOK','msg'=>$filename['msg'],'field'=>'media_ext'));
					die;
				}

				if(!empty($newsObject->sound) && !empty($filename)) {
					unlink(public_path() . $newsObject->sound);
				}
				$newsDataForm['sound'] = $filename;
			}

			if(!empty($newsObject->image_path) && !empty($imageData)) {
				Utility::deleteFile($newsObject->image_path);
			}

			$newsDataForm = array_merge($newsDataForm, $imageData);
			$newsObject->bind($newsDataForm, false);

			$newsObject->save();

			if(isset($data['redirectTo'])) {
				$result = array('status'=>'OK', 'msg'=>'Success', 'url'=>'/admin/'. $this->_name .'/list');
			} else if(isset($data['addNew'])) {
				$result = array('status'=>'OK', 'msg'=>'Success', 'url'=>'/admin/news/add');
			} else {
				$result = array('status'=>'OK', 'msg'=>'Success', 'url'=>'/admin/'. $this->_name .'/edit/'.$newsObject->id);
			}

			//copy image for app update
			$source = public_path($newsObject->image_path. '/'. $newsObject->image_name.'.'.$newsObject->image_ext);
			$target = basename($source);
			$targetPath = public_path('uploads/'.$newsObject->Apps->folder).'/';
			Utility::copy($source, $target, $targetPath);
			
			// Copy sound
			$source = public_path().$newsObject->sound;
			$target = basename($source);
			
			
			Utility::copy($source, $target, $targetPath);
			
			if(!empty($image)) {
				Utility::remove($targetPath.$oldImage);
			}
			if(!empty($file)) {
				Utility::remove($targetPath.$oldSound);
			}
			
			echo json_encode($result);
		}

		die;
	}

	public function delete($id) {
		$news = News::find($id);
		$news->deleted = 1;
		$news->save();
		return \Redirect::to('/admin/' . $this->_name);
	}
	public function deleteforever($id) {
		$news = News::find($id);

		if(!empty($news->image_path)) {
			Utility::deleteFile($news->image_path);
		}

		$news->delete();
		return \Redirect::to('/admin/' . $this->_name);
	}
}
