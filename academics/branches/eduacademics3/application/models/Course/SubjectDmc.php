<?php
/**
 * @todo complete member_dmc_record func
 * Enter description here ...
 *
 *
 */
class Acad_Model_Course_SubjectDmc extends Acad_Model_Generic
{
    protected $_considered_dmc_records = array();
    protected $_member_dmc_records = array();
    protected $_internal_marks = array();
    protected $_marks_scored_internal;
    protected $_marks_scored_uexam;
    protected $_member_id;
    //
    protected $_semester_id;
    protected $_marks_obtained;
    //
    protected $_department_id;
    protected $_programme_id;
    protected $_subject_code;
    protected $_marks;
    protected $_appear_type;
    protected $_dmc_id;
    protected $_custody_date;
    protected $_is_granted;
    protected $_grant_date;
    protected $_recieving_date;
    protected $_is_copied;
    protected $_dispatch_date;
    protected $_total_marks;
    protected $_scaled_marks;
    protected $_mapper;
    /**
     * @return the $_internal_marks
     */
    protected function getInternal_marks ()
    {
        $internal_marks = $this->_internal_marks;
        $internal_marks = $this->getMapper()->helper($this);
        $this->setInternal_marks($internal_marks);
        return $this->_internal_marks;
    }
    /**
     * @param field_type $_internal_marks
     */
    protected function setInternal_marks ($_internal_marks)
    {
        $this->_internal_marks = $_internal_marks;
    }
    public function getMarks_scored_internal ()
    {
        return $this->_marks_scored_internal;
    }
    public function setMarks_scored_internal ($_marks_scored_internal)
    {
        $this->_marks_scored_internal = $_marks_scored_internal;
    }
    public function getMarks_scored_uexam ()
    {
        return $this->_marks_scored_uexam;
    }
    public function setMarks_scored_uexam ($_marks_scored_uexam)
    {
        $this->_marks_scored_uexam = $_marks_scored_uexam;
    }
    protected function getConsidered_dmc_records ()
    {
        $considered_dmc_records = $this->_considered_dmc_records;
        if (sizeof($considered_dmc_records) == 0) {
            $considered_dmc_records = $this->getMapper()->fetchPassedSemestersInfo(
            $this);
            $this->setConsidered_dmc_records($considered_dmc_records);
        }
        return $this->_considered_dmc_records;
    }
    protected function setConsidered_dmc_records ($_considered_dmc_records)
    {
        $this->_considered_dmc_records = $_considered_dmc_records;
    }
    protected function getMember_dmc_records ()
    {
        $member_dmc_records = $this->_member_dmc_records;
        if (sizeof($member_dmc_records) == 0) {
            $member_dmc_records = $this->getMapper()->fetchMemberDmcRecords(
            $this);
            $this->setMember_dmc_records($member_dmc_records);
        }
        return $this->_member_dmc_records;
    }
    protected function setMember_dmc_records ($_member_dmc_records)
    {
        $this->_member_dmc_records = $_member_dmc_records;
    }
    public function getMember_id ()
    {
        return $this->_member_id;
    }
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    public function getSemester_id ()
    {
        return $this->_semester_id;
    }
    public function setSemester_id ($_semester_id)
    {
        $this->_semester_id = $_semester_id;
    }
    public function getMarks_obtained ()
    {
        return $this->_marks_obtained;
    }
    public function setMarks_obtained ($_marks_obtained)
    {
        $this->_marks_obtained = $_marks_obtained;
    }
    public function getDepartment_id ()
    {
        return $this->_department_id;
    }
    public function setDepartment_id ($_department_id)
    {
        $this->_department_id = $_department_id;
    }
    public function getProgramme_id ()
    {
        return $this->_programme_id;
    }
    public function setProgramme_id ($_programme_id)
    {
        $this->_programme_id = $_programme_id;
    }
    public function getSubject_code ()
    {
        return $this->_subject_code;
    }
    public function setSubject_code ($_subject_code)
    {
        $this->_subject_code = $_subject_code;
    }
    public function getMarks ()
    {
        return $this->_marks;
    }
    public function setMarks ($_marks)
    {
        $this->_marks = $_marks;
    }
    public function getAppear_type ()
    {
        return $this->_appear_type;
    }
    public function setAppear_type ($_appear_type)
    {
        $this->_appear_type = $_appear_type;
    }
    public function getDmc_id ()
    {
        return $this->_dmc_id;
    }
    public function setDmc_id ($_dmc_id)
    {
        $this->_dmc_id = $_dmc_id;
    }
    public function getCustody_date ()
    {
        return $this->_custody_date;
    }
    public function setCustody_date ($_custody_date)
    {
        $this->_custody_date = $_custody_date;
    }
    public function getIs_granted ()
    {
        return $this->_is_granted;
    }
    public function setIs_granted ($_is_granted)
    {
        $this->_is_granted = $_is_granted;
    }
    public function getGrant_date ()
    {
        return $this->_grant_date;
    }
    public function setGrant_date ($_grant_date)
    {
        $this->_grant_date = $_grant_date;
    }
    public function getRecieving_date ()
    {
        return $this->_recieving_date;
    }
    public function setRecieving_date ($_recieving_date)
    {
        $this->_recieving_date = $_recieving_date;
    }
    public function getIs_copied ()
    {
        return $this->_is_copied;
    }
    public function setIs_copied ($_is_copied)
    {
        $this->_is_copied = $_is_copied;
    }
    public function getDispatch_date ()
    {
        return $this->_dispatch_date;
    }
    public function setDispatch_date ($_dispatch_date)
    {
        $this->_dispatch_date = $_dispatch_date;
    }
    public function getTotal_marks ()
    {
        return $this->_total_marks;
    }
    public function setTotal_marks ($_total_marks)
    {
        $this->_total_marks = $_total_marks;
    }
    public function getScaled_marks ()
    {
        return $this->_scaled_marks;
    }
    public function setScaled_marks ($_scaled_marks)
    {
        $this->_scaled_marks = $_scaled_marks;
    }
    /**
     * 
     * @param Acad_Model_Mapper_Course_SubjectDmc $mapper
     * @return Acad_Model_Course_SubjectDmc
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Acad_Model_Mapper_Course_SubjectDmc
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Mapper_Course_SubjectDmc());
        }
        return $this->_mapper;
    }
    /**
     * 
     * gets the marks of student in a subject..
     * by deafult includes all appear types
     */
    public function getSubjectMarksHistory ()
    {
        return $this->getMapper()->fetchSubjectMarksHistory($this);
    }
    /**
     * gets the details of a SubjectDMC
     * PreRequistes - either (regNo, subCode AND marks must be set)
     * or (dmcId must be set)
     */
    public function initDmcInfo ()
    {
        $options = $this->getMapper()->fetchDmcInfo($this);
        $this->setOptions($options);
    }
    public function getPassedSemesters ()
    {
        $considered_dmc_records = $this->getConsidered_dmc_records();
        return array_keys($considered_dmc_records);
    }
    /* public function initAggregate ()
    {
        $considered_dmc_records = $this->getConsidered_dmc_records();
        $semester_id = $this->getSemester_id();
        if (! isset($semester_id)) {
            throw new Exception('Please provide semester id first', 
            Zend_Log::ERR);
        } else {
            if (array_key_exists($semester_id, $considered_dmc_records)) {
                $options = $considered_dmc_records[$semester_id];
                //call unset all.. be careful
                $this->setOptions($options);
            } else {
                $error = 'Sorry, ' . $this->getMember_id() . ' Your DMC for ' .
                 $semester_id . ' semester does not exist in our database';
                throw new Exception($error, Zend_Log::ERR);
            }
        }
    }*/
    /**
     * returns an array containing dmcIds of semesters passed by student  
     * Enter description here ...
     */
    public function getMemberDmcIds ()
    {
        $member_dmc_records = $this->getMember_dmc_records();
        Zend_Registry::get('logger')->debug($member_dmc_records);
        return array_keys($member_dmc_records);
    }
    public function getSemAppearedSubjects ()
    {
        $int_mark_helper = $this->getInternal_marks();
        return array_keys($int_mark_helper);
    }
    public function createClearedSemDmc ()
    {
        $dmc = array();
        $subjects = $this->getSemAppearedSubjects();
        $int_mark_helper = $this->getInternal_marks();
        foreach ($subjects as $subject) {
            $this->setSubject_code($subject);
            $marks_history = $this->getSubjectMarksHistory();
            $all_marks = array_keys($marks_history);
            $max = $all_marks[0];
            $inf['subject_code'] = $subject;
            $inf['dmc_id'] = $marks_history[$max]['dmc_id'];
            $inf['appear_type'] = $marks_history[$max]['appear_type'];
            $inf['marks_scored_uexam'] = $max;
            $inf['marks_scored_internal'] = $int_mark_helper[$subject]['marks_scored_internal'];
            $dmc[] = $inf;
        }
        return $dmc;
    }
    public function createDmc ()
    {
        k;
    }
}