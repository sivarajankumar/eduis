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
 * @author udit sharma
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
        $department_id = $request->getParam('department_id');
        $degree_id = $request->getParam('degree_id');
        $semester_id = $request->getParam('semester_id');
        $test_id = $request->getParam('test_id');
        
        //$request->isXmlHttpRequest() and $valid
        if (1) {
            $this->gridparam['page'] = $request->getParam('page', 1); // get the requested page
            $this->gridparam['limit'] = $request->getParam('rows', 20); // rows limit in Grid
            $this->gridparam['sidx'] = $request->getParam('sidx', 1); // get index column - i.e. user click to sort
            $this->gridparam['sord'] = $request->getParam('sord','asc'); // sort direction
            
            $params = array('department_id'=>$department_id,
                           'degree_id'=>$degree_id,
                           'semester_id'=>$semester_id,
                           'test_id'=>$test_id,
                           'test_type_id'=>'SESS'
                           );
            $model = new Acad_Model_Test_Sessional($params);
            $result = $model->fetchSchedule();
    
            $this->_count = count($result);
            $this->total_pages = 0;
            $this->offset = 0;
            $response = new stdClass();
            $response->page = $this->gridparam['page'];
            $response->total = $this->total_pages;
            $response->records = $this->_count;

            if($result['exists'] == true){
                
                foreach ($result as $key => $row) 
                {
                    $response->rows[$key]['id'] = $row->getTestInfoId();
                    $response->rows[$key]['cell'] = array($row->getSubject_code(),
                                                          $row->getSubject_name(),  
                                                          $row->getDate_of_conduct(), 
                                                          $row->getTime(), 
                                                          $row->getMax_marks(), 
                                                          $row->getPass_Marks(), 
                                                          $row->getIs_optional());
                }
            
                $this->_helper->logger($response);
                $this->_helper->json($response);
            }
            elseif($result['exists'] == false){
                foreach ($result as $key => $row) 
                {
                    $response->rows[$key]['id'] = $row->getTestInfoId();
                    $response->rows[$key]['cell'] = array($row->getSubject_code(),
                                                          $row->getSubject_name(),  
                                                          $row->getDate_of_conduct(), 
                                                          $row->getTime(), 
                                                          $row->getDefault_max_marks(), 
                                                          $row->getDefault_pass_Marks(), 
                                                          $row->getIs_optional());
                }
            
                $this->_helper->logger($response);
                $this->_helper->json($response);
            } 
            else {
            $this->getResponse()
                ->setException('Non ajax request')
                ->setHttpResponseCode(400);
            }
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

