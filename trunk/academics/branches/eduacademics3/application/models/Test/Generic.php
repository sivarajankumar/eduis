<?php
/** 
 * @author Administrator, udit sharma
 * @version 3.0
 * 
 */
abstract class Acad_Model_Test_Generic
{
    
    /**
     * Test info id
     * @var int
     */
    protected $_test_info_id;
    
    /**
     * Department id
     * @var string
     */
    protected $_department_id;
     
    /**
     * Degree id
     * @var string
     */
    protected $_degree_id;
     
     
    /**
     * Semester id
     * @var int
     */
    protected $_semester_id;
    
    
    /**
     * Subject code
     * @var string
     */
    protected $_subject_code;
    
    /**
     * Subject name
     * @var string
     */
    protected $_subject_name;
    
    
    /**
     * Test type id
     * @var string
     * Can be overridden in derived classes.
     */
    protected $_test_type_id;
    
    
    /**
     * Test id
     * @var int
     */
    protected $_test_id;
    
    /**
     * Time of conduct or submission(in case of assignments)
     * @var str
     */
    protected $_time;
     
    /**
     * Date of announcement
     * @var date
     */
    protected $_date_of_announcement;
    
    /**
     * Date of conduct
     * @var date
     */
    protected $_date_of_conduct;
    
    
    /**
     * Max marks
     * @var int
     * Can be overridden by derived class
     */
    protected $_max_marks;
     
     
    /**
     * Pass marks
     * @var int
     * Can be overridden by derived class
     */
    protected $_pass_marks;
    
    
    /**
     * Remarks
     * @var string
     */
    protected $_remarks;

    /**
     * Is optional
     * @var small int
     * Default value 
     * 0 => False
     * 1 => True 
     */
    protected $_is_optional = 0;
    
    
    /**
     * Is Locked
     * @var small int
     * Default value 
     * 0 => False
     * 1 => True 
     */
    protected $_is_locked = 0;
    
    /**
     * Default pass marks
     * @var int 
     * Can be overridden in derived classes.
     */
    protected $_default_pass_marks;
    
    /**
     * Default max marks
     * @var int
     * Can be overridden in derived classes.
     */
    protected $_default_max_marks;
    
    /**
     * Set test info id
     * @param int $testInfoId - test info id
     * @return Acad_Model_Test_Generic
     */
    public function setTest_info_id($testInfoId){
        $this->_test_info_id=$testInfoId;        
        return $this;
    }
    
    
    /**
     * Get test info id
     * @return int $_test_info_id - test info id
     */
    public function getTest_info_id(){
        if (isset($this->_test_info_id)) {
            return $this->_test_info_id;
        }
        throw new Zend_Exception("The object's primary key (i.e. _test_info_id) is not set.",Zend_Log::ERR);
    }
    
    
    /**
     * Set department id
     * @param string $departmentid - department id
     * @return Acad_Model_Test_Generic
     */
    public function setDepartment_id($departmentid){
        $this->_department_id=$departmentid;
        return $this;
    }
    
    /**
     * Get department id
     * @return string $_department_id - department id
     */
    public function getDepartment_id(){
        return $this->_department_id;
    }
    
    
    /**
     * Set degree id
     * @param string $degreeid - degree id
     * @return Acad_Model_Test_Generic
     */
    public function setDegree_id($degreeid){
        $this->_degree_id=$degreeid;
        return $this;
    }
    
    /**
     * Get degree id
     * @return string $_degree_id - degree id
     */
    public function getDegree_id(){
        return $this->_degree_id;
    }
     
    /**
     * Set semester id
     * @param int $semesterid - semester id
     * @return Acad_Model_Test_Generic
     */
    public function setSemester_id($semesterid){
        $this->_semester_id=$semesterid;
        return $this;
    }
    
    /**
     * Get semester id
     * @return int $_semester_id - semester id
     */
    public function getSemester_id(){
        return $this->_semester_id;
    }
    
    /**
     * Set subject code
     * @param array
     * @return Acad_Model_Test_Generic
     */
    public function setSubject_code($subjectcode){
        $this->_subject_code=$subjectcode;
        return $this;
    }
    
    /**
     * Get subject code
     * @return string $_subject_code - subject
     */
    public function getSubject_code(){
        return $this->_subject_code;
    }
    
