<?php
/**
 *
 * @author Alex
 *
 */
namespace App\Modules\Admin\Models;

class Category extends Base {

	/**
	 *
	 * @var \string $table
	 */
	protected $table = 'categories';

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
     * @param Int $parentId
     * @use Model::ofParent()->get();
     */
	public function scopeOfParent($query, $parentId) {
		return $query->whereParentId($parentId)
					 ->whereDeleted(self::AVAILABLE)
					 ->whereStatus(self::ACTIVATE);
	}

	/**
	*
	*/
	public static function getList() {
		$categories = self::ofParent(0)->get();
        $list = array();
        $list['all'] = \Lang::get('admin::common.all');
        foreach($categories as &$item) {
            $list[$item->id] = $item->title;
        }
		return $list;
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
					'title' => 'Required|Regex:/^([a-zA-Z0-9\s])+$/i|Min:1|Max:100',
					'sorting' => 'numeric',
			);
		} else {
			$rules = array(
				'title' => 'Required|Regex:/^([a-zA-Z0-9\s])+$/i|Min:1|Max:100',
				'sorting' => 'numeric',
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

}
