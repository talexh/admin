<?php
/**
 *
 * @author Alex
 *
 */
namespace App\Modules\Admin\Utilities;

class Utility {

	public static $IMG_PREFIX = array('crop_','thumb_','destination_','original_');
	private function __construct() {

	}
	private function __clone() {

	}
	private function __wakeup() {

	}

	public static function makeNiceName($string, $tolowercase = true) {
		$string = str_replace(array('à','á','ạ','ả','ã','â','ầ','ấ','ậ','ẩ','ẫ','ă','ằ','ắ','ặ','ẳ','ẵ','À','Á','Ạ','Ả','Ã','Â','Ầ','Ấ','Ậ','Ẩ','Ẫ','Ă','Ằ','Ắ','Ặ','Ẳ','Ẵ'), array('a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a'), $string);
		$string = str_replace(array('è','é','ẹ','ẻ','ẽ','ê','ề','ế','ệ','ể','ễ','È','É','Ẹ','Ẻ','Ẽ','Ê','Ề','Ế','Ệ','Ể','Ễ'), array('e','e','e','e','e','e','e','e','e','e','e','e','e','e','e','e','e','e','e','e','e','e'), $string);
		$string = str_replace(array('ì','í','ị','ỉ','ĩ','Ì','Í','Ị','Ỉ','Ĩ'), array('i','i','i','i','i','i','i','i','i','i'), $string);
		$string = str_replace(array('ò','ó','ọ','ỏ','õ','ô','ồ','ố','ộ','ổ','ỗ','ơ','ờ','ớ','ợ','ở','ỡ','Ò','Ó','Ọ','Ỏ','Õ','Ô','Ồ','Ố','Ộ','Ổ','Ỗ','Ơ','Ờ','Ớ','Ợ','Ở','Ỡ'), array('o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o'), $string);
		$string = str_replace(array('ù','ú','ụ','ủ','ũ','ư','ừ','ứ','ự','ử','ữ','Ù','Ú','Ụ','Ủ','Ũ','Ư','Ừ','Ứ','Ự','Ử','Ữ'), array('u','u','u','u','u','u','u','u','u','u','u','u','u','u','u','u','u','u','u','u'), $string);
		$string = str_replace(array('ỳ','ý','ỵ','ỷ','ỹ','Ỳ','Ý','Ỵ','Ỷ','Ỹ'), array('y','y','y','y','y','y','y','y','y','y'), $string);
		$string = str_replace(array('đ','Đ'), array('d','d'), $string);

		$search = array('&amp;','@','Â©','Â®','Ã€','Ã�','Ã‚','Ã„','Ã…','Ã†','Ã‡','Ãˆ','Ã‰','Ã‹','ÃŒ','Ã�','ÃŽ','Ã�','Ã’','Ã“','Ã”','Ã•','Ã–','Ã˜','Ã™','Ãš','Ã›','Ãœ','Ã�','ÃŸ','Ã ','Ã¡','Ã¢','Ã¤','Ã¥','Ã¦','Ã§','Ã¨','Ã©','Ãª','Ã«','Ã¬','Ã­','Ã®','Ã¯','Ã²','Ã³','Ã´','Ãµ','Ã¶','Ã¸','Ã¹','Ãº','Ã»','Ã¼','Ã½','Ã¾','Ã¿','Ä€','Ä�','Ä‚','Äƒ','Ä„','Ä…','Ä†','Ä‡','Äˆ','Ä‰','ÄŠ','Ä‹','ÄŒ','Ä�','ÄŽ','Ä�','Ä�','Ä‘','Ä’','Ä“','Ä”','Ä•','Ä–','Ä—','Ä˜','Ä™','Äš','Ä›','Äœ','Ä�','Äž','ÄŸ','Ä ','Ä¡','Ä¢','Ä£','Ä¤','Ä¥','Ä¦','Ä§','Ä¨','Ä©','Äª','Ä«','Ä¬','Ä­','Ä®','Ä¯','Ä°','Ä±','Ä²','Ä³','Ä´','Äµ','Ä¶','Ä·','Ä¸','Ä¹','Äº','Ä»','Ä¼','Ä½','Ä¾','Ä¿','Å€','Å�','Å‚','Åƒ','Å„','Å…','Å†','Å‡','Åˆ','Å‰','ÅŠ','Å‹','ÅŒ','Å�','ÅŽ','Å�','Å�','Å‘','Å’','Å“','Å”','Å•','Å–','Å—','Å˜','Å™','Åš','Å›','Åœ','Å�','Åž','ÅŸ','Å ','Å¡','Å¢','Å£','Å¤','Å¥','Å¦','Å§','Å¨','Å©','Åª','Å«','Å¬','Å­','Å®','Å¯','Å°','Å±','Å²','Å³','Å´','Åµ','Å¶','Å·','Å¸','Å¹','Åº','Å»','Å¼','Å½','Å¾','Å¿','Æ�','Æ’','Æ ','Æ¡','Æ¯','Æ°','Ç�','ÇŽ','Ç�','Ç�','Ç‘','Ç’','Ç“','Ç”','Ç•','Ç–','Ç—','Ç˜','Ç™','Çš','Ç›','Çœ','Çº','Ç»','Ç¼','Ç½','Ç¾','Ç¿','É™','Ð�','Ð„','Ð†','Ð‡','Ð�','Ð‘','Ð’','Ð“','Ð”','Ð•','Ð–','Ð—','Ð˜','Ð™','Ðš','Ð›','Ðœ','Ð�','Ðž','ÐŸ','Ð ','Ð¡','Ð¢','Ð£','Ð¤','Ð¥','Ð¦','Ð§','Ð¨','Ð©','Ðª','Ð«','Ð¬','Ð­','Ð®','Ð¯','Ð°','Ð±','Ð²','Ð³','Ð´','Ðµ','Ð¶','Ð·','Ð¸','Ð¹','Ðº','Ð»','Ð¼','Ð½','Ð¾','Ð¿','Ñ€','Ñ�','Ñ‚','Ñƒ','Ñ„','Ñ…','Ñ†','Ñ‡','Ñˆ','Ñ‰','ÑŠ','Ñ‹','ÑŒ','Ñ�','ÑŽ','Ñ�','Ñ‘','Ñ”','Ñ–','Ñ—','Ò�','Ò‘','×�','×‘','×’','×“','×”','×•','×–','×—','×˜','×™','×š','×›','×œ','×�','×ž','×Ÿ','× ','×¡','×¢','×£','×¤','×¥','×¦','×§','×¨','×©','×ª','â„¢');
		$replace = array('and','at','c','r','a','a','a','ae','a','ae','c','e','e','e','i','i','i','i','o','o','o','o','oe','o','u','u','u','ue','y','ss','a','a','a','ae','a','ae','c','e','e','e','e','i','i','i','i','o','o','o','o','oe','o','u','u','u','ue','y','p','y','a','a','a','a','a','a','c','c','c','c','c','c','c','c','d','d','d','d','e','e','e','e','e','e','e','e','e','e','g','g','g','g','g','g','g','g','h','h','h','h','i','i','i','i','i','i','i','i','i','i','ij','ij','j','j','k','k','k','l','l','l','l','l','l','l','l','l','l','n','n','n','n','n','n','n','n','n','o','o','o','o','o','o','oe','oe','r','r','r','r','r','r','s','s','s','s','s','s','s','s','t','t','t','t','t','t','u','u','u','u','u','u','u','u','u','u','u','u','w','w','y','y','y','z','z','z','z','z','z','z','e','f','o','o','u','u','a','a','i','i','o','o','u','u','u','u','u','u','u','u','u','u','a','a','ae','ae','o','o','e','jo','e','i','i','a','b','v','g','d','e','zh','z','i','j','k','l','m','n','o','p','r','s','t','u','f','h','c','ch','sh','sch','-','y','-','je','ju','ja','a','b','v','g','d','e','zh','z','i','j','k','l','m','n','o','p','r','s','t','u','f','h','c','ch','sh','sch','-','y','-','je','ju','ja','jo','e','i','i','g','g','a','b','g','d','h','v','z','h','t','i','k','k','l','m','m','n','n','s','e','p','p','c','c','q','r','w','t','tm');
		$newString = str_replace($search, $replace, $string);
		$newString = str_replace(' ', '-', $newString);
		if($tolowercase)
			$newName = strtolower(preg_replace('/[^A-Za-z0-9\-._]/', '', $newString));
		else $newName = preg_replace('/[^A-Za-z0-9\-._]/', '', $newString);
		return (strlen($newName)>45) ? substr($newName, -45) : $newName;
	}

