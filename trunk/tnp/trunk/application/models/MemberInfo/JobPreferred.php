<?php
class Tnp_Model_MemberInfo_JobPreferred extends Tnp_Model_Generic
{
    protected $_member_id;
    protected $_job_area;
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
     * @return the $_job_area
     */
    public function getJob_area ()
    {
        return $this->_job_area;
    }
    /**
     * @param field_type $_member_id
     */
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    /**
     * @param field_type $_job_area
     */
    public function setJob_area ($_job_area)
    {
        $this->_job_area = $_job_area;
    }
    /**
     * Sets Mapper
     * @param Tnp_Model_Mapper_MemberInfo_JobPreferred $mapper
     * @return Tnp_Model_Core_Training
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_MemberInfo_JobPreferred
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_MemberInfo_JobPreferred());
        }
        return $this->_mapper;
    }
}