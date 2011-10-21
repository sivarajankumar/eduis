<?php
class Acad_Model_Mapper_Exam_Competitive
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Acad_Model_Mapper_Exam_Competitive
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
            $this->setDbTable('Acad_Model_Exam_Competitive');
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
     * fetches Competitive Exam details
     *
     *@param Acad_Model_Exam_Competitive $competitiveExam
     */
    public function fetchMemberExamInfo (
    Acad_Model_Exam_Competitive $competitiveExam)
    {
        $member_id = $competitiveExam->getMember_id();
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $student_competitive_exam_fields = array('exam_id', 'exam_roll_no', 
        'exam_date', 'total_score', 'all_india_rank');
        $competitive_exam_fields = array();
        $select = $adapter->select()
            ->from($this->getDbTable()
            ->info('name'), $student_competitive_exam_fields)
            ->where('member_id = ?', $member_id);
        $competitive_exam_info = $adapter->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $competitive_exam_info;
    }
    /**
     * Enter description here ...
     * @param Acad_Model_Exam_Competitive $competitiveExam
     * @param array $property_range Example :array('name'=>array('from'=>n ,'to'=>m));
     * here 'from' stands for >= AND 'to' stands for <=
     * 
     */
    public function fetchStudents (Acad_Model_Exam_Competitive $competitiveExam, 
    array $setter_options = null, array $property_range = null)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $select = $adapter->select()->from(
        ($this->getDbTable()
            ->info('name')), 'member_id');
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
            $competitiveExam->$getter_string();
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