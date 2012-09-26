<?php
class Core_Model_Mapper_MemberContacts
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Core_Model_Mapper_MemberContacts
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
            $this->setDbTable('Core_Model_DbTable_MemberContacts');
        }
        return $this->_dbTable;
    }
    /**
     * Fetches Contact details of a Member
     * 
     * @param integer $member_id
     */
    public function fetchInfo ($member_id, $contact_type_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = new Core_Model_DbTable_MemberContacts();
        $member_contacts_table = $db_table->info('name');
        $required_cols = array('member_id', 'contact_type_id', 
        'contact_details');
        $contacts_type_db_table = new Core_Model_DbTable_ContactType();
        $contacts_type_table = $contacts_type_db_table->info('name');
        $contacts_type_cols = 'contact_type_name';
        $cond = $member_contacts_table . '.contact_type_id=' .
         $contacts_type_table . '.contact_type_id';
        $select = $adapter->select()
            ->from($member_contacts_table, $required_cols)
            ->joinInner($contacts_type_table, $cond, $contacts_type_cols)
            ->where('member_id = ?', $member_id)
            ->where(strval($member_contacts_table . '.contact_type_id = ?'), 
        $contact_type_id);
        $contact_info = array();
        $contact_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        if (empty($contact_info)) {
            return false;
        } else {
            return $contact_info[$member_id];
        }
    }
    /**
     * Fetches Contact Type Ids of a Member
     * 
     * @param integer $member_id
     */
    public function fetchContactTypeIds ($member_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $contacts_table = $db_table->info('name');
        $required_cols = array('contact_type_id');
        $select = $adapter->select()
            ->from($contacts_table, $required_cols)
            ->where('member_id = ?', $member_id);
        $contacty_type_ids = array();
        $contacty_type_ids = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        return $contacty_type_ids;
    }
    /**
     * Fetches All Contact Types 
     * 
     */
    public function fetchAllContactTypes ()
    {
        $contacts_type_db_table = new Core_Model_DbTable_ContactType();
        $contacts_type_table = $contacts_type_db_table->info('name');
        $adapter = $this->getDbTable()->getAdapter();
        $required_cols = array('contact_type_id', 'contact_type_name');
        $select = $adapter->select()->from($contacts_type_table, $required_cols);
        $contacty_types = array();
        $result = array();
        $result = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        if (empty($result)) {
            return false;
        } else {
            foreach ($result as $contact_type_id => $contact_type_name_array) {
                $contacty_types[$contact_type_id] = $contact_type_name_array['contact_type_name'];
            }
            return $contacty_types;
        }
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $member_id, $contact_type_id)
    {
        $dbtable = $this->getDbTable();
        $where1 = 'member_id = ' . $member_id;
        $where2 = 'contact_type_id = ' . $contact_type_id;
        return $dbtable->update($prepared_data, array($where1, $where2));
    }
}
?>