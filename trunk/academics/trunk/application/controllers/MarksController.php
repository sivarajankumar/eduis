<?php

class MarksController extends Zend_Controller_Action
{

    protected $_department_id;
    protected $_staff_id;
    public function init()
    {
        $authInfo = Zend_Auth::getInstance()->getStorage()->read();
        $this->_department_id = $authInfo['department_id'];
        $this->_staff_id =$authInfo['staff_id'];
    }

    public function indexAction()
    {
       
    }

    /**
     * to assign sessional marks
     * @todo save 
     */
    public function assignAction()
    
     {
          $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $model = new Acad_Model_Test_SessionalMapper();
        $string = $this->getRequest();
        $refined = html_entity_decode($string);
        $array = explode('', $refined);
        $insert = $this->model->CRUD($array);
        
     }
     public function filltestgrid()
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
     public function fillstudentgrid()
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
                 
       
     }


