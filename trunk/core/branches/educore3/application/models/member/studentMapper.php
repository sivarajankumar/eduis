<?php
class Core_Model_Member_StudentMapper
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Core_Model_Member_StudentMapper
     */
    public function setDbTable (Zend_Db_Table_Abstract $dbTable)
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
        $select = $adapter->select()
            ->from($this->getDbTable()
            ->info('NAME'))
            ->where('member_id = ?', $member_id);
        $fetchall = $adapter->fetchAll($select);
        $result = array();
        foreach ($fetchall as $row) {
            foreach ($row as $columnName => $columnValue) {
                $result[$columnName] = $columnValue;
            }
        }
        return $result;
    }
    /**
     * Enter description here ...
     * @param Core_Model_Member_Student $searchParams
     */
    public function fetchStudents (Core_Model_Member_Student $searchParams)
    {
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $select = $adapter->select()->from(($this->getDbTable()
            ->info('NAME')), 'member_id');
        // if model were to contain cast_name we would use
        // join in the if statement        
        if (isset($searchParams->getReg_no())) {
            $select->where('regn_no = ?', $searchParams->getReg_no());
        }
        if (isset($searchParams->getCast_id())) {
            $select->where('cast_id = ?', $searchParams->getCast_id());
        }
        if (isset($searchParams->getBlood_group_id())) {
            $select->where('blood_group_id = ?', 
            $searchParams->getBlood_group_id());
        }
        if (isset($searchParams->getNationality_id())) {
            $select->where('nationality_id = ?', 
            $searchParams->getNationality_id());
        }
        if (isset($searchParams->getReligion_id())) {
            $select->where('religion_id= ?', $searchParams->getReligion_id());
        }
        /*if (isset($searchParams->getStudent_roll_no())) {
            $select->where('student_roll_no = ?', 
            $searchParams->getStudent_roll_no());
        }*/
        if (isset($searchParams->getFirst_name())) {
            $select->where('first_name = ?', $searchParams->getFirst_name());
        }
        if (isset($searchParams->getMiddle_name())) {
            $select->where('middle_name = ?', $searchParams->getMiddle_name());
        }
        if (isset($searchParams->getLast_name())) {
            $select->where('last_name= ?', $searchParams->getLast_name());
        }
        if (isset($searchParams->getDob())) {
            $select->where('dob = ?', $searchParams->getDob());
        }
        if (isset($searchParams->getGender())) {
            $select->where('gender = ?', $searchParams->getGender());
        }
        if (isset($searchParams->getContact_no())) {
            $select->where('contact_no = ?', $searchParams->getContact_no());
        }
        if (isset($searchParams->getE_mail())) {
            $select->where('e_mail= ?', $searchParams->getE_mail());
        }
        if (isset($searchParams->getMarital_status())) {
            $select->where('marital_status = ?', 
            $searchParams->getMarital_status());
        }
        if (isset($searchParams->getCouncelling_no())) {
            $select->where('councelling_no = ?', 
            $searchParams->getCouncelling_no());
        }
        if (isset($searchParams->getAdmission_date())) {
            $select->where('admission_date = ?', 
            $searchParams->getAdmission_date());
        }
        if (isset($searchParams->getAlloted_category())) {
            $select->where('alloted_category = ?', 
            $searchParams->getAlloted_category());
        }
        if (isset($searchParams->getAlloted_branch())) {
            $select->where('alloted_branch = ?', 
            $searchParams->getAlloted_branch());
        }
        if (isset($searchParams->getState_of_domicile())) {
            $select->where('state_of_domicile = ?', 
            $searchParams->getState_of_domicile());
        }
        if (isset($searchParams->getUrban())) {
            $select->where('urban= ?', $searchParams->getUrban());
        }
        if (isset($searchParams->getHostel())) {
            $select->where('hostel= ?', $searchParams->getHostel());
        }
        if (isset($searchParams->getBus())) {
            $select->where('bus= ?', $searchParams->getBus());
        }
        if (isset($searchParams->getImage_no())) {
            $select->where('image_no = ?', $searchParams->getImage_no());
        }
        return $select->query()->fetchColumn();
    }
}