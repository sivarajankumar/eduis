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
    public function save ($options, Tnp_Model_Profile_Components_Experience $experience)
    {
        if (isset($save_stu)) {
            $dbtable = new Tnp_Model_DbTable_Student();
        }
        $cols = $dbtable->info('cols');
        //$db_options is $options with keys renamed a/q to db_columns
        $db_options = array();
        foreach ($options as $key => $value) {
            $db_options[$this->correctDbKeys($key)] = $value;
        }
        $db_options_keys = array_keys($db_options);
        $recieved_keys = array_intersect($db_options_keys, $cols);
        $data = array();
        foreach ($recieved_keys as $key_name) {
            $str = "get" . ucfirst($this->correctModelKeys($key_name));
            $data[$key_name] = $experience->$str();
        }
        //$adapter = $this->getDbTable()->getAdapter();
        //$where = $adapter->quoteInto("$this->correctDbKeys('member_id') = ?", $student->getMember_id());
        $adapter = $this->getDbTable()->getAdapter();
        $table = $this->getDbTable()->info('name');
        $adapter->beginTransaction();
        try {
            $sql = $adapter->insert($table, $data);
            $adapter->commit();
        } catch (Exception $exception) {
            $adapter->rollBack();
            throw $exception;
        }
    }
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
            $functionalAreaInfo = $select->query()->fetchAll(
            Zend_Db::FETCH_UNIQUE);
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
     * 
     * @todo decide the params
     * @param Tnp_Model_Profile_Components_Experience $params
     */
    protected function searchPreRequisite (
    Tnp_Model_Profile_Components_Experience $experience)
    {}
    /**
     * Enter description here ...
     * @param Tnp_Model_Profile_Components_Experience $experience
     * @param array $property_range Example :array('name'=>array('from'=>n ,'to'=>m));
     * here 'from' stands for >= AND 'to' stands for <=
     * 
     */
    public function fetchStudents (
    Tnp_Model_Profile_Components_Experience $experience, 
    array $setter_options = null, array $property_range = null)
    {
        $setter_options_keys = array_keys($setter_options);
        $property_range_keys = array_keys($property_range);
        $merge = array_merge($setter_options_keys, $property_range_keys);
        //declare table name and table columns for join statement
        $table = (array('s' => $this->getDbTable()->info('name')));
        $name1 = array('i' => 'industries');
        $cond1 = 's.industry_id = i.industry_id';
        $name2 = array('f' => 'functional_area');
        $cond2 = 's.functional_area_id = f.functional_area_id';
        $name3 = array('r' => 'roles');
        $cond3 = 's.role_id = r.role_id';
        //get column names of industries present in arguments received
        $industries_col = array('industry_name');
        $ind_intrsctn = array();
        $ind_intrsctn = array_intersect($industries_col, $merge);
        //get column names of functional_area present in arguments received
        $functional_area_col = array('functional_area_name');
        $functional_intrsctn = array();
        $functional_intrsctn = array_intersect($functional_area_col, $merge);
        //get column names of roles present in arguments received
        $roles_col = array('role_name');
        $roles_intrsctn = array();
        $roles_intrsctn = array_intersect($roles_col, $merge);
        //
        $adapter = $this->getDbTable()->getAdapter();
        $select = $adapter->select()->from($table, 'member_id');
        if (! empty($ind_intrsctn)) {
            $select->join($name1, $cond1);
        }
        if (! empty($functional_intrsctn)) {
            $select->join($name2, $cond2);
        }
        if (! empty($roles_intrsctn)) {
            $select->join($name3, $cond3);
        }
        foreach ($property_range as $key => $range) {
            if (! empty($range['from'])) {
                $select->where("$key >= ?", $range['from']);
            }
            if (! empty($range['to'])) {
                $select->where("$key <= ?", $range['to']);
            }
        }
        foreach ($setter_options as $property_name => $value) {
            $getter_string = 'get' . ucfirst($property_name);
            $experience->$getter_string();
            $condition = $property_name . ' = ?';
            $select->where($condition, $value);
        }
        $result = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        if (! empty($result)) {
            $serach_error = 'No results match your search criteria.';
            return $serach_error;
        } else {
            return $result;
        }
    }
}