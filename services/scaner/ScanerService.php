<?php
namespace App\Modules\Admin\Services\Scaners;

use App\Modules\Admin\Services\ServiceFactory;
use App\Modules\Admin\Services\Scaners\Scaner;

class ScanerService extends ServiceFactory {
	public function createService() {
		return Scaner::create();
	}
}