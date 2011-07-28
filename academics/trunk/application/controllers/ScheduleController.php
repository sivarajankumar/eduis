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
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        
    }
    public function SessionalAction()
    {
        $authInfo = Zend_Auth::getInstance()->getStorage()->read();
        $department_id = $authInfo['department_id'];
        $degree_id = $authInfo['degree_id'];
        $sem = $authInfo['semester'];
        $values = array('department_id'=>$department_id,'degree_id'=>$degree_id,'semester_id'=>$sem);
        $model = new Acad_Model_Assessment_Sessional($values);
        $schedule = $model->fetchSchedule();
        
        
        
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
            echo $this->_helper->json($result, false);
    } 
    
    /**
     * fetches the schedule of unlocked assignments
     * date of conduct refers to date of submission
     */
    public function AssignmentAction()
    {
        $authInfo = Zend_Auth::getInstance()->getStorage()->read();
        $department_id = $authInfo['department_id'];
        $degree_id = $authInfo['degree_id'];
        $sem = $authInfo['semester'];
        $values = array('department_id'=>$department_id,'degree_id'=>$degree_id,'semester_id'=>$sem);
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
            echo $this->_helper->json($result, false);
    }
    
}