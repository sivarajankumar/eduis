<?php
class Tnp_Model_Mapper_Profile_Components_Certification
{
    protected $_table_cols = null;
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * @return the $_table_cols
     */
    protected function getTable_cols ()
    {
        if (! isset($this->_table_cols)) {
            $this->setTable_cols();
        }
        return $this->_table_cols;
    }
    /**
     * @param field_type $_table_cols
     */
    protected function setTable_cols ()
    {
        $this->_table_cols = $this->getDbTable()->info('cols');
    }
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_Profile_Components_Certification
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
            $this->setDbTable('Tnp_Model_DbTable_StudentCertification');
        }
        return $this->_dbTable;
    }
    /**
     * 
     * Enter description here ...
     * @param array $options
     * @param Tnp_Model_Profile_Components_Certification $certification
     */
    public function save ($options, 
    Tnp_Model_Profile_Components_Certification $certification = null)
    {
        $certInfo = $certification->getSave_certification();
        $stuCertification = $certification->getSave_data();
        if (isset($certInfo)) {
            $dbtable = new Tnp_Model_DbTable_Certification();
        }
        if (isset($stuCertification)) {
            $dbtable = new Tnp_Model_DbTable_StudentCertification();
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
            $data[$key_name] = $certification->$str();
        }
        //$adapter = $this->getDbTable()->getAdapter();
        //$where = $adapter->quoteInto("$this->correctDbKeys('member_id') = ?", $student->getMember_id());
        $adapter = $dbtable->getAdapter();
        $table = $dbtable->info('name');
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
     * @param Tnp_Model_Profile_Components_Certification $certification
     */
    public function fetchMemberCertificationInfo (
    Tnp_Model_Profile_Components_Certification $certification)
    {
        $member_id = $certification->getMember_id();
        if (! isset($member_id)) {
            throw new Exception('Please provide member_id first. ');
        } else {
            $required_fields = array('certification_id', 'start_date', 
            'complete_date');
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $select = $adapter->select()
                ->from($this->getDbTable()
                ->info('name'), $required_fields)
                ->where('member_id = ?', $member_id);
            $certification_info = array();
            $certification_info = $select->query()->fetchAll(
            Zend_Db::FETCH_UNIQUE);
            return $certification_info;
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Components_Certification $certification
     */
    public function fetchCertification_id (
    Tnp_Model_Profile_Components_Certification $certification)
    {
        $certification_name = $certification->getCertification_name();
        $technical_field_id = $certification->getTechnical_field_id();
        if (! isset($certification_name) or ! isset($technical_field_id)) {
            throw new Exception(
            'Insufficient Params.. certificationName, TechFieldId both are required');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $select = $adapter->select()
                ->from('certification', 'certification_id')
                ->where('certification_name = ?', $certification_name)
                ->where('technical_field_id = ?', $technical_field_id);
            $certification_id = $select->query()->fetchColumn();
            $certification->setCertification_id($certification_id);
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Components_Certification $certification
     */
    public function fetchCertificationInfo (
    Tnp_Model_Profile_Components_Certification $certification)
    {
        $certification_id = $certification->getCertification_id();
        if (! isset($certification_id)) {
            throw new Exception('Insufficient Params.. certificationId not set');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $requiredFields = array('certification_id', 'certification_name', 
            'technical_field_id');
            $select = $adapter->select()
                ->from('certification', $requiredFields)
                ->where('certification_id = ?', $certification_id);
            $certification_info = array();
            $certification_info = $select->query()->fetchAll(
            Zend_Db::FETCH_UNIQUE);
            return $certification_info[$certification_id];
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Components_Certification $certification
     */
    public function fetchTechnical_field_id (
    Tnp_Model_Profile_Components_Certification $certification)
    {
        $technical_field_name = $certification->getTechnical_field_name();
        $technical_sector = $certification->getTechnical_sector();
        if (! isset($technical_field_name) or ! isset($technical_sector)) {
            throw new Exception(
            'Insufficient Params.. Techsector, TechFieldName both are required to get tech field id');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $select = $adapter->select()
                ->from('technical_fields', 'technical_field_id')
                ->where('technical_field_name = ?', $technical_field_name)
                ->where('technical_sector = ?', $technical_sector);
            $technical_field_id = $select->query()->fetchColumn();
            $certification->setTechnical_field_id($technical_field_id);
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Components_Certification $certification
     */
    public function fetchTechnicalFieldInfo (
    Tnp_Model_Profile_Components_Certification $certification)
    {
        $technical_field_id = $certification->getTechnical_field_id();
        if (! isset($technical_field_id)) {
            throw new Exception(
            'Insufficient Params.. technical_field_id not set');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $requiredFields = array('technical_field_id', 
            'technical_field_name', 'technical_sector');
            $select = $adapter->select()
                ->from('technical_fields', $requiredFields)
                ->where('technical_field_id = ?', $technical_field_id);
            $technical_field_info = $select->query()->fetchAll(
            Zend_Db::FETCH_UNIQUE);
            return $technical_field_info[$technical_field_id];
        }
    }
    /**
     * Enter description here ...
     * @param Tnp_Model_Profile_Components_Certification $certification
     * @param array $property_range Example :array('name'=>array('from'=>n ,'to'=>m));
     * here 'from' stands for >= AND 'to' stands for <=
     * 
     */
    public function fetchStudents (
    Tnp_Model_Profile_Components_Certification $certification, 
    array $setter_options = null, array $property_range = null)
    {
        //declare table name and table columns for join statement
        $table = (array('s' => $this->getDbTable()->info('name')));
        $name1 = array('c' => 'certification');
        $cond1 = 's.certification_id = c.certification_id';
        $name2 = array('t' => 'technical_fields');
        $cond2 = 'c.technical_field_id = t.technical_field_id';
        //get column names of certification present in arguments received
        $certification_col = array('certification_name', 
        'technical_field_id');
        $certification_intrsctn = array();
        $certification_intrsctn = array_intersect($certification_col, 
        $setter_options, $property_range);
        //get column names of functional_area present in arguments received
        $technical_fields_col = array('technical_field_name', 
        'technical_sector');
        $technical_fields_intrsctn = array();
        $technical_fields_intrsctn = array_intersect($technical_fields_col, 
        $setter_options, $property_range);
        //
        $adapter = $this->getDbTable()->getAdapter();
        $select = $adapter->select()->from($table, 'member_id');
        if (! empty($certification_intrsctn)) {
            $select->join($name1, $cond1);
        }
        if (! empty($technical_fields_intrsctn)) {
            $select->join($name2, $cond2);
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
            $certification->$getter_string();
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