<?php
/**
 * ProfileController
 * 
 * @author
 * @version 
 */
require_once 'Zend/Controller/Action.php';
class ProfileController extends Zend_Controller_Action
{
    /**
     * The default action - show the home page
     */
	
	protected $_applicant;
	protected $_applicant_personal;
	protected $_applicant_academic;
	protected $_applicant_career;
	

	public function init ()
    {
        $this->applicant = new Zend_Session_Namespace('applicant','applicant_personal','applicant_academic','applicant_career');
        $this->view->assign('applicant',$this->applicant);
        $this->view->assign('steps',array('personal','academic','career'));
    }
    
    
    
public function validaterollnoAction ()
    {
        /*$rollNo = $this->getRequest()->getParam('roll_no');
        $admission_basis = $this->getRequest()->getParam('admission_basis');
        $candidate = new Admsn_Model_Member_Candidate();
        $status = $candidate->setRoll_no($rollNo)->exists();
        
        $applicant = new Zend_Session_Namespace('applicant');
        $applicant->unsetAll();
        if (isset($status['is_locked']) and $status['is_locked'] == 1) {
            throw new Zend_Exception($rollNo.' has locked the application.',Zend_Log::ERR);
        } elseif ($status) {
            $applicant->roll_no = $status['roll_no'];
            $applicant->admission_basis = $status['admission_basis'];
            
        } else {
            $applicant->roll_no = $rollNo;
            $applicant->admission_basis = $admission_basis;
        }
        
       $this->_helper->json($status);*/
    }
    
    public function indexAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function followstepAction()
    {
    	$request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
        foreach ($params as $colName => $value) {
            $value = is_array($value)?$value:htmlentities(trim($value));
            $this->applicant->$colName = $value;
        }
    	
    }
    public function personalAction()
    {      
    	$this->view->assign('stepNo',0);
    }
    
    public function setpersonalAction ()
    {
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
        foreach ($params as $colName => $value) {
            $value = is_array($value)?$value:htmlentities(trim($value));
            $this->applicant_academic->$colName = $value;
        }
        echo 'Following information recieved:<br/>';
        foreach ($params as $colName => $value) {
            
            $value = is_array($value)?var_export($value,true):htmlentities(trim($value));
            echo '<b>'.ucwords(str_ireplace('_', ' ', $colName)).'</b> : '.$value.'<br/>';
        }
    }
    
public function academicAction ()
    {
        $this->view->assign('stepNo',1);
    }
    
    public function setacademicAction ()
    {
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
        foreach ($params as $colName => $value) {
            $value = is_array($value)?$value:htmlentities(trim($value));
            $this->applicant_personal->$colName = $value;
        }
        echo 'Following information recieved:<br/>';
        foreach ($params as $colName => $value) {
            
            $value = is_array($value)?var_export($value,true):htmlentities(trim($value));
            echo '<b>'.ucwords(str_ireplace('_', ' ', $colName)).'</b> : '.$value.'<br/>';
        }
    }
    
    public function careerAction() 
    {
    	$this->view->assign('stepNo',2);
    }
    
  public function setcareerAction ()
    {
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
        foreach ($params as $colName => $value) {
            $value = is_array($value)?$value:htmlentities(trim($value));
            $this->applicant_career->$colName = $value;
        }
        echo 'Following information recieved:<br/>';
        foreach ($params as $colName => $value) {
            
            $value = is_array($value)?var_export($value,true):htmlentities(trim($value));
            echo '<b>'.ucwords(str_ireplace('_', ' ', $colName)).'</b> : '.$value.'<br/>';
        }
    }
    
    public function saveAction() 
    {
    	$authInfo = Zend_Auth::getInstance()->getStorage()->read();
    	$this->_applicant = $authInfo['applicant'];
    	$this->_applicant_personal = $authInfo['applicant_personal'];
        $this->_applicant_academic = $authInfo['applicant_academic'];
        $this->_applicant_career = $authInfo['applicant_career'];
        
        
        
    }
    
    
    
    
}
