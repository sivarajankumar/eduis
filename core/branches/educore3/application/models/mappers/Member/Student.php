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
     * 
     * @todo
     */
    public function save ()
    {}
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
            $sql = 'SELECT
        `student_personal`.`member_id`,`student_personal`.`reg_no`, `student_personal`.`cast_id`, `student_personal`.`nationality_id`
    , `student_personal`.`religion_id`, `student_personal`.`first_name`, `student_personal`.`middle_name`
    , `student_personal`.`last_name`, `student_personal`.`dob`, `student_personal`.`gender`
    , `student_personal`.`contact_no`, `student_personal`.`e_mail`, `student_personal`.`marital_status`
    , `student_personal`.`councelling_no`, `student_personal`.`admission_date`
    , `student_personal`.`alloted_category`, `student_personal`.`alloted_branch`, `student_personal`.`state_of_domicile`
    , `student_personal`.`urban`, `student_personal`.`hostel`, `student_personal`.`bus`
    , `student_personal`.`image_no`, `student_personal`.`blood_group`, `student_department`.`department_id`
    , `student_department`.`prgramme_id`, `student_department`.`batch_start`, `student_department`.`group_id`
    , `student_semester`.`semster_id`
    FROM
    `core`.`student_department`
    INNER JOIN `core`.`student_personal`
    ON (`student_department`.`member_id` = `student_personal`.`member_id`)
    INNER JOIN `core`.`student_semester`
    ON (`student_semester`.`member_id` = `student_department`.`member_id`)
    WHERE (`student_personal`.`member_id` = ?)';
            $bind[] = $member_id;
            $student_info = array();
            $student_info = $adapter->query($sql, $bind)->fetchAll(
            Zend_Db::FETCH_UNIQUE);
            return $student_info[$member_id];
        }
    }
    /**
     * @todo when rollNOs are not unique additional params like programme semester must be set.
     * fetches memberId of a student
     *@param Core_Model_Member_Student $student
     */
    public function fetchMember_id (Core_Model_Member_Student $student)
    {
        $roll_no = $student->getStudent_roll_no();
        if (empty($roll_no)) {
            $error = 'Please provide a Roll No';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $select = $adapter->select()
                ->from('student_semester', 'member_id')
                ->where('roll_no = ?', $roll_no);
            return $select->query()->fetchColumn();
        }
    }
    /**
     *fetches Roll Number of a student
     *@param Core_Model_Member_Student $student
     */
    public function fetchStudent_roll_no (Core_Model_Member_Student $student)
    {
        $memberId = $student->getMember_id();
        if (empty($memberId)) {
            $error = 'Please provide a Memmber Id ';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $select = $adapter->select()
                ->from('student_semester', 'roll_no')
                ->where('member_id = ?', $memberId);
            return $select->query()->fetchColumn();
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
        $student_department_col = array('department_id', 'prgramme_id', 
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
            case 'nationalit':
                return 'nationality';
                break;
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
            case 'nationality':
                return 'nationalit';
                break;
            default:
                return $key;
                break;
        }
    }
}