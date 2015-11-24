<?php
/**
 *
 * @author Alex
 *
 */
namespace App\Modules\Admin\Models;

/**
 *
 * @class Images
 *
 */
class Images extends Base {

	/**
	 *
	 * @var \string $table
	 */
	protected $table = 'images';

	public function category() {
		return $this->hasOne("Category", 'image_id');
	}
}