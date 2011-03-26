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
        $this->department_id = 'APSC';
        $this->view->assign('masterDepartment', $this->department_id);
        $slaves = Acad_Model_DbTable_SemesterDegree::slaveDepartment($this->department_id);
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
    public function getsessionalAction ()
    {
        $request = $this->getRequest();
        $test_id = $request->getParam('test_id');
        $format = $request->getParam('format', 'json');
        if (1) {
            $values = array('department_id' => 'CSE', 
            				'test_type_id' => 'SESS', 
            				'test_id' => 1);
            $model = new Acad_Model_Test_Sessional($values);
            $sessionals = $model->fetchAll();
            $result = array();
            foreach ($sessionals as $key => $sessional) {
                $result[$sessional->getSemester_id()][$sessional->getDate_of_conduct()][] = array($sessional->getTest_info_id(), 
                $sessional->getDepartment_id(), 
                $sessional->getDegree_id(), 
                $sessional->getSubject_code(), 
                $sessional->getSubject_name(), 
                $sessional->getTime());
            }
            switch (strtolower($format)) {
                case 'json':
                    $this->_helper->logger($result);
                    echo $this->_helper->json($result,false);
                    
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
        
        
        if ($request->isXmlHttpRequest() and $valid) 
        {
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
                $this->total_pages = 1;
                $this->offset = 0;
                $response = new stdClass();
                $response->page = $this->gridparam['page'];
                $response->total = $this->total_pages;
                $response->records = $this->_count;

                if(true == $result['exists']){
                
                    foreach ($result['data'] as $key => $row) 
                    {
                        $response->rows[$key]['id'] = $row->getTest_info_id();
                        $response->rows[$key]['cell'] = array($row->getSubject_code(),
                                                              $row->getSubject_name(),  
                                                              $row->getDate_of_conduct(), 
                                                              $row->getTime(), 
                                                              $row->getMax_marks(), 
                                                              $row->getPass_Marks()); 
                                                              
                    }
            
                    
                    $this->_helper->json($response);
                }
                elseif(false == $result['exists']){
                    foreach ($result['data'] as $key => $row) 
                    {
                        $response->rows[$key]['id'] = $row->getTest_info_id();
                        $response->rows[$key]['cell'] = array($row->getSubject_code(),
                                                              $row->getSubject_name(),  
                                                              $row->getDate_of_conduct(), 
                                                              $row->getTime(), 
                                                              $row->getDefault_max_marks(), 
                                                              $row->getDefault_pass_Marks());
                    }
            
                    
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
     * Get upcoming sessional information.
     * 
     * @about JSON data provider.
     */
    public function getupcomingsessional(){
        
        $request = $this->getRequest();
        
        if($request->isXmlHttpRequest()){
            $model = new Acad_Model_Test_Sessional();
        }
        else{
            $this->getResponse()
                 ->setException('Non ajax request')
                 ->setHttpResponseCode(400);
        }
    }
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

