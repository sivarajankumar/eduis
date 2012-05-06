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
     * @param bool $throw_exception optional
     * @return the $_member_id
     */
    public function getMember_id ($throw_exception = null)
    {
        $member_id = $this->_member_id;
        if (empty($member_id) and $throw_exception == true) {
            $message = 'Member_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $member_id;
        }
    }
    /**
     * @return the $_member_type_id
     */
    public function getMember_type_id ($throw_exception = null)
    {
        $member_type_id = $this->_member_type_id;
        if (empty($member_type_id) and $throw_exception == true) {
            $message = 'Member_type_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $member_type_id;
        }
    }
    /**
     * @return the $_member_type_name
     */
    public function getMember_type_name ()
    {
        return $this->_member_type_name;
    }
    /**
     * @return the $_first_name
     */
    public function getFirst_name ()
    {
        return $this->_first_name;
    }
    /**
     * @return the $_middle_name
     */
    public function getMiddle_name ()
    {
        return $this->_middle_name;
    }
    /**
     * @return the $_last_name
     */
    public function getLast_name ()
    {
        return $this->_last_name;
    }
    /**
     * @return the $_dob
     */
    public function getDob ()
    {
        return $this->_dob;
    }
    /**
     * @return the $_gender
     */
    public function getGender ()
    {
        return $this->_gender;
    }
    /**
     * @return the $_blood_group
     */
    public function getBlood_group ()
    {
        return $this->_blood_group;
    }
    /**
     * @return the $_cast_id
     */
    public function getCast_id ()
    {
        return $this->_cast_id;
    }
    /**
     * @return the $_nationality_id
     */
    public function getNationality_id ()
    {
        return $this->_nationality_id;
    }
    /**
     * @return the $_religion_id
     */
    public function getReligion_id ()
    {
        return $this->_religion_id;
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
     * @return the $_join_date
     */
    public function getJoin_date ()
    {
        return $this->_join_date;
    }
    /**
     * @return the $_relieve_date
     */
    public function getRelieve_date ()
    {
        return $this->_relieve_date;
    }
    /**
     * @return the $_image_no
     */
    public function getImage_no ()
    {
        return $this->_image_no;
    }
    /**
     * @return the $_is_active
     */
    public function getIs_active ($throw_exception = null)
    {
        return $this->_is_active;
    }
    /**
     * @param field_type $_member_id
     */
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    /**
     * @param field_type $_member_type_id
     */
    public function setMember_type_id ($_member_type_id)
    {
        $this->_member_type_id = $_member_type_id;
    }
    /**
     * @param field_type $_member_type_name
     */
    public function setMember_type_name ($_member_type_name)
    {
        $this->_member_type_name = $_member_type_name;
    }
    /**
     * @param field_type $_first_name
     */
    public function setFirst_name ($_first_name)
    {
        $this->_first_name = $_first_name;
    }
    /**
     * @param field_type $_middle_name
     */
    public function setMiddle_name ($_middle_name)
    {
        $this->_middle_name = $_middle_name;
    }
    /**
     * @param field_type $_last_name
     */
    public function setLast_name ($_last_name)
    {
        $this->_last_name = $_last_name;
    }
    /**
     * @param field_type $_dob
     */
    public function setDob ($_dob)
    {
        $this->_dob = $_dob;
    }
    /**
     * @param field_type $_gender
     */
    public function setGender ($_gender)
    {
        $this->_gender = $_gender;
    }
    /**
     * @param field_type $_blood_group
     */
    public function setBlood_group ($_blood_group)
    {
        $this->_blood_group = $_blood_group;
    }
    /**
     * @param field_type $_cast_id
     */
    public function setCast_id ($_cast_id)
    {
        $this->_cast_id = $_cast_id;
    }
    /**
     * @param field_type $_nationality_id
     */
    public function setNationality_id ($_nationality_id)
    {
        $this->_nationality_id = $_nationality_id;
    }
    /**
     * @param field_type $_religion_id
     */
    public function setReligion_id ($_religion_id)
    {
        $this->_religion_id = $_religion_id;
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
     * @param field_type $_join_date
     */
    public function setJoin_date ($_join_date)
    {
        $this->_join_date = $_join_date;
    }
    /**
     * @param field_type $_relieve_date
     */
    public function setRelieve_date ($_relieve_date)
    {
        $this->_relieve_date = $_relieve_date;
    }
    /**
     * @param field_type $_image_no
     */
    public function setImage_no ($_image_no)
    {
        $this->_image_no = $_image_no;
    }
    /**
     * @param field_type $_is_active
     */
    public function setIs_active ($_is_active)
    {
        $this->_is_active = $_is_active;
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
     * Fetches CRITICAL information of a Student(
     * Member_id must be set before calling this function)
     * @return Student|false object of Acad_Model_Member_Student
     */
    public function fetchCriticalInfo ()
    {
        $member_id = $this->getMember_id(true);
        return $this->getMapper()->fetchCriticalInfo($member_id);
    }
    /**
     * Fetches the Active class_ids of a Student
     * Member_id must be set before calling this function 
     * @return false|array an array containing all class ids in which member is active
     */
    /**
     * Fetches the Active class_ids of a Student
     * Member_id must be set before calling this function 
     * @return false|array an array containing all class ids in which member is active
     */
    public function fetchActiveClassIds ()
    {
        $student_active_class_ids = array();
        $student_class_ids = $this->fetchAllClassIds();
        $member_id = $this->getMember_id(true);
        $class_obj = new Acad_Model_Class();
        $class_obj->setIs_active(true);
        $active_class_ids = $class_obj->fetchClassIds(null, null, true);
        if (! empty($student_class_ids) and ! empty($active_class_ids)) {
            $student_active_class_ids = array_intersect($student_class_ids, 
            $active_class_ids);
        }
        return $student_active_class_ids;
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
        return $student_class_obj->fetchClassIds();
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
        return $class_object->fetchClassIds(true, true);
    }
    /**
     * Fetches information regarding CLASS of a Student,
     * Member_id must be set before calling this function 
     * @return StudentClass|false object of Acad_Model_StudentClass
     */
    public function fetchClassInfo ($class_id)
    {
        $member_id = $this->getMember_id(true);
        $student_class_object = new Acad_Model_StudentClass();
        $student_class_object->setMember_id($member_id);
        $student_class_object->setClass_id($class_id);
        return $student_class_object->fetchInfo();
    }
    /**
     * Fetches Batch Id of a Student,
     * Member_id must be set before calling this function 
     * @return int the Batch_id of student
     */
    public function fetchBatchId ()
    {
        $member_id = $this->getMember_id(true);
        $student_class_object = new Acad_Model_StudentClass();
        $student_class_object->setMember_id($member_id);
        $batch_identifier_class_id = $student_class_object->fetchBatchIdentifierClassId();
        $class_object = new Acad_Model_Class();
        $class_object->setClass_id($batch_identifier_class_id);
        $class_object->fetchInfo();
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
        $member_id = $this->getMember_id(true);
        $student_subject_object = new Acad_Model_StudentSubject();
        $student_subject_object->setMember_id($member_id);
        $student_subject_object->setClass_id($class_id);
        $subjects = array();
        return $student_subject_object->fetchSubjects();
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
        $member_id = $this->getMember_id(true);
        $student_subject_object = new Acad_Model_StudentSubject();
        $student_subject_object->setMember_id($member_id);
        $student_subject_object->setSubject_id($subject_id);
        return $student_subject_object->fetchClassIds();
    }
    public function fetchQualificationsIds ()
    {
        $member_id = $this->getMember_id(true);
        $qualification_object = new Acad_Model_Member_Qualification();
        $qualification_object->setMember_id($member_id);
        return $qualification_object->fetchQualificationIds();
    }
    /**
     * Fetches Qualification Details of a member
     * 
     * @param int $qualification_id
     * @return Qualifiaction|false object of Acad_Model_Qualification_Matric|Acad_Model_Qualification_Twelfth|Acad_Model_Qualification_Diploma|Acad_Model_Qualification_Btech|Acad_Model_Qualification_Mtech
     */
    public function fetchQualifiactionInfo ($qualification_id)
    {
        $member_id = $this->getMember_id(true);
        $qualification_object = new Acad_Model_Qualification();
        $qualification_object->setQualification_id($qualification_id);
        $qualification = $qualification_object->fetchInfo();
        $qualification_name = $qualification_object->getQualification_name();
        $qualification_detail = array('qualification_id' => $qualification_id, 
        'qualification_name' => $qualification_name);
        switch ($qualification_name) {
            case 'MATRIC':
                $matric_object = new Acad_Model_Qualification_Matric();
                $matric_object->setMember_id($member_id);
                $matric_object->setQualification_id(
                $qualification_detail['qualification_id']);
                return $matric_object->fetchInfo();
                break;
            case 'TWELFTH':
                $twelfth_object = new Acad_Model_Qualification_Twelfth();
                $twelfth_object->setMember_id($member_id);
                $twelfth_object->setQualification_id(
                $qualification_detail['qualification_id']);
                return $twelfth_object->fetchInfo();
                break;
            case 'DIPLOMA':
                $diploma_object = new Acad_Model_Qualification_Diploma();
                $diploma_object->setMember_id($member_id);
                $diploma_object->setQualification_id(
                $qualification_detail['qualification_id']);
                return $diploma_object->fetchInfo();
                break;
            case 'BTECH':
                $btech_object = new Acad_Model_Qualification_Btech();
                $btech_object->setMember_id($member_id);
                $btech_object->setQualification_id(
                $qualification_detail['qualification_id']);
                return $btech_object->fetchInfo();
                break;
            case 'MTECH':
                $mtech_object = new Acad_Model_Qualification_Mtech();
                $mtech_object->setMember_id($member_id);
                $mtech_object->setQualification_id(
                $qualification_detail['qualification_id']);
                return $mtech_object->fetchInfo();
                break;
            default:
                return false;
                break;
        }
    }
    /**
     * Fetches DmcInfoIds in Descending order(
     * Form of array returned :array(dmc_info_id=>dmc_id))
     */
    public function fetchDmcInfoIdsByDate ()
    {
        $member_id = $this->getMember_id(true);
        $dmc_info_object = new Acad_Model_Course_DmcInfo();
        $dmc_info_object->setMember_id($member_id);
        return $dmc_info_object->fetchDmcInfoIdsByDate();
    }
    /**
     * Fetched DmcInfoIds of a member(
     * Form of array returned :array(dmc_info_id=>dmc_id)
     * @param bool $class_specific  
     * @param bool $result_type_specific
     * @param bool $all
     * @param bool $considered_only
     * @param bool $ordered_by_date
     */
    public function fetchDmcInfoIds ($class_specific = null, 
    $result_type_specific = null, $all = null, $considered_only = null, 
    $ordered_by_date = null)
    {
        $member_id = $this->getMember_id(true);
        //
        $class_id = null;
        $result_type_id = null;
        $is_considered = null;
        //
        $dmc_info_ids = array();
        if ($class_specific == true) {
            $class_id = $this->getClass_id(true);
        }
        if ($result_type_specific == true) {
            $result_type_id = $this->getResult_type_id(true);
        }
        if ($considered_only == true) {
            $is_considered = $this->getIs_considered(true);
        }
        $dmc_info_object = new Acad_Model_Course_DmcInfo();
        $dmc_info_object->setMember_id($member_id);
        return $dmc_info_object->fetchMemberDmcInfoIds($class_id, 
        $result_type_id, $all, $is_considered, $ordered_by_date);
    }
    /**
     * Fetches DMC of a Student,
     * @param int $dmc_info_id
     * @param int $student_subject_id
     * @return DMC|false object of Acad_Model_Course_DmcMarks
     */
    public function fetchDmc ($dmc_info_id, $student_subject_id)
    {
        $dmc_marks_object = new Acad_Model_Course_DmcMarks();
        $dmc_marks_object->setDmc_info_id($dmc_info_id);
        $dmc_marks_object->setStudent_subject_id($student_subject_id);
        return $dmc_marks_object->fetchInfo();
    }
    /**
     * Fetches DMC information
     * @param int $dmc_info_id
     * @return DMC|false object of Acad_Model_Course_DmcInfo
     */
    public function fetchDmcInfo ($dmc_info_id)
    {
        $dmc_info_object = new Acad_Model_Course_DmcInfo();
        $dmc_info_object->setDmc_info_id($dmc_info_id);
        return $dmc_info_object->fetchInfo();
    }
    public function fetchCompetitveExamIds ()
    {
        $member_id = $this->getMember_id(true);
        $competitive_object = new Acad_Model_StudentCompetitiveExam();
        $competitive_object->setMember_id($member_id);
        return $competitive_object->fetchExamIds();
    }
    /**
     * 
     * Enter description here ...
     * @param object|false object of Acad_Model_StudentCompetitiveExam
     */
    public function fetchCompetitveExamInfo ($competitive_exam_id)
    {
        $member_id = $this->getMember_id(true);
        $competitive_object = new Acad_Model_StudentCompetitiveExam();
        $competitive_object->setMember_id($member_id);
        $competitive_object->setExam_id($competitive_exam_id);
        return $competitive_object->fetchStudentExamInfo();
    }
    public function saveCriticalInfo ($data_array)
    {
        $member_id = $this->getMember_id(true);
        $data_array['member_id'] = $member_id;
        $info = $this->fetchCriticalInfo();
        if ($info == false) {
            $this->initSave();
            $preparedData = $this->prepareDataForSaveProcess($data_array);
            return $this->getMapper()->save($preparedData);
        } else {
            $this->initSave();
            $preparedData = $this->prepareDataForSaveProcess($data_array);
            $data_array['member_id'] = null;
            return $this->getMapper()->update($preparedData, $member_id);
        }
    }
    /**
     * 
     * save Competitive Exam Info
     * requires member_id to be set
     * @param array $data_array
     */
    public function saveCompetitiveExamInfo ($data_array)
    {
        $member_id = $this->getMember_id(true);
        $data_array['member_id'] = $member_id;
        $competitive_object = new Acad_Model_StudentCompetitiveExam();
        $exam_id = $data_array['exam_id'];
        $competitive_object->setMember_id($member_id);
        $competitive_object->setExam_id($exam_id);
        $info = $competitive_object->fetchStudentExamInfo();
        if ($info == false) {
            $competitive_object->initSave();
            $preparedData = $competitive_object->prepareDataForSaveProcess(
            $data_array);
            return $competitive_object->getMapper()->save($preparedData);
        } else {
            $competitive_object->initSave();
            $prepared_data = $competitive_object->prepareDataForSaveProcess(
            $data_array);
            $data_array['member_id'] = null;
            return $competitive_object->getMapper()->update($prepared_data, 
            $member_id, $exam_id);
        }
    }
    /**
     * 
     * Saves Students Qualification Information to Database
     * @param int $qualifiaction_id
     * @param array $data_array
     * @throws Exception if Invalid Qualifiaction_name provided
     */
    public function saveQualificationInfo ($qualifiaction_id, $data)
    {
        $qualification_id = $data['qualification_id'];
        $qualifiaction_obj = new Acad_Model_Qualification();
        $qualifiactions = $qualifiaction_obj->fetchQualifications();
        $qualifiaction_name = $qualifiactions[$qualifiaction_id]['qualifiaction_name'];
        switch ($qualifiaction_name) {
            case 'MATRIC':
                $object = new Acad_Model_Qualification_Matric();
                $info = $this->fetchQualifiactionInfo($qualification_id);
                break;
            case 'TWELFTH':
                $object = new Acad_Model_Qualification_Twelfth();
                $info = $this->fetchQualifiactionInfo($qualification_id);
                break;
            case 'DIPLOMA':
                $object = new Acad_Model_Qualification_Diploma();
                $info = $this->fetchQualifiactionInfo($qualification_id);
                break;
            case 'BTECH':
                $object = new Acad_Model_Qualification_Btech();
                $info = $this->fetchQualifiactionInfo($qualification_id);
                break;
            case 'MTECH':
                $object = new Acad_Model_Qualification_Mtech();
                $info = $this->fetchQualifiactionInfo($qualification_id);
                break;
            default:
                throw new Exception(
                'Attempt to save Invalid Qualification\'s data. Qualification Name Provided : ' .
                 $qualifiaction_name . '.', Zend_Log::ERR);
                break;
        }
        $member_id = $this->getMember_id();
        $data['member_id'] = $member_id;
        if ($info == false) {
            $object->initSave();
            $preparedData = $object->prepareDataForSaveProcess($data);
            return $object->getMapper()->save($preparedData);
        } else {
            $object->initSave();
            $prepared_data = $object->prepareDataForSaveProcess($data);
            $data['member_id'] = null;
            return $object->getMapper()->update($prepared_data, $member_id);
        }
    }
    public function saveClassInfo ($data_array)
    {
        $class_id = $data_array['class_id'];
        $info = $this->fetchClassInfo($class_id);
        $member_id = $this->getMember_id();
        $data_array['member_id'] = $member_id;
        if ($info == false) {
            $student_class_object = new Acad_Model_StudentClass();
            $student_class_object->initSave();
            $preparedData = $student_class_object->prepareDataForSaveProcess(
            $data_array);
            return $student_class_object->getMapper()->save($preparedData);
        } else {
            $student_class_object = new Acad_Model_StudentClass();
            $student_class_object->initSave();
            $prepared_data = $student_class_object->prepareDataForSaveProcess(
            $data_array);
            $data_array['member_id'] = null;
            return $student_class_object->getMapper()->update($prepared_data, 
            $member_id, $class_id);
        }
    }
    public function saveDmcInfo ($data_array)
    {
        $member_id = $this->getMember_id();
        $data_array['member_id'] = $member_id;
        $dmc_info_object = new Acad_Model_Course_DmcInfo();
        $dmc_id = $data_array['dmc_id'];
        $dmc_info_object->setDmc_id($dmc_id);
        $dmc_info_id = $dmc_info_object->fetchDmcInfoId();
        if ($dmc_info_id == false) {
            $dmc_info_object->initSave();
            $preparedData = $dmc_info_object->prepareDataForSaveProcess(
            $data_array);
            return $dmc_info_object->getMapper()->save($preparedData);
        } else {
            $dmc_info_object->initSave();
            $prepared_data = $dmc_info_object->prepareDataForSaveProcess(
            $data_array);
            $data_array['member_id'] = null;
            return $dmc_info_object->getMapper()->update($prepared_data, 
            $dmc_info_id);
        }
    }
    public function saveDmcMarks ($data_array)
    {
        $member_id = $this->getMember_id(true);
        $dmc_marks_object = new Acad_Model_Course_DmcMarks();
        $dmc_info_id = $data_array['dmc_info_id'];
        $student_subject_id = $data_array['student_subject_id'];
        $dmc_marks = $this->fetchDmcInfo($dmc_info_id, $student_subject_id);
        if ($dmc_marks == false) {
            $dmc_marks_object->initSave();
            $preparedData = $dmc_marks_object->prepareDataForSaveProcess(
            $data_array);
            return $dmc_marks_object->getMapper()->save($preparedData);
        } else {
            $dmc_marks_object->initSave();
            $prepared_data = $dmc_marks_object->prepareDataForSaveProcess(
            $data_array);
            return $dmc_marks_object->getMapper()->update($prepared_data, 
            $dmc_info_id, $student_subject_id);
        }
    }
}