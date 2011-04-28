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
    protected $department_id;
    public function init ()
    {
        $authInfo = Zend_Auth::getInstance()->getStorage()->read();
        $this->department_id = $authInfo['department_id'];
        $this->view->assign('masterDepartment', $this->department_id);
        $slaves = Acad_Model_DbTable_SemesterDegree::slaveDepartment(
        $this->department_id);
        $this->view->assign('slaveDepartment', $slaves);
        parent::init();
    }
    /**
     * @about Interface.
     */
    public function indexAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
         // action body
    }
    /**
     * @about Interface.
     */
    public function getcandidatesAction ()
    {
        $request = $this->getRequest();
        $test_id = $request->getParam('test_id');
        $format = $request->getParam('format', 'json');
        if ($test_id) {
            $options = array('test_id' => $test_id);
            $model = new Acad_Model_Test_Sessional($options);
            $sessionals = $model->fetchAll();
            $result = array();
            foreach ($sessionals as $key => $sessional) {
                $result[$sessional->getSemester_id()][$sessional->getDate_of_conduct()][] = array(
                $sessional->getTest_info_id(), $sessional->getDepartment_id(), 
                $sessional->getDegree_id(), $sessional->getSubject_code(), 
                $sessional->getSubject_name(), $sessional->getTime());
            }
            switch (strtolower($format)) {
                case 'json':
                    $this->_helper->logger($result);
                    echo $this->_helper->json($result, false);
                    return;
                default:
                    $this->getResponse()
                        ->setException('Unsupported format request')
                        ->setHttpResponseCode(400);
            }
        } else {
            header("HTTP/1.1 400 Bad Request");
        }
         // action body
    /*if ($result != null) {
            $this->_helper->json($result);
        } else {
            return new Exception('Wrong paramter', Zend_Log::ERR);
        }*/
    }
}

