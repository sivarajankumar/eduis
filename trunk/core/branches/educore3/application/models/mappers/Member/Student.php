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
            $this->setDbTable('Core_Model_DbTable_Members');
        }
        return $this->_dbTable;
    }
    /**
     * Fetches CRITICAL information of a Student
     * 
     * @param integer $member_id
     */
    public function fetchCriticalInfo ($member_id)
    {
        $adapter = $this->getDbTable()->getAdapter();
        $req_cols = array('member_id', 'member_type_id', 'first_name', 
        'last_name', 'middle_name', 'dob', 'blood_group', 'gender', 
        'religion_id', 'cast_id', 'nationality_id', 'join_date', 'relieve_date', 
        'image_no', 'is_active');
        $table_name = $this->getDbTable()->info('name');
        //
        $cast_db_table = new Core_Model_DbTable_Casts();
        $cast_table = $cast_db_table->info('name');
        $cast_cols = 'cast_name';
        //
        $religion_db_table = new Core_Model_DbTable_Religions();
        $religion_table = $religion_db_table->info('name');
        $religion_cols = 'religion_name';
        //
        $nationaities_db_table = new Core_Model_DbTable_Nationalities();
        $nationaities_table = $nationaities_db_table->info('name');
        $nationaities_cols = 'nationality_name';
        //
        $member_type_db_table = new Core_Model_DbTable_MemberType();
        $member_type_table = $member_type_db_table->info('name');
        $member_type_cols = 'member_type_name';
        //
        $cond1 = $table_name . '.cast_id=' . $cast_table . '.cast_id';
        $cond2 = $table_name . '.religion_id=' . $religion_table . '.religion_id';
        $cond3 = $table_name . '.nationality_id=' . $nationaities_table .
         '.nationality_id';
        $cond4 = $table_name . '.member_type_id=' . $member_type_table .
         '.member_type_id';
        $select = $adapter->select()
            ->from($table_name, $req_cols)
            ->joinInner($cast_table, $cond1, $cast_cols)
            ->joinInner($religion_table, $cond2, $religion_cols)
            ->joinInner($nationaities_table, $cond3, $nationaities_cols)
            ->joinInner($member_type_table, $cond4, $member_type_cols)
            ->where('member_id = ?', $member_id);
        $student_info = array();
        $student_info = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
        return $student_info[$member_id];
    }
    public function save ($prepared_data)
    {
        $dbtable = $this->getDbTable();
        try {
            $row_id = $dbtable->insert($prepared_data);
        } catch (Exception $exception) {
            throw $exception;
        }
        return mysql_insert_id();
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
        Zend_Registry::get('logger')->debug($setter_options);
        $correct_db_options = array();
        foreach ($setter_options as $k => $val) {
            $correct_db_options[$this->correctDbKeys($k)] = $val;
            $correct_db_options_keys = array_keys($correct_db_options);
        }
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
}