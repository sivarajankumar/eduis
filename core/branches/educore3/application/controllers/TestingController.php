<?php
class TestingController extends Zend_Controller_Action
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
        $batch = new Core_Model_Batch();
        $batch->setBatch_id($batch_id);
        $info = $batch->fetchInfo();
        if ($info instanceof Core_Model_Batch) {
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
    public function viewbatchinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function viewemailidsAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $member_ids = array(1, 2, 3, 4, 5);
        $httpClient = new Zend_Http_Client(
        'http://' . CORE_SERVER . '/student/fetchemailids');
        //$httpClient->setCookie('PHPSESSID', $_COOKIE['PHPSESSID']);
        $httpClient->setMethod('POST');
        $call_back = 'viewbatchinfo';
        $httpClient->setParameterPost(
        array('member_ids' => $member_ids, 'format' => 'json', 
        'call_back' => $call_back));
        $response = $httpClient->request();
        if ($response->isError()) {
            $remoteErr = 'REMOTE ERROR: (' . $response->getStatus() . ') ' .
             $response->getHeader('Message') . $response->getBody();
            throw new Zend_Exception($remoteErr, Zend_Log::ERR);
        } else {
            $jsonContent = $response->getBody($response);
            Zend_Registry::get('logger')->debug($jsonContent);
            Zend_Registry::get('logger')->debug(
            Zend_Json_Decoder::decode($jsonContent));
            Zend_Registry::get('logger')->debug(json_decode($jsonContent));
            /*Zend_Registry::get('logger')->debug(
            Zend_Json_Decoder::decode($jsonContent));*/
        /*$r = Zend_Json_Decoder::decode($jsonContent);
            $batch_info = $r['batch_info'];
            Zend_Registry::get('logger')->debug($batch_info);*/
        }
    }
    public function getbatchinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        /* $request_object = $this->getRequest();
        $params = array_diff($request_object->getParams(), 
        $request_object->getUserParams());*/
        //
        set_time_limit(0);
        // $tdata = $this->findBatchInfo(41);
        $tdata = array($this->findBatchInfo(30), 
        $this->findBatchInfo(31), $this->findBatchInfo(32));
        Zend_Registry::get('logger')->debug($tdata);
        define('TEMP_CORE', realpath(dirname(__FILE__) . '/../temp'));
        $filename = TEMP_CORE . "/excel-" . date("m-d-Y") . ".xls";
        $realPath = realpath($filename);
        if (false === $realPath) {
            touch($filename);
            chmod($filename, 0777);
        }
        $filename = realpath($filename);
        $handle = fopen($filename, "w");
        $finalData = array();
        foreach ($tdata as $key => $row) {
            foreach ($row as $col => $value) {
                $finalData[$key][utf8_decode($col)] = utf8_decode($value);
            }
        }
        Zend_Registry::get('logger')->debug($finalData);
        foreach ($finalData as $finalRow) {
            fputcsv($handle, $finalRow, "\t");
        }
        fclose($handle);
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->getResponse()
            ->setRawHeader(
        "Content-Type: application/vnd.ms-excel; charset=UTF-8")
            ->setRawHeader(
        "Content-Disposition: attachment; filename=excel.xls")
            ->setRawHeader("Content-Transfer-Encoding: binary")
            ->setRawHeader("Expires: 0")
            ->setRawHeader(
        "Cache-Control: must-revalidate, post-check=0, pre-check=0")
            ->setRawHeader("Pragma: public")
            ->setRawHeader("Content-Length: " . filesize($filename))
            ->sendResponse();
        readfile($filename);
         //exit();
    }
}
