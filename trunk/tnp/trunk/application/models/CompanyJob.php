<?php
class Tnp_Model_CompanyJob extends Tnp_Model_Generic
{
    protected $_company_job_id;
    protected $_company_id;
    protected $_job;
    protected $_eligibility_criteria;
    protected $_description;
    protected $_date_of_announcement;
    protected $_external;
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
     * @return the $_company_id
     */
    public function getCompany_id ($throw_exception = null)
    {
        $company_id = $this->_company_id;
        if (empty($company_id) and $throw_exception == true) {
            $message = '_company_id is not set in ' . get_class($this);
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $company_id;
        }
    }
    /**
     * @return the $_job
     */
    public function getJob ()
    {
        return $this->_job;
    }
    /**
     * @return the $_eligibility_criteria
     */
    public function getEligibility_criteria ()
    {
        return $this->_eligibility_criteria;
    }
    /**
     * @return the $_description
     */
    public function getDescription ()
    {
        return $this->_description;
    }
    /**
     * @return the $_date_of_announcement
     */
    public function getDate_of_announcement ()
    {
        return $this->_date_of_announcement;
    }
    /**
     * @return the $_external
     */
    public function getExternal ()
    {
        return $this->_external;
    }
    /**
     * @param field_type $_company_job_id
     */
    public function setCompany_job_id ($_company_job_id)
    {
        $this->_company_job_id = $_company_job_id;
    }
    /**
     * @param field_type $_company_id
     */
    public function setCompany_id ($_company_id)
    {
        $this->_company_id = $_company_id;
    }
    /**
     * @param field_type $_job
     */
    public function setJob ($_job)
    {
        $this->_job = $_job;
    }
    /**
     * @param field_type $_eligibility_criteria
     */
    public function setEligibility_criteria ($_eligibility_criteria)
    {
        $this->_eligibility_criteria = $_eligibility_criteria;
    }
    /**
     * @param field_type $_description
     */
    public function setDescription ($_description)
    {
        $this->_description = $_description;
    }
    /**
     * @param field_type $_date_of_announcement
     */
    public function setDate_of_announcement ($_date_of_announcement)
    {
        $this->_date_of_announcement = $_date_of_announcement;
    }
    /**
     * @param field_type $_external
     */
    public function setExternal ($_external)
    {
        $this->_external = $_external;
    }
    /**
     * Sets Mapper
     * @param Tnp_Model_Mapper_CompanyJob $mapper
     * @return Tnp_Model_CompanyJob
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_CompanyJob
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_CompanyJob());
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
     * Fetches information regarding Company
     *
     */
    public function fetchInfo ()
    {
        $company_job_id = $this->getCompany_job_id(true);
        $info = $this->getMapper()->fetchInfo($company_job_id);
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
    public function fetchCompanyJobIds ()
    {
        $company_id = $this->getCompany_job_id(true);
        return $this->getMapper()->fetchCompanyJobIds($company_id);
    }
    public function companyJobExistCheck ()
    {
        $company_id = $this->getCompany_job_id(true);
        return $this->getMapper()->companyJobExistCheck($company_id);
    }
    public function saveInfo ($company_job_info)
    {
        if (empty($company_job_info['company_job_id'])) {
            $this->initSave();
            $prepared_data = $this->prepareDataForSaveProcess($company_job_info);
            Zend_Registry::get('logger')->debug('saving JoB info');
            return $this->save($company_job_info);
        } else {
            $company_job_id = $company_job_info['company_job_id'];
            $this->initSave();
            $prepared_data = $this->prepareDataForSaveProcess($company_job_info);
            unset($prepared_data['company_job_id']);
            Zend_Registry::get('logger')->debug('updating JoB info');
            $this->update($company_job_info, $company_job_id);
            return $company_job_id;
        }
    }
    private function save ($company_job_info)
    {
        $this->initSave();
        $prepared_data = $this->prepareDataForSaveProcess($company_job_info);
        return $this->getMapper()->save($prepared_data);
    }
    private function update ($company_job_info, $company_job_id)
    {
        $this->initSave();
        $prepared_data = $this->prepareDataForSaveProcess($company_job_info);
        return $this->getMapper()->update($prepared_data, $company_job_id);
    }
}