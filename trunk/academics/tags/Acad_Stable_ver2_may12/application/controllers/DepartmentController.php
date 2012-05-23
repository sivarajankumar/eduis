<?php

class DepartmentController extends Zend_Controller_Action
{

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
        $dateFrom = $request->getParam('date_from');
        $dateUpto = $request->getParam('date_upto');
        $semester = $request->getParam('semester');
        $format = $this->_getParam('format', 'html');
        $authContent = Zend_Auth::getInstance()->getIdentity();
        if ('mgmt' == strtolower($authContent['department_id'])){
            $this->view->assign('aboveDepartments', TRUE);
        } else {
            $department_id = $authContent['department_id'];
        }
        $this->view->assign('programme_id',$programme_id);
        $this->view->assign('department_id',$department_id);
        if (isset($department_id) and isset($programme_id)) {
        $attendance = $department->getStudentAttendance($programme_id,$dateFrom,$dateUpto,$semester);
            switch (strtolower($format)) {
                case 'test':
                    $this->_helper->logger($attendance);
                    return;
                case 'html':
                    $this->_helper->viewRenderer->setNoRender(false);
                    $this->_helper->layout()->enableLayout();
                    $this->view->assign('department_id', $department_id);
                    $this->view->assign('date_from', $dateFrom);
                    $this->view->assign('date_upto', $dateUpto);
                    $this->view->assign('attendance',$attendance);
                    
                    $session_startdate = Acad_Model_DbTable_AcademicSession::getSessionStartDate();
                    $this->view->assign('session_startdate', $session_startdate);
                    return;
                case 'json':
                    echo $this->_helper->json($attendance, false);
                    return;
            }
        }
    }
}

