<?php
/**
 *
 * @author Alex
 *
 */
namespace App\Modules\Admin\Services\Uploads;
use App\Modules\Admin\Services\ServiceFactory;
use App\Modules\Admin\Services\Uploads\Uploader;
use App\Modules\Admin\Utilities\Utility;


class Uploader {

	public static $IMG_EXTS = array('png','jpg','jpeg','gif');
	public static $MEDIA_EXTS = array('mp3');
	/**
	 *
	 * This function allowed upload file and it will create folder with the same name of filename
	 * @param string $file
	 * @param string $langauge
	 * @param booleean $createNewIfNotExists
	 *
	 */
	public function uploadImage($file, $createNewIfNotExists = true, $allowedResize = true) {
		$filename = $file->getClientOriginalName();
		$ext = strtolower($file->getClientOriginalExtension());
		$name = Utility::makeNiceName(substr($filename,0,strlen($filename) - strlen($ext) - 1));
		$image = \Image::make($file);
		$imageConfigs = \Config::get('admin::image');
		$sizes = $imageConfigs['sizes'];

		$path = $imageConfigs['upload_path'];
		$newPath = $path . $name;

		if(!$this->validatImage($ext)) {
			return 'The image ext must be a file of type: '.implode(',', self::$IMG_EXTS).'.';
		}
		if($createNewIfNotExists) {
			$filecounter = 0;
			while (file_exists($newPath)) {
				$newPath = $path . $name . '_' . (++$filecounter);
				//$name = $name . '_' . ($filecounter);
			}
			mkdir($newPath,0777);
			if($filecounter > 0) {
				$name = $name . '_' . ($filecounter);
			}

		} else {
			$filecounter = 0;
			while (file_exists($newPath)) {
				$newPath = $path . '/' . $name . '_' . (++$filecounter) . '.'.$ext;
			}
			if($filecounter > 0) {
				$name = $name . '_' . $filecounter . '.' . $ext;
			}
		}

		if(!$allowedResize) {
			$newFilename =  $newPath . '/' . $name  . '.' . $ext;
			$image->save($newFilename);
			return array(
				'image_name' => $name,
				'abspath' => $newPath,
				'image_path' => str_replace(public_path(), '', $newPath),
				'image_ext' => $ext,
				'allowed_resize' => 'unresized'
			);
		}

		foreach($sizes as $key=>$size) {
			$newFilename = $newPath . '/' . $key .'_' . $name . '.' . $ext;
			if(empty($size)) {
				$image->save($newFilename);
			} else {
				$height = ($size['height'] == 'auto' || $size['height'] == '') ? null : $size['height'];
				$width = $size['width'];

				$filecounter = 1;
				while (file_exists($newFilename)) {
					$newFilename = $newPath . '/' . $key .'_' . $name. '_' . ($filecounter++) . '.' . $ext;
				}
				if(( (isset($width) && is_numeric($width)) && (isset($height) && is_numeric($height)) ) || ($width == null || $height == null)) {
					if($key == 'crop') {
						$image->crop($width, $height)->save($newFilename);
					} else {
						$image->resize($width, $height,function ($constraint) {
							$constraint->aspectRatio();
						})->save($newFilename);
					}
				} else {
					$image->save($newFilename);
				}
			}
		}

		return array(
			'image_name' => $name,
			'abspath' => $newPath,
			'image_path' => str_replace(public_path(), '', $newPath),
			'image_ext' => $ext,
			'allowed_resize' => 'resized'
		);

	}

	public function cropping($file, $w, $h, $x, $y) {
		$filename = $file->getClientOriginalName();
		$ext = $file->getClientOriginalExtension();
		$image = \Image::make($file);
		$path = $imageConfigs['upload_path'];

		$newFilename = $path . 'crop_' . str_replace(array('destination_', 'original_', 'thumb_', 'crop_'), array('','','',''),$filename) . '.' . $ext;
		$image->crop($w, $h, $x, $y)->save($newFilename);

	}

	public function uploadFile($file, $createNewIfNotExists = true) {
		if($file) {
			$filename = $file->getClientOriginalName();
			$ext = $file->getClientOriginalExtension();
			$name = Utility::makeNiceName(substr($filename,0,strlen($filename) - strlen($ext) - 1));
			$filename = $name . '.' . $ext;

			if(!$this->validatMedia($ext)) {
				return array('msg'=>'The sound ext must be a file of type: '.implode(',', self::$MEDIA_EXTS).'.');
			}

			$imageConfigs = \Config::get('admin::image');

			$path = $imageConfigs['media_upload_path'];

			if($createNewIfNotExists) {
				if(!file_exists($path)) {
					mkdir($path,0777);
				}
			} else {
				$path = str_replace('/media', '', $subject);
			}

			$newPath = $path . '/' . $filename;

			$filecounter = 0;
			while (file_exists($newPath)) {
				$newPath = $path . '/' . $name . '_' . (++$filecounter) . '.'.$ext;
			}
			if($filecounter > 0) {
				$filename = $name . '_' . $filecounter . '.' . $ext;
			}

			$file->move($path, $filename);
			return str_replace(public_path(), '', $path).'/'.$filename;
		}
		return '';

	}

	public function validatImage($ext) {
		if(!in_array($ext, self::$IMG_EXTS)) return false;
		return true;
	}

	public function validatMedia($ext) {
		if(!in_array($ext, self::$MEDIA_EXTS)) return false;
		return true;
	}

}
?>
