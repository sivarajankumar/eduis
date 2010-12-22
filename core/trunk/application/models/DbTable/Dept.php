<?php
/**
 *
 * @category   EduIS
 * @package    Core
 * @subpackage Dept
 * @since	   0.1
 */
class Core_Model_DbTable_Dept extends Zend_Db_Table
{
	protected $_name = 'department';
	protected $_primary = 'department_id';
	
	/**
	 * All departments of College
	 */
	public function alldepartment() {
		;
	}
}