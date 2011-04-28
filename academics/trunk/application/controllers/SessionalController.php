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
    public function getsessionalAction ()
    {
        $request = $this->getRequest();
        $test_id = $request->getParam('test_id');
        $format = $request->getParam('format', 'json');
        if (1) {
            $values = array('department_id' => $this->department_id, 
            'test_type_id' => 'SESS', 'test_id' => 1);
            $model = new Acad_Model_Test_Sessional($values);
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
        if ($request->isXmlHttpRequest() and $valid) {
            $this->gridparam['page'] = $request->getParam('page', 1); // get the requested page
            $this->gridparam['limit'] = $request->getParam('rows', 
            20); // rows limit in Grid
            $this->gridparam['sidx'] = $request->getParam('sidx', 1); // get index column - i.e. user click to sort
            $this->gridparam['sord'] = $request->getParam('sord', 
            'asc'); // sort direction
            $params = array('department_id' => $department_id, 
            'degree_id' => $degree_id, 'semester_id' => $semester_id, 
            'test_id' => $test_id, 'test_type_id' => 'SESS');
            $model = new Acad_Model_Test_Sessional($params);
            $result = $model->fetchSchedule();
            $response = new stdClass();
            $response->page = $this->gridparam['page'];
            $response->total = 1;
            

            if ($result instanceof Zend_Exception) {
                $this->getResponse()
                    ->setException(new Exception('Invalid sessional parameter OR No entry exists', Zend_Log::ERR))
                    ->setHttpResponseCode(400);
            } elseif (true == $result['exists']) {
                $response->records = count($result['data']);
                foreach ($result['data'] as $key => $row) {
                    $response->rows[$key]['id'] = $row->getTest_info_id();
                    $response->rows[$key]['cell'] = array(
                    $row->getSubject_code(), $row->getSubject_name(), 
                    $row->getDate_of_conduct(), $row->getTime(), 
                    $row->getMax_marks(), $row->getPass_Marks());
                }
                
                $this->_helper->json($response);
            } else {
                foreach ($result['data'] as $key => $row) {
                    $response->rows[$key]['id'] = 'new_'.$key;
                    $response->rows[$key]['cell'] = array(
                    $row->getSubject_code(), $row->getSubject_name(), 
                    $row->getDate_of_conduct(), $row->getTime(), 
                    $row->getDefault_max_marks(), $row->getDefault_pass_Marks());
                }
                $this->_helper->json($response);
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
     * 
     * Enter description here ...
     * insert data in database through SessionalMapper 
     */
    public function imodAction ()
    {
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        
        $sessional = new Acad_Model_Test_Sessional($params);
        $sessional->setTest_info_id($params['id']);
        $result = $sessional->save();
        if ($result) {
            echo 'Successfully saved!! Test Id :'.var_export($result, true);
        }
    }
    
    public function getconductedAction(){
        $request = $this->getRequest();
        $department = $request->getParam('department_id');
        $degree = $request->getParam('degree_id');
        $semester = $request->getParam('semester_id');
        $format = $this->getRequest()->getParam('format', 'json');
        $sessional = new Acad_Model_Test_Sessional();
        $class = new Acad_Model_Class();
        $class->setDepartment($department)->setDegree($degree)->setSemester($semester);
        $result = $sessional->getConducted($class);
        switch (strtolower($format)) {
            case 'json':
                echo $this->_helper->json($result,false);
                return;
            case 'jsonp':
                $callback = $request->getParam('callback');
                echo $callback . '(' . $this->_helper->json($result, false) . ')';
                return;
            case 'select':
                echo '<select>';
                echo '<option>Select one</option>';
                foreach ($result as $key => $row) {
                    echo '<option value="' . $row['department_id'] . '">' .
                     $row['department_id'] . '</option>';
                }
                echo '</select>';
                return;
                break;
        }
        header("HTTP/1.1 400 Bad Request");
    }
    
    public function tempAction(){
        $class = new Acad_Model_Class();
        $class->setDepartment('CSE')
                ->setDegree('BTECH')
                ->setSemester('4');
        $faculty = new Acad_Model_Member_Faculty();
        $result = $faculty->getSubjects($class);
        echo '<pre>';
        print_r($result);
        //$this->_helper->logger($result);
    }
}

