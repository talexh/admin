<?php
/**
 *
 * @author Alex
 *
 */
namespace App\Modules\Admin\Models;

class Base extends \Eloquent {
    const AVAILABLE = 0; // This const means deleted = false
	const UNAVAILABLE = 1; // This const means deleted = true
	const ACTIVATE = 1; // This const means status = active
	const DEACTIVATE = 0; // This const means status = deactive

    /**
     *
     * @param \Object $query
     * @param Boolean $status
     * @use Model::ofStatus()->get();
     */
	public function scopeOfActivate($query) {
		return $query->whereStatus(self::ACTIVATE);
	}

	/**
     *
     * @param \Object $query
     * @param Boolean $deleted
     * @use Model::ofReady()->get();
     */
	public function scopeOfReady($query) {
		return $query->whereDeleted(self::AVAILABLE)->whereStatus(self::ACTIVATE);
	}

	/**
     *
     * @param \Object $query
     * @param Boolean $deleted
     * @use Model::ofAvailable()->get();
     */
	public function scopeOfAvailable($query) {
		return $query->whereDeleted(self::AVAILABLE);
	}

	/**
     *
     * @param \Object $query
     * @param Boolean $deleted
     * @use Model::ofDeleted()->get();
     */
	public function scopeOfDeleted($query) {
		return $query->whereDeleted(self::UNAVAILABLE);
	}

    public function getLanguages() {
		$languages = \DB::table('languages')->where('enabled',1)
											->orderBy('default', 'DESC')
											->orderBy('sort_order', 'ASC')
											->get();
		foreach($languages as &$language) {
			$language->useid = $language->id;
			if($language->default == 1) {
				$language->useid = 0;
			}
		}
		return $languages;
	}
	/**
	 *
	 * @param array $data
     * @param boolean isNew
	 * @return object $model
	 */
	public function bind($data, $isNew = true) {
        if(!$isNew) {
            $this->created_at = date('Y-m-d H:i:s', time());
        }
        $this->updated_at = date('Y-m-d H:i:s', time());

        $this->status = isset($data['status'])? $data['status'] : 0;

		foreach($data as $key=>$value) {
			$this->$key = $value;
		}
	}

	/**
	 *
	 * @param matrix $data
	 * @param object $model
	 * @return NULL|collection
	 */
	public function binds($data, $model) {

		$notE = false;
		$collections = array();

		foreach($data as $i=>$item) {
			foreach($item as $key=>$value) {
				if(property_exists($model, $key)) {
					$model->$key = $value;
				} else {
					$notE = true;
					break;
				}
			}
			if(!$notE)
				$collections[] = $model;
		}
		return $collections;
	}

}
