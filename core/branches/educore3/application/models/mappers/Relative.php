<?php
class Core_Model_Mapper_Relative
{
    protected $_relative_columns = array('member_id', 'name', 'relation_id', 
    'occupation', 'designation', 'office_add', 'contact', 'annual_income', 
    'landline_no');
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * @return the $_relative_columns
     */
    protected function getRelative_columns ()
    {
        return $this->_relative_columns;
    }
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Core_Model_Mapper_Relative
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
            $this->setDbTable('Core_Model_DbTable_Relative');
        }
        return $this->_dbTable;
    }
    /**
     * 
     * Enter description here ...
     * @param array $options
     * @param Core_Model_Relative $relative
     */
    public function save ($options, Core_Model_Relative $relative = null)
    {
        $all_relative_cols = $this->getRelative_columns();
        //$db_options is $options with keys renamed a/q to db_columns
        $db_options = array();
        foreach ($options as $key => $value) {
            $db_options[$this->correctDbKeys($key)] = $value;
        }
        $db_options_keys = array_keys($db_options);
        $recieved_relative_keys = array_intersect($db_options_keys, 
        $all_relative_cols);
        $relative_data = array();
        foreach ($recieved_relative_keys as $key_name) {
            $str = "get" . ucfirst($this->correctModelKeys($key_name));
            $relative_data[$key_name] = $relative->$str();
        }
        //Zend_Registry::get('logger')->debug($relative_data);
        //$adapter = $this->getDbTable()->getAdapter();
        //$where = $adapter->quoteInto("$this->correctDbKeys('member_id') = ?", $student->getMember_id());
        $adapter = $this->getDbTable()->getAdapter();
        $table = $this->getDbTable()->info('name');
        $adapter->beginTransaction();
        try {
            $sql = $adapter->insert($table, $relative_data);
        } catch (Exception $exception) {
            $adapter->rollBack();
            echo $exception->getMessage() . "</br>";
        }
    }
    /**
     *fetches information about a relative
     *@param Core_Model_Relative $relative
     */
    public function fetchRelativeInfo (Core_Model_Relative $relative)
    {
        $member_id = $relative->getMember_id();
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $relatives_fields = $this->getRelative_columns();
        $relations_fields = array('relation_name');
        $select = $adapter->select()
            ->from($this->getDbTable()
            ->info('name'), $relatives_fields)
            ->joinInner('relations', 
        'relatives.relation_id = relations.relation_id', $relations_fields)
            ->where('member_id = ?', $member_id);
        $relative_info = array();
        $relative_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $relative_info[$member_id];
    }
    /**
     * Enter description here ...
     * @param Core_Model_Relative $relative
     * @param array $property_range Example :array('name'=>array('from'=>n ,'to'=>m));
     * here 'from' stands for >= AND 'to' stands for <=
     * 
     */
    public function fetchStudents (Core_Model_Relative $relative, 
    array $setter_options = null, array $property_range = null)
    {
        $correct_db_options = array();
        foreach ($setter_options as $k => $val) {
            $correct_db_options[$this->correctDbKeys($k)] = $val;
        }
        $correct_db_options_keys = array_keys($correct_db_options);
        $correct_db_options1 = array();
        foreach ($property_range as $k1 => $val1) {
            $correct_db_options1[$this->correctDbKeys($k1)] = $val1;
        }
        $correct_db_options1_keys = array_keys($correct_db_options1);
        $merge = array_merge($correct_db_options_keys, 
        $correct_db_options1_keys);
        $table = array('rel' => $this->getDbTable()->info('name'));
        //1)get column names of relatives present in arguments received
        $relative_col = $this->getRelative_columns();
        $relative_intrsctn = array();
        $relative_intrsctn = array_intersect($relative_col, $merge);
        $adapter = $this->getDbTable()->getAdapter();
        $select = $adapter->select()->from($table, 'member_id');
        if (count($correct_db_options1)) {
            foreach ($correct_db_options1 as $key => $range) {
                if (! empty($range['from'])) {
                    $select->where("$key >= ?", $range['from']);
                }
                if (! empty($range['to'])) {
                    $select->where("$key <= ?", $range['to']);
                }
            }
        }
        if (count($correct_db_options)) {
            foreach ($correct_db_options as $property_name => $value) {
                $getter_string = 'get' .
                 ucfirst($this->correctModelKeys($property_name));
                $relative->$getter_string();
                $condition = $property_name . ' = ?';
                $select->where($condition, $value);
            }
        }
        $result = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        if (! count($result)) {
            $search_error = 'No results match your search criteria.';
            return $search_error;
        } else {
            return $result;
        }
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
}