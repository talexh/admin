<?php
/**
 *
 * @author Alex
 *
 */
namespace App\Modules\Admin\Models;

class News extends Base {

	/**
	 *
	 * @var \string $table
	 */
	protected $table = 'news';

	/**
	*
	* @var \array $properties
	*/
	protected $properties;

	public function setProperties($properties) {
		$this->properties = $properties;
		return $this;
	}
	public function getProperties() {
		return $this->properties;
	}

	/**
     *
     * @param \Object $query
     * @param Integer $categoryId
     * @param Integer $appId
     * @use Model::ofReadyByCategoryNApp()->get();
     */
	public function scopeOfReadyByCategoryNApp($query, $categoryId, $appId) {
		if($categoryId && $appId == 'all') {
			return $query->whereDeleted(self::AVAILABLE)->whereStatus(self::ACTIVATE)->whereCategoryId($categoryId);
		} else if($categoryId == 'all' && $appId) {
			return $query->whereDeleted(self::AVAILABLE)->whereStatus(self::ACTIVATE)->whereAppId($appId);
		} else if($categoryId && $appId) {
			return $query->whereDeleted(self::AVAILABLE)->whereStatus(self::ACTIVATE)->whereCategoryId($categoryId)->whereAppId($appId);
		} else {
			return $query->whereDeleted(self::AVAILABLE)->whereStatus(self::ACTIVATE);
		}

	}

	/**
	 *
	 * @param \Object $query
	 * @param Integer $categoryId
	 * @use Model::ofReadyByCategory()->get();
	 */
	public function scopeOfReadyByCategory($query, $categoryId) {
		return $query->whereDeleted(self::AVAILABLE)->whereStatus(self::ACTIVATE)->whereCategoryId($categoryId);
	}

	/**
	 *
	 * @param \Object $query
	 * @param Boolean $deleted
	 * @use Model::ofReadyByApp()->get();
	 */
	public function scopeOfReadyByApp($query, $appId) {
		if($appId) {
			return $query->whereDeleted(self::AVAILABLE)->whereStatus(self::ACTIVATE)->whereAppId($appId);
		}
	}

	/**
	 * Validations input form add News
	 *
	 * @param array $input
	 * @param boolean $isNew
	 */
	public static function validate($input, $isNew = true) {
		if($isNew) {
			$rules = array(
					'title' => 'Required|Min:1|Max:100',
					'description'     => 'Between:0,255',
					'sorting' => 'numeric',
					//'image_ext'	=> 'Required|mimes:jpeg,jpg,png,gif',
					//'sound' => 'Required|mimes:audio/mpeg,mp3'
			);
		} else {
			$rules = array(
				'title' => 'Required|Min:1|Max:100',
				'description'     => 'Between:0,255',
				'sorting' => 'numeric',
				//'image_ext'	=> 'Required|mimes:jpeg,jpg,png,gif',
				//'sound' => 'mimes:audio/mpeg,mp3'
			);
		}

		return \Validator::make($input, $rules);
	}

	/**
	 * Defines a one-to-many relationship
	 */
	public function apps() {
		return $this->belongsTo('App\\Modules\\Admin\\Models\\Apps', 'app_id');
	}
	/**
	 * Defines a one-to-many relationship
	 */
	public function category() {
		return $this->belongsTo('App\\Modules\\Admin\\Models\\Category', 'category_id');
	}

}
