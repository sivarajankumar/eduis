<?php
class Acad_Model_Mapper_CompetitiveExam
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Acad_Model_Mapper_CompetitiveExam
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
            $this->setDbTable('Acad_Model_DbTable_CompetitiveExam');
        }
        return $this->_dbTable;
    }
    public function fetchInfo ($exam_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $comp_table = $db_table->info('name');
        $required_cols = array('exam_id', 'name', 'abbreviation');
        $select = $adapter->select()
            ->from($comp_table, $required_cols)
            ->where('exam_id = ?', $exam_id);
        $exam_info = array();
        $exam_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $exam_info[$exam_id];
    }
    public function fetchExams ()
    {
        $adapter = $this->getDbTable()->getAdapter();
        $db_table = $this->getDbTable();
        $comp_table = $db_table->info('name');
        $required_cols = array('exam_id', 'abbreviation');
        $select = $adapter->select()->from($comp_table, $required_cols);
        $comp_exams = array();
        $comp_exams = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        if (empty($comp_exams)) {
            return false;
        } else {
            foreach ($comp_exams as $exam_id => $abbrr_array) {
                foreach ($abbrr_array as $abbrr) {
                    $comp_exams[$exam_id] = $abbrr;
                }
            }
            return $comp_exams;
        }
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        return $dbtable->insert($prepared_data);
    }
    public function update ($prepared_data, $exam_id)
    {
        $dbtable = $this->getDbTable();
        $where = 'exam_id = ' . $exam_id;
        return $dbtable->update($prepared_data, $where);
    }
}