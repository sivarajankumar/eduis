<?php
/**
 * @todo incomplete
 * Enter description here ...
 * 
 */
class Tnp_Model_Mapper_Profile_Components_Experience
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_Profile_Components_Experience
     */
    public function setDbTable ($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (! $dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
    /**
     * Get registered Zend_Db_Table instance
     * @return Zend_Db_Table_Abstract
     */
    public function getDbTable ()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Tnp_Model_DbTable_StudentExperience');
        }
        return $this->_dbTable;
    }
    /**
     * 
     * @todo
     */
    public function save ()
    {}
    /**
     * 
     * @param Tnp_Model_Profile_Components_Experience $experience
     */
    public function fetchMemberExperienceInfo (
    Tnp_Model_Profile_Components_Experience $experience)
    {
        $member_id = $experience->getMember_id();
        $required_fields = array('student_experience_id', 'member_id', 
        'industry_id', 'functional_area_id', 'role_id', 'experience_months', 
        'experience_years', 'organisation', 'start_date', 'end_date', 
        'is_parttime', 'description');
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $select = $adapter->select()
            ->from($this->getDbTable()
            ->info('name'), $required_fields)
            ->where('member_id = ?', $member_id);
        $experience_info = array();
        $experience_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $experience_info;
    }
    /**
     *@todo 
     * @param Tnp_Model_Profile_Components_Experience $experience
     */
    public function fetchIndustry_id (
    Tnp_Model_Profile_Components_Experience $experience)
    {
        $industryName = $experience->getIndustry_name();
        if (! isset($industryName)) {
            throw new Exception('Insufficient Params.. industryName is required');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $select = $adapter->select()
                ->from('industries', 'industry_id')
                ->where('industry_name = ?', $industryName);
            $industryId = $select->query()->fetchColumn();
            $experience->setIndustry_id($industryId);
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Components_Experience $experience
     */
    public function fetchIndustryInfo (
    Tnp_Model_Profile_Components_Experience $experience)
    {
        $industry_id = $experience->getIndustry_id();
        if (! isset($industry_id)) {
            throw new Exception('Insufficient Params.. industryId is required');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $required_fields = array('industry_id', 'industry_name');
            $select = $adapter->select()
                ->from('industries', $required_fields)
                ->where('industry_id = ?', $industry_id);
            $industry_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
            return $industry_info[$industry_id];
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Components_Experience $experience
     */
    public function fetchFunctional_area_id (
    Tnp_Model_Profile_Components_Experience $experience)
    {
        $functionalAreaName = $experience->getFunctional_area_name();
        if (! isset($functionalAreaName)) {
            throw new Exception(
            'Insufficient Params.. functionalAreaName is required');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $select = $adapter->select()
                ->from('functional_area', 'functional_area_id')
                ->where('functional_area_name = ?', $functionalAreaName);
            $functionalAreaId = $select->query()->fetchColumn();
            $experience->setFunctional_area_id($functionalAreaId);
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Components_Experience $experience
     */
    public function fetchFunctionalAreaInfo (
    Tnp_Model_Profile_Components_Experience $experience)
    {
        $functionalAreaId = $experience->getFunctional_area_id();
        if (! isset($functionalAreaId)) {
            throw new Exception(
            'Insufficient Params.. functionalAreaId is required', Zend_Log::ERR);
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $required_fields = array('functional_area_id', 
            'functional_area_name');
            $select = $adapter->select()
                ->from('functional_area', $required_fields)
                ->where('functional_area_id = ?', $functionalAreaId);
            $functionalAreaInfo = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
            return $functionalAreaInfo[$functionalAreaId];
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Components_Experience $experience
     */
    public function fetchRole_id (
    Tnp_Model_Profile_Components_Experience $experience)
    {
        $roleName = $experience->getRole_name();
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $select = $adapter->select()
            ->from('roles', 'role_id')
            ->where('role_name = ?', $roleName);
        $roleId = $select->query()->fetchColumn();
        $experience->setRole_id($roleId);
    }
    /**
     * 
     * @param Tnp_Model_Profile_Components_Experience $experience
     */
    public function fetchRoleInfo (
    Tnp_Model_Profile_Components_Experience $experience)
    {
        $roleId = $experience->getRole_id();
        if (! isset($roleId)) {
            throw new Exception('Insufficient Params.. roleId is required');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $required_fields = array('role_id', 'role_name');
            $select = $adapter->select()
                ->from('roles', $required_fields)
                ->where('role_id = ?', $roleId);
            $experience_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
            return $experience_info[$roleId];
        }
    }
    /**
     * @todo
     * @param Tnp_Model_Profile_Components_Experience $experience
     */
    public function fetchMemberId (
    Tnp_Model_Profile_Components_Experience $searchParams)
    {
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $select = $adapter->select()->from(
        ($this->getDbTable()
            ->info('name')), 'member_id');
        $industryName = $searchParams->getIndustry_name();
        $industryId = $searchParams->getIndustry_id();
        $functionalAreaName = $searchParams->getFunctional_area_name();
        $functionalAreaId = $searchParams->getFunctional_area_id();
        $roleName = $searchParams->getRole_name();
        $roleId = $searchParams->getRole_id();
        // todo
        $searchPreReq = '';
        if ($searchPreReq == true) {
            // do this
        }
         //return $select->query()->fetchColumn();
    }
    /**
     * 
     * @todo decide the params
     * @param Tnp_Model_Profile_Components_Experience $params
     */
    protected function searchPreRequisite (
    Tnp_Model_Profile_Components_Experience $experience)
    {}
}