    /**
     * Set subject name
     * @param array
     * @return Acad_Model_Test_Generic
     */
    public function setSubject_name($subjectname){
        $this->_subject_name=$subjectname;
        return $this;
    }
    
    /**
     * Get subject name
     * @return string $_subject_name - subject
     */
    public function getSubject_name(){
        return $this->_subject_name;
    }
    
    
    /**
     * Set test type id
     * @param string $testtypeid - test type id
     * @return Acad_Model_Test_Generic
     */
    protected function _setTest_type_id($testtypeid){
        $this->_test_type_id=$testtypeid;
        return $this;
    }
    
    /**
     * Get test type id
     * @return string $test_type_id - test_type_id
     */
    public function getTest_type_id(){
        return $this->_test_type_id;
    }
    
     
    /**
     * Set test id
     * @param int $testid - test id
     * @return Acad_Model_Test_Generic
     */
    public function setTest_id($testid){
        $this->_test_id=$testid;
        return $this;
    }
    
    /**
     * Get test id
     * @return string $_test_id - test id
     */
    public function getTest_id(){
        return $this->_test_id;
    }
    
	/**
     * Set Time of conduct/submission
     * @param str $time - Time of conduct/submission
     * @return Acad_Model_Test_Generic
     */
    public function setTime($time){
        $this->_time = $time;
        return $this;
    }
    
    /**
     * Get Time of conduct/assignments
     * @return str $time - Time of conduct
     */
    public function getTime(){
        return $this->_time;
    }
    
    /**
     * Set date of announcement
     * @param date $dateofannouncement - date of announcement
     * @return Acad_Model_Test_Generic
     */
    public function setDate_of_coduct($dateofannouncement){
        $this->_date_of_announcement = $dateofannouncement;
        return $this;
    }
    
    /**
     * Get date of announcement
     * @return date $date_of_announcement - date of announcement
     */
    public function getDate_of_announcement(){
        return $this->_date_of_announcement;
    }
    
    /**
     * Set date of conduct
     * @param date $dateofconduct - date of conduct
     * @return Acad_Model_Test_Generic
     */
    public function setDate_of_conduct($dateofconduct){
        $this->_date_of_conduct = $dateofconduct;
        return $this;
    }
    
    /**
     * Get date of conduct
     * @return date $date_of_conduct - date of conduct
     */
    public function getDate_of_conduct(){
        return $this->_date_of_conduct;
    }
    
	/**
     * Set max marks
     * @param int $maxmarks - max marks
     * @return Acad_Model_generic
     */
    public function setMax_marks($maxmarks){
        $this->_max_marks = $maxmarks;
        return $this;
    }
    
    /**
     * Get max marks
     * @return int $_max_marks - max marks
     */
    public function getMax_marks(){
        return $this->_max_marks;
    }
    
    /**
     * Set pass marks
     * @param int $passmarks - pass marks
     * @return Acad_Model_generic
     */
    public function setPass_marks($passmarks){
        $this->_pass_marks = $passmarks;
        return $this;
    }
    
    /**
     * Get pass marks
     * @return int $_pass_marks - pass marks
     */
    public function getPass_marks(){
        return $this->_pass_marks;
    }    
     
    /**
     * Set remarks
     * @param string $remark - remarks
     * @return Acad_Model_Test_Generic
     */
    public function setRemark($remarks){
        $this->_remarks = $remarks;
        return $this;
    }
    
    /**
     * Get remarks
     * @return string $remark - remarks
     */
    public function getRemark(){
        return $this->_remarks;
    }
    
	/**
     * Set is optional
     * @param string $isoptional - is optional
     * @return Acad_Model_Test_Generic
     */
    public function setIs_optional($isoptional){
        $this->_is_optional = $isoptional;
        return $this;
    }

    /**
     * Get is optional
     * @return string $_is_optional - is optional
     */
    public function getIs_optional(){
        return $this->_is_optional;
    }
    

	/**
     * Set as locked
     * @param string $islocked - is locked
     * @return Acad_Model_Test_Generic
     */
    public function setIs_locked($islocked){
        $this->_is_locked = $islocked;
        return $this;
    }
    
    /**
     * Get is optional
     * @return string $_is_optional - is optional
     */
    public function getIs_locked(){
        return $this->_is_locked;
    }
    
