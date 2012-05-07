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
     * Fetches all member ids for given preffered functional area
     * Enter description here ...
     */
    public function fetchMemberIds ()
    {
        $job_area_preferred = $this->getJob_area(true);
        $member_ids = $this->getMapper()->fetchMemberIds($job_area_preferred);
        if (empty($member_ids)) {
            return false;
        } else {
            return $member_ids;
        }
    }
    public function fetchInfo ()
    {
        $emp_test_id = $this->getEmployability_test_id(true);
        $info = array();
        $info = $this->getMapper()->fetchInfo($emp_test_id);
        if (empty($info)) {
            return false;
        } else {
            return $this->setOptions($info);
        }
    }
}