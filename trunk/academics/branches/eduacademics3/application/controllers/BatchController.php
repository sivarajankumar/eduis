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
    private function findBatchInfo ($batch_id)
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
    private function findBatchIds ($batch_start = null, $department_id = null, 
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
            $batch_id = $batch->saveInfo($batch_info);
            Zend_Registry::get('logger')->debug('batch id = ' . $batch_id);
            return $batch_id;
        } catch (Exception $e) {
            return false;
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
        $save['batch_id'] = $batch_info['batch_id'];
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
            $batch_ids = $this->findBatchIds($batch_start, $department_id, 
            $programme_id);
        } else {
            $batch_ids = false;
        }
        $format = $this->_getParam('format', 'log');
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                $this->view->assign('batch_ids', $batch_ids);
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($batch_ids, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($batch_ids);
                break;
            case 'log':
                Zend_Registry::get('logger')->debug('No format was provided..');
                Zend_Registry::get('logger')->debug($batch_ids);
                break;
            default:
                ;
                break;
        }
    }
    public function getbatchinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request_object = $this->getRequest();
        $params = array_diff($request_object->getParams(), 
        $request_object->getUserParams());
        $batch_id = null;
        if (! empty($params['myarray'])) {
            $my_array = $params['myarray'];
            $batch_id = $my_array['batch_id'];
        } else {
            $batch_id = $request_object->getParam('batch_id');
        }
        if ($batch_id != null) {
            $batch_info = $this->findBatchInfo($batch_id);
            $response['batch_info'] = $batch_info;
        } else {
            $response['batch_info'] = false;
        }
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
