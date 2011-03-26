<?php
/** 
 * @author Babita
 * @version 3.0
 * 
 */
class Acad_Model_Member_Faculty extends Acad_Model_Member_Generic
{
    /**
     * Faculty Subjects
     * @var string|int
     */
    protected $_subject_faculty;
    /**
     * Set Faculty Subjects
     * @param string $_subject_faculty
     * @return Acad_Model_Member_Faculty()
     */
    public function getFacultySubjects ($_subject_faculty)
    {
        
        $sql = 'SELECT
		subject_faculty.subject_code
            , subject.subject_name
        FROM
            subject_faculty
            INNER JOIN subject 
                ON (subject_faculty.subject_code = subject.subject_code)
            INNER JOIN subject_department 
                ON (subject_department.subject_code = subject.subject_code)
        WHERE (subject_faculty.staff_id = ?)';
        /*$this->logger->log ( 'getFacultySubject($_subject_faculty)', Zend_Log::INFO );
		$this->logger->log ( $result, Zend_Log::DEBUG );*/
        return $this->getAdapter()->fetchAll($sql, $_subject_faculty);
    }
}
?>