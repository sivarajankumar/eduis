<?php
class Acad_Model_Mapper_Exam_Competitive
{
    protected $_competitive_exam_cols = array('exam_id', 'name', 'abbr');
    protected $_student_competitive_exam_cols = array('member_id', 'exam_id', 
    'oll_no', 'date', 'total_score', 'all_india_rank');
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * @return the $_competitive_exam_cols
     */
    protected function getCompetitive_exam_cols ()
    {
        return $this->_competitive_exam_cols;
    }
    /**
     * @return the $_student_competitive_exam_cols
     */
    protected function getStudent_competitive_exam_cols ()
    {
        return $this->_student_competitive_exam_cols;
    }
    /**
     * @return the $_competitive_cols
     */
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
            $this->setDbTable('Acad_Model_DbTable_Competitive');
        }
        return $this->_dbTable;
    }
    /**
     * fetches member's Competitive Exam details
     *
     *@param Acad_Model_Exam_Competitive $competitiveExam
     */
    public function fetchMemberExamInfo (
    Acad_Model_Exam_Competitive $competitiveExam)
    {
        $member_id = $competitiveExam->getMember_id();
        $adapter = $this->getDbTable()->getAdapter();
        $student_competitive_exam_fields = $this->getStudent_competitive_exam_cols();
        $table = $this->getDbTable()->info('name');
        $select = $adapter->select()
            ->from($table, $student_competitive_exam_fields)
            ->where('member_id = ?', $member_id);
        $competitive_exam_info = $select->query()->fetchAll(
        Zend_Db::FETCH_UNIQUE);
        return $competitive_exam_info[$member_id];
    }
    /**
     * fetches Competitive Exam details
     *
     *@param Acad_Model_Exam_Competitive $competitiveExam
     */
    public function fetchExamInfo (Acad_Model_Exam_Competitive $competitiveExam)
    {
        $exam_id = $competitiveExam->getExam_id();
        $adapter = $this->getDbTable()->getAdapter();
        $competitive_exam_fields = $this->getCompetitive_exam_cols();
        $select = $adapter->select()
            ->from('competitive_exam', $competitive_exam_fields)
            ->where('exam_id = ?', $exam_id);
        $competitive_exam_info = $select->query()->fetchAll(
        Zend_Db::FETCH_UNIQUE);
        return $competitive_exam_info[$exam_id];
    }
    /**
     * 
     * Enter description here ...
     * @param array $options
     * @param Acad_Model_Exam_Competitive $competitiveExam
     */
    public function save ($options, 
    Acad_Model_Exam_Competitive $competitiveExam = null)
    {
        $dbtable = $this->getDbTable();
        $cols = $this->getStudent_competitive_exam_cols();
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
            $data[$key_name] = $competitiveExam->$str();
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
     * Enter description here ...
     * @param Acad_Model_Exam_Competitive $competitiveExam
     * @param array $property_range Example :array('name'=>array('from'=>n ,'to'=>m));
     * here 'from' stands for >= AND 'to' stands for <=
     * 
     */
    public function fetchStudents (Acad_Model_Exam_Competitive $competitiveExam, 
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
        $table = $this->getDbTable()->info('name');
        //1)get column names of tenth present in arguments received
        $tenth_col = $this->getDbTable()->info('cols');
        $tenth_intrsctn = array();
        $tenth_intrsctn = array_intersect($tenth_col, $merge);
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
                $aisse->$getter_string();
                $condition = $property_name . ' = ?';
                $select->where($condition, $value);
            }
        }
        $result = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        if (! count($result)) {
            $search_error = 'No results match your search criteria.';
            throw new Exception($search_error, Zend_Log::WARN);
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