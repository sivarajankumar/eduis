<?php
/** 
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
     * Subject Mapper
     * @var Acad_Model_Member_FacultyMapper
     */
    protected $_mapper;
    /**
     * Set Subject Mapper
     * @param Acad_Model_Member_FacultyMapper $mapper - Subject Mapper
     * @return Acad_Model_Test_Sessional
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * Get Subject Mapper
     * @return Acad_Model_Member_FacultyMapper $mapper - Subject Mapper
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Member_FacultyMapper());
        }
        return $this->_mapper;
    }
    
    
	/**
	 * Set Faculty ID
	 * 
	 * @param  string|int $faculty_id 
	 * @return Acad_Model_Member_Faculty
	 */
    public function setFacultyId($faculty_id) {
        return self::setMemberId($faculty_id);
    }
    
	/* (non-PHPdoc)
	 * @see Acad_Model_Member_Generic::getPersonalInfo()
	 */
	public function _fetchPersonalInfo() {
	    $faculty_id = $this->getFacultyId();
        $cache = self::getCache('remote');
        $facultyPersonal = $cache->load('facultyPersonal');
        // see if a cache already exists:
        if ($facultyPersonal === false or !isset($facultyPersonal[$faculty_id])) {
    		$PROTOCOL = 'http://';
    		$URL_STAFF_INFO = $PROTOCOL . CORE_SERVER . '/staff/getinfo' . "?staff_id=$faculty_id";
    		$client = new Zend_Http_Client ( $URL_STAFF_INFO );
    		$client->setCookie ( 'PHPSESSID', $_COOKIE ['PHPSESSID'] );
    		$response = $client->request ();
            if ($response->isError()) {
    			$remoteErr = 'REMOTE ERROR: ('.$response->getStatus () . ') ' . $response->getMessage ();
    			Zend_Registry::get('logger')->err($remoteErr);
                throw new Zend_Exception($remoteErr, Zend_Log::ERR);
            } else {
                $jsonContent = $response->getBody();
                $facultyInfo = Zend_Json_Decoder::decode($jsonContent);
                $facultyPersonal[$faculty_id] = $facultyInfo;
                $cache->save($facultyPersonal, 'facultyPersonal');
            }
        }
        return $facultyPersonal[$faculty_id];
	}

	public function getName() {
	    $facultyInfo = $this->getPersonalInfo();
	    $facultyName = array($facultyInfo['initial'],
	                            $facultyInfo['first_name'],
	                            $facultyInfo['middle_name'],
	                            $facultyInfo['last_name']);
	    return implode(' ', $facultyName);
	    
	}
	/**
	 * Get Faculty ID
	 * 
	 * @return string|int
	 */
    public function getFacultyId() {
        return self::getMemberId();
    }
    
    /**
     * Get Faculty Subjects
     * @param Acad_Model_Class|Acad_Model_Department $viewLevel = null
     * @param bool $showModes = null
     * @return array
     */
    public function getSubjects ($viewLevel = NULL, $showModes = NULL){
        return $this->getMapper()->fetchSubjects($this,$viewLevel, $showModes);
    }
    
    /**
     * Get Subjects which are taught by faculty in current session.
     * @param Acad_Model_Class|Acad_Model_Department $viewLevel = null
     * @param bool $showModes = null
     * @return array
     */
    public function getInHandSubjects ($viewLevel = NULL, $showModes = NULL){
        return $this->getMapper()->fetchInHandSubjects($this,$viewLevel, $showModes);
    }
    
    /**
     * List of all periods marked.
     */
    public function listMarkedAttendance() {
        return $this->getMapper()->listMarkedAttendance($this);
    }
    

    public function listUnMarkedAttendance() {
        return $this->getMapper()->listUnMarkedAttendance($this);
    }
}
?>