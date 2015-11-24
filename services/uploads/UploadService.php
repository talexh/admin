<?php
/**
 *
 * @author Alex
 *
 */
namespace App\Modules\Admin\Services\Uploads;
use App\Modules\Admin\Services\ServiceFactory;
use App\Modules\Admin\Services\Uploads\Uploader;

class UploadService extends ServiceFactory {
	public function createService() {
		return new Uploader();
	}
}
?>
