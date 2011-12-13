<?php

class DepartmentController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $dbtable = new Acad_Model_DbTable_StudentAttendance2();
        
        $result = $dbtable->stats('CSE','BTECH');
        echo("<pre>");
        print_r($result);
        
    }


    public function attendanceAction()
    {
        $department = new Acad_Model_Department();
        $request = $this->getRequest();
        $department_id = $request->getParam('department_id');
        $programme_id = $request->getParam('programme_id','BTECH');
        $date_from = $request->getParam('date_from');
        $date_upto = $request->getParam('date_upto');
        $authContent = Zend_Auth::getInstance()->getIdentity();
        if ('mgmt' == strtolower($authContent['department_id'])){
            $this->view->assign('aboveDepartments', TRUE);
        } else {
            $department_id = $authContent['department_id'];
        }
        $this->view->assign('programme_id',$programme_id);
        $this->view->assign('department_id',$department_id);
        if (isset($department_id) and isset($programme_id)) {
            $attendance = $department->getStudentAttendance($programme_id,$date_from,$date_upto);
            $this->view->assign('attendance',$attendance);
            //$this->_helper->logger($attendance);
        }
        
        
    }
}

