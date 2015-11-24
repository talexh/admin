<?php
namespace App\Modules\Admin\Controllers;
use User;
use Input;
use Hash;
use Lang;
use Config;
use Session;
use App\Modules\Admin\Models\News;
use App\Modules\Admin\Models\Apps;
use App\Modules\Admin\Models\Category;
use App\Modules\Admin\Utilities\Utility;
use App\Modules\Admin\Services\Scaners\ScanerService;

class AdminController extends BaseController {

	/*
	 * |--------------------------------------------------------------------------
	 * | Default Admin Controller
	 * |--------------------------------------------------------------------------
	 * |
	 * | You may wish to use controllers instead of, or in addition to, Closure
	 * | based routes. That's great! Here is an example controller method to
	 * | get you started. To route to this controller, just add the route:
	 * |
	 * |	Route::get('/', 'AdminController@showWelcome');
	 * |
	 */

    /*public function __construct(){
        $this->beforeFilter('auth');
    }*/

	protected $_name = 'admin';

	/**
	 *
	 */
	public function dashboard() {
		$params = array();
		$params['title'] = 'Dashboard';
		$params['ctrl'] = $this->_name;
		return \View::make ( 'admin::dashboard', $params);
	}

	/**
	 *
	 *
	 */
	public function profile() {
		$title = \Lang::get('admin::common.profile');
		$userSession = \Session::get ( 'User' );
		$user = User::find ( $userSession->id );

		$params = array();
		$params['title'] = $title;
		$params['ctrl'] = $this->_name.'/profile';
		$params['profile'] = $user;

		return \View::make ( 'admin::admin/profile', $params );
	}

	/**
	 *
	 */
	public function updateProfile() {

		$v = User::validate ( Input::all(), false );

		if ($v->passes ()) {
			$user = User::find ( Input::get ( 'id' ) );

			$user->name = Input::get ( 'name' );
			$pwd = Input::get('password');
			if(!empty($pwd)) {
				$user->password = Hash::make ( Input::get('password') );
			}
			$user->save ();
			return \Redirect::to ( '/admin/profile' );
		} else {
			return \Redirect::to ( '/admin/profile' )->withErrors ($v);
		}
	}

	/**
	* Export data to json
	* @return void
	*/
	public function export(){

		$imageConfigs = \Config::get('admin::image');

		$params['apps'] = Apps::getList();
		$params['title'] = \Lang::get('admin::common.export-data4app');
		$params['ctrl'] = $this->_name.'/export';

		return \View::make('admin::admin/export', $params);
	}
	/**
	 * Export data to json
	 * @return void
	 */
	public function doExport() {
		$imageConfigs = \Config::get('admin::image');
		$appId = \Input::get('app_id');

		$categories = Category::ofReady()->orderBy('sorting')->get();
		$data = array();

		if($appId == 'all') {
			$apps = Apps::ofReady()->get();
			foreach($apps as $app) {
				foreach($categories as $item) {
					$news = News::ofReadyFilter($item->id, $app->id)->orderBy('sorting')->get();

					if(empty($news)) continue;

					$newsList = array();
					foreach($news as $itemNews) {
						$newsList[] = array('id'=>$itemNews->id,'categoryId'=>$itemNews->category_id,'title'=>$itemNews->title,'description'=>$itemNews->description, 'image_name'=>$itemNews->image_name.'.'.$itemNews->image_ext,'allowed_resize'=>$itemNews->allowed_resize,'sound'=>basename($itemNews->sound),'sorting'=>$itemNews->sorting,'created'=>$itemNews->created_at->toDateTimeString(),'updated'=>$itemNews->updated_at->toDateTimeString());
					}
					$data['news'][$item->id] = $newsList;
					$data['categories'][] = array('id'=>$item->id,'title'=>$item->title, 'image_name'=>$item->image_name.'.'.$item->image_ext,'allowed_resize'=>$item->allowed_resize,'sorting'=>$item->sorting,'created'=>$item->created_at->toDateTimeString(),'updated'=>$item->updated_at->toDateTimeString());
				}
				$file = public_path('uploads/'.$app->folder) . '/app_'.$app->id.'_data.js';
				$content = 'var jsonData = ' . json_encode($data) . ";\nvar APP_ID = ".$app->id . ";";
				Utility::writeFile($file, $content);
				\Lang::get('admin::news.title-page');
				$params['exportMessage'] = \Lang::get('admin::common.export-success');

				// Check update and log for the app know have some new data updated
				$scaner = new ScanerService();
				$scanPath = public_path('uploads/'.$app->folder);
				$scaner->createService()->setPath($scanPath)->logging($app);
			}
		} else {
			$app = null;
			foreach($categories as $item) {
				$news = News::ofReadyFilter($item->id, $appId)->orderBy('sorting')->get();
				$newsList = array();
				foreach($news as $itemNews) {
					$app = $itemNews->Apps;
					$newsList[] = array('id'=>$itemNews->id,'categoryId'=>$itemNews->category_id,'title'=>$itemNews->title,'description'=>$itemNews->description, 'image_name'=>$itemNews->image_name.'.'.$itemNews->image_ext,'allowed_resize'=>$itemNews->allowed_resize,'sound'=>basename($itemNews->sound),'sorting'=>$itemNews->sorting,'created'=>$itemNews->created_at->toDateTimeString(),'updated'=>$itemNews->updated_at->toDateTimeString());
				}
				$data['news'][$item->id] = $newsList;
				$data['categories'][] = array('id'=>$item->id,'title'=>$item->title, 'image_name'=>$item->image_name.'.'.$item->image_ext,'allowed_resize'=>$item->allowed_resize,'sorting'=>$item->sorting,'created'=>$item->created_at->toDateTimeString(),'updated'=>$item->updated_at->toDateTimeString());
			}
			$file = public_path('uploads/'.$app->folder) . '/app_'.$app->id.'_data.js';
			$content = 'var jsonData = ' . json_encode($data) . ";\nvar APP_ID = ".$app->id . ";";
			Utility::writeFile($file, $content);
			\Lang::get('admin::news.title-page');
			$params['exportMessage'] = \Lang::get('admin::common.export-success');

			// Check update and log for the app know have some new data updated
			$scaner = new ScanerService();
			$scanPath = public_path('uploads/'.$app->folder);
			$scaner->createService()->setPath($scanPath)->logging($app);
		}

		$params['msg'] = \Lang::get('admin::common.export-data4app');
		$params['status'] = "OK";
		$params['url'] = "/admin/export";
		//$params['ctrl'] = $this->_name;
		echo json_encode($params);
		die;


	}

	public function exportConfirm() {
		return \View::make('admin::admin/export_result', $params);
	}
}
