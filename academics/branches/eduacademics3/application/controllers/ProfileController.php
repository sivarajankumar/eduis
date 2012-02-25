<?php

class ProfileController extends Zend_Controller_Action
{

    protected $_applicant;
    protected $_applicant_academic;
    protected $_applicant_admissionbasis;
    protected $_applicant_degreedetails;
    public function init()
    {
        $this->_applicant = new Zend_Session_Namespace('applicant');
        $this->_applicant_admissionbasis = new Zend_Session_Namespace(
        'applicant_admissionbasis');
        $this->_applicant_academic = new Zend_Session_Namespace(
        'applicant_academic');
        $this->_applicant_degreedetails = new Zend_Session_Namespace(
        'applicant_degreedetails');
        $this->view->assign('applicant', $this->_applicant);
        $this->view->assign('steps', 
        array( 'admissionbasis', 'academic', 'degreedetails'));
    }
    

    public function indexAction()
    {
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        
        foreach ($params as $colName => $value) {
            $value = is_array($value) ? $value : htmlentities(trim($value));
            $this->_applicant->$colName = $value;
        }  
        //print_r($params);
        $params['member_id'] = $this->_applicant->member_id;
        $params['department_id'] = $this->_applicant->department_id;
        $params['programme_id'] = $this->_applicant->programme_id;
        $params['semester_id'] = $this->_applicant->semester_id;
        $this->_redirect('profile/admissionbasis');
    }
    
    public function admissionbasisAction ()
    {
        $this->view->assign('stepNo', 0   );
        
    }
    public function setadmissionbasisAction ()
    {
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $params['member_id'] = $this->_applicant->member_id;
        $params['department_id'] = $this->_applicant->department_id;
        $params['programme_id'] = $this->_applicant->programme_id;
        $params['semester_id'] = $this->_applicant->semester_id;
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
        foreach ($params as $colName => $value) {
            $value = is_array($value)?$value:htmlentities(trim($value));
            $this->_applicant->$colName = $value;
        }
       print_r($params);
        $this->_redirect('/profile/academic');
    }
    
    public function academicAction()
    {
        $this->view->assign('stepNo',1);
    }
    
    public function setacademicAction()
    {
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $params['programme_id'] = $this->_applicant->programme_id;
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
        foreach ($value as $colName => $value){
            $value = is_array($value)?$value:htmlentities(trim($value));
            $this->_applicant->$colName = $value;
        }
        echo 'Following information recieved:<br/>';
        foreach ($params as $colName => $value)
        {
            $value = is_array($value)?var_export($value,true):htmlentities(trim($value));
            echo '<b>'.ucwords(str_ireplace('_', ' ', $colName)).'</b> : '.$value.'<br/>';
            
        }
        print_r($value);
        //$URL =  '/student/saveprofile' . '?' . http_build_query($params);
    }
    
    public function degreedetailsAction() {
        
        $this->view->assign('stepNo', 2);
        //$this->view->assign('programme_id','btech');
    }
    
    public function setdegreedetailsAction() 
    {
        $request = $this->getRequest();
        $params = array_diff($request->getParam(), $request->getUserParams());
        $params['programme_id'] = $this->_applicant->programme_id;
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->helper->layout()->disableLayout();
        foreach ($value as $colName => $value) {
            $value = is_array($value)?$value:htmlentities(trim($value));
            $this->_applicant->$colName = $value;
        }
         echo 'Following information recieved:<br/>';
         foreach ($value as $colName => $value) {
             $value = is_array($value)?var_export($value,true):htmlentities(trim($value));
             echo '<b>'.ucwords(str_ireplace('_', ' ' , $colName)).'</b> : '.$value.'<br/>';
             
         }
        
    }
    
    

}