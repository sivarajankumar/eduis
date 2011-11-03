<?php
class Core_Model_Mapper_Address
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Core_Model_Mapper_Address
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
            $this->setDbTable('Core_Model_DbTable_Address');
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
     * fetches Address Information of a Member
     * @param Core_Model_Address $address
     */
    public function fetchAddressInfo (Core_Model_Address $address)
    {
        $member_id = $address->getMember_id();
        $adress_type = $address->getAdress_type();
        if (empty($member_id) or empty($adress_type)) {
            $error = 'Both ,Member Id and Address must be set';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getAdapter();
            $required_fields = array('member_id', 'postal_code', 'city', 
            'district', 'state', 'area', 'address');
            $select = $adapter->select()
                ->from($this->getDbTable()
                ->info('name'), $required_fields)
                ->where('member_id = ?', $member_id)
                ->where('adress_type = ?', $adress_type);
            $address_info = array();
            $address_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
            return $address_info[$member_id];
        }
    }
    /**
     * Enter description here ...
     * @param Core_Model_Address $address
     * @param array $property_range Example :array('name'=>array('from'=>n ,'to'=>m));
     * here 'from' stands for >= AND 'to' stands for <=
     * 
     */
    public function fetchStudents (Core_Model_Address $address, 
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
        $table = array('addr' => $this->getDbTable()->info('name'));
        //1)get column names of student_department present in arguments received
        $address_col = array('member_id', 'adress_type', 'postal_code', 
        'city', 'district', 'state', 'area', 'address');
        $address_intrsctn = array();
        $address_intrsctn = array_intersect($address_col, $merge);
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
                $address->$getter_string();
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