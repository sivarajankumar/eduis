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
    public function insert ($data)
    {
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
    
    public function stats ($department = NULL, $programme = NULL, $semester = NULL, 
    $group = NULL, $subject_code = NULL, $subject_mode = NULL, $date_from = NULL, 
    $date_upto = NULL, $showSubjectName = NULL,array $order = NULL)
    {
        $select = $this->getAdapter()->select();
        $select->from(array('patt'=>'period_attendance2'), array());
        if (isset($department)) {
            $select->where('department_id = ?', $department);
        } else {
            $select->columns('department_id');
        }
        if (isset($programme)) {
            $select->where('programme_id = ?', $programme);
        } else {
            $select->columns('programme_id');
        }
        if (isset($semester)) {
            $select->where('semester_id = ?', $semester);
        } else {
            $select->columns('semester_id');
        }
        if (isset($group)) {
            $select->where('group_id = ?', $group);
        } else {
            $select->columns('group_id');
        }
        if (isset($subject_code)) {
            $select->where('subject_code = ?', $subject_code);
        } else {
            $select->columns('subject_code');
        }
        if (isset($subject_mode)) {
            $select->where('subject_mode_id = ?', $subject_mode);
        } else {
            $select->columns('subject_mode_id');
        }
        if (isset($date_from)) {
            $select->where('period_date >= ?', $date_from);
        }
        if (isset($date_upto)) {
            $select->where('period_date <= ?', $date_upto);
        }
        
        if (isset($showSubjectName)) {
            $select->join('subject', '`patt`.`subject_code` = `subject`.`subject_code`',array('subject_name'));
        }
        $select->columns(array('faculty_id', 
                            'last_period_date' => 'MAX(`patt`.`period_date`)',
                            'last_updated' => 'MAX(`patt`.`marked_date`)',
                            'delivered' => 'COUNT(`patt`.`attendance_id`)', 
                            'total_duration' => 'SUM(`patt`.`duration`)'))
                ->group(array('department_id',
                            'programme_id',
                            'semester_id',
                            'group_id',
                            'patt.subject_code',
                            'subject_mode_id'));
                
         if (!empty($order)) {
             $select->order($order);
         }
        
        return $select->query()->fetchAll(Zend_Db::FETCH_GROUP);
    }
    
    public function departmentwise($department= NULL,$programme=NULL, $date_from = NULL, 
    $date_upto = NULL) {
        $order = array('semester_id','subject_mode_id', 'subject_code','group_id');
        $rawResult = self::stats($department,$programme,null,null,null,null,$date_from,$date_upto,true,$order);
        $processed = array();
        foreach ($rawResult as $semester_id => $attendanceList) {
            foreach ($attendanceList as $key => $attendance) {
                
                $subjectCode = $attendance['subject_code'];
                $subjectMode = $attendance['subject_mode_id'];
                $group_id = $attendance['group_id'];
                
                unset($attendance['subject_code']);
                unset($attendance['subject_mode_id']);
                unset($attendance['group_id']);
                
                $processed[$semester_id][$subjectMode][$subjectCode][$group_id][] = $attendance;
            }
            
        }
        return $processed;
    }
}