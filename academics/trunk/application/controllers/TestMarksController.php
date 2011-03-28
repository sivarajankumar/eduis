<?php
class TestMarksController extends Zend_Controller_Action
{
    protected $_department_id;
    protected $_staff_id;
    public function init ()
    {
        $authInfo = Zend_Auth::getInstance()->getStorage()->read();
        $this->department_id = $authInfo['department_id'];
        $this->staff_id = $authInfo['staff_id'];
        parent::init();
    }
    public function indexAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function fetchMarksAction ()
    {
       
    }
    
    public function imodAction()
    {
        $request = $this->getRequest();
        $subjectCode = $request->getParam('subjectCode');
        $test_id = $request->getParam('test_id');
        $test_type_id = $request->getParam('test_type_id');
        
        $model = new Acad_Model_Test_TestMarks();
        $test_info_id = $model->getTestInfoId($subjectCode, $test_id, 
        $test_type_id, $this->_department_id);
        
        $request = $this->getRequest();
        $test_id = $request->getParam('test_id');
        $refined = html_entity_decode($request);
        $array = explode('', $refined);
        array_push($array, 
        array('department_id' => $this->department_id, 
              'test_type_id' => 'SESS',
              'test_id'=>$this->test_id));
        $insert = $this->model->save($array);
    }
}

