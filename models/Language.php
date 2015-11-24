<?php
/**
 *
 * @author Alex
 *
 */
namespace App\Modules\Admin\Models;

/**
 *
 * @class Language
 *
 */
class Language extends Base {

	/**
	 *
	 * @var \string $table
	 */
	protected $table = 'languages';

	public function scopeOfDefault($query, $default) {
		return $query->whereDefault($default);
	}

	public function categories() {
		return $this->hasMany("Category");
	}
}