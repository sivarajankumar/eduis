<?php
class Tnp_Model_JobRecord extends Tnp_Model_Generic
{
    protected $_company_job_id;
    protected $_member_id;
    protected $_appeared;
    protected $_selected;
    protected $_package;
    protected $_date_of_selection;
    protected $_drive_location;
    protected $_registered;
    protected $_mapper;
    /**
     * @return the $_company_job_id
     */
    public function getCompany_job_id ($throw_exception = null)
    {
        $company_id = $this->_company_job_id;
        if (empty($company_id) and $throw_exception == true) {
            $message = '_company_job_id is not set in ' . get_class($this);
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $company_id;
        }
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
     * @return the $_appeared
     */
    public function getAppeared ()
    {
        return $this->_appeared;
    }
    /**
     * @return the $_selected
     */
    public function getSelected ()
    {
        return $this->_selected;
    }
    /**
     * @return the $_package
     */
    public function getPackage ()
    {
        return $this->_package;
    }
    /**
     * @return the $_date_of_selection
     */
    public function getDate_of_selection ()
    {
        return $this->_date_of_selection;
    }
    /**
     * @return the $_drive_location
     */
    public function getDrive_location ()
    {
        return $this->_drive_location;
    }
    /**
     * @return the $_registered
     */
    public function getRegistered ()
    {
        return $this->_registered;
    }
    /**
     * @param field_type $_company_job_id
     */
    public function setCompany_job_id ($_company_job_id)
    {
        $this->_company_job_id = $_company_job_id;
    }
    /**
     * @param field_type $_member_id
     */
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    /**
     * @param field_type $_appeared
     */
    public function setAppeared ($_appeared)
    {
        $this->_appeared = $_appeared;
    }
    /**
     * @param field_type $_selected
     */
    public function setSelected ($_selected)
    {
        $this->_selected = $_selected;
    }
    /**
     * @param field_type $_package
     */
    public function setPackage ($_package)
    {
        $this->_package = $_package;
    }
    /**
     * @param field_type $_date_of_selection
     */
    public function setDate_of_selection ($_date_of_selection)
    {
        $this->_date_of_selection = $_date_of_selection;
    }
    /**
     * @param field_type $_drive_location
     */
    public function setDrive_location ($_drive_location)
    {
        $this->_drive_location = $_drive_location;
    }
    /**
     * @param field_type $_registered
     */
    public function setRegistered ($_registered)
    {
        $this->_registered = $_registered;
    }
    /**
     * Sets Mapper
     * @param Tnp_Model_Mapper_JobRecord $mapper
     * @return Tnp_Model_JobRecord
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_JobRecord
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_JobRecord());
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
    public function fetchInfo ()
    {
        $company_job_id = $this->getCompany_job_id(true);
        $member_id = $this->getMember_id(true);
        $info = $this->getMapper()->fetchInfo($company_job_id, $member_id);
        if (empty($info)) {
            return false;
        } else {
            $this->setOptions($info);
            return $this;
        }
    }
    public function fetchStudents ()
    {
        $company_job_id = $this->getCompany_job_id(true);
        $members = $this->getMapper()->fetchStudents($company_job_id);
        if (empty($members)) {
            return false;
        } else {
            return $members;
        }
    }
    public function checkMemberJob ()
    {
        $company_job_id = $this->getCompany_job_id(true);
        $member_id = $this->getMember_id(true);
        return $this->getMapper()->checkMemberJob($company_job_id, $member_id);
    }
    public function saveInfo ($info)
    {
        $member_id = $info['member_id'];
        $company_job_id = $info['company_job_id'];
        $this->setMember_id($member_id);
        $this->setCompany_job_id($company_job_id);
        $exists = $this->checkMemberJob();
        if ($exists) {
            Zend_Registry::get('logger')->debug('updating Student JoB info');
            $this->update($info, $member_id, $company_job_id);
        } else {
            Zend_Registry::get('logger')->debug('saving Student JoB info');
            $this->save($info);
        }
    }
    private function save ($info)
    {
        $this->initSave();
        $prepared_data = $this->prepareDataForSaveProcess($info);
        return $this->getMapper()->save($prepared_data);
    }
    private function update ($info, $member_id, $company_job_id)
    {
        $this->initSave();
        $prepared_data = $this->prepareDataForSaveProcess($info);
        unset($prepared_data['member_id']);
        unset($prepared_data['company_job_id']);
        return $this->getMapper()->update($prepared_data, $member_id, 
        $company_job_id);
    }
}