	/**
     * Set default pass marks
     * @param string $defaultpassmarks - default pass marks
     */
    public function setDefault_pass_marks($defaultpassmarks){
        $this->_default_pass_marks = $defaultpassmarks;
        return $this;
    }
    
	/**
     * Get default pass marks
     * @return string $_default_pass_marks - default pass marks
     */
    public function getDefault_pass_marks(){
        return $this->_default_pass_marks;
    }
    
	/**
     * Set default max marks
     * @param string $defaultmaxmarks - default max marks
     */
    public function setDefault_max_marks($defaultmaxmarks){
        $this->_default_max_marks = $defaultmaxmarks;
        return $this;
    }
    
	/**
     * Get default max marks
     * @return string $_default_max_marks - default max marks
     */
    public function getDefault_max_marks(){
        return $this->_default_max_marks;
    }
	/**
     * Save test marks
     * 
     * @return void
     * @deprecated 'Useless thing'
     */
    public function _save ()
    {
        $this->getMapper()->save($this);
    }
    
    /**
     * Test conducted in class.
     * @param Acad_Model_Class $class
     */
    public function getConducted(Acad_Model_Class $class) {
        $sql = 'SELECT
  test_id,
  (SELECT
     test_id
   FROM test
   WHERE test_type_id = ?
   ORDER BY test_id DESC
   LIMIT 1) AS max_test_id
FROM test_info
WHERE (department_id = ?
       AND degree_id = ?
       AND semester_id = ?
       AND test_type_id = ?)
ORDER BY test_type_id,test_id DESC
LIMIT 1';
        
        $bind[] = self::getTest_type_id();
        $bind[] = $class->getDepartment();
        $bind[] = $class->getDegree();
        $bind[] = $class->getSemester();
        $bind[] = self::getTest_type_id();
        return Zend_Db_Table::getDefaultAdapter()->query($sql,$bind)->fetch();
    }
    

    public function getStudents() {
        $sql = 'SELECT
        `student_roll_no`
        , `marks_scored`
        , `status`
    FROM
        `academics`.`test_marks`
    WHERE (`test_info_id` = ?)';
        
        $bind[] = self::getTest_info_id();
        return Zend_Db_Table::getDefaultAdapter()->query($sql,$bind)->fetchAll(Zend_Db::FETCH_UNIQUE);
    }
    

    public function setMarks($data) {
        
        $where[] = 'test_info_id = '.self::getTest_info_id();
        $where[] = 'student_roll_no = '.$data['student_roll_no'];
        
        $bind['marks_scored'] = $data['marks_scored'];
        $bind['status'] = $data['status'];
        return Zend_Db_Table::getDefaultAdapter()->update('test_marks', $bind,$where);
    }

    public function getMarks() {
        $select = Zend_Db_Table::getDefaultAdapter()->select();
        $select->from('test_marks',array('student_roll_no',
        									'marks_scored',
        									'status'))
                ->where('test_info_id = ?',self::getTest_info_id());
        return $select->query()->fetchAll(Zend_Db::FETCH_GROUP);
    }
    
    
    public function __toArray() {
        $sql = 'SELECT *
FROM
    `academics`.`test_info`
WHERE (`test_info_id` = ?)';
        $bind[] = self::getTest_info_id();
        $tuple =  Zend_Db_Table::getDefaultAdapter()->query($sql,$bind)->fetch();
        $this->setOptions($tuple);
        $data['date_of_conduct'] = $this->getDate_of_conduct();
        $data['time'] = $this->getTime();
        $data['max_marks'] = $this->getMax_marks();
        $data['pass_marks'] = $this->getPass_marks();
        $data['department_id'] = $this->getDepartment_id();
        $data['degree_id'] = $this->getDegree_id();
        $data['semester_id'] = $this->getSemester_id();
        $data['subject_code'] = $this->getSubject_code();
        $data['test_id'] = $this->getTest_id();
        $data['test_type_id'] = $this->getTest_type_id();
        $data['date_of_announcement'] = $this->getDate_of_announcement();
        $data['is_locked'] = $this->getIs_locked();
        $data['is_optional'] = $this->getIs_optional();
        return $data;
                
    }
    
    public function setLock($lock = TRUE) {
        
        $where[] = 'test_info_id = '.self::getTest_info_id();
        
        $bind['is_locked'] = ($lock)?'1':'0';
        
        return Zend_Db_Table::getDefaultAdapter()->update('test_info', $bind,$where);
    }
}
?>