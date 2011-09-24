<?php
class StudentPersonalController extends Corez_Base_BaseController
{
    /*
     * @about Interface.
     */
    public function indexAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $this->view->assign('controller', $this->_request->getControllerName());
        $this->view->assign('module', $this->_request->getModuleName());
    }
    
    /*
     * RETURNS THE PROFILE OF GIVEN ROLL NUMBER
     */
     public function getprofileAction() 
    {
    
        $model = new Core_Model_Member_Student(); 
        $authInfo = Zend_Auth::getInstance()->getStorage()->read();
        $member_id = $authInfo['member_id']; 
       /* 
       if (isset($member_id) 
        {
           
            $model->setMember_id($member_id);
            $model->getStudentInfo();
            
        }
        elseif ($this->getRequest()->getParam('roll_no'))
        {
            $model->setStudent_roll_no($this->_roll_no);
            $model->getMember_id();
            $model->getStudentInfo();
        }
        else 
        {
           throw new Exception('..................ABE ROLL NUMBER DAAL...........',Zend_Log::ERR);
        }
        */
       $this->_roll_no = '2308009'; 
       $model->setStudent_roll_no($this->_roll_no);
       $model->getMember_id();
       $model->getStudentInfo();
       $info = array(
       'roll_no'=>$model->getStudent_roll_no(),
       'regn_no'=>$model->getReg_no(),
       'first_name'=>$model->getFirst_name(),
       'middle_name'=>$model->getMiddle_name(),
       'last_name'=>$model->getLast_name(),
       'gender'=>$model->getGender(),
       'phone_no'=>$model->getContact_no(),
       'dob'=>$model->getDob(),
       'email'=>$model->getE_mail());
       print_r($info);
       //$this->_helper->json($info);
    }
}
