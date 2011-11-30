<?php
class Acad_Model_Course_Dmc extends Acad_Model_Generic
{
    protected $_save_dmc_info = false;
    protected $_save_marks = false;
    protected $_stu_sub_info = array();
    protected $_stu_sub_id;
    protected $_member_id;
    protected $_roll_no;
    protected $_subject_code;
    protected $_department_id;
    protected $_programme_id;
    protected $_semester_id;
    protected $_dmc_info_id;
    protected $_dmc_id;
    protected $_custody_date;
    protected $_is_granted;
    protected $_grant_date;
    protected $_recieving_date;
    protected $_is_copied;
    protected $_dispatch_date;
    protected $_examination;
    protected $_marks;
    protected $_appear_type;
    protected $_marks_type;
    protected $_mapper;
    /**
     * @return the $_save_dmc_info
     */
    public function getSave_dmc_info ()
    {
        return $this->_save_dmc_info;
    }
    /**
     * @param field_type $_save_dmc_info
     */
    public function setSave_dmc_info ($_save_dmc_info)
    {
        $this->_save_dmc_info = $_save_dmc_info;
    }
    /**
     * @return the $_save_marks
     */
    public function getSave_marks ()
    {
        return $this->_save_marks;
    }
    /**
     * @param field_type $_save_marks
     */
    public function setSave_marks ($_save_marks)
    {
        $this->_save_marks = $_save_marks;
    }
    /**
     * @return the $_stu_sub_info
     */
    protected function getStu_sub_info ()
    {
        $stu_sub_info = $this->getMapper()->fetchStudentSubjectsInfo($this);
        $this->setStu_sub_info($stu_sub_info);
        return $this->_stu_sub_info;
    }
    /**
     * @param field_type $_stu_sub_info
     */
    protected function setStu_sub_info ($_stu_sub_info)
    {
        $this->_stu_sub_info = $_stu_sub_info;
    }
    /**
     * @return the $_stu_sub_id
     */
    public function getStu_sub_id ()
    {
        return $this->_stu_sub_id;
    }
    /**
     * @param field_type $_stu_sub_id
     */
    public function setStu_sub_id ($_stu_sub_id)
    {
        $this->_stu_sub_id = $_stu_sub_id;
    }
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
     * @return the $_roll_no
     */
    public function getRoll_no ()
    {
        return $this->_roll_no;
    }
    /**
     * @param field_type $_roll_no
     */
    public function setRoll_no ($_roll_no)
    {
        $this->_roll_no = $_roll_no;
    }
    /**
     * @return the $_subject_code
     */
    public function getSubject_code ()
    {
        return $this->_subject_code;
    }
    /**
     * @param field_type $_subject_code
     */
    public function setSubject_code ($_subject_code)
    {
        $this->_subject_code = $_subject_code;
    }
    /**
     * @return the $_department_id
     */
    public function getDepartment_id ()
    {
        return $this->_department_id;
    }
    /**
     * @param field_type $_department_id
     */
    public function setDepartment_id ($_department_id)
    {
        $this->_department_id = $_department_id;
    }
    /**
     * @return the $_programme_id
     */
    public function getProgramme_id ()
    {
        return $this->_programme_id;
    }
    /**
     * @param field_type $_programme_id
     */
    public function setProgramme_id ($_programme_id)
    {
        $this->_programme_id = $_programme_id;
    }
    /**
     * @return the $_semester_id
     */
    public function getSemester_id ()
    {
        return $this->_semester_id;
    }
    /**
     * @param field_type $_semester_id
     */
    public function setSemester_id ($_semester_id)
    {
        $this->_semester_id = $_semester_id;
    }
    /**
     * @return the $_dmc_info_id
     */
    public function getDmc_info_id ()
    {
        return $this->_dmc_info_id;
    }
    /**
     * @param field_type $_dmc_info_id
     */
    public function setDmc_info_id ($_dmc_info_id)
    {
        $this->_dmc_info_id = $_dmc_info_id;
    }
    /**
     * @return the $_dmc_id
     */
    public function getDmc_id ()
    {
        return $this->_dmc_id;
    }
    /**
     * @param field_type $_dmc_id
     */
    public function setDmc_id ($_dmc_id)
    {
        $this->_dmc_id = $_dmc_id;
    }
    /**
     * @return the $_custody_date
     */
    public function getCustody_date ()
    {
        return $this->_custody_date;
    }
    /**
     * @param field_type $_custody_date
     */
    public function setCustody_date ($_custody_date)
    {
        $this->_custody_date = $_custody_date;
    }
    /**
     * @return the $_is_granted
     */
    public function getIs_granted ()
    {
        return $this->_is_granted;
    }
    /**
     * @param field_type $_is_granted
     */
    public function setIs_granted ($_is_granted)
    {
        $this->_is_granted = $_is_granted;
    }
    /**
     * @return the $_grant_date
     */
    public function getGrant_date ()
    {
        return $this->_grant_date;
    }
    /**
     * @param field_type $_grant_date
     */
    public function setGrant_date ($_grant_date)
    {
        $this->_grant_date = $_grant_date;
    }
    /**
     * @return the $_recieving_date
     */
    public function getRecieving_date ()
    {
        return $this->_recieving_date;
    }
    /**
     * @param field_type $_recieving_date
     */
    public function setRecieving_date ($_recieving_date)
    {
        $this->_recieving_date = $_recieving_date;
    }
    /**
     * @return the $_is_copied
     */
    public function getIs_copied ()
    {
        return $this->_is_copied;
    }
    /**
     * @param field_type $_is_copied
     */
    public function setIs_copied ($_is_copied)
    {
        $this->_is_copied = $_is_copied;
    }
    /**
     * @return the $_dispatch_date
     */
    public function getDispatch_date ()
    {
        return $this->_dispatch_date;
    }
    /**
     * @param field_type $_dispatch_date
     */
    public function setDispatch_date ($_dispatch_date)
    {
        $this->_dispatch_date = $_dispatch_date;
    }
    /**
     * @return the $_examination
     */
    public function getExamination ()
    {
        return $this->_examination;
    }
    /**
     * @param field_type $_examination
     */
    public function setExamination ($_examination)
    {
        $this->_examination = $_examination;
    }
    /**
     * @return the $_marks
     */
    public function getMarks ()
    {
        return $this->_marks;
    }
    /**
     * @param field_type $_marks
     */
    public function setMarks ($_marks)
    {
        $this->_marks = $_marks;
    }
    /**
     * @return the $_appear_type
     */
    public function getAppear_type ()
    {
        return $this->_appear_type;
    }
    /**
     * @param field_type $_appear_type
     */
    public function setAppear_type ($_appear_type)
    {
        $this->_appear_type = $_appear_type;
    }
    /**
     * @return the $_marks_type
     */
    public function getMarks_type ()
    {
        return $this->_marks_type;
    }
    /**
     * @param field_type $_marks_type
     */
    public function setMarks_type ($_marks_type)
    {
        $this->_marks_type = $_marks_type;
    }
    /**
     * 
     * @param Acad_Model_Mapper_Course_Dmc $mapper
     * @return Acad_Model_Course_Dmc
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Acad_Model_Mapper_Course_Dmc
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Mapper_Course_Dmc());
        }
        return $this->_mapper;
    }
    public function saveDmcInfo ($options)
    {
        $this->setSave_dmc_info(true);
        parent::save($options);
    }
    public function saveDmcMarks ($options)
    {
        $this->setSave_marks(true);
        parent::save($options);
    }
    public function getAllDmcInfoIds ()
    {
        $member_id = $this->getMember_id();
        if (! isset($member_id)) {
            throw new Exception(
            'Insufficient data provided..   Member_id required');
        } else {
            return $this->getMapper()->fetchDmcInfoIds($this);
        }
    }
    public function getAllDmcIds ()
    {
        $member_id = $this->getMember_id();
        $semester = $this->getSemester_id();
        $test_info_id = $this->getDmc_info_id();
        if (! isset($member_id)) {
            throw new Exception(
            'Insufficient data provided..   Member_id required');
        } else {
            return $this->getMapper()->fetchDmcInfoIds($this);
        }
    }
    public function getStudentSubjects ()
    {
        $stu_sub_info = $this->getStu_sub_info();
        return array_keys($stu_sub_info);
    }
    /**
     * @todo reg no included in search
     * Enter description here ...
     * @throws Exception
     */
    public function findMemberID ()
    {
        $roll_no = $this->getRoll_no();
        $department_id = $this->getDepartment_id();
        $programme_id = $this->getProgramme_id();
        $semester_id = $this->getSemester_id();
        if (! isset($roll_no) or ! isset($department_id) or
         ! isset($programme_id) or ! isset($semester_id)) {
            throw new Exception(
            'Insufficient data provided..   roll_no,department_id,programme_id and semester_id are ALL required');
        } else {
            $options = $this->getMapper()->fetchMemberID($this);
            $this->setOptions($options);
        }
    }
    public function findRollNo ()
    {
        $member_id = $this->getMember_id();
        $department_id = $this->getDepartment_id();
        $programme_id = $this->getProgramme_id();
        $semester_id = $this->getSemester_id();
        if (! isset($member_id)) {
            throw new Exception(
            'Insufficient data provided..   department_id,programme_id and semester_id are ALL required');
        } else {
            $options = $this->getMapper()->fetchRollNo($this);
            $this->setOptions($options);
        }
    }
    public function findStuSubId ()
    {
        $subject_code = $this->getSubject_code();
        $stu_sub_info = $this->getStu_sub_info();
        if (! isset($subject_code)) {
            throw new Exception(
            'Insufficient data provided..   Subject_code required');
        } else {
            if (array_key_exists($subject_code, $stu_sub_info)) {
                return $stu_sub_info[$subject_code]['stu_sub_id'];
            }
        }
    }
    public function initDmcInfo ()
    {
        $dmc_info_id = $this->getDmc_info_id();
        if (! isset($dmc_info_id)) {
            throw new Exception(
            'Insufficient data provided..   dmc_info_id required');
        } else {
            $options = $this->getMapper()->fetchDmcInfo($this);
            $this->setOptions($options);
        }
    }
}