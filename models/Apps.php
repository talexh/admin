<?php
/**
 *
 * @author Alex
 *
 */
namespace App\Modules\Admin\Models;
use App\Modules\Admin\Models\Images;
use App\Modules\Admin\Models\Language;

class Apps extends Base {

	/**
	 *
	 * @var \string $table
	 */
	protected $table = 'apps';

	/**
     *
     * @use Model::getList($fields);
     */
    public static function getList() {
        $data = self::ofReady()->get();
        $list = array();
        $list['all'] = \Lang::get('admin::common.all');
        foreach($data as $item) {
            $list[$item->id] = $item->name;
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
				'name' => 'Required|Min:2|Max:50',
				'description'     => 'Between:0,255',
				'folder'	=> 'Min:2|Max:20',
				'sorting' => 'Numeric'
			);
		} else {
			$rules = array(
				'name' => 'Required|Min:2|Max:50',
				'description'     => 'Between:0,255',
				'folder'	=> 'Min:2|Max:20',
				'sorting' => 'Numeric'
			);
		}

		return \Validator::make($input, $rules);
	}

}
