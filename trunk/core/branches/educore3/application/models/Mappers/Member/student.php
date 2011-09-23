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
     * fetches information of a student
     *@param Core_Model_Member_Student $student
     */
    public function fetchStudentInfo (Core_Model_Member_Student $student)
    {
        $member_id = $student->getMember_id();
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $sql = 'SELECT
    `student_personal`.`reg_no`
    , `student_personal`.`cast_id`
    , `student_personal`.`nationality_id`
    , `student_personal`.`religion_id`
    , `student_personal`.`first_name`
    , `student_personal`.`middle_name`
    , `student_personal`.`last_name`
    , `student_personal`.`dob`
    , `student_personal`.`gender`
    , `student_personal`.`contact_no`
    , `student_personal`.`e_mail`
    , `student_personal`.`marital_status`
    , `student_personal`.`councelling_no`
    , `student_personal`.`admission_date`
    , `student_personal`.`alloted_category`
    , `student_personal`.`alloted_branch`
    , `student_personal`.`state_of_domicile`
    , `student_personal`.`urban`
    , `student_personal`.`hostel`
    , `student_personal`.`bus`
    , `student_personal`.`image_no`
    , `student_personal`.`blood_group`
    , `student_department`.`department_id`
    , `student_department`.`prgramme_id`
    , `student_department`.`batch_start`
    , `student_department`.`group_id`
    , `student_semester`.`semster_id`
    , `student_personal`.`member_id`
FROM
    `core`.`student_department`
    INNER JOIN `core`.`student_personal` 
        ON (`student_department`.`member_id` = `student_personal`.`member_id`)
    INNER JOIN `core`.`student_semester` 
        ON (`student_semester`.`member_id` = `student_department`.`member_id`)
WHERE (`student_personal`.`member_id` = ?)';
        $bind[] = $member_id;
        $fetchall = $adapter->query($sql, $bind)->fetchAll();
        $result = array();
        foreach ($fetchall as $row) {
            foreach ($row as $columnName => $columnValue) {
                $result[$columnName] = $columnValue;
            }
        }
        return $result;
    }
    /**
     * @todo when rollNOs are not unique additional params like programme semester must be set.
     * fetches memberId of a student
     *@param Core_Model_Member_Student $student
     */
    public function fetchMember_id (Core_Model_Member_Student $student)
    {
        $roll_no = $student->getStudent_roll_no();
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $select = $adapter->select()
            ->from('student_semester', 'member_id')
            ->where('roll_no = ?', $roll_no);
        return $select->query()->fetchColumn();
    }
    /**
     *fetches Roll Number of a student
     *@param Core_Model_Member_Student $student
     */
    public function fetchStudent_roll_no (Core_Model_Member_Student $student)
    {
        $memberId = $student->getMember_id();
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $select = $adapter->select()
            ->from('student_semester', 'roll_no')
            ->where('member_id = ?', $memberId);
        return $select->query()->fetchColumn();
    }
    /**
     * Enter description here ...
     * @param Core_Model_Member_Student $student
     */
    public function fetchStudents (Core_Model_Member_Student $student)
    {
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $select = $adapter->select()->from(
        ($this->getDbTable()
            ->info('NAME')), 'member_id');
        $reg_no = $student->getReg_no();
        $cast_id = $student->getCast_id();
        $blood_group_id = $student->getBlood_group_id();
        $nationality_id = $student->getBlood_group_id();
        $religion_id = $student->getReligion_id();
        $first_name = $student->getFirst_name();
        $first_name = $student->getFirst_name();
        $middle_name = $student->getMiddle_name();
        $last_name = $student->getLast_name();
        $dob = $student->getDob();
        $gender = $student->getGender();
        $contact_no = $student->getContact_no();
        $email_id = $student->getE_mail();
        $marrital_status = $student->getMarital_status();
        $councelling_no = $student->getCouncelling_no();
        $admission_date = $student->getAdmission_date();
        $alloted_category = $student->getAlloted_category();
        $alloted_branch = $student->getAlloted_branch();
        $state_of_domicile = $student->getState_of_domicile();
        $urban = $student->getUrban();
        $hostel = $student->getHostel();
        $bus = $student->getHostel();
        $image_no = $student->getImage_no();
        if (isset($reg_no)) {
            $select->where('regn_no = ?', $reg_no);
        }
        if (isset($cast_id)) {
            $select->where('cast_id = ?', $cast_id);
        }
        if (isset($blood_group_id)) {
            $select->where('blood_group_id = ?', $blood_group_id);
        }
        if (isset($nationality_id)) {
            $select->where('nationality_id = ?', $nationality_id);
        }
        if (isset($religion_id)) {
            $select->where('religion_id= ?', $religion_id);
        }
        if (isset($first_name)) {
            $select->where('first_name = ?', $first_name);
        }
        if (isset($middle_name)) {
            $select->where('middle_name = ?', $middle_name);
        }
        if (isset($last_name)) {
            $select->where('last_name= ?', $last_name);
        }
        if (isset($dob)) {
            $select->where('dob = ?', $dob);
        }
        if (isset($gender)) {
            $select->where('gender = ?', $gender);
        }
        if (isset($contact_no)) {
            $select->where('contact_no = ?', $contact_no);
        }
        if (isset($email_id)) {
            $select->where('e_mail= ?', $email_id);
        }
        if (isset($marrital_status)) {
            $select->where('marital_status = ?', $marrital_status);
        }
        if (isset($councelling_no)) {
            $select->where('councelling_no = ?', $councelling_no);
        }
        if (isset($admission_date)) {
            $select->where('admission_date = ?', $admission_date);
        }
        if (isset($alloted_category)) {
            $select->where('alloted_category = ?', $alloted_category);
        }
        if (isset($alloted_branch)) {
            $select->where('alloted_branch = ?', $alloted_branch);
        }
        if (isset($state_of_domicile)) {
            $select->where('state_of_domicile = ?', $state_of_domicile);
        }
        if (isset($urban)) {
            $select->where('urban= ?', $urban);
        }
        if (isset($hostel)) {
            $select->where('hostel= ?', $hostel);
        }
        if (isset($bus)) {
            $select->where('bus= ?', $bus);
        }
        if (isset($image_no)) {
            $select->where('image_no = ?', $image_no);
        }
        return $select->query()->fetchColumn();
    }
}