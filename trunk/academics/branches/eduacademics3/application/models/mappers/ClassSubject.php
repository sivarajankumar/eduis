<?php
class Acad_Model_Mapper_ClassSubject
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Acad_Model_Mapper_ClassSubject
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
            $this->setDbTable('Acad_Model_DbTable_ClassSubject');
        }
        return $this->_dbTable;
    }
    public function fetchClassSubjects ($class_id)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $table_name = $db_table->info('name');
        $required_cols = array('subject_id');
        $select = $adapter->select()
            ->from($table_name, $required_cols)
            ->where('class_id= ?', $class_id);
        $class_subjects = array();
        $class_subjects = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        return $class_subjects;
    }
    public function fetchInfo ($class_id, $subject_id)
    {
        $db_table = $this->getDbTable();
        $adapter = $db_table->getAdapter();
        $table_name = $db_table->info('name');
        $required_cols = array('class_id', 'subject_id', 'internal_max_marks', 
        'external_max_marks', 'internal_pass_marks', 'external_pass_marks');
        $select = $adapter->select()
            ->from($table_name, $required_cols)
            ->where('class_id= ?', $class_id)
            ->where('subject_id= ?', $subject_id);
        $info = array();
        $info = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        return $info;
    }
    public function fetchSubjectClass ($subject_id)
    {
        $db_table = $this->gclass_idetDbTable();
        $adapter = $db_table->getAdapter();
        $table_name = $db_table->info('name');
        $required_cols = array('class_id');
        $select = $adapter->select()
            ->from($table_name, $required_cols)
            ->where('subject_id = ?', $subject_id);
        $subject_class = array();
        $subject_class = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        return $subject_class;
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $class_id, $subject_id)
    {
        $dbtable = $this->getDbTable();
        $where1 = 'class_id = ' . $class_id;
        $where2 = 'subject_id = ' . $subject_id;
        return $dbtable->update($prepared_data, array($where1, $where2));
    }
}
?>