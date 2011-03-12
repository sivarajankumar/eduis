<?php
class SessionalController extends Acadz_Base_BaseController
{
    protected $department_id;
    public function init ()
    {
        $authInfo = Zend_Auth::getInstance()->getStorage()->read();
        $this->department_id = $authInfo['department_id'];
        parent::init();
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
        //$request->isXmlHttpRequest() and $valid
        if (1) {
            $this->gridparam['page'] = $request->getParam('page',1); // get the requested page
            $this->gridparam['limit'] = $request->getParam('rows',20); // rows limit in Grid
            $this->gridparam['sidx'] = $request->getParam('sidx',1); // get index column - i.e. user click to sort
            $this->gridparam['sord'] = $request->getParam('sord', 'asc'); // sort direction
            
            $model = new Acad_Model_Test_Sessional();
            $result = $model->fetchAll();
            
            $this->_count = count($result);
            $this->total_pages = 0;
            $this->offset = 0;
            $response = new stdClass();
            $response->page = $this->gridparam['page'];
            $response->total = $this->total_pages;
            $response->records = $this->_count;
            $pkey = array('test_info_id');
            foreach ($result as $key => $row) {
                $gridTuplekey = null;
                foreach ($pkey as $num => $col) {
                    $gridTuplekey[] = $row->getTestInfoId();
                }
                $response->rows[$key]['id'] = implode('__', $gridTuplekey);
                $response->rows[$key]['cell'] = $row->getSubject();
            }
            $this->_helper->logger($response);
            //$this->_helper->json($response);
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
        $refined = html_entity_decode($string);
        $array = explode('', $refined);
        array_push($array, 
        array('department_id' => $this->department_id, 'test_type_id' => 'ssnl'));
        $insert = $this->model->save($array);
    }
}

