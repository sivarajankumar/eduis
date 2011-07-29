<?php
/**
 * Assign marks corresponding test id
 * fetch marks of sessional and assignments
 *
 */
class MarksController extends Acadz_Base_BaseController
{

    protected $_department_id;
    protected $_staff_id;
    public function init()
    {
        $authInfo = Zend_Auth::getInstance()->getStorage()->read();
        $this->_department_id = $authInfo['department_id'];
        $this->_staff_id =$authInfo['identity'];
        parent::init();
    }
    
	/**
     * @about Interface.
     */
    public function indexAction ()
    {
        /*$this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();*/
    }

    /**
     * to assign sessional marks
     *  
     */
    public function assignAction()
     {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        //$this->_helper->logger($selectSubject);
        /*$model = new Acad_Model_Test_SessionalMapper();
        $string = $this->getRequest();
        $refined = html_entity_decode($string);
        $array = explode('', $refined);
        $insert = $this->model->CRUD($array);*/
     }
     public function filltestgridAction()
     {
       $request = $this->getRequest();
       $valid = $request->getParam('nd');
       $SubjectCode = $request->getParam('subject_code');
       
       if ($request->isXmlHttpRequest() and $valid) 
        {
            $this->gridparam['page'] = $request->getParam('page', 1); // get the requested page
            $this->gridparam['limit'] = $request->getParam('rows', 20); // rows limit in Grid
            $this->gridparam['sidx'] = $request->getParam('sidx', 1); // get index column - i.e. user click to sort
            $this->gridparam['sord'] = $request->getParam('sord','asc'); // sort direction
            $params = array('department_id'=>$this->_department_id,
                             'staff_id'=>$this->_staff_id,
                             'subject_code'=>$SubjectCode
                           );
       
           $model = new Acad_Model_Course_Subject($params);
           $marks = $model->fetchTest();
           
           $this->_count = count($marks);
                $this->total_pages = 1;
                $this->offset = 0;
                $response = new stdClass();
                $response->page = $this->gridparam['page'];
                $response->total = $this->total_pages;
                $response->records = $this->_count;
                 
                foreach ($marks as $key => $row) 
                    {
                        $response->rows[$key]['id'] = $row->getTest_info_id();
                        $response->rows[$key]['cell'] = array($row->getTest_Id(),
                                                              $row->getTest_Type_Id(),
                                                              
                                                              $row->getMax_marks(), 
                                                              $row->getPass_Marks(),
                                                              $row->getRemarks(),
                                                              $row->getIsOptional()
                                                              );
                                                               
                                                              
                    }
               //$this->_helper->json($response);
               $this->_helper->logger($response);
              }
            
            
    }
    /**
     * @deprecated not in use
     * Enter description here ...
     */
     public function fillstudentgridAction()
     {
       $request = $this->getRequest();
       $valid = $request->getParam('nd');
       $test_Info_id = $request->getParam('test_info_id');
       
       if ($request->isXmlHttpRequest() and $valid) 
        {
            $this->gridparam['page'] = $request->getParam('page', 1); // get the requested page
            $this->gridparam['limit'] = $request->getParam('rows', 20); // rows limit in Grid
            $this->gridparam['sidx'] = $request->getParam('sidx', 1); // get index column - i.e. user click to sort
            $this->gridparam['sord'] = $request->getParam('sord','asc'); // sort direction

            $model = new Acad_Model_Test_Sessional($test_Info_id);
            $marks = $model->fetchStudents();
           
           $this->_count = count($marks);
                $this->total_pages = 1;
                $this->offset = 0;
                $response = new stdClass();
                $response->page = $this->gridparam['page'];
                $response->total = $this->total_pages;
                $response->records = $this->_count;
                
           foreach ($marks as $key => $row) 
                    {
                        $response->rows[$key]['id'] = $row->getTest_info_id();
                        $response->rows[$key]['cell'] = array($row->getStudents(),
                                                              $row->getMarks(),
                                                              $row->getMax_marks(), 
                                                              $row->getStatus(),
                                                              );
                    }
               //$this->_helper->json($response);
               $this->_helper->logger($response);
              }
         }
                 

    /**
     * 
     * Enter description here ...
     * insert data in database through SessionalMapper 
     */
    public function imodAction ()
    {
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        
        $sessional = new Acad_Model_Test_Sessional();
        $params['student_roll_no'] = $params['id'];
        unset($params['id']);
        
        $sessional->setTest_info_id($params['test_info_id']);
        $result = $sessional->setMarks($params);
        if ($result) {
            echo 'Successfully saved!! Affected: '.$result;
        }
    }
    

    /**
     * 
     * Enter description here ...
     * insert data in database through SessionalMapper 
     */
    public function lockAction ()
    {
        $request = $this->getRequest();
        $test_info_id = $request->getParam('test_info_id');
        
        $sessional = new Acad_Model_Test_Sessional(array('test_info_id'=>$test_info_id));
        
        $result = $sessional->setLock(true);
        if ($result) {
            echo 'Successfully saved!! Affected: '.$result;
        }
    }
    

    /**
     * 
     * Enter description here ...
     * insert data in database through SessionalMapper 
     */
    public function statsAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        
    }
    /**
     * View marks of selected sessional
     * Enter description here ...
     */
    
    public function sessionalAction()
    {
        $authInfo = Zend_Auth::getInstance()->getStorage()->read();
        $department_id = $authInfo['department_id'];
        $degree_id = $authInfo['degree_id'];
        $semester_id = $authInfo['semester'];
        $rollno = $authInfo['user_id'];
       
        $model = new Acad_Model_Assessment_Sessional();
        $result= $model->fetchMarks($degree_id,$department_id,$semester_id,$rollno);
        $response = new stdClass();
        $response->page = $this->gridparam['page'];
        $response->total = $this->total_pages;
        $response->records = $this->_count;
        
        foreach ($result as $key => $row)
        {
            $response->rows[$key]['id']=$row['test_info_id'];
            $response->rows[$key]['cell']=array(
                                            $row['test_id'],
                                            $row['subject_code'],
                                            $row['subject_name'],
                                            $row['max_marks'],
                                            $row['pass_marks'],
                                            $row['marks_scored'],
                                            $row['status']);
        }
        $this->_helper->logger($response);
        echo $this->_helper->json($response);
    }
    /**
     * View marks of locked assignments
     * Enter description here ...
     */
    public function assignmentAction()
    {
        $authInfo = Zend_Auth::getInstance()->getStorage()->read();
        $department_id = $authInfo['department_id'];
        $degree_id = $authInfo['degree_id'];
        $semester_id = $authInfo['semester'];
        $rollno = $authInfo['user_id'];
       
        $model = new Acad_Model_Assessment_Assignment();
        $result = $model->fetchMarks($degree_id,$department_id,$semester_id,$rollno);        
        $response = new stdClass();
        $response->page = $this->gridparam['page'];
        $response->total = $this->total_pages;
        $response->records = $this->_count;
        
        foreach ($result as $key => $row)
        {
            $response->rows[$key]['id']=$row['test_info_id'];
            $response->rows[$key]['cell']=array(
                                            $row['test_id'],
                                            $row['subject_code'],
                                            $row['subject_name'],
                                            $row['max_marks'],
                                            $row['pass_marks'],
                                            $row['marks_scored'],
                                            $row['status']);
        }
        $this->_helper->logger($response);
        echo $this->_helper->json($response);
    }
}