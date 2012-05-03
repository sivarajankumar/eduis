<?php
class Acad_Model_Member_Qualification extends Acad_Model_Generic
{
    protected $_member_id;
    protected $_qualification_id;
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
     * @return the $_qualification_id
     */
    public function getQualification_id ($throw_exception = null)
    {
        $qualification_id = $this->_qualification_id;
        if (empty($qualification_id) and $throw_exception == true) {
            $message = '_qualification_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $qualification_id;
        }
    }
    /**
     * @param field_type $_member_id
     */
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    /**
     * @param field_type $_qualification_id
     */
    public function setQualification_id ($_qualification_id)
    {
        $this->_qualification_id = $_qualification_id;
    }
    /**
     * Sets Mapper
     * @param Acad_Model_Mapper_Member_Qualification $mapper
     * @return Acad_Model_Member_Qualification
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Acad_Model_Mapper_Member_Qualification
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Mapper_Member_Qualification());
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
     * Fetches Qualification ids of a member(
     * Member_id must be set before calling this function)
     * @return array|false 
     */
    public function fetchQualificationIds ()
    {
        $member_id = $this->getMember_id(true);
        $qualification_ids = $this->getMapper()->fetchQualificationIds(
        $member_id);
        if (empty($qualification_ids)) {
            return false;
        } else {
            return $qualification_ids;
        }
    }
    /**
     * 
     * Saves the Qualifications of a member
     * Member_id must be set before calling this function
     * @param array $qualifications an array containing qualification ids of a member
     */
    public function saveQualifications ($qualifications)
    {
        $member_id = $this->getMember_id(true);
        foreach ($qualifications as $qualification) {
            $this->initSave();
            $data_array = array('member_id' => $member_id, 
            'qualification_id' => $qualification);
            $preparedData = $this->prepareDataForSaveProcess($data_array);
            $this->getMapper()->save($preparedData);
        }
    }
}