	// return date number bettween date1, date2
	public static function dateDiff($start, $end) {
		$dStart = date_create($start);
		$dEnd = date_create($end);
		$diff = date_diff($dStart,$dEnd);
		$d = $diff->format("%a");
		return $d;
	}

	public static function writeFile($file, $content) {
		$f = fopen($file, 'w+') or die(\Lang::get('admin::common.error-file-open'));
		fwrite($f, $content);
		fclose($f);
	}

	public static function readFile($file) {
		// $f = fopen($file, 'r') or die(\Lang::get('admin::common.error-file-open'));
		// $content = fread($f);
		// fclose($f);

		$content = @file_get_contents($file);

		return $content;
	}

	public static function deleteFile($path) {
		if(empty($path)) return false;

		$abspath = public_path() . $path .'/';
		$files = self::scanDirectory($abspath);
		foreach($files as $file) {
			unlink($abspath . $file);
		}
		rmdir($abspath);
	}

	public static function copy($source, $target, $targetPath, $createNew = false) {
		if($createNew) {
			if (!file_exists($targetPath)) {
				@mkdir($targetPath, 0777);
			}
		}

		if(is_file($source) && file_exists($source)) {
			@copy($source, $targetPath . $target);
		}
	}

	public static function moveFiles($source, $target) {
		$files = \File::allFiles($source);
		foreach($files as $file) {
			if ( ! \File::move($file, $target.'/'.basename($file))) {
			    die("Couldn't move file: ". $file . ' to '. $target.'/'.basename($file));
			}
		}
		\File::deleteDirectory($source);
	}
	
