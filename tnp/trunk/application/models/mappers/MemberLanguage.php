<?php
class Tnp_Model_Mapper_MemberLanguage
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_MemberLanguage
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
            $this->setDbTable('Tnp_Model_DbTable_StudentLanguage');
        }
        return $this->_dbTable;
    }
    public function fetchProficiency ($member_id, $language_id)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $select = $adapter->select()->from($db_table->info('name'), 
        array('proficiency'));
        $proficiency = array();
        $select->where('member_id = ?', $member_id)->where('language_id = ?', 
        $language_id);
        $proficiency = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        return $proficiency;
    }
    public function fetchLanguagesInfo ($member_id)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $stu_lan_table = $db_table->info('name');
        $required_cols = array('language_id', 'proficiency');
        $select = $adapter->select()->from($stu_lan_table, $required_cols);
        $stu_lans = array();
        $select->where('member_id = ?', $member_id);
        $result = array();
        $language_info = array();
        $result = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        foreach ($result as $language_id => $proficiency_array) {
            $language_info[$language_id] = $proficiency_array['proficiency'];
        }
        return $language_info;
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function delete ($member_id, $language_id)
    {
        $dbtable = $this->getDbTable();
        $where1 = 'member_id = ' . $member_id;
        $where2 = 'language_id = ' . $language_id;
        return $dbtable->delete(array($where1, $where2));
    }
    public function update ($prepared_data, $member_id, $language_id)
    {
        $dbtable = $this->getDbTable();
        $where1 = 'member_id = ' . $member_id;
        $where2 = 'language_id = ' . $language_id;
        return $dbtable->update($prepared_data, array($where1, $where2));
    }
}
?>