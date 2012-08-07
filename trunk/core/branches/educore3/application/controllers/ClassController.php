<?php
class ClassController extends Zend_Controller_Action
{
    public function init ()
    {}
    public function indexAction ()
    {}
    /**
     * Fetches information about a class on the basis of Class_id
     * 
     * @param int $class_id
     */
    private function getClassInfo ($class_id)
    {
        $class = new Core_Model_Class();
        $class->setClass_id($class_id);
        $info = $class->fetchInfo();
        if ($info instanceof Core_Model_Class) {
            $class_info = array();
            $class_info['class_id'] = $info->getClass_id();
            $class_info['batch_id'] = $info->getBatch_id();
            $class_info['semester_id'] = $info->getSemester_id();
            $class_info['semester_type'] = $info->getSemester_type();
            $class_info['semester_duration'] = $info->getSemester_duration();
            $class_info['handled_by_dept'] = $info->getHandled_by_dept();
            $class_info['start_date'] = $info->getStart_date();
            $class_info['completion_date'] = $info->getCompletion_date();
            $class_info['is_active'] = $info->getIs_active();
            return $class_info;
        } else {
            return false;
        }
    }
    /**
     * fetches $class_id on the basis of class info given
     * Enter description here ...
     * @param int $batch_id
     * @param int $semester_id
     * @param bool $is_active
     */
    private function getClassIds ($batch_id = null, $semester_id = null, 
    $is_active = null)
    {
        $batch_id_basis = null;
        $semester_id_basis = null;
        $is_active_basis = null;
        $class = new Core_Model_Class();
        if ($batch_id) {
            $batch_id_basis = true;
            $class->setBatch_id($batch_id);
        }
        if ($semester_id) {
            $semester_id_basis = true;
            $class->setSemester_id($semester_id);
        }
        if ($is_active) {
            $is_active_basis = true;
            $class->setIs_active($is_active);
        }
        $class_ids = $class->fetchClassIds($batch_id_basis, $semester_id_basis, 
        $is_active_basis);
        if (is_array($class_ids)) {
            return $class_ids;
        } else {
            return false;
        }
    }
    private function saveClassInfo ($class_info)
    {
        $class = new Core_Model_Class();
        try {
            $class->save($class_info);
        } catch (Exception $e) {
            Zend_Registry::get('logger')->debug($e);
            throw new Exception(
            'There was some error saving Class information. Please try again', 
            Zend_Log::ERR);
        }
    }
    private function getDepartments ()
    {
        $department = new Core_Model_Department();
        $departments = $department->fetchDepartments();
        if (empty($departments)) {
            return false;
        } else {
            return $departments;
        }
    }
    private function getProgrammeInfo ($programme_id)
    {
        $programme = new Core_Model_Programme();
        $info = $programme->fetchInfo();
        if ($info instanceof Core_Model_Programme) {
            $prog_info['programme_name'] = $info->getProgramme_name();
            $prog_info['total_semesters'] = $info->getTotal_semesters();
            $prog_info['duration'] = $info->getDuration();
            return $prog_info;
        } else {
            return false;
        }
    }
    private function getProgrammes ()
    {
        $programme = new Core_Model_Programme();
        $programmes = $programme->fetchProgrammes();
        if (empty($programmes)) {
            return false;
        } else {
            return $programmes;
        }
    }
    public function addClassAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $departments = $this->getDepartments();
        $programmes = $this->getProgrammes();
        if (empty($departments)) {
            $this->view->assign('departments', false);
        } else {
            $this->view->assign('departments', $departments);
        }
        if (empty($programmes)) {
            $this->view->assign('programmes', false);
        } else {
            $this->view->assign('programmes', $programmes);
        }
    }
    public function savebatchAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $my_array = $params['myarray'];
        $batch_info = $my_array['batch_info'];
        $save['department_id'] = $batch_info['department_id'];
        $save['programme_id'] = $batch_info['programme_id'];
        $save['batch_start'] = $batch_info['batch_start'];
        $save['batch_number'] = $batch_info['batch_number'];
        $save['is_active'] = $batch_info['is_active'];
        $this->saveBatchInfo($save);
    }
    public function viewbatchinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function getbatchidsAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request_object = $this->getRequest();
        $params = array_diff($request_object->getParams(), 
        $request_object->getUserParams());
        $my_array = $params['myarray'];
        $batch_params = $my_array['batch_params'];
        if (! empty($batch_params)) {
            $department_id = $batch_params['department_id'] || null;
            $programme_id = $batch_params['programme_id'] || null;
            $batch_start = $batch_params['batch_start'] || null;
            $batch_ids = $this->getBatchIds($department_id, $programme_id, 
            $batch_start);
            $this->_helper->json($batch_ids);
        }
    }
    public function getbatchinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request_object = $this->getRequest();
        $params = array_diff($request_object->getParams(), 
        $request_object->getUserParams());
        $my_array = $params['myarray'];
        $batch_id = $my_array['batch_id'];
        $batch_info = $this->getBatchInfo($batch_id);
        $response['batch_info'] = $batch_info;
        $format = $request_object->getParam('format');
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                if (! empty($batch_info)) {
                    $this->view->assign('response', $response);
                } else {
                    $this->view->assign('response', false);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($response, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($response);
                break;
            default:
                ;
                break;
        }
    }
}