	public static function copyFiles($source, $target) {
		$files = \File::allFiles($source);
		foreach($files as $file) {
			if ( ! \File::copy($file, $target.'/'.basename($file))) {
			    die("Couldn't copy file: ". $file . ' to '. $target.'/'.basename($file));
			}
		}
	}
	
	public static function remove($filename) {
		if(is_file($filename) && file_exists($filename)) {
			@unlink($filename);
		}
	}
	public static function rename($filename, $tolower = false) {
		!$tolower ? rename( $filename,$filename ) : rename( $filename, strtolower($filename) );
	}

	public static function loadDirs($path, $loadFile = false) {

		if ($handle = opendir($path)) {
			$files = array();
			/* This is the correct way to loop over the directory. */
			while (false !== ($entry = readdir($handle))) {
				if(strlen($entry) > 4) {
					$ext = pathinfo($entry, PATHINFO_EXTENSION);
					// check if empty
					if(is_dir($path.$entry) && !$loadFile) {
						$files[$entry] = $path.$entry;
					} else if($loadFile) {
						if(in_array($ext, array('png','jpg','svg','gif','mp3'))) {
							$files[] = $path.'/'.$entry;
						}
					}
				}
			}

			/* This is the WRONG way to loop over the directory. */
			while ($entry = readdir($handle)) {
				if(strlen($entry) > 4) {
					$ext = pathinfo($entry, PATHINFO_EXTENSION);
					if(is_dir($path.$entry) && !$loadFile) {
						$files[$entry] = $path.$entry;
					} else if($loadFile) {
						if(in_array($ext, array('png','jpg','svg','gif','mp3'))) {
							$files[] = $path.'/'.$entry;
						}
					}
				}
			}
			closedir($handle);
			return $files;
		}
		return array();
	}

	public static function scanDirectory($dir, $isNotChecking = true) {
		$dirs = self::loadDirs($dir, $isNotChecking);
		$data = array();
		if($isNotChecking) {
			// list of files
			foreach ($dirs as $file) {
				if($file != '.' && $file != '..') {
					$data[] = basename($file);
				}
			}
		} else {
			// list of dirs
			foreach($dirs as $folder=>$path) {
				$files = self::loadDirs($path, true);
				foreach ($files as $file) {
					if($file != '.' && $file != '..') {
						$data[] = $file;
					}
				}

			}
		}

		return $data;
	}

	public static function fileInfo($filename) {
		if(!file_exists($filename)) {
			return array();
		}
		$files = array();
		$files['date'] = date('Y-m-d H:i',filemtime($filename));
		$files['filename'] = $filename;
		return $files;
	}

	public static function createFolder($path) {
		@mkdir($path, 0777);
	}

	public static function debugger($data, $stopHere = false) {
		echo '<pre>';
		print_r($data);
		echo '</pre>';
		if($stopHere) {
			die;
		}
	}
}
?>
