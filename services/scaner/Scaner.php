<?php
namespace App\Modules\Admin\Services\Scaners;

use App\Modules\Admin\Utilities\Utility;
use Config;
class Scaner {

	protected $path;


	private function __construct(){}
	private function __wakeup(){}
	private function __clone(){}

	public static function create() {
		return new Scaner();
	}

	public function setPath($path) {
		$this->path = $path;
		return $this;
	}
	public function getPath() {
		return $this->path;
	}

	public function logging($app = null) {
		$imageConfigs = \Config::get('admin::image');
		//$files = Utility::scanDirectory($this->path);
		$files = \File::allFiles($this->path);
		$listLogs = array();
		$i = 0;
		$j = 0;
		$log4AllData = '{"log4AllData":[';
		$someNew = '{"log4Data":[';
		foreach($files as $file) {
			$info = Utility::fileInfo($file);
			if(!empty($info)) {
				$diff = Utility::dateDiff(date('Y-m-d',time()), $info['date']);

				// Just check something changed and infor the app need to update the data
				if($diff <= 14) {

					if(!empty($info['filename'])) {
						$someNew .= '{"last_modified":"' . $info['date'] . '","filename":"'. str_replace(substr($info['filename'], 0, strpos($info['filename'], '/public')+ strlen('/public')), url('/'), $info['filename']).'"}';
						if($i < sizeof($files) - 1) {
							$someNew .= ",\n";
						}
						$i++;
					}
				}

				// Log for all data of the app

				if(!empty($info['filename'])) {
					$log4AllData .= '{"last_modified":"' . $info['date'] . '","filename":"'. str_replace(substr($info['filename'], 0, strpos($info['filename'], '/public')+ strlen('/public')), url('/'), $info['filename']).'"}';
					if($j < sizeof($files) - 1) {
						$log4AllData .= ",\n";
					}
					$j++;
				}
			}
		}
		//$info = Utility::fileInfo($imageConfigs['loggingfolder'].'data.js');

		/*if($i > 0) {
			$i = $i + 1;
			$someNew .= ',{"last_modified":"' . $info['date'] . '","filename":"' . url('/appsdata/data.js') . '"}';
		}
		if($j > 0) {
			$j = $j + 1;
			$log4AllData .= ',{"last_modified":"' . $info['date'] . '","filename":"' . url('/appsdata/data.js') . '"}';
		}*/
		$someNew .= '],"date":"'.date('Y-m-d',time()).'","total":'.$i.'}';
		$log4AllData .= '],"date":"'.date('Y-m-d',time()).'","total":'.$j.'}';
		if(!file_exists($imageConfigs['loggingfolder'])) {
			Utility::createFolder( $imageConfigs['loggingfolder'] );
		}
		Utility::writeFile( $imageConfigs['loggingfolder'] . 'app_'.$app->id.'_logger4all.json', $log4AllData);
		Utility::writeFile( $imageConfigs['loggingfolder'] . 'app_'.$app->id.'_logger.json', $someNew);
	}

	public function writeLog4FirstDownload() {
		$files = Utility::scanDirectory($this->path);
	}

}
