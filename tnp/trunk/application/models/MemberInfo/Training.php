<?php
class Tnp_Model_MemberInfo_Training extends Tnp_Model_Generic
{
    protected $_member_id;
    protected $_training_id;
    protected $_functional_area_id;
    protected $_training_institute;
    protected $_start_date;
    protected $_completion_date;
    protected $_training_semester;
    protected $_description;
    protected $_grade;
    protected $_mapper;
    /**
     * @return the $_training_id
     */
    public function getTraining_id ($throw_exception = null)
    {
        $training_id = $this->_training_id;
        if (empty($training_id) and $throw_exception == true) {
            $message = '_training_id is not set in ' . get_class($this);
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $training_id;
        }
    }
    /**
     * @param field_type $_training_id
     */
    public function setTraining_id ($_training_id)
    {
        $this->_training_id = $_training_id;
    }
    /**
     * @return the $_grade
     */
    public function getGrade ()
    {
        return $this->_grade;
    }
    /**
     * @param field_type $_grade
     */
    public function setGrade ($_grade)
    {
        $this->_grade = $_grade;
    }
    /**
     * @return the $_functional_area_id
     */
    public function getFunctional_area_id ($throw_exception = null)
    {
        $functional_area_id = $this->_functional_area_id;
        if (empty($functional_area_id) and $throw_exception == true) {
            $message = '_functional_area_id is not set in ' . get_class($this);
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $functional_area_id;
        }
    }
    /**
     * @return the $_description
     */
    public function getDescription ()
    {
        return $this->_description;
    }
    /**
     * @param field_type $_functional_area_id
     */
    public function setFunctional_area_id ($_functional_area_id)
    {
        $this->_functional_area_id = $_functional_area_id;
    }
    /**
     * @param field_type $_description
     */
    public function setDescription ($_description)
    {
        $this->_description = $_description;
    }
    /**
     * @param bool $throw_exception optional
     * @return the $_member_id
     */
    public function getMember_id ($throw_exception = null)
    {
        $member_id = $this->_member_id;
        if (empty($member_id) and $throw_exception == true) {
            $message = 'Member_id is not set in ' . get_class($this);
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $member_id;
        }
    }
    /**
     * @return the $_training_institute
     */
    public function getTraining_institute ()
    {
        return $this->_training_institute;
    }
    /**
     * @return the $_start_date
     */
    public function getStart_date ()
    {
        return $this->_start_date;
    }
    /**
     * @return the $_completion_date
     */
    public function getCompletion_date ()
    {
        return $this->_completion_date;
    }
    /**
     * @return the $_training_semester
     */
    public function getTraining_semester ()
    {
        return $this->_training_semester;
    }
    /**
     * @param field_type $_member_id
     */
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    /**
     * @param field_type $_training_institute
     */
    public function setTraining_institute ($_training_institute)
    {
        $this->_training_institute = $_training_institute;
    }
    /**
     * @param field_type $_start_date
     */
    public function setStart_date ($_start_date)
    {
        $this->_start_date = $_start_date;
    }
    /**
     * @param field_type $_completion_date
     */
    public function setCompletion_date ($_completion_date)
    {
        $this->_completion_date = $_completion_date;
    }
    /**
     * @param field_type $_training_semester
     */
    public function setTraining_semester ($_training_semester)
    {
        $this->_training_semester = $_training_semester;
    }
    /**
     * Sets Mapper
     * @param Tnp_Model_Mapper_MemberTraining $mapper
     * @return Tnp_Model_MemberInfo_Training
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_MemberTraining
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_MemberTraining());
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
    public function fetchMemberIds ($functional_area_spec = null, 
    $training_institute_spec = null, $start_date_spec = null, 
    $completion_date_spec = null, $training_semester_spec = null)
    {
        $functional_area_id = null;
        $training_institute = null;
        $start_date = null;
        $completion_date = null;
        $training_semester = null;
        if ($functional_area_spec == true) {
            $functional_area_id = $this->getFunctional_area_id(true);
        }
        if ($training_institute_spec == true) {
            $training_institute = $this->getTraining_institute(true);
        }
        if ($start_date_spec == true) {
            $start_date = $this->getStart_date(true);
        }
        if ($completion_date_spec == true) {
            $completion_date = $this->getCompletion_date(true);
        }
        if ($training_semester_spec == true) {
            $training_semester = $this->getTraining_semester(true);
        }
        $member_ids = array();
        $member_ids = $this->getMapper()->fetchMemberIds($functional_area_id, 
        $training_institute, $start_date, $completion_date, $training_semester);
        if (empty($member_ids)) {
            return false;
        } else {
            return $member_ids;
        }
    }
    public function fetchInfo ()
    {
        $member_id = $this->getMember_id(true);
        $training_id = $this->getTraining_id(true);
        $info = array();
        $info = $this->getMapper()->fetchInfo($member_id, $training_id);
        if (empty($info)) {
            return false;
        } else {
            return $this->setOptions($info);
        }
    }
    public function fetchTrainingIds ()
    {
        $member_id = $this->getMember_id(true);
        $functional_area_ids = array();
        $functional_area_ids = $this->getMapper()->fetchTrainingIds($member_id);
        if (empty($functional_area_ids)) {
            return false;
        } else {
            return $functional_area_ids;
        }
    }
    public function deleteTrainingRecord ()
    {
        $member_id = $this->getMember_id(true);
        $training_id = $this->getTraining_id(true);
        return $this->getMapper()->delete($member_id, $training_id);
    }
}