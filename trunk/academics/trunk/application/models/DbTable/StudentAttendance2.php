<?php
class Acad_Model_DbTable_StudentAttendance2 extends Acadz_Base_Model
{
    protected $_name = 'student_attendance2';
    protected $logger;
    protected $dbSelect;
    public function init ()
    {
        $this->logger = Zend_Registry::get('logger');
    }
    

    public function insert($data) {
        
        
            $this->logger->debug($data);
        /*try {
            $this->getAdapter()
                ->beginTransaction();
            
            $absentees = $data['absentee'];
            unset($data['absentee']);
            
            $this->logger->debug($data);
            //$periodModel = new Acad_Model_DbTable_PeriodAttendance();
            //$attendance_id = $periodModel->insert($data);
            
            
            $status = 'ABSENT';
            $sql = 'INSERT INTO `academics`.`student_attendance2`
            (`attendance_id`,
             `student_roll_no`,
             `status`)
VALUES +';
            $multi = array();
            foreach ($absentees as $key => $student_roll_no) {
                $multi[]= "($key,$student_roll_no,$status)";
            }
            $sql .= implode(',', $multi);
            
            $this->logger->debug($sql);
            //$affected = self::getAdapter()->query($sql)->execute();
            
            /*$this->getDbTable()
                ->getAdapter()
                ->commit();
        } catch (Exception $e) {
            $this->logger->debug($e->getMessage());
            $this->getDbTable()
                ->getAdapter()
                ->rollBack();
            throw $e;
        }*/
    }
}