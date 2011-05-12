<?php
/**
 *
 * @category   EduIS
 * @package    Academic
 * @since	   3.0
 */
/**
 * 
 * 
 * Test in a degree of a department
 */
class TestController extends Acadz_Base_BaseController
{
    //protected $department_id;
    /*public function init ()
    {
        $authInfo = Zend_Auth::getInstance()->getStorage()->read();
        $this->department_id = $authInfo['department_id'];
        $this->view->assign('masterDepartment', $this->department_id);
        $slaves = Acad_Model_DbTable_SemesterDegree::slaveDepartment(
        $this->department_id);
        $this->view->assign('slaveDepartment', $slaves);
        parent::init();
    }*/
    /**
     * @about Interface.
     */
    /*public function indexAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
         // action body
    }*/
    /**
     * @about Interface.
     */
    public function getstudentsAction ()
    {
        $request = $this->getRequest();
        $test_info_id = $request->getParam('test_info_id');
        $format = $request->getParam('format', 'json');
        if ($test_info_id) {
            $options = array('test_info_id' => $test_info_id);
            $test = new Acad_Model_Test_Sessional($options);
            $candidates['students'] = $test->getStudents();
            $candidates['test_info'] = $test->__toArray();
            $this->_helper->logger($candidates);
            switch (strtolower($format)) {
                case 'json':
                    echo $this->_helper->json($candidates, false);
                    return;
                case 'grid':
                    $valid = $request->getParam('nd');
                    $this->gridparam['page'] = $request->getParam('page', 1); // get the requested page
                    $this->gridparam['limit'] = $request->getParam('rows', 70); // rows limit in Grid
                    $this->_count = count($candidates['students']);
                    $response = new stdClass();
                    $count = 0;
                    foreach ($candidates['students'] as $key => $value) {
                        $response->rows[$count]['id'] = $key;
                        $response->rows[$count++]['cell'] = array($key, $value['marks_scored'], $value['status']);
                    }
                    $response->page = $this->gridparam['page'];
                    $response->total = 1;
                    $response->records = $this->_count;
                    $response->test_info = $candidates['test_info'];
                    echo $this->_helper->json($response, false);
                    return;
                default:
                    $this->getResponse()
                        ->setException('Unsupported format request')
                        ->setHttpResponseCode(400);
            }
        }
        
        header("HTTP/1.1 400 Bad Request");
    }
}

