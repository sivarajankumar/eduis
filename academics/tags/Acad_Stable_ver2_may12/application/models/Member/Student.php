<?php
class Acad_Model_Member_Student extends Acad_Model_Member_Generic
{
    protected $_mapper;
    /**
     * Set roll number of student
     * 
     * Since roll number and member Id are same.
     * 
     * @param string|int $rollNumber Roll number
     * @return Acad_Model_Member_Student
     */
    public function setRollNumber ($rollNumber)
    {
        return self::setMemberId($rollNumber);
    }
    /**
     * Get roll number of student
     * 
     * Since roll number and member Id are same.
     * 
     * @return string|int $rollNumber Roll number
     */
    public function getRollNumber ()
    {
        return self::getMemberId();
    }
    public function getAttendence ($dateFrom = null, $dateUpto = null)
    {}
    public function setAttendence ($data)
    {
        $periodArray = array('period_date' => 0, 'department_id' => 0, 
        'programme_id' => 0, 'semester_id' => 0, 'group_id' => 0, 
        'subject_code' => 0, 'subject_mode_id' => 0, 'duration' => 0, 
        'weekday_number' => 0, 'period_number' => 0, 'period_type' => 0, 
        'faculty_id' => 0);
        $studentattArray = array_diff_key($data, $periodArray);
        $periodArray = array_diff_key($data, $studentattArray);
        try {
            Zend_Db_Table::getDefaultAdapter()->beginTransaction();
            $periodModel = new Acad_Model_DbTable_PeriodAttendance2();
            $attendance_id = $periodModel->insert($periodArray);
            $absentees = null;
            if (isset($studentattArray['absentee'])) {
                $absentees = $studentattArray['absentee'];
                unset($studentattArray['absentee']);
            } else {
                Zend_Registry::get('logger')->debug('Nobody absent in this period.');
            }
            if (count($absentees)) {
                $status = 'ABSENT';
                $sql = 'INSERT INTO `academics`.`student_attendance2`
            (`attendance_id`,
             `student_roll_no`,
             `status`) VALUES ';
                $multi = array();
                foreach ($absentees as $key => $student_roll_no) {
                    $multi[] = "($attendance_id,'$student_roll_no','$status')";
                }
                $sql .= implode(',', $multi);
                //$this->logger->debug($sql);
                $affected = Zend_Db_Table::getDefaultAdapter()->query(
                $sql);
            }
            Zend_Db_Table::getDefaultAdapter()->commit();
            return $attendance_id;
        } catch (Exception $e) {
            Zend_Registry::get('logger')->debug($e->getMessage());
            Zend_Db_Table::getDefaultAdapter()->rollBack();
            throw $e;
        }
    }
    /**
     * Set data mapper
     * 
     * @param  mixed $mapper 
     * @return Acad_Model_Student
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * Get data mapper
     *
     * Lazy loads Acad_Model_StudentMapper instance if no mapper registered.
     * 
     * @return Acad_Model_StudentMapper
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Member_StudentMapper());
        }
        return $this->_mapper;
    }
    /**
     * Save the current entry
     * 
     * @return void
     */
    public function save ()
    {
        $this->getMapper()->save($this);
    }
    /**
     * Find an entry
     *
     * Resets entry state if matching id found.
     * 
     * @param  int $id 
     * @return Acad_Model_Student
     */
    public function find ($id)
    {
        $this->getMapper()->find($id, $this);
        return $this;
    }
    /**
     * Fetch all entries
     * 
     * @return array
     */
    public function fetchAll ()
    {
        return $this->getMapper()->fetchAll();
    }
}
    