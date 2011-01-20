<?php
class Acad_Model_DbTable_SubjectFaculty  extends Aceis_Base_Model {
	protected $_name = 'subject_faculty';
	
	public function getFacultySubject($faculty) {
		/*$sql = $this->select ()->from ( $this->_name, array ('subject_code', 'subject_mode_id' ) )->where ( "staff_id = ?", $faculty );
		$stmt = $sql->query ();
		$result = $stmt->fetchAll ();*/
		$sql = 'SELECT
		subject_faculty.subject_code
    , subject.subject_name
    , subject_faculty.subject_mode_id
    , subject_department.department_id
    , subject_department.degree_id
    , subject_department.semester_id
FROM
    aceis.subject_faculty
    INNER JOIN aceis.subject 
        ON (subject_faculty.subject_code = subject.subject_code)
    INNER JOIN aceis.subject_department 
        ON (subject_department.subject_code = subject.subject_code)
WHERE (subject_faculty.staff_id = ?)';
		
		
		/*$this->logger->log ( 'getFacultySubject($faculty)', Zend_Log::INFO );
		$this->logger->log ( $result, Zend_Log::DEBUG );*/
		return $this->getAdapter()->fetchAll($sql, $faculty);
	}
	
	/*
	 * Subject's Faculty
	 */
    public static function getSubjectFaculty($subjectCode, $subjectMode = NULL, $department = NULL) {
    	
        $sql = self::getDefaultAdapter ()
                        ->select ()
                        ->from(array ('subfac' => 'subject_faculty' ),
                               array(//'staff_id',   //Use it from either table
                                     //'subject_code',  //For test purpose
                                     //'subject_mode_id' //For test purpose
                                     ))
                               
                        ->join(array ('staffper' => 'staff_personal' ),
                               '(`subfac`.staff_id = `staffper`.staff_id)',
                               array('staff_id',
                                     'first_name',
                                     'last_name'))
                               
                        ->where('`subfac`.subject_code = ?',$subjectCode)
                        ->order(array('staff_id'));
                        
        if (isset ( $subjectMode )) {
            $sql->where ( "`subfac`.subject_mode_id = ?", $subjectMode );
        } else {
        	$sql->columns('subject_mode_id','subfac');
        }
        
        // TODO Havent considered department yet, which department to choose? faculty's or subject's
        
       if (isset ( $department )) {
            $sql->where ( "`subfac`.department_id = ?", $department );
        } else {
        	$sql->columns('department_id','subfac');
        }

        return $sql->query()->fetchAll();
    }
    public function insert(array $data) {
    $subject_modes = explode(',',$data['subject_mode_id']); 
    $insert_str = "INSERT INTO `subject_faculty` (`department_id`,`subject_code`,`subject_mode_id`,`staff_id`) VALUES ";
    $addComma = false;
    foreach($subject_modes as $key => $value)
    {
    	if(!(empty($value)))
    	{
    		$department_id = $data['department_id'];
    		$subject_code = $data['subject_code'];
    		$subject_mode_id = $value;
    		$staff_id = $data['staff_id'];
    		if($addComma)
    		{
    			$insert_str .= ',';
    		}
    		$insert_str .=  "( '$department_id' ,'$subject_code','$subject_mode_id' ,'$staff_id')";
    		$addComma = true;
    	}
    }
    try{
     		$this->getDefaultAdapter ()->query ( $insert_str );
    		return  Zend_Controller_Front::getInstance()->getResponse()->setHttpResponseCode ( 200 );
    		
    		} catch ( Exception $e ) {
				
			throw $e;	
			}
   //return $insert_str;
    }
    public static function getDepartmentFaculty($department_id)
    {
    	$sql = self::getDefaultAdapter()->select()->distinct()->from('subject_faculty','staff_id')
    											   ->join('staff_personal','subject_faculty.staff_id = staff_personal.staff_id',array('first_name','last_name') )
    											   ->join('semester_degree','semester_degree.department_id = subject_faculty.department_id')
    											   ->where('semester_degree.handled_by_dept =? ',$department_id);
    											   
    	return $sql->query()->fetchAll();											   
    											  		
    }
    
 
}