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
    public function fetchMemberExperienceIds (
    Tnp_Model_Profile_Components_Experience $experience)
    {
        $member_id = $experience->getMember_id();
        if (! isset($member_id)) {
            throw new Exception('Please set memberId first');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $select = $adapter->select()
                ->from('student_experience', 'student_experience_id')
                ->where('member_id = ?', $member_id);
            $fetchall = $select->query()->fetchAll();
            $experienceIds = array();
            foreach ($fetchall as $row) {
                foreach ($row as $columnName => $columnValue) {
                    if ($columnName == 'student_experience_id') {
                        $experienceIds[] = $columnValue;
                    }
                }
            }
            return $experienceIds;
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Components_Experience $experience
     */
    public function fetchMemberExperienceDetails (
    Tnp_Model_Profile_Components_Experience $experience)
    {
        $member_id = $experience->getMember_id();
        $cols = array(student_experience_id, member_id, industry_id, 
        functional_area_id, role_id, experience_months, experience_year, 
        organisation, start_date, end_date, is_parttime, description);
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $select = $adapter->select()
            ->from($this->getDbTable()
            ->info('NAME'), $cols)
            ->where('member_id = ?', $member_id);
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
            ->info('NAME')), 'member_id');
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
    public function fetchIndustry_name (
    Tnp_Model_Profile_Components_Experience $experience)
    {
        $industryId = $experience->getIndustry_id();
        if (! isset($industryId)) {
            throw new Exception('Insufficient Params.. industryId is required');
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
    public function fetchFunctional_area_name (
    Tnp_Model_Profile_Components_Experience $experience)
    {
        $functionalAreaId = $experience->getFunctional_area_id();
        if (! isset($functionalAreaId)) {
            throw new Exception(
            'Insufficient Params.. functionalAreaId is required');
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
            throw new Exception('Insufficient Params.. roleId is required');
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