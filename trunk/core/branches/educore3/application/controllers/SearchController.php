<?php
class SearchController extends Zend_Controller_Action
{
    public function init ()
    {
        /* Initialize action controller here */
    }
    public function indexAction ()
    {
        // action body
    }
    public function testAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $programme = array('BTECH');
        $departments = array('CSE', 'BT', 'ECE', 'MECH');
        $batch_number = 0;
        $is_active = 0;
        $db = new Zend_Db_Table();
        $trunc_batch = 'TRUNCATE TABLE `core`.`batch`';
        $db->getAdapter()->query($trunc_batch);
        Zend_Registry::get('logger')->debug('Trnucated batch table : ');
        $sql = 'INSERT INTO `core`.`batch`(`department_id`,`programme_id`,`batch_start`,`batch_number`,`is_active`) VALUES (?,?,?,?,?)';
        for ($batch_start = 2002; $batch_start < 2013; $batch_start ++) {
            $batch_number += 1;
            if ($batch_start > 2008) {
                $is_active = 1;
            }
            foreach ($departments as $departments_id) {
                foreach ($programme as $programme_id) {
                    $bind = array($departments_id, $programme_id, $batch_start, 
                    $batch_number, $is_active);
                    $db->getAdapter()->query($sql, $bind);
                }
            }
        }
        Zend_Registry::get('logger')->debug('Batches Added : ');
        Zend_Registry::get('logger')->debug($batch_number);
        $trunc_class = 'TRUNCATE TABLE `core`.`class`';
        $db->getAdapter()->query($trunc_class);
        Zend_Registry::get('logger')->debug('Trnucated Class table : ');
        $get_batch_ids = 'SELECT `batch_id`,`department_id`,`is_active` FROM `core`.`batch` ORDER BY `batch_id`';
        $bat_dep = array();
        $bat_dep = $db->getAdapter()
            ->query($get_batch_ids)
            ->fetchAll(Zend_Db::FETCH_UNIQUE);
        Zend_Registry::get('logger')->debug($bat_dep);
        $class_insert = 'INSERT INTO `core`.`class`(`batch_id`,`handled_by_dept`,`semester_id`,`semester_type`,`is_active`) VALUES (?,?,?,?,?)';
        foreach ($bat_dep as $batch_id => $info) {
            for ($semester = 1; $semester < 9; $semester ++) {
                if (is_int(($semester / 2))) {
                    $semester_type = 'EVEN';
                } else {
                    $semester_type = 'ODD';
                }
                $bind = array($batch_id, $info['department_id'], $semester, 
                $semester_type, $info['is_active']);
                $db->getAdapter()->query($class_insert, $bind);
            }
        }
    }
    public function searchAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'log');
        $critical_fields = array();
        $rel_fields = array();
        Zend_Registry::get('logger')->debug($params);
        foreach ($params as $key => $value) {
            switch (substr($key, 0, 1)) {
                case ('0'):
                    $critical_key = substr($key, 1);
                    $critical_fields[$critical_key] = $params[$key];
                    break;
                case ('1'):
                    $rel_key = substr($key, 1);
                    $rel_fields[$rel_key] = $params[$key];
                    break;
                default:
                    throw new Exception('invalid params');
                    break;
            }
        }
        /* -------------------------------------- */
        $member_ids = array();
        if (! empty($critical_fields)) {
            $critical_range_fields = array('dob' => '');
            $critical_range_params = array_intersect_key($critical_fields, 
            $critical_range_fields);
            $critical_exact_params = array_diff_key($critical_fields, 
            $critical_range_params);
            $student = new Core_Model_Member_Student();
            $personal_matches = $student->search($critical_exact_params, 
            $critical_range_params);
            Zend_Registry::get('logger')->debug($personal_matches);
        }
        if (! empty($rel_fields)) {
            $rel_range_fields = array('annual_income' => '');
            $rel_range_params = array_intersect_key($rel_fields, 
            $rel_range_fields);
            $rel_exact_params = array_diff_key($rel_fields, $rel_range_params);
            $relatives = new Core_Model_MemberRelatives();
            $rel_matches = $relatives->search($rel_exact_params, 
            $rel_range_params);
        }
        if (! empty($personal_matches)) {
            $member_ids = array_merge($member_ids, $personal_matches);
        }
        if (! empty($rel_matches)) {
            $member_ids = array_merge($member_ids, $rel_matches);
        }
        if (empty($member_ids)) {
            $member_ids = false;
        }
        $member_ids = array_unique($member_ids);
        switch ($format) {
            case 'html':
                $this->view->assign('response', $member_ids);
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($member_ids, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($member_ids);
                break;
            case 'log':
                Zend_Registry::get('logger')->debug($member_ids);
                break;
            default:
                ;
                break;
        }
    }
}

