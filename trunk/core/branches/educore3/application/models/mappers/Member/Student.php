<?php
/**
 * @package CORE
 *
 */
class Core_Model_Mapper_Member_Student
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Core_Model_Mapper_Member_Student
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
            $this->setDbTable('Core_Model_DbTable_StudentPersonal');
        }
        return $this->_dbTable;
    }
    /**
     * Fetches personal information of a Student
     * @param Core_Model_Member_Student $student
     */
    public function fetchStudentInfo (Core_Model_Member_Student $student)
    {
        $member_id = $student->getMember_id();
        if (empty($member_id)) {
            $error = 'Please provide a Member Id';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getAdapter();
            $stu_prs_cols = $this->getDbTable()->info('cols');
            $stu_dep_cols = array('department_id', 'programme_id', 
            'batch_start', 'group_id');
            $stu_sem_cols = array('semester_id');
            $select = $adapter->select()->from(
            $this->getDbTable()
                ->info('name'), $stu_prs_cols);
            $cond1 = 'student_personal.member_id = student_department.member_id';
            $cond2 = 'student_personal.member_id = student_semester.member_id';
            $select->joinInner('student_department', $cond1, $stu_dep_cols);
            $select->joinInner('student_semester', $cond2, $stu_sem_cols);
            $select->where('student_personal.member_id = ?', $member_id);
            $student_info = array();
            $student_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
            if (sizeof($student_info[$member_id]) == 0) {
                throw new Exception(
                'NO DATA EXISTS FOR MEMBER_ID' . $member_id . '!!');
            } else {
                return $student_info[$member_id];
            }
        }
    }
    /**
     * 
     * Enter description here ...
     * @param Core_Model_Member_Student $student
     */
    public function fetchMemberID (Core_Model_Member_Student $student)
    {
        $roll_no = $student->getRoll_no();
        $department_id = $student->getDepartment_id();
        $programme_id = $student->getProgramme_id();
        $semester_id = $student->getSemester_id();
        $adapter = $this->getDbTable()->getAdapter();
        $select = $adapter->select()
            ->from('student_semester', 'member_id')
            ->where('department_id = ?', $department_id)
            ->where('programme_id = ?', $programme_id)
            ->where('semester_id = ?', $semester_id)
            ->where('roll_no = ?', $roll_no);
        $result = $select->query()->fetchColumn();
        if (! $result) {
            throw new Exception(
            'No Member Id exists for Roll No : ' . $roll_no . '');
        } else {
            return $result;
        }
    }
    /**
     * 
     * Enter description here ...
     * @param unknown_type $student
     */
    public function fetchRollNo (Core_Model_Member_Student $student)
    {
        $member_id = $student->getMember_id();
        $department_id = $student->getDepartment_id();
        $programme_id = $student->getProgramme_id();
        $semester_id = $student->getSemester_id();
        $adapter = $this->getDbTable()->getAdapter();
        $select = $adapter->select()
            ->from('student_semester', 'roll_no')
            ->where('department_id = ?', $department_id)
            ->where('programme_id = ?', $programme_id)
            ->where('semester_id = ?', $semester_id)
            ->where('member_id = ?', $member_id);
        $result = $select->query()->fetchAll(Zend_Db::FETCH_NAMED);
        return $result[0];
    }
    /**
     * 
     * Enter description here ...
     * @param array $options
     * @param Core_Model_Member_Student $student
     */
    public function save ($options, Core_Model_Member_Student $student = null)
    {
        $save_stu_dep = $student->getSave_stu_dep();
        $save_stu_per = $student->getSave_stu_per();
        $save_student = $student->getSave_student();
        if (isset($save_stu_dep)) {
            $dbtable = new Core_Model_DbTable_StudentDepartment();
        }
        if (isset($save_stu_per)) {
            $dbtable = new Core_Model_DbTable_StudentPersonal();
        }
        if (isset($save_student)) {
            $dbtable = new Core_Model_DbTable_StudentSemester();
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
            $data[$key_name] = $student->$str();
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
     * @param Core_Model_Member_Student $student
     * @param array $property_range Example :array('name'=>array('from'=>n ,'to'=>m));
     * here 'from' stands for >= AND 'to' stands for <=
     * 
     */
    public function fetchStudents (Core_Model_Member_Student $student, 
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
        //declare table name and table columns for join statement
        $table = array('s_persnl' => $this->getDbTable()->info('name'));
        //define 
        //(a)names of tables used for 'join' operation.
        //(b)corresponding join conditions 
        $name1 = array('s_dep' => 'student_department');
        $cond1 = 's_dep.member_id = s_persnl.member_id';
        $name2 = 'casts';
        $cond2 = "s_persnl.cast_id = $name2.cast_id ";
        $name3 = 'bus';
        $cond3 = "$name3.member_id =s_persnl.member_id ";
        $name4 = array('nlty' => 'nationalities');
        $cond4 = 'nlty.nationality_id= s_persnl.nationality_id';
        $name5 = array('rel' => 'religion');
        $cond5 = 's_persnl.religion_id = rel.religion_id';
        $name6 = array('bus_st' => 'bus_stations');
        $cond6 = "$name3.boarding_station = bus_st.boarding_station";
        //1)get column names of student_department present in arguments received
        $student_department_col = array('department_id', 'programme_id', 
        'batch_start', 'group_id');
        $student_department_intrsctn = array();
        $student_department_intrsctn = array_intersect($student_department_col, 
        $merge);
        //2)get column names of casts present in arguments received
        $casts_col = array('cast');
        $casts_intrsctn = array();
        $casts_intrsctn = array_intersect($casts_col, $merge);
        //3)get column names of bus present in arguments received
        $bus_col = array('boarding_station');
        $bus_intrsctn = array();
        $bus_intrsctn = array_intersect($bus_col, $merge);
        //4)get column names of nationality present in arguments received
        $nationality_col = array('nationality');
        $nationality_intrsctn = array();
        $nationality_intrsctn = array_intersect($nationality_col, $merge);
        //5)get column names of religions present in arguments received
        $religions_col = array('religion');
        $religions_intrsctn = array();
        $religions_intrsctn = array_intersect($religions_col, $merge);
        //6)get column names of bus_stations table present in arguments received
        $bus_stations_col = array('station_name');
        $bus_stations = array();
        $bus_stations = array_intersect($bus_stations_col, $merge);
        $adapter = $this->getDbTable()->getAdapter();
        $select = $adapter->select()->from($table, 'member_id');
        if (! empty($student_department_intrsctn)) {
            $select->join($name1, $cond1, $student_department_col);
        }
        if (! empty($casts_intrsctn)) {
            $select->join($name2, $cond2, $casts_col);
        }
        if (! empty($bus_intrsctn)) {
            $select->join($name3, $cond3, $bus_col);
        }
        if (! empty($nationality_intrsctn)) {
            $select->join($name4, $cond4, $nationality_intrsctn);
        }
        if (! empty($religions_intrsctn)) {
            $select->join($name5, $cond5, $religions_col);
        }
        if (! empty($bus_stations)) {
            $select->join($name6, $cond6, $bus_stations_col);
        }
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
                $student->$getter_string();
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