<?php
/**
 * fetch the schedule(datesheet) of 
 * upcoming sessional and assignments
 * 
 */
class ScheduleController extends Acadz_Base_BaseController
{
    public function init()
    {
        
    }
    /**
     * @about Interface.
     */
    public function indexAction()
    {
        //$this->_helper->viewRenderer->setNoRender(false);
        //$this->_helper->layout()->enableLayout();
        
    }
    public function sessionalAction()
    {
         $this->_helper->layout()->enableLayout();
//        $authInfo = Zend_Auth::getInstance()->getStorage()->read();
//        $department_id = $authInfo['department_id'];
//        $degree_id = $authInfo['degree_id'];
//        $semester_id = $authInfo['semester'];
//        $rollno = $authInfo['user_id'];
/**
 * 
 * @todo dynamic entry of fields
 */
        $department_id = 'CSE';
        $degree_id = 'BTECH';
        $semester_id = '6';
        $rollno = '2308001';
         $name = 'Prarthana';
         $this->view->assign('name',$name);
        $this->view->assign('rollno',$rollno);
        $this->view->assign('sem',$semester_id);
        $this->view->assign('degree',$degree_id);
        $this->view->assign('deptt',$department_id);
        $model = new Acad_Model_Assessment_Sessional();
        $schedule = $model->fetchSchedule($degree_id,$department_id,$semester_id,1);
        $this->view->assign('schedule',$schedule);
       
        
        /*
            $result = array();
            $header = $result[$schedule->getTest_type_id()][$schedule->getTest_id()];
            foreach ($schedule as $key => $value) 
            {
            $result[]=array($value->getTest_info_id(),
                            $value->getSubject_code(),
                            $value->getSubject_name(),
                            $value->getDate_of_conduct(),
                            $value->getTime());
            }
            $this->_helper->logger($result);
            echo $this->_helper->json($result, false);*/
            
    } 
    
    /**
     * fetches the schedule of unlocked assignments
     * date of conduct refers to date of submission
     */
    public function assignmentAction()
    {
       /* $authInfo = Zend_Auth::getInstance()->getStorage()->read();
        $department_id = $authInfo['department_id'];
        $degree_id = $authInfo['degree_id'];
        $sem = $authInfo['semester'];
       $id = $authInfo['user_id'];
        $values = array('department_id'=>$department_id,'degree_id'=>$degree_id,'semester_id'=>$sem,'user_id'=>$id);
        $model = new Acad_Model_Assessment_Assignment($values);
        $schedule = $model->fetchSchedule();
        
        
        
            $result = array();
            //$header = $result[$schedule->getTest_type_id()][$schedule->getSubject_code()][$schedule->getSubject_name()];
            foreach ($schedule as $key => $value) 
            {
            $result[]=array($value->getTest_info_id(),
                            $value-> getTest_type_id(),                            
                            $value->getTest_id(),
                            $value->getSubject_code(),
                            $value->getSubject_name(),
                            $value->getDate_of_conduct(),
                            $value->getTime());
            }
            $this->_helper->logger($result);
            echo $this->_helper->json($result, false);*/
         $department_id = 'CSE';
        $degree_id = 'BTECH';
        $semester_id = '6';
        $rollno = '2308001';
         $name = 'Prarthana';
         $this->view->assign('name',$name);
        $this->view->assign('rollno',$rollno);
        $this->view->assign('sem',$semester_id);
        $this->view->assign('degree',$degree_id);
        $this->view->assign('deptt',$department_id);
        $model = new Acad_Model_Assessment_Assignment();
        $schedule = $model->fetchSchedule($degree_id,$department_id,$semester_id);
        $this->view->assign('schedule',$schedule);
         
    }
    
}