<?php
class TestingController extends Zend_Controller_Action
{
    public function newAction ()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(flase);
        $obj = new Acad_Model_Course_DmcInfo();
        $obj->setDmc_id(1);
        $r = $obj->fetchDmcInfoId();
        Zend_Registry::get('logger')->debug($r);
    }
    public function newsAction ()
    {
        /**
         * to get initial backlogs set is_pass to 0
         * Enter description here ...
         * @var unknown_type
         */
        $subjects_passed_in_first_attempt = 'SELECT
                      `dmc_marks`.`student_subject_id`,
                      `student_class`.`member_id`
                    FROM `academics`.`batch`
                      INNER JOIN `academics`.`class`
                        ON (`batch`.`batch_id` = `class`.`batch_id`)
                      INNER JOIN `academics`.`student_class`
                        ON (`class`.`class_id` = `student_class`.`class_id`)
                      INNER JOIN `academics`.`dmc_info`
                        ON (`dmc_info`.`member_id` = `student_class`.`member_id`)
                          AND (`dmc_info`.`class_id` = `student_class`.`class_id`)
                      INNER JOIN `academics`.`result_type`
                        ON (`dmc_info`.`result_type_id` = `result_type`.`result_type_id`)
                      INNER JOIN `academics`.`dmc_marks`
                        ON (`dmc_marks`.`dmc_info_id` = `dmc_info`.`dmc_info_id`)
                    WHERE (`batch`.`department_id` = ?
                           AND `batch`.`programme_id` = ?
                           AND `batch`.`batch_start` = ?
                           AND `dmc_marks`.`is_pass` = ?
                           AND `result_type`.`result_type_name` = ?)';
        /********************************************************************************/
        $subjects_failing_currently = 'SELECT
                      `dmc_marks`.`student_subject_id`,
                      `student_class`.`member_id`
                    FROM `academics`.`batch`
                      INNER JOIN `academics`.`class`
                        ON (`batch`.`batch_id` = `class`.`batch_id`)
                      INNER JOIN `academics`.`student_class`
                        ON (`class`.`class_id` = `student_class`.`class_id`)
                      INNER JOIN `academics`.`dmc_info`
                        ON (`dmc_info`.`member_id` = `student_class`.`member_id`)
                          AND (`dmc_info`.`class_id` = `student_class`.`class_id`)
                      INNER JOIN `academics`.`result_type`
                        ON (`dmc_info`.`result_type_id` = `result_type`.`result_type_id`)
                      INNER JOIN `academics`.`dmc_marks`
                        ON (`dmc_marks`.`dmc_info_id` = `dmc_info`.`dmc_info_id`)
                    WHERE (`batch`.`department_id` = ?
                           AND `batch`.`programme_id` = ?
                           AND `batch`.`batch_start` = ?
                           AND `dmc_marks`.`is_pass` = ?
                           AND `result_type`.`result_type_name` = ?)';
        $bind = array('CSE', 'BTECH', 2005, 1, 'regular_fail');
        /*******************************************************************************/
        /**
         * 
         * backlogs=0 calculator.
         * @var string
         */
        $semester_passed_in_first_attempt = 'SELECT
  `dmc_marks`.`student_subject_id`,
  `student_class`.`member_id`
FROM `academics`.`batch`
  INNER JOIN `academics`.`class`
    ON (`batch`.`batch_id` = `class`.`batch_id`)
  INNER JOIN `academics`.`student_class`
    ON (`class`.`class_id` = `student_class`.`class_id`)
  INNER JOIN `academics`.`dmc_info`
    ON (`dmc_info`.`member_id` = `student_class`.`member_id`)
      AND (`dmc_info`.`class_id` = `student_class`.`class_id`)';
        $semester_passed_in_first_attempt = $semester_passed_in_first_attempt . 'INNER JOIN `academics`.`result_type`
    ON (`dmc_info`.`result_type_id` = `result_type`.`result_type_id`)
  INNER JOIN `academics`.`dmc_marks`
    ON (`dmc_marks`.`dmc_info_id` = `dmc_info`.`dmc_info_id`)
WHERE (`batch`.`department_id` = ?
       AND `batch`.`programme_id` = ?
       AND `batch`.`batch_start` = ?
       AND `result_type`.`result_type_name` = ?)';
        $bind2 = array('CSE', 'BTECH', 2005, 'regular_pass');
        /********************************************************************************/
        $all_batch_dep_students = 'SELECT
    `student_class`.`member_id`
FROM
    `academics`.`batch`
    INNER JOIN `academics`.`class` 
        ON (`batch`.`batch_id` = `class`.`batch_id`)
    INNER JOIN `academics`.`student_class` 
        ON (`class`.`class_id` = `student_class`.`class_id`)
WHERE (`batch`.`department_id` =?
    AND `batch`.`programme_id` =?
    AND `batch`.`batch_start` =?)';
        $bind3 = array('CSE', 'BTECH', 2005);
    /********************************************************************************/
    }
    public function paramcheckAction ()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $member_ids = array(3, 4);
        $student = new Acad_Model_Member_Student();
        $latst_cls_dmc_info_ids = array();
        /**
         * calculate students's latest dmc_info_id for each class
         * which willbe referred to find out backlogs
         */
        foreach ($member_ids as $member_id) {
            $student->setMember_id($member_id);
            $class_ids = $student->fetchAllClassIds();
            foreach ($class_ids as $class_id) {
                $dmc_info_ids = $this->fetchMemberDmcInfoIds($member_id, 
                $class_id);
                $order_reversed = array_reverse($dmc_info_ids, true);
                $single_latest = array_pop($order_reversed);
                $latst_cls_dmc_info_ids[$member_id][$class_id] = array_search(
                $single_latest, $dmc_info_ids);
            }
        }
        $dmc_info_id_referred = array();
        foreach ($latst_cls_dmc_info_ids as $member_id => $class_dmc_info_id_array) {
            $dmc_info_id_referred = array_merge($dmc_info_id_referred, 
            array_values($class_dmc_info_id_array));
        }
        $fail_subj_sql = 'SELECT `dmc_info`.`member_id`,
        						`dmc_marks`.`student_subject_id`
        FROM
        `academics`.`dmc_marks`
        INNER JOIN `academics`.`dmc_info`
        ON (`dmc_marks`.`dmc_info_id` = `dmc_info`.`dmc_info_id`)
        WHERE (`dmc_info`.`dmc_info_id` = ?
        AND `dmc_marks`.`is_pass` = ?)';
        $db = new Zend_Db_Table();
        $adapter = $db->getAdapter();
        $backlog_list = array();
        foreach ($dmc_info_id_referred as $dmc_info_id) {
            $bind = array($dmc_info_id, 0);
            $r = $adapter->query($fail_subj_sql, $bind)->fetchAll();
            if (! empty($r)) {
                foreach ($r as $k => $v) {
                    $backlog_list[$v['member_id']][] = $v['student_subject_id'];
                }
            }
        }
        /*
         * backlog counter
         * count($stsb) represents backlogs
         */
        $backlogs = array();
        foreach ($backlog_list as $member_id => $backlog_array) {
            $backlogs[$member_id] = count($backlog_array);
        }
        Zend_Registry::get('logger')->debug($backlogs);
    }
    private function fetchMemberDmcInfoIds ($member_id, $class_id)
    {
        $dmc_info = new Acad_Model_Course_DmcInfo();
        $dmc_info->setMember_id($member_id);
        $dmc_info->setClass_id($class_id);
        $dmc_info_ids = $dmc_info->fetchMemberDmcInfoIds(true, null, null, null, 
        true);
        return $dmc_info_ids;
    }
    public function abcAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $member_ids = array(3, 4);
        $mem_backlogds = array();
        $student = new Acad_Model_Member_Student();
        foreach ($member_ids as $member_id) {
            $student->setMember_id($member_id);
            $mem_backlogds[$member_id] = $student->fetchCurrentBacklogCount();
        }
        $t = $student->fetchNeverBacklogStudents();
        Zend_Registry::get('logger')->debug($mem_backlogds);
        Zend_Registry::get('logger')->debug($t);
    }
    public function studentInfoAction ($info_required)
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $params = $this->getRequest()->getParams();
        $member_id = $params['member_id']; // Can be Extracted from Session also
        /**
         * 
         * All params are conditionally set depending on their status
         *
         */
        $department_id = $params['department_id'];
        $programme_id = $params['programme_id'];
        $semester_id = $params['semester_id'];
        $class_id = $params['class_id'];
        $dmc_info_id = $params['dmc_info_id'];
        $student_subject_id = $params['student_subject_id'];
        //
        $student_object = new Acad_Model_Member_Student();
        $student_object->setMember_id($member_id);
        /*
         *  Format for $all_dmc_info_ids = array('dmc_info_id'=>1234,' 'class_id'=>123, 'dmc_id'=>567,
         *  'result_type_id'=1)
         */
        switch ($info_required) {
            case 'batch_id':
                $batch_id = $student_object->fetchBatchId();
                return $batch_id;
                break;
            case 'dmc_info_ids':
                $all_dmc_info_ids = $student_object->fetchClassDmcInfoIds(null, 
                null, true);
                return $all_dmc_info_ids;
                break;
            case 'current_class_id':
                $current_class_id = $student_object->fetchClassId(null, true);
                return $current_class_id;
                break;
            case 'all_class_ids':
                $class_ids = $student_object->fetchClassId(null, null, true);
                return $class_ids;
                break;
            case 'class_info':
                $class_object = new Acad_Model_Class();
                $class_object->setClass_id($class_id);
                $class_object->fetchInfo();
                $info = array();
                // get all info you want
                return $info;
                break;
            case 'subjects':
                $subjects = array();
                $subjects = $student_object->fetchClassSubjects($class_id);
                return $subjects;
                break;
            case 'dmc_data':
                $dmc_data = array();
                $dmc_data = $student_object->fetchDmc($dmc_info_id, 
                $student_subject_id);
                return $subjects;
                break;
            default:
                ;
                break;
        }
    }
    public function testAction ()
    {
        /* $request = $this->getRequest();
        $format = $request->getParam('format', 'json');
        $this->_helper->json($candidates, false);*/
    //$student = new Acad_Model_Qualification();
    /*$data_array = array('member_id' => 1, 'member_type_id' => 1, 
        'first_name' => 'AMRIT', 'last_name' => 'SINGH', 'dob' => '1990-05-09', 
        'blood_group' => 'B-', 'gender' => 'MALE', 'religion_id' => 1, 
        'cast_id' => 1, 'nationality_id' => 1, 'join_date' => '2008-08-28', 
        'relieve_date' => '2012-08-28', 'image_no' => 12245, 'is_active' => 1);
        $student->initSave();
        $student->saveCriticalInfo($data_array);*/
    //$student->setQualification_id(1);
    /* $c = $student->fetchCriticalInfo();
        $info = array();
        if ($c) {
            $props = $student->getAllowedProperties();
            foreach ($props as $prop) {
                $getter_string = 'get' . ucfirst($prop);
                $info[$prop] = $student->$getter_string();
            }
        }*/
    /*  $q = $student->fetchInfo();
        Zend_Registry::get('logger')->debug($q);
        if ($q) {
            Zend_Registry::get('logger')->debug(
            $student->getQualification_name());
        }*/
    /*$re = new Acad_Model_StudentSubject();
        $rt = $re->fetchResultTypes();
        Zend_Registry::get('logger')->debug($rt);*/
    /* $name = 'Amrit';
        $this->disName();*/
    /* $obj = new Acad_Model_Member_Student();
        $obj->setMember_id(1);
        $p = $obj->fetchDmcInfoIds(1);
         Zend_Registry::get('logger')->debug($p);*/
    /*$params = $this->getRequest()->getParams();
        Zend_Registry::get('logger')->debug($params);*/
    }
}

