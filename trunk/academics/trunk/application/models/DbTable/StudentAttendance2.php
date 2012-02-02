<?php
class Acad_Model_DbTable_StudentAttendance2 extends Acadz_Base_Model_Dbtable
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
        $select->from(array('patt'=>'period_attendance2'), array('department_id',
        															'programme_id',
                                                                    'semester_id'));
        if (isset($department)) {
            $select->where('department_id = ?', $department);
        }
        if (isset($programme)) {
            $select->where('programme_id = ?', $programme);
        }
        if (isset($semester)) {
            $select->where('semester_id = ?', $semester);
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
            $date = new Zend_Date($date_from);
            $select->where('period_date >= ?', $date->get(Zend_Date::ISO_8601));
        }
        if (isset($date_upto)) {
            $date = new Zend_Date($date_upto);
            $select->where('period_date <= ?', $date->get(Zend_Date::ISO_8601));
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
}