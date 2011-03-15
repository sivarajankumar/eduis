<?php
/**
 *
 * @category   EduIS
 * @package    Core
 * @subpackage Batch
 * @since	   0.1
 */
/**
 * 
 * 
 * @author Prarthana
 * @author Harsh
 * Sessional datesheet in a degree of a department
 */
class SessionalController extends Acadz_Base_BaseController
{
    protected $department_id;
    public function init ()
    {
        $authInfo = Zend_Auth::getInstance()->getStorage()->read();
        $this->department_id = $authInfo['department_id'];
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
     * Back end data provider to datagrid.
     * @return json
     */
    public function fillgridAction ()
    {
        $request = $this->getRequest();
        $valid = $request->getParam('nd');
        //$request->isXmlHttpRequest() and $valid
        if (1) {
            $this->gridparam['page'] = $request->getParam('page', 1); // get the requested page
            $this->gridparam['limit'] = $request->getParam('rows', 
            20); // rows limit in Grid
            $this->gridparam['sidx'] = $request->getParam('sidx', 1); // get index column - i.e. user click to sort
            $this->gridparam['sord'] = $request->getParam('sord', 
            'asc'); // sort direction
            $model = new Acad_Model_Test_Sessional();
            $result = $model->fetchAll();
            $this->_count = count($result);
            $this->total_pages = 0;
            $this->offset = 0;
            $response = new stdClass();
            $response->page = $this->gridparam['page'];
            $response->total = $this->total_pages;
            $response->records = $this->_count;
            foreach ($result as $key => $row) 
            {
                $response->rows[$key]['id'] = $row->getTestInfoId();
                $response->rows[$key]['cell'] = array($row->getSubject(), 
                $row->getConductDate(), $row->getTime(), $row->getMaxmarks(), 
                $row->getMinMarks(), $row->getRemark());
            }
            $this->_helper->logger($response);
            $this->_helper->json($response);
        } else {
            $this->getResponse()
                ->setException('Non ajax request')
                ->setHttpResponseCode(400);
        }
    }
    /**
     * 
     * 
     * enabling layout and assigning department_id to view
     */
    public function manageAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $this->view->assign('masterDepartment', $this->department_id);
    }
    /**
     * @deprecated
     * 
     */
    protected function _imod ()
    {}
    /**
     * 
     * Enter description here ...
     * insert data in database through SessionalMapper 
     */
    public function imodAction ()
    {
        $model = new Acad_Model_Test_SessionalMapper();
        $string = $this->getRequest();
        $refined = html_entity_decode($string);
        $array = explode('', $refined);
        array_push($array, 
        array('department_id' => $this->department_id, 'test_type_id' => 'sess'));
        $insert = $this->model->save($array);
    }
}

