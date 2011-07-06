<?php
/**
 * ApplicationFormController
 * 
 * @author
 * @version 
 */
class ApplicationFormController extends Admsnz_Base_BaseController
{
    /**
     * @var Zend_Session_Namespace applicant.
     */
    protected $applicant;
    
    public function init ()
    {
        $this->applicant = new Zend_Session_Namespace('applicant');
        $this->view->assign('applicant',$this->applicant);
        $this->view->assign('steps',array('personal','academic','address','facilities','councelling','print'));
    }
    /**
     * The default action - show the home page
     */
    public function indexAction ()
    {/*
        $this->applicant->caculatePercent = function($obtained, $total) {
            return  ((int)$obtained/(int)$total)/100;
        };
        */
    }

    public function personalAction ()
    {
        $this->view->assign('stepNo',0);
        //TODO Basic information of candidate.
    }
    
    public function setpersonalAction ()
    {
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
        foreach ($params as $colName => $value) {
            $value = is_array($value)?$value:htmlentities(trim($value));
            $this->applicant->$colName = $value;
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
            $this->applicant->$colName = $value;
        }
        echo 'Following information recieved:<br/>';
        foreach ($params as $colName => $value) {
            
            $value = is_array($value)?var_export($value,true):htmlentities(trim($value));
            echo '<b>'.ucwords(str_ireplace('_', ' ', $colName)).'</b> : '.$value.'<br/>';
        }
    }
    
    
    public function addressAction ()
    {
        $this->view->assign('stepNo',2);
    }
    
    public function setaddressAction ()
    {
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
        foreach ($params as $colName => $value) {
            $value = is_array($value)?$value:htmlentities(trim($value));
            $this->applicant->$colName = $value;
        }
        echo 'Following information recieved:<br/>';
        foreach ($params as $colName => $value) {
            
            $value = is_array($value)?var_export($value,true):htmlentities(trim($value));
            echo '<b>'.ucwords(str_ireplace('_', ' ', $colName)).'</b> : '.$value.'<br/>';
        }
    }
    
    public function facilitiesAction ()
    {
        $this->view->assign('stepNo',3);
        
    }
    
    public function setfacilitiesAction ()
    {
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
        foreach ($params as $colName => $value) {
            $value = is_array($value)?$value:htmlentities(trim($value));
            $this->applicant->$colName = $value;
        }
        echo 'Following information recieved:<br/>';
        foreach ($params as $colName => $value) {
            
            $value = is_array($value)?var_export($value,true):htmlentities(trim($value));
            echo '<b>'.ucwords(str_ireplace('_', ' ', $colName)).'</b> : '.$value.'<br/>';
        }
    }

    public function councellingAction ()
    {
        $this->view->assign('stepNo',4);
    }
    
    public function setcouncellingAction ()
    {
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
        foreach ($params as $colName => $value) {
            $value = is_array($value)?$value:htmlentities(trim($value));
            $this->applicant->$colName = $value;
        }
        echo 'Following information recieved:<br/>';
        foreach ($params as $colName => $value) {
            
            $value = is_array($value)?var_export($value,true):htmlentities(trim($value));
            echo '<b>'.ucwords(str_ireplace('_', ' ', $colName)).'</b> : '.$value.'<br/>';
        }
    }
    

    public function printAction ()
    {
        $this->_helper->layout()->disableLayout();
        $this->view->assign('stepNo',5);
    }
}
