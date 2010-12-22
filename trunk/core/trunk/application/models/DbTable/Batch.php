<?php
/**
 *
 * @category   EduIS
 * @package    Core
 * @subpackage Batch
 * @since	   0.1
 */
/*
 * Model for Batch(es) in a degree of a department.
 * 
 */
class Core_Model_DbTable_Batch extends Corez_Base_Model {
	protected $_name = 'batch';
	const TABLE_NAME = 'batch';
	/*
	 * Batches' start year of given department's degree.
	 * @param Department
	 * @param Degree
	 * @param Show all batches (Active + inactive), Default = FALSE
	 */
	public static function batch($department_id, $degree_id, $showAll = FALSE) {
		$sql = self::getDefaultAdapter()->select()
		               ->from(self::TABLE_NAME, 'batch_start')
		               ->where('degree_id = ?', $degree_id)
		               ->where('department_id = ?', $department_id);
		if (!$showAll) {
			$sql->where('is_active = "1"');
		}
		               
		return $sql->query()->fetchAll();
	}
	
	/**
	 * Update batch status every year
	 */
	public function updateBatch() {
		;
	}
}