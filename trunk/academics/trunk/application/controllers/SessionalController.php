<?php
class SessionalController extends Acadz_Base_BaseController
{
    protected $department_id;
    public  function init()
     {
        
        $authInfo = Zend_Auth::getInstance()->getStorage()->read();
        $this->department_id = $authInfo['department_id'];
        
    }
    public function indexAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
         // action body
    }
    /**
     * Back end data provider to datagrid.
     * @return json
     */
    public function fillgridAction ()
    {
        $request = $this->getRequest();
        $valid = $request->getParam('nd');
        if ($request->isXmlHttpRequest() and $valid) {
            $model = new Acad_Model_Test_Sessional();
            $this->grid = $this->_helper->grid();
            $this->grid->sql = $this->model->select()->from(
            $this->model->info('name'));
            $searchOn = $request->getParam('_search');
            if ($searchOn != 'false') {
                $sarr = $request->getParams();
                foreach ($sarr as $value) {
                    switch ($key) {
                        case 'department_id':
                        case 'degree_id':
                            $this->grid->sql->where("$key LIKE ?", $value . '%');
                            break;
                        case 'batch_start':
                            $this->grid->sql->where("$key = ?", $value);
                            break;
                    }
                }
            }
            self::fillgridfinal();
        } else {
            $this->getResponse()
                ->setException('Non ajax request')
                ->setHttpResponseCode(400);
        }
    }
    public function manageAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $this->view->assign('masterDepartment', $this->department_id);
     
    }
    protected function _imod ()
    {}
    public function imodAction ()
    {
        
        $model = new Acad_Model_Test_SessionalMapper();
       
        $string = $this->getRequest();
        $refined= html_entity_decode($string);
        $array = explode('', $refined);
      
       
       array_push($array, array('department_id'=>$this->department_id,'test_type_id'=>'ssnl'));   
        
      
        $insert=$this->model->save($array);
    }
}

