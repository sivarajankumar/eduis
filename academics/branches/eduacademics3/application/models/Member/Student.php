<?php
class Acad_Model_Member_Student extends Acad_Model_Generic
{
    // critical information
    protected $_member_id;
    protected $_member_type_id;
    protected $_member_type_name;
    protected $_first_name;
    protected $_middle_name;
    protected $_last_name;
    protected $_dob;
    protected $_gender;
    protected $_blood_group;
    protected $_cast_id;
    protected $_nationality_id;
    protected $_religion_id;
    protected $_cast_name;
    protected $_nationality_name;
    protected $_religion_name;
    protected $_join_date;
    protected $_relieve_date;
    protected $_image_no;
    protected $_is_active;
    protected $_mapper;
    /**
     * @return the $_member_id
     */
    public function getMember_id ()
    {
        return $this->_member_id;
    }
    /**
     * @param field_type $_member_id
     */
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    /**
     * @return the $_member_type_id
     */
    public function getMember_type_id ()
    {
        return $this->_member_type_id;
    }
    /**
     * @param field_type $_member_type_id
     */
    public function setMember_type_id ($_member_type_id)
    {
        $this->_member_type_id = $_member_type_id;
    }
    /**
     * @return the $_member_type_name
     */
    public function getMember_type_name ()
    {
        return $this->_member_type_name;
    }
    /**
     * @param field_type $_member_type_name
     */
    public function setMember_type_name ($_member_type_name)
    {
        $this->_member_type_name = $_member_type_name;
    }
    /**
     * @return the $_first_name
     */
    public function getFirst_name ()
    {
        return $this->_first_name;
    }
    /**
     * @param field_type $_first_name
     */
    public function setFirst_name ($_first_name)
    {
        $this->_first_name = $_first_name;
    }
    /**
     * @return the $_middle_name
     */
    public function getMiddle_name ()
    {
        return $this->_middle_name;
    }
    /**
     * @param field_type $_middle_name
     */
    public function setMiddle_name ($_middle_name)
    {
        $this->_middle_name = $_middle_name;
    }
    /**
     * @return the $_last_name
     */
    public function getLast_name ()
    {
        return $this->_last_name;
    }
    /**
     * @param field_type $_last_name
     */
    public function setLast_name ($_last_name)
    {
        $this->_last_name = $_last_name;
    }
    /**
     * @return the $_dob
     */
    public function getDob ()
    {
        return $this->_dob;
    }
    /**
     * @param field_type $_dob
     */
    public function setDob ($_dob)
    {
        $this->_dob = $_dob;
    }
    /**
     * @return the $_gender
     */
    public function getGender ()
    {
        return $this->_gender;
    }
    /**
     * @param field_type $_gender
     */
    public function setGender ($_gender)
    {
        $this->_gender = $_gender;
    }
    /**
     * @return the $_blood_group
     */
    public function getBlood_group ()
    {
        return $this->_blood_group;
    }
    /**
     * @param field_type $_blood_group
     */
    public function setBlood_group ($_blood_group)
    {
        $this->_blood_group = $_blood_group;
    }
    /**
     * @return the $_cast_id
     */
    public function getCast_id ()
    {
        return $this->_cast_id;
    }
    /**
     * @param field_type $_cast_id
     */
    public function setCast_id ($_cast_id)
    {
        $this->_cast_id = $_cast_id;
    }
    /**
     * @return the $_nationality_id
     */
    public function getNationality_id ()
    {
        return $this->_nationality_id;
    }
    /**
     * @param field_type $_nationality_id
     */
    public function setNationality_id ($_nationality_id)
    {
        $this->_nationality_id = $_nationality_id;
    }
    /**
     * @return the $_religion_id
     */
    public function getReligion_id ()
    {
        return $this->_religion_id;
    }
    /**
     * @param field_type $_religion_id
     */
    public function setReligion_id ($_religion_id)
    {
        $this->_religion_id = $_religion_id;
    }
    /**
     * @return the $_cast_name
     */
    public function getCast_name ()
    {
        return $this->_cast_name;
    }
    /**
     * @return the $_nationality_name
     */
    public function getNationality_name ()
    {
        return $this->_nationality_name;
    }
    /**
     * @return the $_religion_name
     */
    public function getReligion_name ()
    {
        return $this->_religion_name;
    }
    /**
     * @param field_type $_cast_name
     */
    public function setCast_name ($_cast_name)
    {
        $this->_cast_name = $_cast_name;
    }
    /**
     * @param field_type $_nationality_name
     */
    public function setNationality_name ($_nationality_name)
    {
        $this->_nationality_name = $_nationality_name;
    }
    /**
     * @param field_type $_religion_name
     */
    public function setReligion_name ($_religion_name)
    {
        $this->_religion_name = $_religion_name;
    }
    /**
     * @return the $_join_date
     */
    public function getJoin_date ()
    {
        return $this->_join_date;
    }
    /**
     * @param field_type $_join_date
     */
    public function setJoin_date ($_join_date)
    {
        $this->_join_date = $_join_date;
    }
    /**
     * @return the $_relieve_date
     */
    public function getRelieve_date ()
    {
        return $this->_relieve_date;
    }
    /**
     * @param field_type $_relieve_date
     */
    public function setRelieve_date ($_relieve_date)
    {
        $this->_relieve_date = $_relieve_date;
    }
    /**
     * @return the $_image_no
     */
    public function getImage_no ()
    {
        return $this->_image_no;
    }
    /**
     * @param field_type $_image_no
     */
    public function setImage_no ($_image_no)
    {
        $this->_image_no = $_image_no;
    }
    /**
     * @return the $_is_active
     */
    public function getIs_active ()
    {
        return $this->_is_active;
    }
    /**
     * @param field_type $_is_active
     */
    public function setIs_active ($_is_active)
    {
        $this->_is_active = $_is_active;
    }
    /**
     * @return the $_reg_id
     */
    public function getReg_id ()
    {
        return $this->_reg_id;
    }
    /**
     * @param field_type $_reg_id
     */
    public function setReg_id ($_reg_id)
    {
        $this->_reg_id = $_reg_id;
    }
    /**
     * @return the $_marital_status
     */
    public function getMarital_status ()
    {
        return $this->_marital_status;
    }
    /**
     * @param field_type $_marital_status
     */
    public function setMarital_status ($_marital_status)
    {
        $this->_marital_status = $_marital_status;
    }
    /**
     * @return the $_councelling_no
     */
    public function getCouncelling_no ()
    {
        return $this->_councelling_no;
    }
    /**
     * @param field_type $_councelling_no
     */
    public function setCouncelling_no ($_councelling_no)
    {
        $this->_councelling_no = $_councelling_no;
    }
    /**
     * @return the $_admission_date
     */
    public function getAdmission_date ()
    {
        return $this->_admission_date;
    }
    /**
     * @param field_type $_admission_date
     */
    public function setAdmission_date ($_admission_date)
    {
        $this->_admission_date = $_admission_date;
    }
    /**
     * @return the $_alloted_category
     */
    public function getAlloted_category ()
    {
        return $this->_alloted_category;
    }
    /**
     * @param field_type $_alloted_category
     */
    public function setAlloted_category ($_alloted_category)
    {
        $this->_alloted_category = $_alloted_category;
    }
    /**
     * @return the $_alloted_branch
     */
    public function getAlloted_branch ()
    {
        return $this->_alloted_branch;
    }
    /**
     * @param field_type $_alloted_branch
     */
    public function setAlloted_branch ($_alloted_branch)
    {
        $this->_alloted_branch = $_alloted_branch;
    }
    /**
     * @return the $_state_of_domicile
     */
    public function getState_of_domicile ()
    {
        return $this->_state_of_domicile;
    }
    /**
     * @param field_type $_state_of_domicile
     */
    public function setState_of_domicile ($_state_of_domicile)
    {
        $this->_state_of_domicile = $_state_of_domicile;
    }
    /**
     * @return the $_urban
     */
    public function getUrban ()
    {
        return $this->_urban;
    }
    /**
     * @param field_type $_urban
     */
    public function setUrban ($_urban)
    {
        $this->_urban = $_urban;
    }
    /**
     * @return the $_avails_hostel
     */
    public function getAvails_hostel ()
    {
        return $this->_avails_hostel;
    }
    /**
     * @param field_type $_avails_hostel
     */
    public function setAvails_hostel ($_avails_hostel)
    {
        $this->_avails_hostel = $_avails_hostel;
    }
    /**
     * @return the $_avails_bus
     */
    public function getAvails_bus ()
    {
        return $this->_avails_bus;
    }
    /**
     * @param field_type $_avails_bus
     */
    public function setAvails_bus ($_avails_bus)
    {
        $this->_avails_bus = $_avails_bus;
    }
    /**
     * Sets Mapper
     * @param Acad_Model_Mapper_Member_Student $mapper
     * @return Acad_Model_Member_Student
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Acad_Model_Mapper_Member_Student
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Mapper_Member_Student());
        }
        return $this->_mapper;
    }
    /**
     * Provides correct db column names corresponding to model properties
     * @todo add correct names where required
     * @param string $key
     */
    protected function correctDbKeys ($key)
    {
        switch ($key) {
            /*case 'nationalit':
                return 'nationality';
                break;*/
            default:
                return $key;
                break;
        }
    }
    /**
     * Provides correct model property names corresponding to db column names
     * @todo add correct names where required
     * @param string $key
     */
    protected function correctModelKeys ($key)
    {
        switch ($key) {
            /*case 'nationality':
                return 'nationalit';
                break;*/
            default:
                return $key;
                break;
        }
    }
    /**
     * 
     */
    public function initInfo ()
    {}
    /**
     * Fetches CRITICAL information of a Student,
     * Member_id must be set before calling this function 
     * @return Student|false object of Acad_Model_Member_Student
     */
    public function fetchCriticalInfo ()
    {
        $member_id = $this->getMember_id();
        if (empty($member_id)) {
            $error = 'Please provide a Member Id';
            throw new Exception($error, Zend_Log::ERR);
        } else {
            $info = $this->getMapper()->fetchCriticalInfo($member_id);
            if (sizeof($info) == 0) {
                return false;
            } else {
                $this->setOptions($info);
            }
        }
    }
    /**
     * Fetches the Active class_ids of a Student
     * Member_id must be set before calling this function 
     * @return false|array an array containing all class ids in which member is active
     */
    public function fetchActiveClassIds ()
    {
        $student_class_ids = $this->fetchAllClassIds();
        $member_id = $this->getMember_id(true);
        $class_obj = new Acad_Model_Class();
        $active_class_ids = $class_obj->fetchClassIds(null, null, true);
        $student_active_class_ids = array();
        $student_active_class_ids = array_intersect($student_class_ids, 
        $active_class_ids);
        if (empty($student_active_class_ids)) {
            return false;
        } else {
            return $student_active_class_ids;
        }
    }
    /**
     * Fetches the All class_ids of a Student
     * Member_id must be set before calling this function 
     * @return false|array an array containing all class ids in which member was admitted
     */
    public function fetchAllClassIds ()
    {
        $member_id = $this->getMember_id(true);
        $student_class_obj = new Acad_Model_StudentClass();
        $student_class_obj->setMember_id($member_id);
        $student_class_ids = $student_class_obj->fetchClassIds();
        if (empty($student_class_ids)) {
            return false;
        } else {
            return $student_class_ids;
        }
    }
    /**
     * Fetches class_ids in which member was admitted in the given semester(
     * Member_id must be set before calling this function )
     * @param int $batch_id batch_id of the student( Required because a student may have been admitted in more than one batch)
     * @param int $semester_id semester_id of the student
     * @return false|array 
     */
    public function fetchSemesterClassId ($batch_id, $semester_id)
    {
        $class_object = new Acad_Model_Class();
        $class_object->setBatch_id($batch_id);
        $class_object->setSemester_id($semester_id);
        $class_ids = $class_object->fetchClassIds(true, true);
        if (empty($class_ids)) {
            return false;
        } else {
            return $class_ids;
        }
    }
    /**
     * Fetches information regarding CLASS of a Student,
     * Member_id must be set before calling this function 
     * @return StudentClass|false object of Acad_Model_StudentClass
     */
    public function fetchClassInfo ($class_id)
    {
        $member_id = $this->getMember_id();
        $student_class_object = new Acad_Model_StudentClass();
        $student_class_object->setMember_id($member_id);
        $student_class_object->setClass_id($class_id);
        $info_flag = $student_class_object->fetchInfo();
        if (! $info_flag) {
            return false;
        } else {
            return $student_class_object;
        }
    }
    /**
     * Fetches Batch Id of a Student,
     * Member_id must be set before calling this function 
     * @return int the Batch_id of student
     */
    public function fetchBatchId ()
    {
        $member_id = $this->getMember_id();
        $student_class_object = new Acad_Model_StudentClass();
        $student_class_object->setMember_id($member_id);
        $batch_identifier_class_id = $student_class_object->fetchBatchIdentifierClassId();
        $class_object = new Acad_Model_Class();
        $class_object->setClass_id($batch_identifier_class_id);
        $class_info = $class_object->fetchInfo();
        $batch_id = $class_object->getBatch_id();
        return $batch_id;
    }
    /**
     * Fetches Student_subject_id and Subject_id of All subjects studied by a student in an Academic Class.
     * 
     * Returns an array indexed by Student_subject_id and subject_id as values
     * Fetches the Class id of a Student
     * Member_id must be set before calling this function 
     * @param integer $class_id
     * @return array|false
     */
    public function fetchClassSubjects ($class_id)
    {
        $member_id = $this->getMember_id();
        $student_subject_object = new Acad_Model_StudentSubject();
        $student_subject_object->setMember_id($member_id);
        $student_subject_object->setClass_id($class_id);
        $subjects = array();
        $subjects = $student_subject_object->fetchSubjects();
        if (! $subjects) {
            return false;
        } else {
            return $subjects;
        }
    }
    /**
     * Fetches Class in which a student Studied the given Subject.
     * A student may have studied a Subject more than Once but in Different classes. Ex - Detained Student.
     * @param  int $subject_id
     * @return array|false (if a student never studied the subject -false- is returned,
     * else an Array containing Ids of all Classes in which a Student studied the Subject is returned)  
     */
    public function fetchSubjectClass ($subject_id)
    {
        $member_id = $this->getMember_id();
        $student_subject_object = new Acad_Model_StudentSubject();
        $student_subject_object->setMember_id($member_id);
        $student_subject_object->setSubject_id($subject_id);
        $class_id = $student_subject_object->fetchClassIds();
        if (! $class_id) {
            return false;
        } else {
            return $class_id;
        }
    }
    /**
     * Fetches Marks scored by the student in the given Subject
     * A student may have studied a Subject more than Once but in Different classes. Ex - Detained Student,
     * therefore subject_id and class_id are required.
     * An Array indexed by result_type_id
     * @param integer $class_id
     * @param integer $subject_id
     * @throws Exception
     */
    /*    public function fetchSubjectDMC ($class_id, $subject_id, $result_type_id)
    {
        $member_id = $this->getMember_id();
        if (empty($member_id)) {
            $error = 'Please provide a Member Id';
            throw new Exception($error,Zend_Log::ERR);
        } else {
            $student_subject_object = new Acad_Model_StudentSubject();
            $student_subject_object->setMember_id($member_id);
            $student_subject_object->setSubject_id($subject_id);
            $student_subject_object->setClass_id($class_id);
            $marks = $student_subject_object->fetchDMC($result_type_id);
            if ($marks instanceof Acad_Model_DmcMarks) {
                return $marks;
            } else {
                return false;
            }
        }
    }
    public function fetchSubjectsPassed ($class_id)
    {
        $member_id = $this->getMember_id();
        if (empty($member_id)) {
            $error = 'Please provide a Member Id';
            throw new Exception($error,Zend_Log::ERR);
        } else {
            $student_subject_object = new Acad_Model_StudentSubject();
            $student_subject_object->setClass_id($class_id);
            $student_subject_object->setMember_id($member_id);
            $subjects = $student_subject_object->fetchSubjects();
            if (is_bool($subjects)) {} elseif (is_array($subjects)) {
                foreach ($subjects as $subject) {
                    $student_subject_object->fetchSubjectPassedStatus();
                }
            }
        }
    }*/
    /**
     * 
     * Enter description here ...
     * @param integer $class_id
     * @param integer $result_type_specific
     * @param bool $result_type_specific
     * @return false|array
     * 
     */
    public function fetchClassDmcInfoIds ($class_id, $result_type_id = null, 
    $all = null)
    {
        $member_id = $this->getMember_id();
        $dmc_info_obj = new Acad_Model_Course_DmcInfo();
        $dmc_info_obj->setMember_id($member_id);
        $dmc_info_obj->setClass_id($class_id);
        if (isset($result_type_id)) {
            $dmc_info_obj->setResult_type_id($result_type_id);
            $dmc_ids = $dmc_info_obj->fetchMemberDmcInfoIds(true, true);
        } elseif ($all == true) {
            $dmc_ids = $dmc_info_obj->fetchMemberDmcInfoIds(true, null, true);
        }
        if (empty($dmc_ids)) {
            return false;
        } else {
            return $dmc_ids;
        }
    }
    /**
     * Fetches DMC of a Student,
     * @param int $dmc_info_id
     * @param int $student_subject_id
     * @return DMC|false object of Acad_Model_DmcMarks
     */
    public function fetchDmc ($dmc_info_id, $student_subject_id)
    {
        $dmc_marks_object = new Acad_Model_DmcMarks();
        $dmc_marks_object->setDmc_info_id($dmc_info_id);
        $dmc_marks_object->setStudent_subject_id($student_subject_id);
        $dmc_marks_info = $dmc_marks_object->fetchInfo();
        if (! $dmc_marks_info) {
            return false;
        } else {
            return $dmc_marks_info;
        }
    }
    public function fetchCompetitveExamIds ()
    {
        $member_id = $this->getMember_id(true);
        $competitive_object = new Acad_Model_Exam_Competitive();
        $competitive_object->setMember_id($member_id);
        $exam_ids = $competitive_object->fetchExamIds();
        if (! $exam_ids) {
            return false;
        } else {
            return $exam_ids;
        }
    }
    /**
     * 
     * Enter description here ...
     * @param object|false object of Acad_Model_Exam_Competitive
     */
    public function fetchCompetitveExamInfo ($competitive_exam_id)
    {
        $member_id = $this->getMember_id(true);
        $competitive_object = new Acad_Model_Exam_Competitive();
        $competitive_object->setMember_id($member_id);
        $exam_info = $competitive_object->fetchExamIds();
        if (! $exam_info) {
            return false;
        } else {
            return $exam_info;
        }
    }
    /**
     * 
     * Saves Critical info and sets member_id in the current object
     * @param array $data_array
     */
    public function saveCriticalInfo ($data_array)
    {
        $this->initSave();
        $preparedData = $this->prepareDataForSaveProcess($data_array);
        $member_id = $this->getMapper()->save($preparedData);
        $this->setMember_id($member_id);
    }
    public function saveClassInfo ($data_array)
    {
        $class_object = new Acad_Model_StudentClass();
        $class_object->initSave();
        $preparedData = $class_object->prepareDataForSaveProcess($data_array);
        $class_object->getMapper()->save($preparedData);
    }
    protected function save ($class_name, $data_array)
    {
        $target_object = new $class_name();
        $target_object->initSave();
        $preparedData = $target_object->prepareDataForSaveProcess($data_array);
        $target_object->getMapper()->save($preparedData);
    }
}