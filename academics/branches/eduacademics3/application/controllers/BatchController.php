<?php
class BatchController extends Zend_Controller_Action
{
    public function init ()
    {}
    public function indexAction ()
    {}
    /**
     * Ftehces information about a batch on the basis of Btach_id
     * 
     * @param int $batch_id
     */
    private function getBatchInfo ($batch_id)
    {
        $batch = new Acad_Model_Batch();
        $batch->setBatch_id($batch_id);
        $info = $batch->fetchInfo();
        if ($info instanceof Acad_Model_Batch) {
            $batch_info = array();
            $batch_info['department_id'] = $info->getDepartment_id();
            $batch_info['programme_id'] = $info->getProgramme_id();
            $batch_info['batch_start'] = $info->getBatch_start();
            $batch_info['batch_number'] = $info->getBatch_number();
            $batch_info['is_active'] = $info->getIs_active();
            return $batch_info;
        } else {
            return false;
        }
    }
    /**
     * fetches batch_id on the basis of batch info given
     * 
     * @param string $department_id
     * @param string $programme_id
     * @param date $batch_start
     * @return array|false
     */
    private function getBatchIds ($batch_start = null, $department_id = null, 
    $programme_id = null)
    {
        $batch_start_basis = null;
        $department_id_basis = null;
        $programme_id_basis = null;
        $batch = new Acad_Model_Batch();
        if ($batch_start) {
            $batch_start_basis = true;
            $batch->setBatch_start($batch_start);
        }
        if ($department_id) {
            $department_id_basis = true;
            $batch->setDepartment_id($department_id);
        }
        if ($programme_id) {
            $programme_id_basis = true;
            $batch->setProgramme_id($programme_id);
        }
        $batch_ids = $batch->fetchBatchIds($batch_start_basis, 
        $department_id_basis, $programme_id_basis);
        Zend_Registry::get('logger')->debug($batch_ids);
        if (is_array($batch_ids)) {
            return $batch_ids;
        } else {
            return false;
        }
    }
    private function saveBatchInfo ($batch_info)
    {
        $batch = new Acad_Model_Batch();
        try {
            $batch->saveInfo($batch_info);
        } catch (Exception $e) {
            Zend_Registry::get('logger')->debug($e);
            throw new Exception(
            'There was some error saving batch information in academics. Please try again', 
            Zend_Log::ERR);
        }
    }
    private function getDepartments ()
    {
        $department = new Acad_Model_Department();
        $departments = $department->fetchDepartments();
        if (empty($departments)) {
            return false;
        } else {
            return $departments;
        }
    }
    private function getProgrammeInfo ($programme_id)
    {
        $programme = new Acad_Model_Programme();
        $info = $programme->fetchInfo();
        if ($info instanceof Acad_Model_Programme) {
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
        $programme = new Acad_Model_Programme();
        $programmes = $programme->fetchProgrammes();
        if (empty($programmes)) {
            return false;
        } else {
            return $programmes;
        }
    }
    public function addbatchAction ()
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
        $save['batch_id'] = $batch_info['batch_id'];
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
            $batch_params['department_id'] &&
             ($department_id = $batch_params['department_id']);
            $batch_params['programme_id'] &&
             ($programme_id = $batch_params['programme_id']);
            $batch_params['batch_start'] &&
             ($batch_start = $batch_params['batch_start']);
            $batch_ids = $this->getBatchIds($batch_start, $department_id, 
            $programme_id);
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
        $format = $this->_getParam('format', 'html');
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
