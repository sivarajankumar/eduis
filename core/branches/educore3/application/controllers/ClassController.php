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
            $class_info['class_id'] = $info->getBatch_id();
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
     * @param int $class_id
     * @param int $semester_id
     * @param bool $is_active
     */
    private function getClassIds ($class_id = null, $semester_id = null, 
    $is_active = null)
    {
        $class_id_basis = null;
        $semester_id_basis = null;
        $is_active_basis = null;
        $class = new Core_Model_Class();
        if ($class_id) {
            $class_id_basis = true;
            $class->setBatch_id($class_id);
        }
        if ($semester_id) {
            $semester_id_basis = true;
            $class->setSemester_id($semester_id);
        }
        if ($is_active) {
            $is_active_basis = true;
            $class->setIs_active($is_active);
        }
        $class_ids = $class->fetchClassIds($class_id_basis, $semester_id_basis, 
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
            $class_id = $class->saveInfo($class_info);
            Zend_Registry::get('logger')->debug(
            'New class added,$class_id = ' . $class_id);
        } catch (Exception $e) {
            Zend_Registry::get('logger')->debug($e);
            throw new Exception(
            'There was some error saving Class information in core server. Please try again', 
            Zend_Log::WARN);
        }
        $class_info['class_id'] = $class_id;
        $httpClient = new Zend_Http_Client(
        'http://' . ACADEMIC_SERVER . '/class/saveclass', array('timeout' => 30));
        $httpClient->setMethod('POST');
        $httpClient->setParameterPost(
        array('myarray' => array('class_info' => $class_info)));
        try {
            $response = $httpClient->request();
        } catch (Exception $e) {}
        $response = $httpClient->request();
        if ($response->isError()) {
            $remoteErr = 'ERROR from ' . ACADEMIC_SERVER . ' : (' .
             $response->getStatus() . ') ' . $response->getMessage();
            throw new Zend_Exception($remoteErr, Zend_Log::WARN);
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
    public function addclassAction ()
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
    public function saveclassAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $my_array = $params['myarray'];
        $class_info = $my_array['class_info'];
        $save['batch_id'] = $class_info['batch_id'];
        $save['semester_id'] = $class_info['semester_id'];
        $save['semester_type'] = $class_info['semester_type'];
        $save['semester_duration'] = $class_info['semester_duration'];
        $save['handled_by_dept'] = $class_info['handled_by_dept'];
        $save['completion_date'] = $class_info['completion_date'];
        $save['start_date'] = $class_info['start_date'];
        $save['is_active'] = $class_info['is_active'];
        $this->saveClassInfo($save);
    }
    public function viewclassinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function getclassidsAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request_object = $this->getRequest();
        $params = array_diff($request_object->getParams(), 
        $request_object->getUserParams());
        $my_array = $params['myarray'];
        $class_finder = $my_array['class_finder'];
        if (! empty($class_finder)) {
            $batch_id = $class_finder['batch_id'];
            $semester_id = $class_finder['semester_id'];
            $class_ids = $this->getClassIds($batch_id, $semester_id);
            $this->_helper->json($class_ids);
        }
    }
    public function getclassinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request_object = $this->getRequest();
        $params = array_diff($request_object->getParams(), 
        $request_object->getUserParams());
        $my_array = $params['myarray'];
        $class_id = $my_array['class_id'];
        $class_info = $this->getClassInfo($class_id);
        $response['class_info'] = $class_info;
        $format = $this->_getParam('format', 'html');
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                if (! empty($class_info)) {
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
    public function fetchprogrammesAction ()
    {
        $format = $this->_getParam('format', 'html');
        $response['programmes'] = $this->getProgrammes();
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(true);
                $this->_helper->layout()->disableLayout();
                $this->view->assign('response', $response);
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
    public function fetchdepartmentsAction ()
    {
        $format = $this->_getParam('format', 'html');
        $response['departments'] = $this->getDepartments();
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(true);
                $this->_helper->layout()->disableLayout();
                $this->view->assign('response', $response);
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
