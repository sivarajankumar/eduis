<?php
class Tnp_Model_Company extends Tnp_Model_Generic
{
    protected $_company_id;
    protected $_company_name;
    protected $_field;
    protected $_description;
    protected $_verified;
    protected $_mapper;
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
     * @return the $_company_name
     */
    public function getCompany_name ()
    {
        return $this->_company_name;
    }
    /**
     * @return the $_field
     */
    public function getField ()
    {
        return $this->_field;
    }
    /**
     * @return the $_description
     */
    public function getDescription ()
    {
        return $this->_description;
    }
    /**
     * @return the $_verified
     */
    public function getVerified ()
    {
        return $this->_verified;
    }
    /**
     * @param field_type $_company_id
     */
    public function setCompany_id ($_company_id)
    {
        $this->_company_id = $_company_id;
    }
    /**
     * @param field_type $_company_name
     */
    public function setCompany_name ($_company_name)
    {
        $this->_company_name = $_company_name;
    }
    /**
     * @param field_type $_field
     */
    public function setField ($_field)
    {
        $this->_field = $_field;
    }
    /**
     * @param field_type $_description
     */
    public function setDescription ($_description)
    {
        $this->_description = $_description;
    }
    /**
     * @param field_type $_verified
     */
    public function setVerified ($_verified)
    {
        $this->_verified = $_verified;
    }
    /**
     * Sets Mapper
     * @param Tnp_Model_Mapper_Company $mapper
     * @return Tnp_Model_Company
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_Company
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_Company());
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
     * Fetches information regarding Company
     *
     */
    public function fetchInfo ()
    {
        $company_id = $this->getCompany_id(true);
        $info = $this->getMapper()->fetchInfo($company_id);
        if (empty($info)) {
            return false;
        } else {
            $this->setOptions($info);
            return $this;
        }
    }
    /**
     * 
     * @desc fetches the names of all companies
     * @return array|false
     */
    public function fetchCompanies ()
    {
        $companies = array();
        return $this->getMapper()->fetchCompanies();
    }
    public function companyExistCheck ()
    {
        $company_id = $this->getCompany_id(true);
        return $this->getMapper()->companyExistCheck($company_id);
    }
    public function saveInfo ($company_info)
    {
        if (empty($company_info['company_id'])) {
            $this->initSave();
            $prepared_data = $this->prepareDataForSaveProcess($company_info);
            Zend_Registry::get('logger')->debug('saving company info');
            return $this->save($company_info);
        } else {
            Zend_Registry::get('logger')->debug('updating company info');
            $company_id = $company_info['company_id'];
            $this->initSave();
            $prepared_data = $this->prepareDataForSaveProcess($company_info);
            unset($prepared_data['company_id']);
            $this->update($company_info, $company_id);
            return $company_id;
        }
    }
    private function save ($class_info)
    {
        $this->initSave();
        $prepared_data = $this->prepareDataForSaveProcess($class_info);
        return $this->getMapper()->save($prepared_data);
    }
    private function update ($class_info, $company_id)
    {
        $this->initSave();
        $prepared_data = $this->prepareDataForSaveProcess($class_info);
        return $this->getMapper()->update($prepared_data, $company_id);
    }
}