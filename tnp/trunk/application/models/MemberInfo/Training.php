<?php
class Tnp_Model_MemberInfo_Training extends Tnp_Model_Generic
{
    protected $_member_id;
    protected $_training_id;
    protected $_training_institute;
    protected $_start_date;
    protected $_completion_date;
    protected $_training_semester;
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
     * @return the $_training_id
     */
    public function getTraining_id ()
    {
        return $this->_training_id;
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
     * @param field_type $_training_id
     */
    public function setTraining_id ($_training_id)
    {
        $this->_training_id = $_training_id;
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
     * @param Tnp_Model_Mapper_MemberInfo_Training $mapper
     * @return Tnp_Model_Core_Training
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_MemberInfo_Training
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_MemberInfo_Training());
        }
        return $this->_mapper;
    }
}