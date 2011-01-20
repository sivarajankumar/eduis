<?php
/**
 *
 * @category   EduIS
 * @package    Core
 * @subpackage StudentPersonal
 * @since	   0.1
 */
class Core_Model_DbTable_Student extends Corez_Base_Model {
	protected $_name = 'student_personal';
	

	public static function getStudentInfo($rollno) {                                          
		$sql = self::getDefaultAdapter()
		          ->select()
		          ->from(array('stuper' => 'student_personal'),
		                 array('student_roll_no',
		                        'first_name'))
		                 
                  ->join(array('studept' => 'student_department'),
                        '(`stuper`.`student_roll_no` = `studept`.`student_roll_no`)',
                        array('group_id',
                              'department_id',
                              'degree_id' ))
                        
                  ->join(array('batsem' => 'batch_semester'),
                            '(`batsem`.`department_id` = `studept`.`department_id`)
                            AND (`batsem`.`degree_id` = `studept`.`degree_id`)
                            AND (`batsem`.`batch_start` = `studept`.`batch_start`)',
                        array('semester_id'))
                        
                  ->where('`stuper`.`student_roll_no` = ?', $rollno)
                  ->where('`studept`.`is_active` = 1');

        $result = $sql->query()->fetchAll();
        // Roll number is unique so only one record will appear.
        if (count($result)){
        	return $result[0];
        } else {
        	throw new Zend_Exception('Information of "'.$rollno.'" cannot be retrieved.', Zend_Log::ERR);
        }
		
	}
}