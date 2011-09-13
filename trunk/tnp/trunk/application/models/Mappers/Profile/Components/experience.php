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
    public function setDbTable (Zend_Db_Table_Abstract $dbTable)
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
    public function fetchExperienceDetails (
    Tnp_Model_Profile_Components_Experience $experience)
    {
        $u_regn_no = $experience->getU_regn_no();
        $cols = array(student_experience_id, u_regn_no, industry_id, 
        functional_area_id, role_id, experience_months, experience_year, 
        organisation, start_date, end_date, is_parttime, description);
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $select = $adapter->select()
            ->from($this->getDbTable()
            ->info('NAME'), $cols)
            ->where('u_regn_no = ?', $u_regn_no);
        $fetchall = $adapter->fetchAll($select);
        $result = array();
        foreach ($fetchall as $row) {
            foreach ($row as $columnName => $columnValue) {
                $result[$columnName] = $columnValue;
            }
        }
        return $result;
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
            ->info('NAME')), 'u_regn_no');
        $industryName = isset($searchParams->getIndustry_name());
        $industryId = isset($searchParams->getIndustry_id());
        $functionalAreaName = isset($searchParams->getFunctional_area_name());
        $functionalAreaId = isset($searchParams->getFunctional_area_id());
        $roleName = isset($searchParams->getRole_name());
        $roleId = isset($searchParams->getRole_id());
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
    /**
     *@todo 
     * @param Tnp_Model_Profile_Components_Experience $experience
     */
    public function fetchIndustry_id (
    Tnp_Model_Profile_Components_Experience $experience)
    {
        $industryName = $experience->getIndustry_name();
        if (! isset($industryName)) {
            $logger = Zend_Registry::get('logger');
            $logger->debug('Insufficient Params.. industryName is required');
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
    public function fetchIndustry_name (
    Tnp_Model_Profile_Components_Experience $experience)
    {
        $industryId = $experience->getIndustry_id();
        if (! isset($industryId)) {
            $logger = Zend_Registry::get('logger');
            $logger->debug('Insufficient Params.. industryId is required');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $select = $adapter->select()
                ->from('industries', 'industry_name')
                ->where('industry_id = ?', $industryId);
            $industryName = $select->query()->fetchColumn();
            $experience->setIndustry_name($industryName);
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
            $logger = Zend_Registry::get('logger');
            $logger->debug(
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
    public function fetchFunctional_area_name (
    Tnp_Model_Profile_Components_Experience $experience)
    {
        $functionalAreaId = $experience->getFunctional_area_id();
        if (! isset($functionalAreaId)) {
            $logger = Zend_Registry::get('logger');
            $logger->debug('Insufficient Params.. functionalAreaId is required');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $select = $adapter->select()
                ->from('functional_area', 'functional_area_name')
                ->where('functional_area_id = ?', $functionalAreaId);
            $functionalAreaName = $select->query()->fetchColumn();
            $experience->setFunctional_area_name($functionalAreaName);
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
    public function fetchRole_name (
    Tnp_Model_Profile_Components_Experience $experience)
    {
        $roleId = $experience->getRole_id();
        if (! isset($roleId)) {
            $logger = Zend_Registry::get('logger');
            $logger->debug('Insufficient Params.. roleId is required');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $select = $adapter->select()
                ->from('roles', 'role_name')
                ->where('role_id = ?', $roleId);
            $roleName = $select->query()->fetchColumn();
            $experience->setRole_name($roleName);
        }
    }
}