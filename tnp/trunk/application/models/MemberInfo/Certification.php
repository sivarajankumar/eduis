<?php
class Tnp_Model_MemberInfo_Certification extends Tnp_Model_Generic
{
    protected $_member_id;
    protected $_certification_id;
    protected $_start_date;
    protected $_complete_date;
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
     * @return the $_certification_id
     */
    public function getCertification_id ()
    {
        return $this->_certification_id;
    }
    /**
     * @return the $_start_date
     */
    public function getStart_date ()
    {
        return $this->_start_date;
    }
    /**
     * @return the $_complete_date
     */
    public function getComplete_date ()
    {
        return $this->_complete_date;
    }
    /**
     * @param field_type $_member_id
     */
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    /**
     * @param field_type $_certification_id
     */
    public function setCertification_id ($_certification_id)
    {
        $this->_certification_id = $_certification_id;
    }
    /**
     * @param field_type $_start_date
     */
    public function setStart_date ($_start_date)
    {
        $this->_start_date = $_start_date;
    }
    /**
     * @param field_type $_complete_date
     */
    public function setComplete_date ($_complete_date)
    {
        $this->_complete_date = $_complete_date;
    }
    /**
     * Sets Mapper
     * @param Tnp_Model_Mapper_MemberCertification $mapper
     * @return Tnp_Model_MemberInfo_Certification
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_MemberCertification
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_MemberCertification());
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
    public function fetchCertificationIds ()
    {
        $member_id = $this->getMember_id(true);
        $certifications_ids = $this->getMapper()->fetchCertificationIds(
        $member_id);
        if (empty($certifications_ids)) {
            return false;
        } else {
            return $certifications_ids;
        }
    }
    public function fetchInfo ()
    {
        $member_id = $this->getMember_id(true);
        $certification_id = $this->getCertification_id(true);
        $info = array();
        $info = $this->getMapper()->fetchInfo($member_id, $certification_id);
        if (empty($info)) {
            return false;
        } else {
            return $this->setOptions($info);
        }
    }
    public function deleteStuCertification ()
    {
        $member_id = $this->getMember_id(true);
        $certification_id = $this->getCertification_id(true);
        return $this->getMapper()->delete($member_id, $certification_id);
    }
}