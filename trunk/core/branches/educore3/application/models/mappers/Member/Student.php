<?php
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
            $student->$getter_string();
            $condition = $property_name . ' = ?';
            $select->where($condition, $value);
        }
        return $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
    }
}