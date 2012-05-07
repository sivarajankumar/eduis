<?php
class Tnp_Model_Mapper_Core_Skills
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_Core_Skills
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
            $this->setDbTable('Tnp_Model_DbTable_Skills');
        }
        return $this->_dbTable;
    }
    /**
     * 
     * @param integer $skill_id
     */
    public function fetchInfo ($skill_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $skills_table = $db_table->info('name');
        $required_cols = array('skill_id', 'skill_name', 'skill_field');
        $select = $adapter->select()
            ->from($skills_table, $required_cols)
            ->where('skill_id = ?', $skill_id);
        $skill_info = array();
        $skill_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $skill_info[$skill_id];
    }
    public function fetchSkillids ($skill_name = null, $skill_field = null)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $skills_table = $db_table->info('name');
        $required_cols = array('skill_id');
        $select = $adapter->select()->from($skills_table, $required_cols);
        if (! empty($skill_name)) {
            $select->where('skill_name = ?', $skill_name);
        }
        if (! empty($skill_field)) {
            $select->where('skill_field = ?', $skill_field);
        }
        $member_ids = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        return $member_ids;
    }
    /**
     * 
     *@return array ,Format =array($role_id=>$role_name)
     */
    public function fetchSkills ()
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $skills_table = $db_table->info('name');
        $required_cols = array('skill_id', 'skill_name');
        $select = $adapter->select()->from($skills_table, $required_cols);
        $skills = array();
        $result = array();
        $result = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        foreach ($result as $skill_id => $skill_name_array) {
            $skills[$skill_id] = $skill_name_array['skill_name'];
        }
        return $skills;
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $skill_id)
    {
        $dbtable = $this->getDbTable();
        $where = 'skill_id = ' . $skill_id;
        return $dbtable->update($prepared_data, $where);
    }
}
?>